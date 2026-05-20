<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\FormBuilderService;

class FieldTypesSeeder extends Seeder
{
    protected $formBuilder;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct(FormBuilderService $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seeding field types...');
        
        try {
            $count = $this->formBuilder->seedFieldTypes();
            
            $this->command->info("✓ Successfully seeded {$count} field types!");
            
            // Display the field types that were created
            $fieldTypes = $this->formBuilder->getAvailableFieldTypes();
            
            $this->command->info('  Available field types:');
            foreach ($fieldTypes as $component => $config) {
                $this->command->line("    - {$config['name']} ({$component})");
            }
        } catch (\Exception $e) {
            $this->command->error('✗ Error seeding field types: ' . $e->getMessage());
            throw $e;
        }
    }
}



