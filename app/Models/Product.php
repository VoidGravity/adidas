<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        /*
        $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('price');
            $table->string('image_path');
            $table->string('tags');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        */
        'name', 'description', 'price', 'image_path', 'tags' , 'category_id'
        
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
