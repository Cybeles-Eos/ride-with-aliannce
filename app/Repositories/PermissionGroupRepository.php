<?php

namespace App\Repositories;

use App\Models\PermissionGroup;

/**
 * Class PermissionGroupRepository
 * @package App\Repositories
 * @author Richard Guevara
 */
class PermissionGroupRepository
{
    /**
     * Get by permission groups with corresponding permissions
     *
     * @return App/Models/PermissionGroup Collection;
     */
    public function getAllWithPermissions()
    {
        $items = PermissionGroup::get();
        foreach ($items as $item) {
            $item['permissions'] = $item->permissions()->get();
        }

        return $items;
    }

    /**
     * Get single instance
     *
     * @param  $id
     *
     * @return App/Models/PermissionGroup;
     */
    public function get($id)
    {
        $item = PermissionGroup::findOrFail($id);
        return $item;
    }

    /**
     * Get all instance
     *
     * @return App/Models/PermissionGroup;
     */
    public function getAll()
    {
        $item = PermissionGroup::get();
        return $item;
    }
}