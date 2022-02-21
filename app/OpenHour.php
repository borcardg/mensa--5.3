<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpenHour extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'open_hours';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = ['day', 'hourFrom', 'hourTo', 'validFrom', 'validTo', 'site_id'];

    /**
     * The inverse of fillable is guarded, and serves as a "black-list"
     *
     * @var string
     */
    protected $guarded = ['id'];

    public function site()
    {
        return $this->belongsTo(\App\Site::class);
    }
}
