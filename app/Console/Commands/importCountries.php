<?php
namespace App\Console\Commands;

use App\Models\Country;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class importCountries extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import-countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will import countries ';

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
        $response = $client->request('GET', 'https://api.dfavo.app/inventory/countries');
        if ($response) {
            $data = json_decode($response->getBody());
            $s3 = Storage::disk('s3');
            foreach ($data->data->recordInfo as $country) {
                if ($country->icon_svg) {
                    $path_svg = '';
                    $path_png = '';
                    $headers = @get_headers($country->icon_svg);
                    if ($headers && strpos($headers[0], '200')) {
                        $contents_svg = file_get_contents($country->icon_svg);
                        $name_svg = substr($country->icon_svg, strrpos($country->icon_svg, '/') + 1);
                        $path_svg = $s3->put($name_svg, $contents_svg);
                        $path_svg = Storage::disk('s3')->url($name_svg);
                    }
                    $headers = @get_headers($country->icon_png);
                    if ($headers && strpos($headers[0], '200')) {
                        $contents_png = file_get_contents($country->icon_png);
                        $name_png = substr($country->icon_png, strrpos($country->icon_png, '/') + 1);
                        $path_png = $s3->put($name_png, $contents_png);
                        $path_png = Storage::disk('s3')->url($name_png);
                    }

                    $this->info($path_png);
                    $this->info($path_svg);

                    Country::create([
                        'id' => $country->id,
                        'name' => $country->name,
                        'phonecode' => $country->phonecode,
                        'shortname' => $country->shortname,
                        'has_icon' => $country->has_icon,
                        'icon_svg' => $path_svg,
                        'icon_png' => $path_png,
                        'is_selected' => $country->is_selected
                    ]);
                }
            }
        }
    }
}
