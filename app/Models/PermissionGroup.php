<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PermissionGroup
 * @package App\Models
 * @author Richard Guevara
 */
class PermissionGroup extends Model
{
    use SoftDeletes;

    protected $table = 'permission_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function permissions () {
        return $this->hasMany('Spatie\Permission\Models\Permission', 'permission_group_id');

    }
}