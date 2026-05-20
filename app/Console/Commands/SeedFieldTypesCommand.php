<?php

namespace App\Console\Commands;

use App\Services\FormBuilderService;
use Illuminate\Console\Command;

class SeedFieldTypesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:seed-field-types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with available field types for the CMS';

    protected $formBuilder;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FormBuilderService $formBuilder)
    {
        parent::__construct();
        $this->formBuilder = $formBuilder;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Seeding field types...');
        
        try {
            $count = $this->formBuilder->seedFieldTypes();
            
            $this->info("Successfully seeded {$count} field types!");
            
            // Display the field types that were created
            $fieldTypes = $this->formBuilder->getAvailableFieldTypes();
            
            $this->info("\nAvailable field types:");
            foreach ($fieldTypes as $component => $config) {
                $this->line("  - {$config['name']} ({$component}): {$config['description']}");
            }
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Error seeding field types: ' . $e->getMessage());
            return 1;
        }
    }
}
