<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use \Dimsav\Translatable\Translatable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sites';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = ['isCafet', 'name', 'address', 'export', 'image', 'texte', 'opentimenoon', 'opentimeevening', 'remark'];

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
    public $translatedAttributes = ['name', 'address', 'texte', 'remark'];

    public function menus()
    {
        return $this->hasMany(\App\Menu::class);
    }

    public function notices()
    {
        return $this->hasMany(\App\Notice::class);
    }

    public function openHours()
    {
        return $this->hasMany(\App\OpenHour::class);
    }

    public function openPeriods()
    {
        return $this->belongsToMany(\App\OpenPeriod::class);
    }

    public function getTodayAttribute()
    {
        $id = $this->id;

        $date = Carbon::today();

        if ($date->dayOfWeek == 6 || $date->dayOfWeek == 7) {
            // add 2 days to show next week menu
            $date->addDay(2);
        }

        $menus = $this->menus()
            ->join('menus_trans', 'menus.id', '=', 'menus_trans.menu_id')
            ->join('labels', 'labels.id', '=', 'menus.label_id')
            ->join('labels_trans', 'labels.id', '=', 'labels_trans.label_id')
            ->where('date_start', '<=', $date->toDateString())
            ->where('date_end', '>=', $date->toDateString())
            ->where('labels_trans.locale', \App::getLocale())
            ->where('menus_trans.locale', \App::getLocale())
            ->orderBy('isMain', 'desc')
            ->orderBy('order', 'desc')
            ->select('menus.id', 'menus.date_start', 'menus.date_end', 'menus.period', 'menus_trans.title', 'menus_trans.accompaniment', 'labels_trans.name AS label', 'labels.price', 'labels.order')
            ->get();

        if (count($menus) == 0) {
            $menus = null;
        }

        return $menus;
    }
}
