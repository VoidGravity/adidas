<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class route extends Model
{
    use HasFactory;
    protected $fillable = ['route'];
    // protected $fillable = [
    //     'name', 'route'
    // ];
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions', 'route_id', 'permission_id');
    }
}
