<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Notice;
use App\Site;
use Dimsav\Translatable\Translatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $notices = Notice::orderBy('date_start', 'DESC')->paginate(15);

        return view('notices.index', compact('notices'));
    }

    public function form($action, $id)
    {
        $sites = Site::withTranslation()->where('isCafet', '=', '0')->get()->pluck('name', 'id');

        if ($id != 0) {
            $notice = Notice::find($id);

            return view('notices.'.$action, compact('sites', 'notice'));
        } else {
            return view('notices.'.$action, compact('sites'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $sites = Site::withTranslation()->get()->pluck('name', 'id');

        return view('notices.create', compact('sites'));
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
            'isImportant' => $request->get('isImportant'),
            'site_id' => $request->get('site_id'),
            'fr'  => $request->get('fr'), // returns an array ['name' => value]
            'de'  => $request->get('de'),
        ];
        $notice = Notice::create($data);

        if ($request->ajax()) {
            return response()->json(['status' => 'success']);
        }

        $site_id = $notice->site->id;
        $date = $notice->date_start;
        $url = 'sites/'.$site_id.'/'.date('d.m.Y', strtotime($date));

        return redirect($url)->with('msg', 'L\'information a été créée!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $notice = Notice::find($id);

        return view('notices.show', compact('notice'));
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
        $notice = Notice::find($id);
        $sites = Site::withTranslation()->get()->pluck('name', 'id');

        if ($request->ajax()) {
            return response()->json([
                'notice' => $notice,
            ]);
        }

        return view('notices.edit', compact('notice', 'sites'));
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
        $notice = Notice::findOrFail($id);
        $notice->date_start = $request->get('date_start');
        $notice->date_end = $request->get('date_end');

        $v = $request->get('isImportant');
        if (isset($v)) {
            $notice->isImportant = $request->get('isImportant');
        } else {
            $notice->isImportant = false;
        }

        $notice->site_id = $request->get('site_id');

        $notice->translate('fr')->title = $request->get('fr')['title']; // get('en') returns an array ['name' => value]
        $notice->translate('de')->title = $request->get('de')['title'];

        $notice->translate('fr')->content = $request->get('fr')['content']; // get('en') returns an array ['name' => value]
        $notice->translate('de')->content = $request->get('de')['content'];

        $notice->save();

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
            ]);
        }
        $site_id = $notice->site->id;
        $date = $notice->date_start;
        $url = 'sites/'.$site_id.'/'.date('d.m.Y', strtotime($date));

        return redirect($url)->with('msg', 'L\'information a été enregistrée!');
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
        $notice = Notice::findOrFail($id);

        $site_id = $notice->site->id;
        $date = $notice->date_start;
        $notice->delete();

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
            ]);
        }

        $url = 'sites/'.$site_id.'/'.date('d.m.Y', strtotime($date));

        return redirect($url)->with('msg', 'L\'information a été supprimée!');
        // return redirect('notices')->with('msg', 'Successfully deleted notice!');
    }
}
