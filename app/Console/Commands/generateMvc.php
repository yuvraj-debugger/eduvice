<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class generateMvc extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:generate-mvc {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make model view and controller';

    /**
     * Filesystem instance
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        
    
        // Generate Controller
        $controllerpath = $this->getControllerFilePath();

        $controller = $this->getControllerFile();

        if (! $this->files->exists($controllerpath)) {
            $this->files->put($controllerpath, $controller);
            $this->info("File : {$controllerpath} created");
        } else {
            $this->info("File : {$controllerpath} already exits");
        }

        // Generate Model
        $modelpath = $this->getModelFilePath();

        $model = $this->getModelFile();

        if (! $this->files->exists($modelpath)) {
            $this->files->put($modelpath, $model);
            $this->info("File : {$modelpath} created");
        } else {
            $this->info("File : {$modelpath} already exits");
        }
        
        // Generate Views
        $this->makeDirectory('resources/views/'.$this->argument('name'));
        
        //Generate index file
        $viewIndexpath = $this->getViewIndexFilePath();
        
        $viewindex = $this->getViewIndexFile();
        
        if (! $this->files->exists($viewIndexpath)) {
            $this->files->put($viewIndexpath, $viewindex);
            $this->info("File : {$viewIndexpath} created");
        } else {
            $this->info("File : {$viewIndexpath} already exits");
        }
        
        //Generate show file
        $viewshowpath = $this->getViewShowFilePath();
        
        $viewshow = $this->getViewShowFile();
        
        if (! $this->files->exists($viewshowpath)) {
            $this->files->put($viewshowpath, $viewshow);
            $this->info("File : {$viewshowpath} created");
        } else {
            $this->info("File : {$viewshowpath} already exits");
        }
        
        //Generate create file
        $viewcreatepath = $this->getViewCreateFilePath();
        
        $viewcreate = $this->getViewCreateFile();
        
        if (! $this->files->exists($viewcreatepath)) {
            $this->files->put($viewcreatepath, $viewcreate);
            $this->info("File : {$viewcreatepath} created");
        } else {
            $this->info("File : {$viewcreatepath} already exits");
        }
    }

    /**
     * Return the stub file path
     *
     * @return string
     *
     */
    public function getStubPath()
    {
        return __DIR__ . '/../../../stubs/interface.stub';
    }

    /**
     * Return the stub file path
     *
     * @return string
     *
     */
    public function getControllerStubPath()
    {
        return __DIR__ . '/../../../stubs/controlleradvanced.stub';
    }

    /**
     * Return the stub file path
     *
     * @return string
     *
     */
    public function getModelStubPath()
    {
        return __DIR__ . '/../../../stubs/modeladvanced.stub';
    }
    
    /**
     * Return the stub file path
     *
     * @return string
     *
     */
    public function getViewIndexStubPath()
    {
        return __DIR__ . '/../../../stubs/viewindex.stub';
    }
    
    /**
     * Return the stub file path
     *
     * @return string
     *
     */
    public function getViewShowStubPath()
    {
        return __DIR__ . '/../../../stubs/viewshow.stub';
    }
    
    /**
     * Return the stub file path
     *
     * @return string
     *
     */
    public function getViewCreateStubPath()
    {
        return __DIR__ . '/../../../stubs/viewcreate.stub';
    }

    /**
     * *
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getControllerStubVariables()
    {
        return [
            'NAMESPACE' => 'App\Http\Controllers',
            'MODELCLASS' => $this->getSingularClassName($this->argument('name')),
            'VAR_NAME' => $this->argument('name'),
            'CLASS_NAME' => $this->getSingularClassName($this->argument('name')) . 'Controller'
        ];
    }
    
    /**
     * *
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getViewIndexStubVariables()
    {
        return [
            'NAMESPACE' => 'App\views',
            'MODELCLASS' => $this->getSingularClassName($this->argument('name')),
            'TABLE_NAME' => $this->argument('name'),
            'TITLE' => ucwords(str_replace('_', ' ', $this->argument('name'))),
            'TABLE_HEAD' => $this->getViewTableHead(),
            'TABLE_DATA'=>$this->getViewTableData(),
            'CLASS_NAME' => $this->getSingularClassName($this->argument('name'))
        ];
    }
    
    /**
     * *
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getViewShowStubVariables()
    {
        return [
            'NAMESPACE' => 'App\views',
            'MODELCLASS' => $this->getSingularClassName($this->argument('name')),
            'TABLE_NAME' => $this->argument('name'),
            'TITLE' => ucwords(str_replace('_', ' ', $this->argument('name'))),
            'DATA' => $this->getViewData(),
            'CLASS_NAME' => $this->getSingularClassName($this->argument('name'))
        ];
    }
    
    
    /**
     * *
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getViewCreateStubVariables()
    {
        return [
            'NAMESPACE' => 'App\views',
            'MODELCLASS' => $this->getSingularClassName($this->argument('name')),
            'TABLE_NAME' => $this->argument('name'),
            'TITLE' => ucwords(str_replace('_', ' ', $this->argument('name'))),
            'DATA' => $this->getViewFormData(),
            'CLASS_NAME' => $this->getSingularClassName($this->argument('name'))
        ];
    }

    /**
     * *
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getModelStubVariables()
    {
        return [
            'NAMESPACE' => 'App\Models',
            'TABLE_NAME' => $this->argument('name'),
            'CLASS_NAME' => $this->getSingularClassName($this->argument('name')),
            'FILLABLE' => $this->getTableSchema()
        ];
    }

    public function getTableSchema()
    {
        $schema = Schema::getColumnListing($this->argument('name'));
        $columns = array_map(function ($elem) {
            return '\'' . $elem . '\'';
        }, $schema);
        return implode(',',$columns);
    }

    /**
     * *
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getStubVariables()
    {
        return [
            'NAMESPACE' => 'App\\Interfaces',
            'CLASS_NAME' => $this->getSingularClassName($this->argument('name'))
        ];
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getControllerFile()
    {
        return $this->getStubContents($this->getControllerStubPath(), $this->getControllerStubVariables());
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getModelFile()
    {
        return $this->getStubContents($this->getModelStubPath(), $this->getModelStubVariables());
    }
    
    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getViewIndexFile()
    {
        return $this->getStubContents($this->getViewIndexStubPath(), $this->getViewIndexStubVariables());
    }
    
    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getViewShowFile()
    {
        return $this->getStubContents($this->getViewShowStubPath(), $this->getViewShowStubVariables());
    }
    
    
    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getViewCreateFile()
    {
        return $this->getStubContents($this->getViewCreateStubPath(), $this->getViewCreateStubVariables());
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFile()
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param
     *            $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getControllerFilePath()
    {
        return base_path('app/Http/Controllers') . '/' . $this->getSingularClassName($this->argument('name')) . 'Controller.php';
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getModelFilePath()
    {
        return base_path('app/Models') . '/' . $this->getSingularClassName($this->argument('name')) . '.php';
    }
    
    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getViewIndexFilePath()
    {
        return base_path('resources/views') . '/' . $this->argument('name') . '/index.php';
    }
    
    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getViewShowFilePath()
    {
        return base_path('resources/views') . '/' . $this->argument('name') . '/show.php';
    }
    
    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getViewCreateFilePath()
    {
        return base_path('resources/views') . '/' . $this->argument('name') . '/create.php';
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        return base_path('app/Interfaces') . '/' . $this->getSingularClassName($this->argument('name')) . 'Interface.php';
    }

    /**
     * Return the Singular Capitalize Name
     *
     * @param
     *            $name
     * @return string
     */
    public function getSingularClassName($name)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $name)));
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param string $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
    
    /**
     * Generate Table Heads
     */
    public function getViewTableHead()
    {
        $schema = Schema::getColumnListing($this->argument('name'));
        
        $html='';
        foreach($schema as $value)
        {
            $html.='<th>'.ucwords(str_replace('_', ' ', $value)).'</th>';
        }
        $html.='<th>Action</th>';
        return $html;
    }
    
    /**
     * Generate Table Heads
     */
    public function getViewTableData()
    {
        $schema = Schema::getColumnListing($this->argument('name'));
        
        $html='<tr>';
        foreach($schema as $value)
        {
            $html.='<td>{{ $row->'.$value.' }}</td>';
        }
        $html.='<td><a href="#" class="btn btn-success"><i class="fa fa-eye"></i></a> <a href="#" class="btn btn-primary"><i class="fa fa-pencil"></i></a> <a href="#" class="btn btn-danger"><i class="fa fa-trash"></i></a></td></tr>';
        return $html;
    }
    
    /**
     * 
     * Generate view Data
     * 
     */
    public function getViewData()
    {
        $schema = Schema::getColumnListing($this->argument('name'));
        
        $html='<table>';
        foreach($schema as $value)
        {
            
            $html.='<td><b>'.ucwords(str_replace('_', ' ', $value)).'</b></td>';
            $html.='<td>{{ $row->'.$value.' }}</td>';
            
        }
        $html.='</table>';
        return $html;
    }
    
    /**
     *
     * Generate view Data
     *
     */
    public function getViewFormData()
    {
        $schema = Schema::getColumnListing($this->argument('name'));
        $html='<div class="row">';
        foreach($schema as $value)
        {
            $schemaType=Schema::getColumnType($this->argument('name'), $value);
            $html.='<label>'.ucwords(str_replace('_', ' ', $value)).'</label>';
            
            $type='text';
            if($schemaType=='int'||$schemaType=='bigint')
            {
                $type='number';
            }
            if($schemaType=='date')
            {
                $type='date';
            }
            if($schemaType=='time')
            {
                $type='time';
            }
            if($schemaType=='datetime')
            {
                $type='datetime-local';
            }
            $html.='<input type="'.$type.'" name="'.$value.'" placeholder="'.ucwords(str_replace('_', ' ', $value)).'" id="'.$value.'" class="form-control">';
        }
        $html.='</div>';
        return $html;
    }
}