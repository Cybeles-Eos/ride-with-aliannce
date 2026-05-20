<?php

namespace App\Repositories;

use App\Models\City;
use File;

/**
 * Class CityRepository
 * @package App\Repositories
 * @author Richard Guevara
 */
class CityRepository
{
    /**
     * Get all instances
     *
     * @return App/Models/City;
     */
    public function getAll()
    {
        $items = City::get();
//        City::chunk(200, function( $entries ) {
//            foreach( $entries as $entry ) {
//                $item = $this->getData($entry);
//                $items[] = $item;
//            }
//        });

//        $pdo = \DB::connection()->getPdo();
//        $query = "SELECT * FROM cities WHERE 1";
//        $stmt = $pdo->prepare($query);
//        $stmt->execute();
//
//        while ($row = $stmt->fetchObject()) {
//            $items[] = $row;
//        }

//        foreach ($items as $item) {
//            $item = $this->getData($item);
//        }
        return $items;
    }

    /**
     * Get single instance
     *
     * @param  $id
     *
     * @return App/Models/City;
     */
    public function get($id)
    {
        $item = City::findOrFail($id);
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
     * @return App/Models/City;
     */
    public function getByCode($code)
    {
        $item = City::where('code', $code)->first();
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
     * @return App/Models/City;
     */
    public function getData($item)
    {
        if (!empty($item)) {
//            $item['cities'] = $item->cities()->get();
        }

        return $item;
    }
}