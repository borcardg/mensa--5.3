<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpenPeriod extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'open_periods';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = ['day', 'period'];

    /**
     * The inverse of fillable is guarded, and serves as a "black-list"
     *
     * @var string
     */
    protected $guarded = ['id'];

    public function sites()
    {
        return $this->belongsToMany(\App\Site::class);
    }
}
