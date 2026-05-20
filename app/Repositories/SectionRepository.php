<?php

namespace App\Repositories;

use App\Models\Attachment;
use App\Models\Section;
use App\Models\Page;
use Illuminate\Support\Facades\Cache;

class SectionRepository
{
    protected $cachePrefix = 'cms_section_';
    protected $cacheTtl = 3600; // 1 hour default

    /**
     * Render section content with parameters
     */
    public function render($parameters, $page = null)
    {
        return once(function () use ($parameters, $page) {
            $parameters = explode('.', $parameters);
            $sectionName = array_shift($parameters);
            
            $section = $this->findSection($sectionName, $page);
            if (!$section) return new Renderable(null);
            
            $value = $this->processSection($section, $parameters);
            return new Renderable($value);
        });
    }

    /**
     * Get all sections for a page in order with caching
     */
    public function getPageSections($pageId)
    {
        $cacheKey = $this->cachePrefix . 'page_sections_' . $pageId;
        
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($pageId) {
            return Page::with([
                'sections.template.fields.fieldType',
                'sections.data'
            ])->find($pageId)?->activeSections()->get() ?? collect();
        });
    }

    /**
     * Get section by name for specific page with caching
     */
    public function getSectionByName($sectionName, $pageId)
    {
        $cacheKey = $this->cachePrefix . 'section_' . $pageId . '_' . $sectionName;
        
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($sectionName, $pageId) {
            $page = Page::find($pageId);
            if (!$page) return null;
            
            return $page->activeSections()
                ->with(['template.fields.fieldType', 'data'])
                ->where('sections.alias', $sectionName)
                ->first();
        });
    }

    /**
     * Clear cache for specific page
     */
    public function clearPageCache($pageId)
    {
        $patterns = [
            $this->cachePrefix . 'page_sections_' . $pageId,
            $this->cachePrefix . 'section_' . $pageId . '_*',
            $this->cachePrefix . 'page_' . $pageId . '_*'
        ];
        
        foreach ($patterns as $pattern) {
            if (str_contains($pattern, '*')) {
                // Clear cache by pattern (Redis/Memcached)
                $this->clearCacheByPattern($pattern);
            } else {
                Cache::forget($pattern);
            }
        }
    }

    /**
     * Clear all section cache
     */
    public function clearAllCache()
    {
        $this->clearCacheByPattern($this->cachePrefix . '*');
    }

    /**
     * Legacy support - find section by name
     */
    private function find($name)
    {
        return once(function () use ($name) {
            return Section::content($name);
        });
    }

    /**
     * Find section with page context
     */
    private function findSection($sectionName, $page = null)
    {
        if ($page && is_numeric($page)) {
            return $this->getSectionByName($sectionName, $page);
        } elseif ($page && method_exists($page, 'id')) {
            return $this->getSectionByName($sectionName, $page->id);
        }
        
        // Fallback to legacy method for backward compatibility
        return $this->find($sectionName);
    }

    /**
     * Process section data with parameters
     */
    private function processSection($section, $parameters)
    {
        $value = $section;
        
        foreach ($parameters as $parameter) {
            if ($parameter === 'first') {
                $value = is_array($value) ? $value[0] : $value;
            } elseif (is_numeric($parameter)) {
                $value = $value[$parameter] ?? null;
            } elseif ($parameter === 'data' && $section && method_exists($section, 'getIsRepeaterAttribute') && $section->isRepeater) {
                $value = $this->processRepeaterData($section, $section->data);
            } else {
                $value = $value->{$parameter} ?? null;
            }
        }
        
        return $value;
    }

    /**
     * Process repeater section data
     */
    private function processRepeaterData($section, $data)
    {
        if (!$section->template) return collect();
        
        return $data->map(function ($item) use ($section) {
            $processed = [];
            
            foreach ($section->template->fields as $field) {
                $alias = $field->alias;
                $value = $item->data[$alias] ?? null;
                
                if ($field->fieldType->component === 'image' && $value) {
                    $processed[$alias] = $this->getCachedAttachment($value);
                } else {
                    $processed[$alias] = $value;
                }
            }
            
            return (object) $processed;
        });
    }

    /**
     * Cache individual attachments
     */
    private function getCachedAttachment($attachmentId)
    {
        $cacheKey = $this->cachePrefix . 'attachment_' . $attachmentId;
        
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($attachmentId) {
            return Attachment::find($attachmentId);
        });
    }

    /**
     * Clear cache by pattern
     */
    private function clearCacheByPattern($pattern)
    {
        if (Cache::getStore() instanceof \Illuminate\Cache\RedisStore) {
            $redis = Cache::getStore()->connection();
            $keys = $redis->keys($pattern);
            if (!empty($keys)) {
                $redis->del($keys);
            }
        }
        // For other cache drivers, we'd need to implement different logic
        // This is a simplified version for Redis
    }
}

class Renderable {
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Legacy methods for backward compatibility
     */
    public function asWhatItIs()
    {
        return $this->data;
    }

    public function asAttachment()
    {
        if (is_numeric($this->data)) {
            return Attachment::find($this->data);
        }
        return $this->data;
    }

    public function asString()
    {
        return $this->__toString();
    }

    public function __toString()
    {
        return (string) $this->data;
    }

    /**
     * New enhanced methods
     */
    public function asArray()
    {
        if (is_object($this->data) && method_exists($this->data, 'toArray')) {
            return $this->data->toArray();
        }
        return is_array($this->data) ? $this->data : [$this->data];
    }

    public function asCollection()
    {
        return collect($this->asArray());
    }

    public function isEmpty()
    {
        return empty($this->data);
    }

    public function isNotEmpty()
    {
        return !$this->isEmpty();
    }

    public function count()
    {
        if (is_countable($this->data)) {
            return count($this->data);
        }
        return $this->isEmpty() ? 0 : 1;
    }

    public function first()
    {
        if (is_array($this->data) && !empty($this->data)) {
            return $this->data[0];
        }
        if (is_object($this->data) && method_exists($this->data, 'first')) {
            return $this->data->first();
        }
        return $this->data;
    }

    public function get($key, $default = null)
    {
        if (is_array($this->data)) {
            return $this->data[$key] ?? $default;
        }
        if (is_object($this->data)) {
            return $this->data->{$key} ?? $default;
        }
        return $default;
    }

    public function pluck($key)
    {
        if (!is_array($this->data) && !is_object($this->data)) {
            return collect();
        }
        
        return collect($this->data)->pluck($key);
    }

    public function where($key, $value)
    {
        if (!is_array($this->data) && !is_object($this->data)) {
            return new static([]);
        }
        
        $filtered = collect($this->data)->where($key, $value);
        return new static($filtered->all());
    }
}
