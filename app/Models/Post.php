<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $appends = ['image_url'];

    
    public $translatable = ['title','content'];


    function getImageUrlAttribute()
    {
        return $this->image ? url('/uploads/' . $this->image) : "";
    }
}