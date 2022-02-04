<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable =[
        'title',
        'content',
        'slug',
        'category_id'
    ];


    public static function generateSlug($text){
        $slug = Str::slug($text,'-');
        $old_slug = $slug;
        $count =1;
        
        $is_present = Post::where('slug',$slug)->first();
        while($is_present){
            $slug = $old_slug . '-' . $count++;
            $is_present = Post::where('slug',$slug)->first();
        }
        return $slug;
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }
}
