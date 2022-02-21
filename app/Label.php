<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use \Dimsav\Translatable\Translatable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'labels';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = ['price', 'name', 'noon', 'description'];

    /**
     * The inverse of fillable is guarded, and serves as a "black-list"
     *
     * @var string
     */
    protected $guarded = ['id'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    // (optionaly)
    protected $with = ['translations'];

    /**
     * The attributes that are translated.
     *
     * @var string
     */
    public $translatedAttributes = ['name'];

    public function menus()
    {
        return $this->hasMany(\App\Menu::class);
    }
}
