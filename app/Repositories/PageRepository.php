<?php

namespace App\Repositories;

use App\Models\Page;
use File;

/**
 * Class PageRepository
 * @package App\Repositories
 * @author Richard Guevara
 */
class PageRepository
{
    /**
     * Get single instance
     *
     * @param  $id
     *
     * @return App/Models/Page;
     */
    public function get($id)
    {
        $item = Page::findOrFail($id);
        return $item;
    }

    /**
     * Get all active pages
     *
     * @return \App\Models\Page Collection;
     */
    public function getAllActivePages()
    {
        $items = Page::where('is_active', 1)->get();
        return $items;
    }

    /**
     * Get active page by id
     *
     * @param  $id
     *
     * @return App/Models/Page;
     */
    public function getActivePage($id)
    {
        $item = Page::where('is_active', 1)->findOrFail($id);
        return $item;
    }

    /**
     * Get active page by slug
     *
     * @param  $slug
     *
     * @return App/Models/Page;
     */
    public function getActivePageBySlug($slug)
    {
        $item = Page::where('slug', $slug)->where('is_active', 1)->first();
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
        $file_path = '/uploads/banner_images';
        $directory = public_path() . $file_path;

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0775);
        }

        $file->move($directory, $file_name);
        $file_upload_path = 'public' . $file_path . '/' . $file_name;
        return $file_upload_path;
    }

    /**
     * Upload and move file to directory
     *
     * @return string $file_upload_path;
     */
    public function uploadFilePageSection($file)
    {
        $extension = $file->getClientOriginalExtension();
        $file_name = substr((pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)), 0, 30) . '-' . time() . '.' . $extension;
        $file_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', $file_name);
        $file_path = '/uploads/page_section_images';
        $directory = public_path() . $file_path;

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0775);
        }

        $file->move($directory, $file_name);
        $file_upload_path = 'public' . $file_path . '/' . $file_name;
        return $file_upload_path;
    }
}