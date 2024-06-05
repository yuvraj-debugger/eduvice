<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\GlobalCourses;
use App\Models\University;
use Illuminate\Console\Command;
use App\Models\AreaOfInterest;

class dataStableCourse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:data-stable-course';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
      
        $universities=University::where('id','<=',664)->get();
        foreach ($universities as $university)
        {
            $course_data=Course::where('university_id',$university->university_id)->get();
        
            
            if(!empty($course_data))
            {
                foreach($course_data as $course_detail)
                {
                    
                    $course_detail->key_highlight=$course_detail->min_requirement;
                    $campusDetails=$course_detail->campusDetails;
                    if(!empty($campusDetails))
                    {
                        $campusDetail=json_decode($campusDetails);
                        
                        if(!empty($campusDetail))
                        {
                            $tuitionFee=str_replace($course_detail->currencyCode.' '.$course_detail->currencySymbol,'',$campusDetail[0]->tuitionFee);
                            $applicationFee=str_replace($course_detail->currencyCode.' '.$course_detail->currencySymbol,'',$campusDetail[0]->applicationFee);
                            $course_detail->tution_fee_amount=(int)$tuitionFee;
                            $course_detail->tution_fee_currency=$course_detail->currencyCode;
                            $course_detail->application_fee_amount=(int)$applicationFee;
                            $course_detail->application_fee_currency=$course_detail->currencyCode;
                            
                        }
                    }
                    if(!empty($course_detail->study_level_id))
                    {
                        $global_course=GlobalCourses::where('global_course_id',$course_detail->study_level_id)->first();
                        if(!empty($global_course))
                        {
                            $course_detail->global_course_id=$global_course->id;
                        }
                    }
                    if(!empty($course_detail->discipline_id))
                    {
                        $areaofinterest=AreaOfInterest::where('global_course_id',$course_detail->discipline_id)->first();
                        if(!empty($areaofinterest))
                        {
                            $course_detail->area_of_interest_id=$areaofinterest->id;
                        }
                    }
                    
                    $course_detail->update();
                    echo $course_detail->id.'-'.$university->id;
                }
            }
        }
    }
}
