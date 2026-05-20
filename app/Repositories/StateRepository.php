<?php

namespace App\Repositories;

use App\Models\State;
use File;

/**
 * Class StateRepository
 * @package App\Repositories
 * @author Richard Guevara
 */
class StateRepository
{
    /**
     * Get all instances
     *
     * @return App/Models/State;
     */
    public function getAll()
    {
        $items = State::get();
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
     * @return App/Models/State;
     */
    public function get($id)
    {
        $item = State::findOrFail($id);
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
     * @return App/Models/State;
     */
    public function getByCode($code)
    {
        $item = State::where('code', $code)->first();
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
     * @return App/Models/State;
     */
    public function getData($item)
    {
        if (!empty($item)) {
//            $item['cities'] = $item->cities()->get();
        }

        return $item;
    }
}