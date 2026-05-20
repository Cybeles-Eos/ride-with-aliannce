<?php

namespace App\Console\Commands;

use App\Services\CmsCacheService;
use Illuminate\Console\Command;

class ClearCmsCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:clear-cache 
                            {--page= : Clear cache for specific page ID}
                            {--section= : Clear cache for specific section ID}
                            {--template= : Clear cache for specific template ID}
                            {--attachment= : Clear cache for specific attachment ID}
                            {--field-type= : Clear cache for specific field type ID}
                            {--stats : Show cache statistics}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear CMS caches with optional specific targeting';

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
        $this->info('🧹 CMS Cache Management');
        $this->newLine();

        // Show cache statistics first if requested
        if ($this->option('stats')) {
            $this->displayCacheStats();
            $this->newLine();
        }

        $cleared = false;

        // Clear specific page cache
        if ($pageId = $this->option('page')) {
            $this->info("Clearing cache for page ID: {$pageId}");
            $this->cacheService->clearPageCaches($pageId);
            $this->line("✅ Page {$pageId} cache cleared");
            $cleared = true;
        }

        // Clear specific section cache
        if ($sectionId = $this->option('section')) {
            $this->info("Clearing cache for section ID: {$sectionId}");
            $this->cacheService->clearSectionCaches($sectionId);
            $this->line("✅ Section {$sectionId} cache cleared");
            $cleared = true;
        }

        // Clear specific template cache
        if ($templateId = $this->option('template')) {
            $this->info("Clearing cache for template ID: {$templateId}");
            $this->cacheService->clearTemplateCaches($templateId);
            $this->line("✅ Template {$templateId} cache cleared");
            $cleared = true;
        }

        // Clear specific attachment cache
        if ($attachmentId = $this->option('attachment')) {
            $this->info("Clearing cache for attachment ID: {$attachmentId}");
            $this->cacheService->clearAttachmentCaches($attachmentId);
            $this->line("✅ Attachment {$attachmentId} cache cleared");
            $cleared = true;
        }

        // Clear specific field type cache
        if ($fieldTypeId = $this->option('field-type')) {
            $this->info("Clearing cache for field type ID: {$fieldTypeId}");
            $this->cacheService->clearFieldTypeCaches($fieldTypeId);
            $this->line("✅ Field type {$fieldTypeId} cache cleared");
            $cleared = true;
        }

        // If no specific options were provided, clear all caches
        if (!$cleared) {
            if ($this->confirm('Clear ALL CMS caches?', true)) {
                $this->info('Clearing all CMS caches...');
                
                $this->withProgressBar([
                    'Pages' => fn() => $this->clearWithMessage('page caches'),
                    'Sections' => fn() => $this->clearWithMessage('section caches'), 
                    'Templates' => fn() => $this->clearWithMessage('template caches'),
                    'Attachments' => fn() => $this->clearWithMessage('attachment caches'),
                    'Field Types' => fn() => $this->clearWithMessage('field type caches'),
                    'Navigation' => fn() => $this->clearWithMessage('navigation caches'),
                    'System Stats' => fn() => $this->clearWithMessage('system caches')
                ], function ($callback, $type) {
                    $callback();
                    usleep(100000); // Small delay for visual effect
                });

                $this->newLine(2);
                $this->cacheService->clearAllCaches();
                $this->line('✅ All CMS caches cleared successfully!');
            } else {
                $this->line('Cache clearing cancelled.');
                return 0;
            }
        }

        // Show final cache statistics if requested
        if ($this->option('stats')) {
            $this->newLine();
            $this->info('📊 Updated Cache Statistics:');
            $this->displayCacheStats();
        }

        $this->newLine();
        $this->line('🎉 Cache management completed!');

        return 0;
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
     * Clear with message helper
     */
    protected function clearWithMessage($type)
    {
        // This is just for the progress bar visual effect
        return true;
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
