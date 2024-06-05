<?php
namespace App\Console\Commands;

use App\Models\City;
use App\Models\State;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class importCity extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import-city';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import City';

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
        $states = State::all();
        foreach ($states as $state) {
            $response = $client->request('GET', 'https://api.dfavo.app/inventory/cities/' . $state->state_id . '/state');
            if ($response) {
                $data = json_decode($response->getBody());
                foreach ($data->data->recordInfo as $city) {
                    if (isset($city->country)) {
                        $city_where=City::where([
                            'name' => $city->name,
                            'state' => $city->state,
                            'country' => $city->country
                        ])->first();
                        if(empty($city_where))
                        {
                            City::create([
                                'state_id' => $state->id,
                                'city_id' => $city->id,
                                'name' => $city->name,
                                'state' => $city->state,
                                'country' => $city->country,
                                'is_selected' => $city->is_selected
                            ]);
                        }
                        echo $city->name.'\n';
                    }
                }
            }
            else
            {
                echo "Response Faild".$state->name.'\n';
            }
        }
    }
}
