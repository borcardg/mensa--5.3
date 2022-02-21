<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Notice;
use App\Site;
use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use View;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->has('lang')) {
            $lang = $request->get('lang');
            \App::setLocale($lang);
        } // else use default locale set in laravel

        $sites = Site::where('isCafet', '=', '0')->get();

        return response()->json([
            'error' => false,
            'sites' => $sites,
            'status_code' => 200,
        ]);
    }

    /**
     * Display a listing of the resource (menu) corresponding to the selected site and current week.
     *
     * @return Response
     */
    public function weeklyMenus(Request $request)
    {
        //dd($request);

        if ($request->has('lang')) {
            $lang = $request->get('lang');
            if ($lang != 'fr' && $lang != 'de') {
                // use fallback language
                \App::setLocale('fr');
            } else {
                \App::setLocale($lang);
            }
        } // else use default locale set in laravel

        // Only get sites that are not a cafet
        $sites = Site::where('isCafet', 0)
            ->join('sites_trans', 'sites.id', '=', 'sites_trans.site_id')
            ->where('sites_trans.locale', \App::getLocale())
            ->select('sites.id', 'sites_trans.name')
            ->get();

        if ($request->has('date')) {
            $date = Carbon::createFromFormat('Y-m-d', $request->get('date'));
        } else {
            $date = Carbon::today(); // default: today
        }

        $dates = [];
        // $dates[] = $date;
        // $dates[] = $date->copy()->addDay(1);
        // $dates[] = $date->copy()->addDay(2);
        // $dates[] = $date->copy()->addDay(3);
        // $dates[] = $date->copy()->addDay(4);

        //$nd = $date->copy();
        $dow = $date->dayOfWeek;

        if ($date->dayOfWeek < 5) {
            // Prendre le lundi
            // 7 - (7-dow)
            $daysToSub = 7 - (8 - $date->dayOfWeek);
            $date->subDays($daysToSub);
            for ($i = 0; $i < 5; $i++) {
                if ($date->dayOfWeek == 6) {
                    // add 2 days to show next week menu
                    $date->addDay(2);
                } elseif ($date->dayOfWeek == 7) {
                    $date->addDay(1);
                }

                $dates[] = $date->copy();
                $date->addDay(1);
            }
        } else {
            // C'est vendredi --> Semaine suivante
            if ($dow > 5) {
                // Preselect monday for weekend
                $dow = 1;
            }
            for ($i = 0; $i < 5; $i++) {
                if ($date->dayOfWeek == 6) {
                    // add 2 days to show next week menu
                    $date->addDay(2);
                } elseif ($date->dayOfWeek == 7) {
                    $date->addDay(1);
                }

                $dates[] = $date->copy();
                $date->addDay(1);
            }
        }

        // if ($date->day == 6 || $date->day == 7) {
        //     // add 2 days to show next week menu
        //     $date->addDay(2);
        // }

        $data = [];
        $key = 1;
        foreach ($dates as $d) {
            $s = [];

            foreach ($sites as &$site) {
                $pdf = $site->id.'/'.$d->format('d.m.Y');
                $menus = $site->menus()
                    ->join('menus_trans', 'menus.id', '=', 'menus_trans.menu_id')
                    ->join('labels', 'labels.id', '=', 'menus.label_id')
                    ->join('labels_trans', 'labels.id', '=', 'labels_trans.label_id')
                    ->where('date_start', '<=', $d->toDateString())
                    ->where('date_end', '>=', $d->toDateString())
                    ->where('labels_trans.locale', \App::getLocale())
                    ->where('menus_trans.locale', \App::getLocale())
                    ->orderBy('period', 'desc')
                    ->orderBy('order', 'desc')
                    ->select('menus.id', 'menus.date_start', 'menus.date_end', 'menus.period', 'menus_trans.title', 'menus_trans.accompaniment', 'labels_trans.name AS label', 'labels.price', 'labels.order')
                    ->get()->toArray();

                if (count($menus) == 0) {
                    $menus = null;
                }

                $notices = $site->notices()
                    ->join('notices_trans', 'notices.id', '=', 'notices_trans.notice_id')
                    ->where('site_id', $site->id)
                    ->where('notices_trans.locale', \App::getLocale())
                    ->where('date_start', '<=', $d->toDateString())
                    ->where('date_end', '>=', $d->toDateString())
                    ->orderBy('isImportant')
                    ->select('notices.id', 'notices_trans.title', 'notices_trans.content', 'isImportant')
                    ->get()->toArray();

                if (count($notices) == 0) {
                    $notices = null;
                }
                $s2['name'] = $site->name;
                $s2['menus'] = $menus;
                $s2['notices'] = $notices;
                $s2['pdf'] = $pdf;

                $s[] = $s2;
            }

            $weekMap = [
                1 => 'LU',
                2 => 'MA',
                3 => 'ME',
                4 => 'JE',
                5 => 'VE',
                6 => 'SA',
                7 => 'DI',
            ];
            $dayOfTheWeek = $d->dayOfWeek;
            $weekday = $weekMap[$dayOfTheWeek];

            $d1 = [];
            $d1['id'] = $key;
            // if($key == 1){
            //     $d1["current"] = "1";
            // }
            if ($dayOfTheWeek == $dow) {
                $d1['current'] = '1';
            }
            $d1['name'] = $weekday.' '.$d->format('d.m');
            $d1['date'] = $d->toDateString();
            $d1['sites'] = $s;

            $data[] = $d1;
            $key++;
        }

        return response()->json(
            $data
        );
    }

    /**
     * Display a listing of the resource (menu) corresponding to the selected site and current week.
     *
     * @return Response
     */
    public function todayMenus(Request $request, $id)
    {
        if (! $id) {
            return response()->json([
                'error' => "The site doesn't exist.",
                'sites' => null,
                'status_code' => 404,
            ]);
        }

        // if ($request->has('id_site')){
        //     $id = $request->get('id_site');
        // } else {
        //     return response()->json(array(
        //         'error' => "The site doesn't exist.",
        //         'sites' => null,
        //         'status_code' => 404
        //     ));
        // }// no default value, id is mandatory

        if ($request->has('period')) {
            $period = $request->get('period');
        } else {
            $period = true; // default: noon
        }

        if ($request->has('limit')) {
            $limit = $request->get('limit');
        } else {
            $limit = 2; // default: 2
        }

        if ($request->has('lang')) {
            $lang = $request->get('lang');
            if ($lang != 'fr' && $lang != 'de') {
                // use fallback language
                \App::setLocale('fr');
            } else {
                \App::setLocale($lang);
            }
        } // else use default locale (fr) set in laravel

        // Only get menus for site that are not a cafet
        $site = Site::find($id);

        if ($site->isCafet == true) {
            return response()->json([
                'error' => 'The site is a cafeteria, no menus to show',
                'sites' => null,
                'status_code' => 404,
            ]);
        }

        if ($request->has('date')) {
            $date = Carbon::createFromFormat('Y-m-d', $request->get('date'));
        } else {
            $date = Carbon::today(); // default: today
        }

        if ($date->day == 6 || $date->day == 7) {
            // add 2 days to show next week menu
            $date->addDay(2);
        }

        $menus = $site->menus()
            ->join('menus_trans', 'menus.id', '=', 'menus_trans.menu_id')
            ->join('labels', 'labels.id', '=', 'menus.label_id')
            ->join('labels_trans', 'labels.id', '=', 'labels_trans.label_id')
            ->where('date_start', '<=', $date->toDateString())
            ->where('date_end', '>=', $date->toDateString())
            ->where('labels_trans.locale', \App::getLocale())
            ->where('menus_trans.locale', \App::getLocale())
            ->where('period', $period)
            ->orderBy('isMain', 'desc')
            ->orderBy('order', 'desc')
            ->limit($limit)
            ->select('menus.id', 'menus.date_start', 'menus.date_end', 'menus.period', 'menus_trans.title', 'menus_trans.accompaniment', 'labels_trans.name AS label', 'labels.price', 'labels.order')
            ->get()->toArray();

        $notices = $site->notices()
            ->join('notices_trans', 'notices.id', '=', 'notices_trans.notice_id')
            ->where('site_id', $site->id)
            ->where('notices_trans.locale', \App::getLocale())
            ->where('date_start', '<=', $date->toDateString())
            ->where('date_end', '>=', $date->toDateString())
            ->orderBy('isImportant')
            ->select('notices.id', 'notices_trans.title', 'notices_trans.content', 'isImportant')
            ->get()->toArray();

        if (count($menus) == 0) {
            $menus = null;
        }

        if (count($notices) == 0) {
            $notices = null;
        }

        $site['menus'] = $menus;
        $site['notices'] = $notices;

        return response()->json([
            'error' => false,
            'site' => $site,
            'date' => $date->toDateString(),
            'status_code' => 200,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        if ($request->has('lang')) {
            $lang = $request->get('lang');
            if ($lang != 'fr' && $lang != 'de') {
                // use fallback language
                \App::setLocale('fr');
            } else {
                \App::setLocale($lang);
            }
        } // else use default locale set in laravel

        $site = Site::find($id);

        if ($site == null) {
            return response()->json([
                'error' => "Site doesn't exist",
                'site' => null,
                'status_code' => 404,
            ]);
        }

        return response()->json([
            'error' => false,
            'site' => $site,
            'status_code' => 200,
        ]);
    }
}
