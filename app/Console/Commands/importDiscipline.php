<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Course;
use App\Models\AreaOfInterest;
use Illuminate\Support\Facades\Auth;

class importDiscipline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:area-interest';

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
        $courses= Course::all();
        foreach($courses as $course)
        {
            $area= AreaOfInterest::where('disciplines_id',$course->discipline_id)->first();
            if(!empty($area))
            {
                $course->area_of_interest_id=$area->id;
                $course->update();
            }
        }
        
    }
}
