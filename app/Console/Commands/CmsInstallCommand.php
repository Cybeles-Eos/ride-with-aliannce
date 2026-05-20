<?php

namespace App\Console\Commands;

use App\Services\FormBuilderService;
use App\Services\CmsCacheService;
use App\Models\SectionTemplate;
use App\Models\FieldType;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CmsInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:install 
                            {--force : Force installation even if CMS is already installed}
                            {--seed : Seed sample data}
                            {--cache : Warm up caches after installation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install CMS components and seed initial data';

    protected $formBuilder;
    protected $cacheService;

    /**
     * Create a new command instance.
     */
    public function __construct(FormBuilderService $formBuilder, CmsCacheService $cacheService)
    {
        parent::__construct();
        $this->formBuilder = $formBuilder;
        $this->cacheService = $cacheService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🚀 Foundation Art School CMS Installation');
        $this->newLine();

        // Check if already installed
        if (!$this->option('force') && $this->isAlreadyInstalled()) {
            $this->warn('CMS appears to already be installed.');
            if (!$this->confirm('Continue with installation anyway?')) {
                $this->line('Installation cancelled.');
                return 0;
            }
        }

        $steps = [
            'Running Migrations' => [$this, 'runMigrations'],
            'Seeding Field Types' => [$this, 'seedFieldTypes'],
            'Creating Default Templates' => [$this, 'createDefaultTemplates'],
            'Setting Up Storage' => [$this, 'setupStorage'],
            'Publishing Assets' => [$this, 'publishAssets']
        ];

        if ($this->option('seed')) {
            $steps['Seeding Sample Data'] = [$this, 'seedSampleData'];
        }

        if ($this->option('cache')) {
            $steps['Warming Caches'] = [$this, 'warmCaches'];
        }

        $this->info('Installing Foundation Art School CMS...');
        $this->newLine();

        $this->withProgressBar(array_keys($steps), function ($stepName) use ($steps) {
            try {
                $callback = $steps[$stepName];
                call_user_func($callback);
                sleep(1); // Visual effect
            } catch (\Exception $e) {
                throw new \Exception("Failed during '{$stepName}': " . $e->getMessage());
            }
        });

        $this->newLine(2);
        $this->displayInstallationResults();

        return 0;
    }

    /**
     * Check if CMS is already installed
     */
    protected function isAlreadyInstalled()
    {
        try {
            return FieldType::count() > 0 && SectionTemplate::count() > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Run database migrations
     */
    protected function runMigrations()
    {
        $this->call('migrate', ['--force' => true]);
    }

    /**
     * Seed field types
     */
    protected function seedFieldTypes()
    {
        $this->call('cms:seed-field-types');
    }

    /**
     * Create default section templates
     */
    protected function createDefaultTemplates()
    {
        $templates = [
            'Hero Section' => [
                'description' => 'Main hero/banner section for pages',
                'icon' => 'fa-star',
                'category' => 'Layout',
                'fields' => [
                    ['name' => 'Heading', 'alias' => 'heading', 'type' => 'text', 'required' => true],
                    ['name' => 'Subheading', 'alias' => 'subheading', 'type' => 'textarea'],
                    ['name' => 'Background Image', 'alias' => 'bg_image', 'type' => 'image'],
                    ['name' => 'Call to Action Text', 'alias' => 'cta_text', 'type' => 'text'],
                    ['name' => 'Call to Action URL', 'alias' => 'cta_url', 'type' => 'url']
                ]
            ],
            'Content Block' => [
                'description' => 'General content section with text and optional image',
                'icon' => 'fa-paragraph',
                'category' => 'Content',
                'fields' => [
                    ['name' => 'Title', 'alias' => 'title', 'type' => 'text'],
                    ['name' => 'Content', 'alias' => 'content', 'type' => 'rich-text', 'required' => true],
                    ['name' => 'Featured Image', 'alias' => 'image', 'type' => 'image']
                ]
            ],
            'Image Gallery' => [
                'description' => 'Multiple images in a gallery format',
                'icon' => 'fa-images',
                'category' => 'Media',
                'fields' => [
                    ['name' => 'Gallery Title', 'alias' => 'title', 'type' => 'text'],
                    ['name' => 'Gallery Image', 'alias' => 'image', 'type' => 'image', 'required' => true],
                    ['name' => 'Image Caption', 'alias' => 'caption', 'type' => 'textarea']
                ]
            ],
            'Testimonial' => [
                'description' => 'Customer testimonials with author details',
                'icon' => 'fa-quote-left',
                'category' => 'Social',
                'fields' => [
                    ['name' => 'Quote', 'alias' => 'quote', 'type' => 'textarea', 'required' => true],
                    ['name' => 'Author Name', 'alias' => 'author_name', 'type' => 'text', 'required' => true],
                    ['name' => 'Author Title', 'alias' => 'author_title', 'type' => 'text'],
                    ['name' => 'Author Image', 'alias' => 'author_image', 'type' => 'image'],
                    ['name' => 'Company', 'alias' => 'company', 'type' => 'text']
                ]
            ],
            'Contact Information' => [
                'description' => 'Contact details and information',
                'icon' => 'fa-address-book',
                'category' => 'Contact',
                'fields' => [
                    ['name' => 'Section Title', 'alias' => 'title', 'type' => 'text'],
                    ['name' => 'Address', 'alias' => 'address', 'type' => 'textarea'],
                    ['name' => 'Phone', 'alias' => 'phone', 'type' => 'text'],
                    ['name' => 'Email', 'alias' => 'email', 'type' => 'email'],
                    ['name' => 'Website', 'alias' => 'website', 'type' => 'url']
                ]
            ],
            'FAQ Item' => [
                'description' => 'Frequently asked questions',
                'icon' => 'fa-question-circle',
                'category' => 'Content',
                'fields' => [
                    ['name' => 'Question', 'alias' => 'question', 'type' => 'text', 'required' => true],
                    ['name' => 'Answer', 'alias' => 'answer', 'type' => 'rich-text', 'required' => true]
                ]
            ]
        ];

        foreach ($templates as $name => $config) {
            $template = SectionTemplate::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $config['description'],
                    'icon' => $config['icon'],
                    'category' => $config['category'],
                    'is_active' => true
                ]
            );

            // Create fields for the template
            foreach ($config['fields'] as $index => $fieldConfig) {
                $fieldType = FieldType::where('component', $fieldConfig['type'])->first();
                
                if ($fieldType) {
                    $template->fields()->firstOrCreate(
                        ['alias' => $fieldConfig['alias']],
                        [
                            'field_type_id' => $fieldType->id,
                            'name' => $fieldConfig['name'],
                            'label' => $fieldConfig['name'],
                            'is_required' => $fieldConfig['required'] ?? false,
                            'sort_order' => $index + 1
                        ]
                    );
                }
            }
        }
    }

    /**
     * Set up storage directories
     */
    protected function setupStorage()
    {
        $directories = [
            'uploads',
            'uploads/images',
            'uploads/documents',
            'uploads/media',
            'uploads/thumbnails',
            'cache/cms'
        ];

        foreach ($directories as $directory) {
            $path = storage_path('app/public/' . $directory);
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        }

        // Create symbolic link if it doesn't exist
        if (!file_exists(public_path('storage'))) {
            $this->call('storage:link');
        }
    }

    /**
     * Publish assets (if we had any)
     */
    protected function publishAssets()
    {
        // Create necessary directories
        $publicDirectories = [
            'images/cms',
            'js/cms',
            'css/cms'
        ];

        foreach ($publicDirectories as $directory) {
            $path = public_path($directory);
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        }
    }

    /**
     * Seed sample data
     */
    protected function seedSampleData()
    {
        // This would create sample pages and sections
        // Simplified version for now
        $this->call('db:seed', ['--class' => 'CmsSampleDataSeeder']);
    }

    /**
     * Warm up caches
     */
    protected function warmCaches()
    {
        $this->call('cms:warm-cache');
    }

    /**
     * Display installation results
     */
    protected function displayInstallationResults()
    {
        $this->info('🎉 CMS Installation Completed Successfully!');
        $this->newLine();

        // Gather statistics
        $stats = [
            ['Component', 'Status', 'Count'],
            ['Field Types', '✅ Installed', FieldType::count()],
            ['Section Templates', '✅ Created', SectionTemplate::count()],
            ['Storage Directories', '✅ Created', 'Multiple'],
            ['Database Tables', '✅ Migrated', 'All']
        ];

        $this->table($stats[0], array_slice($stats, 1));

        $this->newLine();
        $this->info('🔧 Next Steps:');
        $this->line('1. Visit the admin panel to create your first section templates');
        $this->line('2. Create pages and add sections to them');
        $this->line('3. Upload media files through the media library');
        $this->line('4. Configure caching for optimal performance');

        $this->newLine();
        $this->info('📚 Useful Commands:');
        $this->line('• php artisan cms:clear-cache - Clear CMS caches');
        $this->line('• php artisan cms:warm-cache - Warm up caches');
        $this->line('• php artisan cms:seed-field-types - Re-seed field types');

        $this->newLine();
        $this->line('🌟 Happy content managing!');
    }
}
