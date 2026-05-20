<?php

namespace App\Repositories;

use App\Models\SeoMeta;

/**
 * Class SeoMetaRepository
 * @package App\Repositories
 * @author Richard Guevara
 */
class SeoMetaRepository
{
    /**
     * Get single instance
     *
     * @param  $id
     *
     * @return App/Models/SeoMeta;
     */
    public function get($id)
    {
        $item = SeoMeta::findOrFail($id);
        return $item;
    }

    /**
     * Get max position and add one
     *
     * @param  int $parent_id
     *
     * @return mixed;
     */
    public function getMaxPosition($parent_id = 0)
    {
        $max_position = 1;
        $item_position = SeoMeta::where('parent_id', $parent_id)->max('position');
        if ($item_position) {
            $max_position = $item_position + 1;
        }
        return $max_position;
    }

    /**
     * Save seo meta
     *
     * @param  $input
     *
     * @return App/Models/SeoMeta;
     */
    public function updateOrCreate($input)
    {
        $item = SeoMeta::updateOrCreate(['id'=>$input['seo_meta_id']],$input);
        return $item;
    }

}