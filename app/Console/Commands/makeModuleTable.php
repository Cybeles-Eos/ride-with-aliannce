<?php

namespace App\Console\Commands;

use App\Models\PermissionGroup;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class makeModuleTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:moduletable {--module_name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate module';

    /**
     * Create a new command instance.
     *
     * @param Filesystem $filesystem
     * @param Composer $composer
     * @param PermissionGroup $permission_group_model
     * @param Permission $permission_model
     * @param Role $role_model
     */
    public function __construct(Filesystem $filesystem,
                                Composer $composer,
                                PermissionGroup $permission_group_model,
                                Permission $permission_model,
                                Role $role_model)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
        $this->composer = $composer;
        $this->permission_group_model = $permission_group_model;
        $this->permission_model = $permission_model;
        $this->role_model = $role_model;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Please make sure to have it in ucwords and separated by space if multiple words eg. Product Category)');
        $this->info('This module creator refreshes the database data so make sure you have your back up.');
        $this->info('Also make sure that you have no other modified files currently so that you can revert the created module by using this commands:');
        $this->line('git checkout');
        $this->line('git clean -f -d');
        $this->line('php artisan migrate:refresh --seed');
        if ($this->confirm('Do you wish to continue?')) {
            $data = $this->getInputs();

            $bar = $this->output->createProgressBar(100);
            $bar->start();
            $bar->setEmptyBarCharacter('-');
            $bar->setBarCharacter('=');

            $this->generateController($data);
            $bar->advance(10);
            $this->info('');
            $this->info('Controller ' . $data['module_name'] . ' Created');

            $this->generateModel($data);
            $bar->advance(10);
            $this->info('');
            $this->info('Model ' . $data['module_name'] . ' Created');

            $this->generateRepository($data);
            $bar->advance(10);
            $this->info('');
            $this->info('Repository ' . $data['module_name'] . ' Created');

            $this->generateMigration($data);
            $bar->advance(10);
            $this->info('');
            $this->info('Migration ' . $data['module_name'] . ' Created');

            $bar->finish();
            $this->info('');
            $this->info('Module ' . $data['module_name'] . ' Completed');
        }
    }

    private function getInputs()
    {
        $module_name = $this->option('module_name');

        if (empty($module_name)) {
            $module_name = $this->ask('Module name');
        }

        return [
            'camel_case' => preg_replace('/\s+/', '', ucwords($module_name)),
            'camel_case_plural' => preg_replace('/\s+/', '', ucwords(str_plural($module_name))),
            'snake_case' => preg_replace('/\s+/', '_', strtolower($module_name)),
            'snake_case_plural' => preg_replace('/\s+/', '_', strtolower(str_plural($module_name))),
            'module_name' => $module_name,
            'module_name_plural' => str_plural($module_name),
        ];
    }

    private function generateController($data)
    {
        $template = $this->filesystem->get(storage_path('make_module_templates/controller/TemplateController.php'));
        $template = $this->replaceTexts($data, $template);
        $this->filesystem->put('app/Http/Controllers/' . $data['camel_case'] . 'Controller.php', $template);
    }

    private function generateModel($data)
    {
        $template = $this->filesystem->get(storage_path('make_module_templates/model/Template.php'));
        $template = $this->replaceTexts($data, $template);
        $this->filesystem->put('app/Models/' . $data['camel_case'] . '.php', $template);
    }

    private function generateRepository($data)
    {
        $template = $this->filesystem->get(storage_path('make_module_templates/repository/TemplateRepository.php'));
        $template = $this->replaceTexts($data, $template);
        $this->filesystem->put('app/Repositories/' . $data['camel_case'] . 'Repository.php', $template);
    }

    private function generateMigration($data)
    {
        $template = $this->filesystem->get(storage_path('make_module_templates/migration/2018_02_21_123927_create_templates_table.php'));
        $template = $this->replaceTexts($data, $template);
        $this->filesystem->put('database/migrations/' . date('Y_m_d_His'). '_create_' . $data['snake_case_plural'] . '_table.php', $template);
//        $this->call('migrate', []);
        //$this->filesystem->put('database/migrations/2018_02_21_123927_create_' . $data['snake_case_plural'] . '_table.php', $template);
        // $this->callSilent('migrate:refresh', ['--seed' => TRUE]);

        $iseed = $this->filesystem->get('Iseed.txt');
        $iseed .= "\nphp artisan iseed " . $data['snake_case_plural'] . " --force";
        $this->filesystem->put('Iseed.txt', $iseed);
    }

    private function replaceTexts($data, $template)
    {
        $template = str_replace("DefaultTemplatePlural", $data['module_name_plural'], $template);
        $template = str_replace("DefaultTemplate", $data['module_name'], $template);
        $template = str_replace("TemplateCamelCasePlural", $data['camel_case_plural'], $template);
        $template = str_replace("TemplateCamelCase", $data['camel_case'], $template);
        $template = str_replace("template_snake_case_plural", $data['snake_case_plural'], $template);
        $template = str_replace("template_snake_case", $data['snake_case'], $template);

        return $template;
    }
}
