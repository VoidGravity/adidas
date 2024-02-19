<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Routing\Route;
use App\Models\Route;


class role extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'permissions',
    // ];
    protected $fillable = ['name'];
    
    // public function routes()
    // {
    //     return $this->belongsToMany(Route::class, 'role_permissions', 'role_id', 'permission_id');
    // }
    public function routes()
    {
        return $this->belongsToMany(Route::class, 'role_permissions', 'role_id', 'route_id')
                    ->withPivot('active');
    }
    

    
    
}
