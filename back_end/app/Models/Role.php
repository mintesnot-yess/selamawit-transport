<?php

namespace App\Models;

use Laratrust\Models\Role as RoleModel;

class Role extends RoleModel
{
    public $guarded = [
        'id',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'


    ];
}
