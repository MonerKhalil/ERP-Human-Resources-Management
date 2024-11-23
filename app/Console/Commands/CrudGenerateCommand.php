<?php

namespace App\Console\Commands;

use App\HelpersClasses\MyApp;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command as CommandAlias;

class CrudGenerateCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:create {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create crud model';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $model = MyApp::Classes()->stringProcess->camelCase($this->argument("model"));
        $this->info('this will automatically create controller, model, request,  please wait a minute (-__-)');
        system("php artisan make:model -m {$model}");
        system("php artisan make:seeder {$model}Seeder");
        $this->info('model with migration and seeder file was created successfully');
        system("php artisan make:controller {$model}Controller -m {$model}");
        system("php artisan make:request {$model}Request");
        $this->resolveCreateRequest($model);
        return CommandAlias::SUCCESS;
    }
}
