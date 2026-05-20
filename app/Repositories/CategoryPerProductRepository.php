<?php

namespace App\Repositories;

use App\Models\CategoryPerProductRepository;
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
     * @return App/Models/CategoryPerProductRepository;
     */
    public function getById($id)
    {
        $item = CategoryPerProductRepository::findOrFail($id);
        if (!empty($item)) {
            $item = $this->getData($item);
        }
        return $item;
    }

    /**
     * Get all instance
     *
     * @return App/Models/CategoryPerProductRepository;
     */
    public function getAll()
    {
        $items = CategoryPerProductRepository::get();
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
     * @return \App\Models\CategoryPerProductRepository;
     */
    public function getData($item)
    {
        if (!empty($item)) {

        }

        return $item;
    }
}