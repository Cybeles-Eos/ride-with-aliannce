<?php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;
use App\Models\PermissionGroup;

/**
 * Class PermissionRepository
 * @package App\Repositories
 * @author Richard Guevara
 */
class PermissionRepository
{
    /**
     * Get by permission groups with corresponding permissions
     *
     * @return \Spatie\Permission\Models\Permission Collection;
     */
    public function getAllWithPermissionGroup()
    {
        $items = Permission::get();
        foreach ($items as $item) {
            $item['permission_group'] = PermissionGroup::findOrFail($item->permission_group_id);
        }

        return $items;
    }

    /**
     * Get single instance
     *
     * @param  $id
     *
     * @return \Spatie\Permission\Models\Permission;
     */
    public function get($id)
    {
        $item = Permission::findOrFail($id);
        return $item;
    }
}