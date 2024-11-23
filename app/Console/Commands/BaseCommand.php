<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:crud {model}';

    /**
     * get the path according  to the type.
     *
     * @param string $model
     *
     * @param null $type
     *
     * @return array|string
     * @author karam mustafa
     */
    protected function getDependenciesFiles(string $model, $type = null): array|string
    {
        $arr = [
            'request' => app_path("Http/Requests/{$model}Request.php"),
            'model' => app_path("Models/$model.php"),
            'controller' => app_path("Http/Controllers/{$model}Controller.php"),
            'seeder' => database_path("seeders/{$model}Seeder.php"),
        ];
        return $arr[$type] ?? $arr;
    }

    protected function resolveCreateRequest(string $model)
    {
        $requestFile = File::get($this->getDependenciesFiles($model, 'request'));
        $newRequestFile = str_replace("{{ model }}", $model, $requestFile);
        File::put($this->getDependenciesFiles($model, 'request'), $newRequestFile);
    }
}
