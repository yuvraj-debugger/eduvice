<?php

namespace App\Console\Commands;

use App\Models\CampusCourse;
use App\Models\Course;
use App\Models\CourseEstDetail;
use App\Models\CourseIntake;
use App\Models\CourseOpenIntake;
use App\Models\University;
use App\Models\UniversityCampus;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\GlobalCourses;

class importCourse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import-course';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Course';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $client= new Client();
        $universities=University::orderBy('id','DESC')->get();
        foreach ($universities as $university)
        {
            $response=$client->request('GET','https://api.dfavo.app/inventory/programsList?limit=75000&page=1&institutionId='.$university->institutionId.'');
            if($response)
            {
                $s3 = Storage::disk('s3');
                $data=json_decode($response->getBody());
                
                foreach($data->data->recordsInfo as $course){
                    
                    $course_data_=Course::where('programId',$course->programId)->first();
                    if(!empty($course_data_))
                    {
                        
                        $course_data_->key_highlight=$course->min_requirement;
                        
                        
                        $campusDetails=$course->campusDetails;
                        if(!empty($campusDetails)&&isset($campusDetails[0]))
                        {
                            $tuitionFee=str_replace($course->currencyCode.' '.$course->currencySymbol,'',$campusDetails[0]->tuitionFee);
                            $applicationFee=str_replace($course->currencyCode.' '.$course->currencySymbol,'',$campusDetails[0]->applicationFee);
                            $course_data_->tution_fee_amount=$tuitionFee;
                            $course_data_->tution_fee_currency=$course->currencyCode;
                            $course_data_->application_fee_amount=$applicationFee;
                            $course_data_->application_fee_currency=$course->currencyCode;
                        }
                        if(!empty($course->study_level_id))
                        {
                            $global_course=GlobalCourses::where('global_course_id',$course->study_level_id)->first();
                            if(!empty($global_course))
                            {
                                $course_data_->global_course_id=$global_course->id;
                            }
                        }
                        
                        $course_data_->update();
                        echo $university->id.' Old';                        
                    }
                    else 
                    {
                        $logo = '';
                        if (isset($course->logo)&&!empty($course->logo)) {
                            $headers = @get_headers($course->logo);
                            if ($headers && strpos($headers[0], '200')) {
                                $contents_svg = file_get_contents($course->logo);
                                $name_svg = substr($course->logo, strrpos($course->logo, '/') + 1);
                                $logo = $s3->put($name_svg, $contents_svg);
                                $logo = Storage::disk('s3')->url($name_svg);
                            }
                        }
                        
                        $campusDetails=$course->campusDetails;
                        $tuitionFee=0;
                        $applicationFee=0;
                        if(!empty($campusDetails)&&isset($campusDetails[0]))
                        {
                            $tuitionFee=str_replace($course->currencyCode.' '.$course->currencySymbol,'',$campusDetails[0]->tuitionFee);
                            $applicationFee=str_replace($course->currencyCode.' '.$course->currencySymbol,'',$campusDetails[0]->applicationFee);
                            
                            
                        }
                        $global_course_id=0;
                        if(!empty($course->study_level_id))
                        {
                            $global_course=GlobalCourses::where('global_course_id',$course->study_level_id)->first();
                            if(!empty($global_course))
                            {
                                $global_course_id=$global_course->id;
                            }
                        }
                        $course_data=Course::create([
                            'university_id'=>$university->id,
                            'programId'=>$course->programId,
                            'institutionId'=>$university->institutionId,
                            'currencySymbol'=>$course->currencySymbol,
                            'currencyCode'=>$course->currencyCode,
                            'tution_fee_amount'=>$tuitionFee,
                            'tution_fee_currency'=>$course->currencyCode,
                            'application_fee_amount'=>$applicationFee,
                            'application_fee_currency'=>$course->currencyCode,
                            'countryName'=>$course->countryName,
                            'isShortlisted'=>$course->isShortlisted,
                            'programUrl'=>$course->programUrl,
                            'duration'=>$course->duration,
                            'title'=>$course->programName,
                            'programName'=>$course->programName,
                            'hasLogo'=>$course->hasLogo,
                            'logo'=>$logo,
                            'min_requirement'=>$course->min_requirement,
                            'key_highlight'=>$course->min_requirement,
                            'note'=>$course->note,
                            'institutionName'=>$course->institutionName,
                            'campusDetails'=>json_encode($course->campusDetails),
                            'openIntake'=>json_encode($course->openIntake),
                            'intake'=>'-',
                            'open_intake'=>date('Y-m-d'),
                            'intakeDetails'=>json_encode($course->intakeDetails),
                            'etsDetails'=>json_encode($course->etsDetails),
                            'study_level_id'=>$course->study_level_id,
                            'global_course_id'=>$global_course_id,
                            'discipline_id'=>$course->discipline_id,
                            'type'=>1
                        ]);
                        $university_campus=UniversityCampus::where('name',$course->countryName)->where('university_id',$university->id)->first();
                        
                        
                        foreach($campusDetails as $campusDetail)
                        {
                            $campusCourse=CampusCourse::create([
                                'course_id'=>$course_data->id,
                                'campusId'=>$campusDetail->campusId,
                                'campusName'=>$campusDetail->campusName,
                                'tuitionFee'=>$campusDetail->tuitionFee,
                                'programCode'=>$campusDetail->programCode,
                                'applicationFee'=>$campusDetail->applicationFee,
                                'campus_id'=>(($university_campus)?$university_campus->id:0)
                            ]);
                            
                        }
                        $openIntakes=$course->openIntake;
                        foreach($openIntakes as $openIntake)
                        {
                            $courseOpentake=CourseOpenIntake::create([
                                'intakeName'=>$openIntake->intakeName,
                                'intakeYear'=>$openIntake->intakeYear,
                                'university_id'=>$university->id,
                                'course_id'=>$course_data->id,
                                'programId'=>$course->programId,
                            ]);
                        }
                        
                        $intakeDetails=$course->intakeDetails;
                        foreach($intakeDetails as $intakeDetail)
                        {
                            $courseIntake=CourseIntake::create([
                                'intake'=>$intakeDetail->intake,
                                'intakeYear'=>(isset($intakeDetail->intakeYear))?$intakeDetail->intakeYear:'',
                                'university_id'=>$university->id,
                                'course_id'=>$course_data->id,
                                'programId'=>$course->programId,
                            ]);
                        }
                        
                        $etsDetails=$course->etsDetails;
                        foreach($etsDetails as $etsDetail)
                        {
                            $courseEstDetail=CourseEstDetail::create([
                                'score'=>$etsDetail->score,
                                'min_score'=>$etsDetail->min_score,
                                'scoreName'=>$etsDetail->scoreName,
                                'university_id'=>$university->id,
                                'course_id'=>$course_data->id,
                                'programId'=>$course->programId,
                            ]);
                        }
                        echo $university->id.' New';
                    }
                    
                }
            }
        }
    }
}
