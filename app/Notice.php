<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use \Dimsav\Translatable\Translatable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notices';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = ['date_start', 'date_end', 'isImportant', 'title', 'content', 'site_id'];

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
    public $translatedAttributes = ['title', 'content'];

    public function site()
    {
        return $this->belongsTo(\App\Site::class);
    }
}
