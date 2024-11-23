<?php

namespace App\Console\Commands;

use App\HelpersClasses\MyApp;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Command\Command as CommandAlias;

class CrudDestroyCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:destroy {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'destroy crud model';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $model = MyApp::Classes()->stringProcess->camelCase($this->argument("model"));
        $listOfFiles = $this->getDependenciesFiles($model);
        $isDeleteAnyThing = false;

        foreach ($listOfFiles as $file) {
            if (File::exists($file) && File::isFile($file)) {
                $isDeleteAnyThing = true;
                File::delete($file);
            }
            if (File::exists($file) && File::isDirectory($file)) {
                $isDeleteAnyThing = true;
                File::deleteDirectory($file);
            }
        }
        if (!$isDeleteAnyThing) {
            $this->error("the model $model not found !");
        } else {
            $this->line("<info>The Model $model was deleted with his dependencies successfully </info>, and please remove the migration file manual");
        }
        return CommandAlias::SUCCESS;
    }
}
