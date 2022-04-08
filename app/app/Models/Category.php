<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nestable\NestableTrait;
use Spatie\SchemalessAttributes\SchemalessAttributes;

class Category extends Model
{
    use NestableTrait;
    protected $parent = 'parent_id';
    protected $table = 'categories';
    protected $withCount = ['listings'];



    protected $fillable = [
        'name', 'hash', 'order', 'parent_id', 'slug', 'description'
    ];
	
	public $casts = [
        'request' => 'json',
        'extra_attributes' => 'array',
    ];
	
	public function getDescriptionAttribute()
	{
        return $this->extra_attributes['description'];
	}

	public function child()
	{
		return $this->hasOne('App\Models\Category', 'id', 'parent_id');
	}

    public function listings() {
        return $this->hasMany('App\Models\Listing');
    }

    public function categories() {
        return $this->belongsTo('App\Models\Category', 'id', 'parent_id');
    }

    public function parent() {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function getOptionCategories($id=0, $cat_id_default="", $level_tab="")
	{

		$categories = Category::where('parent_id','=',$id)->get();
	    
	    $options = '';
	    if(!empty($categories))
	    {
	        #It has children, let's get them.
	        foreach ($categories as $category) {
	        	$selected = "";
                if($cat_id_default!="" && $category->id == $cat_id_default) $selected = 'selected="selected"';
	        	if($category->parent_id ==  0) $selected = 'disabled';
	        	$options .= "<option value='".$category->id."' ".$selected.">".$level_tab.ucfirst($category->name)."</option>";	        	
	            $options .= $this->getOptionCategories($category->id,$cat_id_default,$level_tab.'&mdash;');	            
	        }	        
	    }
	    return $options;
	}

    public function get_count($category_id) {
        return Category::Find($category_id)->listings()->count();
    }
}
