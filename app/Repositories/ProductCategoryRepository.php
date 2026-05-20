<?php

namespace App\Repositories;

use App\Models\ProductCategory;
use File;

/**
 * Class ProductCategoryRepository
 * @package App\Repositories
 * @author Richard Guevara
 */
class ProductCategoryRepository
{
    /**
     * Get single instance
     *
     * @param  $id
     *
     * @return App/Models/ProductCategory;
     */
    public function getById($id)
    {
        $item = ProductCategory::findOrFail($id);
        if (!empty($item)) {
            $item = $this->getData($item);
        }
        return $item;
    }

    /**
     * Get all instance
     *
     * @return App/Models/ProductCategory;
     */
    public function getAll()
    {
        $items = ProductCategory::get();
        foreach ($items as $item) {
            $item = $this->getData($item);
        }
        return $items;
    }

    /**
     * Get data
     *
     * @param  $item
     *
     * @return \App\Models\ProductCategory;
     */
    public function getData($item)
    {
        if (!empty($item)) {

        }

        return $item;
    }
}