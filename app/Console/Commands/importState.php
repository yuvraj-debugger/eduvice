<?php

namespace App\Console\Commands;

use App\Models\State;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use App\Models\Country;
use function Sentry\Laravel\Console\log;

class importState extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import-state';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import state';

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
        $countries=Country::all();
        foreach ($countries as $country)
        {
            $response=$client->request('GET','https://api.dfavo.app/inventory/states/'.$country->id.'/country');
            if($response)
            {
                $data=json_decode($response->getBody());
                foreach($data->data->recordInfo as $country_data)
                {
                    State::create([
                        'country_id'=>$country->id,
                        'state_id'=>$country_data->id,
                        'name'=>$country_data->name,
                        'country'=>$country_data->country,
                        'is_selected'=>$country_data->is_selected
                    ]);
                    echo $country_data->name;
                }
            }
            
        }
    }
}
