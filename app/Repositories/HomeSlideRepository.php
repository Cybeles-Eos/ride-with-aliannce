<?php

namespace App\Repositories;

use App\Models\HomeSlide;
use File;

/**
 * Class HomeSlideRepository
 * @package App\Repositories
 * @author Richard Guevara
 */
class HomeSlideRepository
{
    /**
     * Get single instance
     *
     * @param  $id
     *
     * @return App/Models/HomeSlide;
     */
    public function getById($id)
    {
        $item = HomeSlide::findOrFail($id);
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
     * @return App/Models/HomeSlide;
     */
    public function getActiveBySlug($slug)
    {
        $item = HomeSlide::where('is_active', 1)->where('slug', $slug)->first();
        if (!empty($item)) {
            $item = $this->getData($item);
        }
        return $item;
    }

    /**
     * Get all instance
     *
     * @return App/Models/HomeSlide;
     */
    public function getAll()
    {
        $items = HomeSlide::get();
        foreach ($items as $item) {
            $item = $this->getData($item);
        }
        return $items;
    }

    /**
     * Get all instance
     *
     * @return App/Models/HomeSlide;
     */
    public function getAllActive()
    {
        $items = HomeSlide::where('is_active', 1)->get();
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
     * @return \App\Models\HomeSlide;
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
     * @return string $file_upload_path;
     */
    public function uploadFile($file)
    {
        $extension = $file->getClientOriginalExtension();
        $file_name = substr((pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)), 0, 30) . '-' . time() . '.' . $extension;
        $file_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', $file_name);
        $file_path = '/uploads/home_slide_images';
        $directory = public_path() . $file_path;

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0777);
        }

        $file->move($directory, $file_name);
        $file_upload_path = 'public' . $file_path . '/' . $file_name;
        return $file_upload_path;
    }
}