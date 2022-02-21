<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Label;
use App\Menu;
use App\Site;
use DB;
use Dimsav\Translatable\Translatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Input;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $menus = Menu::orderBy('date_start', 'DESC')->paginate(15);

        return view('menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $sites = Site::withTranslation()->where('isCafet', '=', '0')->get()->pluck('name', 'id');
        // $labels = Label::withTranslation()->get()->pluck('name', 'id');
        $noon = Input::get('noon');
        $labels = Label::where('noon', $noon)->get()->pluck('name', 'id');

        return view('menus.create', compact('sites', 'labels'));
    }

    public function form($action, $id = 0)
    {
        $noon = Input::get('noon');
        $sites = Site::withTranslation()->where('isCafet', '=', '0')->get()->pluck('name', 'id');
        //	$labels = Label::where('noon', $noon)->get()->pluck('name', 'id');

        $labs = Label::where('noon', $noon)->get();
        $labels = [];
        foreach ($labs as $label) {
            if ($label->description) {
                $labels[$label->id] = $label->name.' ('.$label->description.')';
            } else {
                $labels[$label->id] = $label->name;
            }
        }

        // $labels = Label::select(
        // 	DB::raw("CONCAT(name,' ', description) AS full_name, id")
        // )->pluck('full_name', 'id');

        if ($id != 0) {
            $menu = Menu::findOrFail($id);

            return view('menus.'.$action, compact('menu', 'sites', 'labels'));
        } else {
            return view('menus.'.$action, compact('sites', 'labels'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = [
            'date_start' => $request->get('date_start'),
            'date_end' => $request->get('date_end'),
            'period' => $request->get('period'),
            'isMain' => $request->get('isMain'),
            'label_id' => $request->get('label_id'),
            'site_id' => $request->get('site_id'),
            'fr'  => $request->get('fr'), // returns an array ['name' => value]
            'de'  => $request->get('de'),
        ];
        $data['fr']['accompaniment'] = nl2br($request->get('fr')['accompaniment']);
        $menu = Menu::create($data);

        if ($request->ajax()) {
            return response()->json(['status' => 'success']);
        }
        // selected_date

        $date = $menu->date_start;

        return redirect('sites/'.$menu->site->id.'/'.date('d.m.Y', strtotime($date)))->with('msg', 'Le menu a été enregistré!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $menu = Menu::find($id);

        return view('menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $menu = Menu::find($id);

        $sites = Site::withTranslation()->where('isCafet', '=', '0')->get()->pluck('name', 'id');
        $labels = Label::withTranslation()->get()->pluck('name', 'id');

        if ($request->ajax()) {
            return response()->json([
                'menu' => $menu,
            ]);
        }

        return view('menus.edit', compact('menu', 'sites', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->date_start = $request->get('date_start');
        $menu->date_end = $request->get('date_end');

        $v = $request->get('period');
        if (isset($v)) {
            $menu->period = $request->get('period');
        } else {
            $menu->period = false;
        }
        $v = $request->get('isMain');
        if (isset($v)) {
            $menu->isMain = $request->get('isMain');
        } else {
            $menu->isMain = false;
        }

        $menu->label_id = $request->get('label_id');
        $menu->site_id = $request->get('site_id');

        $menu->translate('fr')->title = $request->get('fr')['title']; // get('en') returns an array ['name' => value]
        $menu->translate('de')->title = $request->get('de')['title'];

        $menu->translate('fr')->veg = $request->get('fr')['veg']; // get('en') returns an array ['name' => value]
        $menu->translate('de')->veg = $request->get('de')['veg'];

        $menu->translate('fr')->subtitle = $request->get('fr')['subtitle']; // get('en') returns an array ['name' => value]
        $menu->translate('de')->subtitle = $request->get('de')['subtitle'];

        $menu->translate('fr')->specialprice = $request->get('fr')['specialprice']; // get('en') returns an array ['name' => value]
        $menu->translate('de')->specialprice = $request->get('de')['specialprice'];

        $menu->translate('fr')->accompaniment = nl2br($request->get('fr')['accompaniment']); // get('en') returns an array ['name' => value]
        $menu->translate('de')->accompaniment = $request->get('de')['accompaniment'];

        $menu->save();

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
            ]);
        }
        $date = $menu->date_start;

        return redirect('sites/'.$menu->site->id.'/'.date('d.m.Y', strtotime($date)))->with('msg', 'Le menu a été enregistré!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $site = $menu->site->id;
        $date = $menu->date_start;
        $menu->delete();

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
            ]);
        }

        return redirect('sites/'.$site.'/'.date('d.m.Y', strtotime($date)))->with('msg', 'Le menu a été supprimé!');
    }
}
