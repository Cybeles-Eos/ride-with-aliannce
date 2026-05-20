<?php

namespace App\Repositories;

use App\Models\CouponCode;
use File;

/**
 * Class CouponCodeRepository
 * @package App\Repositories
 * @author Richard Guevara
 */
class CouponCodeRepository
{
    /**
     * Get single instance
     *
     * @param  $id
     *
     * @return App/Models/CouponCode;
     */
    public function getById($id)
    {
        $item = CouponCode::findOrFail($id);
        if (!empty($item)) {
            $item = $this->getData($item);
        }
        return $item;
    }

    /**
     * Get single instance
     *
     * @param  $slug
     *
     * @return App/Models/CouponCode;
     */
    public function getActiveBySlug($slug)
    {
        $item = CouponCode::where('is_active', 1)->where('slug', $slug)->first();
        if (!empty($item)) {
            $item = $this->getData($item);
        }
        return $item;
    }

    /**
     * Get all instance
     *
     * @return App/Models/CouponCode;
     */
    public function getAll()
    {
        $items = CouponCode::get();
        foreach ($items as $item) {
            $item = $this->getData($item);
        }
        return $items;
    }

    /**
     * Get all instance
     *
     * @return App/Models/CouponCode;
     */
    public function getAllActive()
    {
        $items = CouponCode::where('is_active', 1)->get();
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
     * @return \App\Models\CouponCode;
     */
    public function getData($item)
    {
        if (!empty($item)) {

        }

        return $item;
    }

    /**
     * Upload and move file to directory
     *
     * @param $file
     * @param $type
     * @param $path
     *
     * @return string $file_upload_path;
     */
    public function uploadFile($file, $type = null, $path)
    {
        $extension = $file->getClientOriginalExtension();
        $file_name = substr((pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)), 0, 30) . '-' . time() . ($type ? '-' . $type : '') . '.' . $extension;
        $file_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', $file_name);
        $file_path = '/uploads/' . $path;
        $directory = public_path() . $file_path;

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0777);
        }

        $file->move($directory, $file_name);
        $file_upload_path = 'public' . $file_path . '/' . $file_name;
        return $file_upload_path;
    }
}