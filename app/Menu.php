<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use \Dimsav\Translatable\Translatable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = ['date_start', 'date_end', 'period', 'isMain', 'title', 'veg', 'subtitle', 'specialprice', 'accompaniment', 'label_id', 'site_id'];

    /**
     * The inverse of fillable is guarded, and serves as a "black-list"
     *
     * @var string
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are translated.
     *
     * @var string
     */
    public $translatedAttributes = ['title', 'accompaniment', 'veg', 'subtitle', 'specialprice'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    // (optionaly)
    //protected $with = ['translations'];

    public function label()
    {
        return $this->belongsTo(\App\Label::class);
    }

    public function site()
    {
        return $this->belongsTo(\App\Site::class);
    }
}
