<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use App\Models\GlobalCourses;

class importGlobalCourses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import-global-courses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Global Courses';

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
        $client = new Client();
        $response = $client->request('GET', 'https://api.dfavo.app/inventory/studyLevels');
        if ($response) {
            $data = json_decode($response->getBody());
            foreach ($data->data->recordInfo as $globalCourse) {
                GlobalCourses::create([
                    'title'=>$globalCourse->name,
                    'global_course_id'=>!empty($globalCourse->id)?$globalCourse->id:0,
                    'interest_id'=>0,
                    'type'=>1
                ]);
            }
        }
        
    }
}
