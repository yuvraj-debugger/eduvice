<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Course;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;

class importCurrency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:currency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Currency';

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
        $countryCode = DB::table('course')->distinct()->get(['currencyCode']);
        foreach ($countryCode as $currencyCode){
            Currency::create([
                'currencySymbol'=> '$',
                'currencyCode'=>  ! empty($currencyCode) ? $currencyCode->currencyCode : '',
            ]);
        }
       
    }
}
