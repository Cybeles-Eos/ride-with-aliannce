<?php

namespace App\Repositories;

use App\Models\Country;
use File;

/**
 * Class CountryRepository
 * @package App\Repositories
 * @author Richard Guevara
 */
class CountryRepository
{
    /**
     * Get all instances
     *
     * @return App/Models/Country;
     */
    public function getAll()
    {
        $items = Country::get();
        foreach ($items as $item) {
            $item = $this->getData($item);
        }
        return $items;
    }

    /**
     * Get single instance
     *
     * @param  $id
     *
     * @return App/Models/Country;
     */
    public function get($id)
    {
        $item = Country::findOrFail($id);
        if (!empty($item)) {
            $item = $this->getData($item);
        }
        return $item;
    }

    /**
     * Get single instance
     *
     * @param  $code
     *
     * @return App/Models/Country;
     */
    public function getByCode($code)
    {
        $item = Country::where('code', $code)->first();
        if (!empty($item)) {
            $item = $this->getData($item);
        }
        return $item;
    }

    /**
     * Get data
     *
     * @param  $item
     *
     * @return App/Models/Country;
     */
    public function getData($item)
    {
        if (!empty($item)) {
//            $item['states'] = $item->states()->get();
        }

        return $item;
    }
}