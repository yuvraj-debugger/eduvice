<?php
namespace App\Console\Commands;

use App\Models\AreaOfInterest;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class importAreaOfInterest extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import-area-of-interest';

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
        $client = new Client();
        $response = $client->request('GET', 'https://api.dfavo.app/inventory/disciplines');
        if ($response) {
            $data = json_decode($response->getBody());
            $s3 = Storage::disk('s3');
            foreach ($data->data->recordInfo as $inventory) {
                $area=AreaOfInterest::where('title',$inventory->name)->first();
                if(!empty($area))
                {
                    $area->disciplines_id=$inventory->id;
                    $area->update();
                }
                else
                {                
                    $path_png_high = '';
                    $path_png = '';
    
                    if (isset($inventory->icon_png)&&!empty($inventory->icon_png)) {
                        $headers = @get_headers($inventory->icon_png);
                        if ($headers && strpos($headers[0], '200')) {
                            $contents_png = file_get_contents($inventory->icon_png);
                            $name_png = substr($inventory->icon_png, strrpos($inventory->icon_png, '/') + 1);
                            $path_png = $s3->put($name_png, $contents_png);
                            $path_png = Storage::disk('s3')->url($name_png);
                        }
                    }
    
                    if (isset($inventory->icon_png_high)&&!empty($inventory->icon_png_high)) {
                        $headers = @get_headers($inventory->icon_png_high);
                        if ($headers && strpos($headers[0], '200')) {
                            $contents_png_high = file_get_contents($inventory->icon_png_high);
                            $name_png_high = substr($inventory->icon_png_high, strrpos($inventory->icon_png_high, '/') + 1);
                            $path_png_high = $s3->put($name_png_high, $contents_png_high);
                            $path_png_high = Storage::disk('s3')->url($name_png_high);
                        }
                    }
    
                    $this->info($path_png);
                    $this->info($path_png_high);
    
                    AreaOfInterest::create([
                        'disciplines_id'=>$inventory->id,
                        'title' => $inventory->name,
                        'position' => $inventory->position,
                        'has_icon' => $inventory->has_icon,
                        'icon_png' => $path_png,
                        'icon_png_high' => $path_png_high,
                        'is_selected' => $inventory->is_selected
                    ]);
                    echo $inventory->name;
                }
            }
        }
    }
}
