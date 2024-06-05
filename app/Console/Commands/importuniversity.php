<?php
namespace App\Console\Commands;

use App\Models\OpenIntake;
use App\Models\University;
use App\Models\UniversityCampus;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class importuniversity extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import-university';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import University';

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
        $response = $client->request('GET', 'https://api.dfavo.app/inventory/institutionsList?limit=1000');
        if ($response) {
            $data = json_decode($response->getBody());
            $s3 = Storage::disk('s3');

            foreach ($data->data->recordsInfo as $university) {
                $university_data = University::where('institutionId', $university->institutionId)->first();
                if (! empty($university_data)) {
                    $university_data->programCount=$university->programCount;
                    $university_data->update();
                    echo $university->institutionName."(".$university->programCount.") Old";
                } else {
                    $logo = '';
                    if (isset($university->logo) && ! empty($university->logo)) {
                        $headers = @get_headers($university->logo);
                        if ($headers && strpos($headers[0], '200')) {
                            $contents_svg = file_get_contents($university->logo);
                            $name_svg = substr($university->logo, strrpos($university->logo, '/') + 1);
                            $logo = $s3->put($name_svg, $contents_svg);
                            $logo = Storage::disk('s3')->url($name_svg);
                        }
                    }

                    $university_data = University::create([
                        'institutionId' => $university->institutionId,
                        'name' => $university->institutionName,
                        'country' => $university->countryName,
                        'shoreType' => $university->shoreType,
                        'is_pgwp' => $university->is_pgwp,
                        'is_public' => $university->is_public,
                        'institutionType' => $university->institutionType,
                        'campusName' => json_encode($university->campusName),
                        'openIntake' => json_encode($university->openIntake),
                        'institutionUrl' => $university->institutionUrl,
                        'logo' => $logo,
                        'address' => '-',
                        'city' => '-',
                        'province' => '-',
                        'admission_contact_person' => '-',
                        'admission_contact_number' => '-',
                        'admission_email' => '-',
                        'admission_website' => $university->institutionUrl,
                        'placement_contact_person' => '-',
                        'placement_contact_number' => '-',
                        'placement_email' => '-',
                        'placement_website' => $university->institutionUrl,
                        'programCount' => $university->programCount,
                        'type' => 1
                    ]);
                    $campusName = $university->campusName;
                    foreach ($campusName as $campus_name) {
                        UniversityCampus::create([
                            'name' => $campus_name->name,
                            'address' => '-',
                            'university_id' => $university_data->id,
                            'type' => 1
                        ]);
                    }
                    $openIntake = $university->openIntake;
                    foreach ($openIntake as $open_intake) {
                        OpenIntake::create([
                            'intakeName' => $open_intake->intakeName,
                            'intakeYear' => $open_intake->intakeYear,
                            'university_id' => $university_data->id,
                            'type' => 1
                        ]);
                    }
                    echo $university->institutionName."(".$university->programCount.") New";
                }
            }
        }
    }
}
