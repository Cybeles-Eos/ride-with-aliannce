<?php

namespace App\Console\Commands;

use App\Services\CmsCacheService;
use App\Models\Page;
use App\Models\SectionTemplate;
use App\Models\FieldType;
use Illuminate\Console\Command;

class WarmCmsCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:warm-cache 
                            {--pages : Only warm page caches}
                            {--templates : Only warm template caches}
                            {--field-types : Only warm field type caches}
                            {--navigation : Only warm navigation caches}
                            {--system : Only warm system caches}
                            {--stats : Show cache statistics after warming}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warm up CMS caches for better performance';

    protected $cacheService;

    /**
     * Create a new command instance.
     *
     * @param CmsCacheService $cacheService
     */
    public function __construct(CmsCacheService $cacheService)
    {
        parent::__construct();
        $this->cacheService = $cacheService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🔥 CMS Cache Warming');
        $this->newLine();

        $warmed = [];
        $hasSpecificOptions = $this->option('pages') || $this->option('templates') || 
                             $this->option('field-types') || $this->option('navigation') || 
                             $this->option('system');

        // Warm specific caches if options provided
        if ($this->option('pages') || !$hasSpecificOptions) {
            $warmed['pages'] = $this->warmPageCaches();
        }

        if ($this->option('templates') || !$hasSpecificOptions) {
            $warmed['templates'] = $this->warmTemplateCaches();
        }

        if ($this->option('field-types') || !$hasSpecificOptions) {
            $warmed['field_types'] = $this->warmFieldTypeCaches();
        }

        if ($this->option('navigation') || !$hasSpecificOptions) {
            $warmed['navigation'] = $this->warmNavigationCaches();
        }

        if ($this->option('system') || !$hasSpecificOptions) {
            $warmed['system'] = $this->warmSystemCaches();
        }

        // If no specific options, warm everything
        if (!$hasSpecificOptions) {
            $this->info('Warming all CMS caches...');
            $results = $this->cacheService->warmUpCaches();
            $this->displayResults($results);
        } else {
            $this->displaySpecificResults($warmed);
        }

        // Show cache statistics if requested
        if ($this->option('stats')) {
            $this->newLine();
            $this->info('📊 Cache Statistics After Warming:');
            $this->displayCacheStats();
        }

        $this->newLine();
        $this->line('🎉 Cache warming completed!');

        return 0;
    }

    /**
     * Warm page caches
     */
    protected function warmPageCaches()
    {
        $this->info('🔥 Warming page caches...');
        
        $pages = Page::where('is_active', true)->get();
        
        $progressBar = $this->output->createProgressBar($pages->count());
        $progressBar->setFormat('verbose');
        
        $warmed = 0;
        foreach ($pages as $page) {
            try {
                // Warm full page cache
                $this->cacheService->getPageWithSections($page->id);
                
                // Warm page sections for rendering
                $this->cacheService->getPageSectionsForRendering($page->id);
                
                $warmed++;
            } catch (\Exception $e) {
                $this->warn("Failed to warm cache for page {$page->id}: " . $e->getMessage());
            }
            
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->newLine();
        $this->line("✅ Warmed {$warmed}/{$pages->count()} page caches");
        
        return $warmed;
    }

    /**
     * Warm template caches
     */
    protected function warmTemplateCaches()
    {
        $this->info('🔥 Warming template caches...');
        
        $templates = SectionTemplate::where('is_active', true)->get();
        
        $progressBar = $this->output->createProgressBar($templates->count());
        $progressBar->setFormat('verbose');
        
        $warmed = 0;
        foreach ($templates as $template) {
            try {
                $this->cacheService->getSectionTemplate($template->id);
                $warmed++;
            } catch (\Exception $e) {
                $this->warn("Failed to warm cache for template {$template->id}: " . $e->getMessage());
            }
            
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->newLine();
        $this->line("✅ Warmed {$warmed}/{$templates->count()} template caches");
        
        return $warmed;
    }

    /**
     * Warm field type caches
     */
    protected function warmFieldTypeCaches()
    {
        $this->info('🔥 Warming field type caches...');
        
        try {
            // Warm active field types
            $fieldTypes = $this->cacheService->getActiveFieldTypes();
            
            // Warm individual field type caches
            foreach ($fieldTypes as $fieldType) {
                $this->cacheService->getFieldType($fieldType->id);
            }
            
            $this->line("✅ Warmed {$fieldTypes->count()} field type caches");
            return $fieldTypes->count();
            
        } catch (\Exception $e) {
            $this->error("Failed to warm field type caches: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Warm navigation caches
     */
    protected function warmNavigationCaches()
    {
        $this->info('🔥 Warming navigation caches...');
        
        try {
            $pages = $this->cacheService->getNavigationPages();
            $this->line("✅ Warmed navigation cache with {$pages->count()} pages");
            return 1;
        } catch (\Exception $e) {
            $this->error("Failed to warm navigation caches: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Warm system caches
     */
    protected function warmSystemCaches()
    {
        $this->info('🔥 Warming system caches...');
        
        try {
            $stats = $this->cacheService->getSystemStats();
            $this->line("✅ Warmed system statistics cache");
            return 1;
        } catch (\Exception $e) {
            $this->error("Failed to warm system caches: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Display comprehensive results
     */
    protected function displayResults($results)
    {
        $this->newLine();
        $this->info('🎯 Cache Warming Results:');
        
        $this->table(
            ['Cache Type', 'Items Warmed', 'Status'],
            [
                ['Pages', $results['pages_warmed'] ?? 0, '✅ Complete'],
                ['Templates', $results['templates_warmed'] ?? 0, '✅ Complete'],
                ['Field Types', $results['field_types_warmed'] ? 'All' : 'None', $results['field_types_warmed'] ? '✅ Complete' : '❌ Failed'],
                ['Navigation', $results['navigation_warmed'] ? 'Complete' : 'Failed', $results['navigation_warmed'] ? '✅ Complete' : '❌ Failed'],
                ['System Stats', $results['system_stats_warmed'] ? 'Complete' : 'Failed', $results['system_stats_warmed'] ? '✅ Complete' : '❌ Failed'],
            ]
        );
    }

    /**
     * Display specific results
     */
    protected function displaySpecificResults($warmed)
    {
        $this->newLine();
        $this->info('🎯 Specific Cache Warming Results:');
        
        $rows = [];
        foreach ($warmed as $type => $count) {
            $rows[] = [ucfirst(str_replace('_', ' ', $type)), $count, '✅ Complete'];
        }
        
        $this->table(['Cache Type', 'Items Warmed', 'Status'], $rows);
    }

    /**
     * Display cache statistics
     */
    protected function displayCacheStats()
    {
        $stats = $this->cacheService->getCacheStats();
        
        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Cache Keys', number_format($stats['total_keys'])],
                ['CMS Cache Keys', number_format($stats['cms_keys'])],
                ['Hit Ratio', $stats['hit_ratio'] . '%'],
                ['Cache Size', $this->formatBytes($stats['cache_size'])],
            ]
        );

        if (isset($stats['error'])) {
            $this->warn($stats['error']);
        }
    }

    /**
     * Format bytes to human readable format
     */
    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
