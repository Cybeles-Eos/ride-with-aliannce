<?php

namespace App\Repositories;

use App\Models\Order;
use File;

/**
 * Class OrderRepository
 * @package App\Repositories
 * @author Richard Guevara
 */
class OrderRepository
{
    /**
     * Get single instance
     *
     * @param  $id
     *
     * @return App/Models/Order;
     */
    public function getById($id)
    {
        $item = Order::findOrFail($id);
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
     * @return App/Models/Order;
     */
    public function getActiveBySlug($slug)
    {
        $item = Order::where('is_active', 1)->where('slug', $slug)->first();
        if (!empty($item)) {
            $item = $this->getData($item);
        }
        return $item;
    }

    /**
     * Get all instance
     *
     * @return App/Models/Order;
     */
    public function getAll()
    {
        $items = Order::get();
        foreach ($items as $item) {
            $item = $this->getData($item);
        }
        return $items;
    }

    /**
     * Get all instance
     *
     * @return App/Models/Order;
     */
    public function getAllActive()
    {
        $items = Order::where('is_active', 1)->get();
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
     * @return \App\Models\Order;
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
        $file_path = '/uploads/order_images';
        $directory = public_path() . $file_path;

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0777);
        }

        $file->move($directory, $file_name);
        $file_upload_path = 'public' . $file_path . '/' . $file_name;
        return $file_upload_path;
    }

    /**
     * Get single instance
     *
     * @return App/Models/Order;
     */
    public function getAllOrdersByUser()
    {
        if (auth()->check()) {
            $items = Order::where('user_id', auth()->user()->id)->get();
        } else {
            $items = Order::where('session_id', session()->getId())->get();
        }

        if (!empty($items)) {
            foreach ($items as $item) {

            }
        }

        return $items;
    }

    public function getUserOrderByReferenceNo($ref_no)
    {
        if (auth()->check()) {
            $item = Order::where('reference_no', $ref_no)->where('user_id', auth()->user()->id)->first();
        } else {
            $item = Order::where('reference_no', $ref_no)->where('session_id', session()->getId())->first();
        }

        if (!empty($item)) {
            $item = $this->getData($item);
        }
        return $item;
    }
}