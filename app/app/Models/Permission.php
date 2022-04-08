<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Permission extends Model {

	public $translatedAttributes = ['title', 'slug', 'content', 'status', 'visibility', 'locale'];
    protected $fillable = ['title'];

    protected $table;   

}
