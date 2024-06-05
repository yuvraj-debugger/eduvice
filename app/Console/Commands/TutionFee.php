<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Course;

class TutionFee extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import-tutionfee';

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
        $courses = Course::all();
        foreach ($courses as $tutionFee) {
            if (! empty($tutionFee)) {
                $tutionFee->tution_fee_amount = (int)$tutionFee->tution_fee_amount;
                $tutionFee->update();
                echo $tutionFee->id;
            }
        }
    }
}
