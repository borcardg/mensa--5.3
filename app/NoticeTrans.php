<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoticeTrans extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notices_trans';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = ['title', 'content'];

    /**
     * The inverse of fillable is guarded, and serves as a "black-list"
     *
     * @var string
     */
    protected $guarded = ['id'];

    public $timestamps = false;
}
