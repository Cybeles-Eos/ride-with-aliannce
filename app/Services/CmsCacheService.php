<?php

namespace App\Services;

use App\Models\Page;
use App\Models\Section;
use App\Models\SectionTemplate;
use App\Models\FieldType;
use App\Models\Attachment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CmsCacheService
{
    protected $cachePrefix = 'cms_';
    protected $defaultTtl = 3600; // 1 hour
    protected $longTtl = 86400; // 24 hours

    /**
     * Page-level caching with full relationships
     */
    public function getPageWithSections($pageId)
    {
        $cacheKey = $this->cachePrefix . 'page_full_' . $pageId;
        
        return Cache::remember($cacheKey, $this->defaultTtl, function () use ($pageId) {
            return Page::with([
                'sections.template.fields.fieldType',
                'sections.data',
                'seoMeta'
            ])->find($pageId);
        });
    }

    /**
     * Section template caching (long-term cache)
     */
    public function getSectionTemplate($templateId)
    {
        $cacheKey = $this->cachePrefix . 'template_' . $templateId;
        
        return Cache::remember($cacheKey, $this->longTtl, function () use ($templateId) {
            return SectionTemplate::with(['fields.fieldType'])->find($templateId);
        });
    }

    /**
     * Field type caching (very long-term cache)
     */
    public function getFieldType($fieldTypeId)
    {
        $cacheKey = $this->cachePrefix . 'field_type_' . $fieldTypeId;
        
        return Cache::remember($cacheKey, $this->longTtl, function () use ($fieldTypeId) {
            return FieldType::find($fieldTypeId);
        });
    }

    /**
     * All active field types (cached for form building)
     */
    public function getActiveFieldTypes()
    {
        $cacheKey = $this->cachePrefix . 'active_field_types';
        
        return Cache::remember($cacheKey, $this->longTtl, function () {
            return FieldType::active()->orderBy('name')->get();
        });
    }

    /**
     * Section data caching
     */
    public function getSectionData($sectionId, $pageId)
    {
        $cacheKey = $this->cachePrefix . 'section_data_' . $sectionId . '_' . $pageId;
        
        return Cache::remember($cacheKey, $this->defaultTtl, function () use ($sectionId, $pageId) {
            return Section::with(['template.fields.fieldType', 'data'])
                ->where('id', $sectionId)
                ->whereHas('pages', function($q) use ($pageId) {
                    $q->where('pages.id', $pageId);
                })
                ->first();
        });
    }

    /**
     * Attachment caching with metadata
     */
    public function getAttachment($attachmentId)
    {
        $cacheKey = $this->cachePrefix . 'attachment_' . $attachmentId;
        
        return Cache::remember($cacheKey, $this->defaultTtl, function () use ($attachmentId) {
            return Attachment::find($attachmentId);
        });
    }

    /**
     * Cache page sections for frontend rendering
     */
    public function getPageSectionsForRendering($pageId)
    {
        $cacheKey = $this->cachePrefix . 'page_render_' . $pageId;
        
        return Cache::remember($cacheKey, $this->defaultTtl, function () use ($pageId) {
            $page = Page::with([
                'sections' => function($query) {
                    $query->where('page_section_order.is_active', true)
                          ->orderBy('page_section_order.sort_order');
                },
                'sections.template.fields' => function($query) {
                    $query->orderBy('sort_order');
                },
                'sections.template.fields.fieldType',
                'sections.data' => function($query) {
                    $query->orderBy('sort_order');
                }
            ])->find($pageId);
            
            return $page ? $page->sections : collect();
        });
    }

    /**
     * Cache navigation/menu data
     */
    public function getNavigationPages()
    {
        $cacheKey = $this->cachePrefix . 'navigation_pages';
        
        return Cache::remember($cacheKey, $this->longTtl, function () {
            return Page::where('is_active', true)
                ->select('id', 'name', 'slug')
                ->orderBy('name')
                ->get();
        });
    }

    /**
     * Cache system statistics
     */
    public function getSystemStats()
    {
        $cacheKey = $this->cachePrefix . 'system_stats';
        
        return Cache::remember($cacheKey, 1800, function () { // 30 minutes
            return [
                'total_pages' => Page::count(),
                'active_pages' => Page::where('is_active', true)->count(),
                'total_sections' => Section::count(),
                'active_sections' => Section::where('is_active', true)->count(),
                'total_templates' => SectionTemplate::count(),
                'active_templates' => SectionTemplate::where('is_active', true)->count(),
                'total_attachments' => Attachment::count(),
                'recent_pages' => Page::where('updated_at', '>=', now()->subDays(7))->count(),
                'storage_used' => Attachment::sum('size'),
            ];
        });
    }

    /**
     * Clear all CMS caches
     */
    public function clearAllCaches()
    {
        $patterns = [
            $this->cachePrefix . 'page_*',
            $this->cachePrefix . 'section_*',
            $this->cachePrefix . 'template_*',
            $this->cachePrefix . 'attachment_*',
            $this->cachePrefix . 'field_type_*',
            $this->cachePrefix . 'navigation_*',
            $this->cachePrefix . 'system_*'
        ];
        
        foreach ($patterns as $pattern) {
            $this->clearCacheByPattern($pattern);
        }
        
        return true;
    }

    /**
     * Clear page-specific caches
     */
    public function clearPageCaches($pageId)
    {
        $patterns = [
            $this->cachePrefix . 'page_full_' . $pageId,
            $this->cachePrefix . 'page_sections_' . $pageId,
            $this->cachePrefix . 'page_render_' . $pageId,
            $this->cachePrefix . 'section_' . $pageId . '_*',
            $this->cachePrefix . 'section_data_*_' . $pageId
        ];
        
        foreach ($patterns as $pattern) {
            if (str_contains($pattern, '*')) {
                $this->clearCacheByPattern($pattern);
            } else {
                Cache::forget($pattern);
            }
        }
        
        // Also clear navigation cache as page might be in menu
        Cache::forget($this->cachePrefix . 'navigation_pages');
    }

    /**
     * Clear section-specific caches
     */
    public function clearSectionCaches($sectionId)
    {
        $patterns = [
            $this->cachePrefix . 'section_data_' . $sectionId . '_*',
            $this->cachePrefix . 'page_render_*',
            $this->cachePrefix . 'page_sections_*'
        ];
        
        foreach ($patterns as $pattern) {
            $this->clearCacheByPattern($pattern);
        }
    }

    /**
     * Clear template-specific caches
     */
    public function clearTemplateCaches($templateId)
    {
        Cache::forget($this->cachePrefix . 'template_' . $templateId);
        
        // Clear all sections using this template
        $sections = Section::where('section_template_id', $templateId)->get();
        foreach ($sections as $section) {
            $this->clearSectionCaches($section->id);
        }
    }

    /**
     * Clear field type caches
     */
    public function clearFieldTypeCaches($fieldTypeId = null)
    {
        if ($fieldTypeId) {
            Cache::forget($this->cachePrefix . 'field_type_' . $fieldTypeId);
        }
        
        Cache::forget($this->cachePrefix . 'active_field_types');
        
        // Clear all templates as field types affect rendering
        $this->clearCacheByPattern($this->cachePrefix . 'template_*');
    }

    /**
     * Clear attachment caches
     */
    public function clearAttachmentCaches($attachmentId)
    {
        Cache::forget($this->cachePrefix . 'attachment_' . $attachmentId);
        
        // Clear all page renders as attachment might be used anywhere
        $this->clearCacheByPattern($this->cachePrefix . 'page_render_*');
    }

    /**
     * Warm up essential caches
     */
    public function warmUpCaches()
    {
        // Warm navigation
        $this->getNavigationPages();
        
        // Warm active field types
        $this->getActiveFieldTypes();
        
        // Warm system stats
        $this->getSystemStats();
        
        // Warm active pages
        $activePages = Page::where('is_active', true)->pluck('id');
        foreach ($activePages as $pageId) {
            $this->getPageWithSections($pageId);
            $this->getPageSectionsForRendering($pageId);
        }
        
        // Warm active templates
        $templates = SectionTemplate::where('is_active', true)->pluck('id');
        foreach ($templates as $templateId) {
            $this->getSectionTemplate($templateId);
        }
        
        return [
            'pages_warmed' => $activePages->count(),
            'templates_warmed' => $templates->count(),
            'navigation_warmed' => true,
            'field_types_warmed' => true,
            'system_stats_warmed' => true
        ];
    }

    /**
     * Get cache statistics
     */
    public function getCacheStats()
    {
        $stats = [
            'total_keys' => 0,
            'cache_size' => 0,
            'hit_ratio' => 0,
            'cms_keys' => 0
        ];
        
        try {
            if (Cache::getStore() instanceof \Illuminate\Cache\RedisStore) {
                $redis = Cache::getStore()->connection();
                
                // Get all keys
                $allKeys = $redis->keys('*');
                $stats['total_keys'] = count($allKeys);
                
                // Get CMS keys
                $cmsKeys = $redis->keys($this->cachePrefix . '*');
                $stats['cms_keys'] = count($cmsKeys);
                
                // Get memory info
                $info = $redis->info('memory');
                if (isset($info['used_memory'])) {
                    $stats['cache_size'] = $info['used_memory'];
                }
                
                // Get stats info
                $statsInfo = $redis->info('stats');
                if (isset($statsInfo['keyspace_hits']) && isset($statsInfo['keyspace_misses'])) {
                    $hits = $statsInfo['keyspace_hits'];
                    $misses = $statsInfo['keyspace_misses'];
                    $total = $hits + $misses;
                    $stats['hit_ratio'] = $total > 0 ? round(($hits / $total) * 100, 2) : 0;
                }
            }
        } catch (\Exception $e) {
            // Fallback for non-Redis stores
            $stats['error'] = 'Could not retrieve cache statistics: ' . $e->getMessage();
        }
        
        return $stats;
    }

    /**
     * Clear cache by pattern (Redis specific)
     */
    private function clearCacheByPattern($pattern)
    {
        try {
            if (Cache::getStore() instanceof \Illuminate\Cache\RedisStore) {
                $redis = Cache::getStore()->connection();
                $keys = $redis->keys($pattern);
                if (!empty($keys)) {
                    $redis->del($keys);
                }
            }
        } catch (\Exception $e) {
            // Fallback: try to clear known specific keys
            \Log::warning('Cache pattern clear failed: ' . $e->getMessage());
        }
    }

    /**
     * Schedule automatic cache warming
     */
    public function scheduleWarmUp()
    {
        // This would be called from a scheduled job
        return $this->warmUpCaches();
    }

    /**
     * Get cache key for debugging
     */
    public function getCacheKey($type, ...$params)
    {
        switch ($type) {
            case 'page':
                return $this->cachePrefix . 'page_full_' . $params[0];
            case 'page_sections':
                return $this->cachePrefix . 'page_sections_' . $params[0];
            case 'page_render':
                return $this->cachePrefix . 'page_render_' . $params[0];
            case 'section_data':
                return $this->cachePrefix . 'section_data_' . $params[0] . '_' . $params[1];
            case 'template':
                return $this->cachePrefix . 'template_' . $params[0];
            case 'attachment':
                return $this->cachePrefix . 'attachment_' . $params[0];
            default:
                return $this->cachePrefix . $type;
        }
    }
}
