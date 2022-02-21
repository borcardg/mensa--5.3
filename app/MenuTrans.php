<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuTrans extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menus_trans';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = ['title', 'accompaniment', 'veg', 'subtitle', 'specialprice'];

    /**
     * The inverse of fillable is guarded, and serves as a "black-list"
     *
     * @var string
     */
    protected $guarded = ['id'];

    public $timestamps = false;
}
