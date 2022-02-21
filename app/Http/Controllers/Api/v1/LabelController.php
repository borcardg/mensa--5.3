<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Label;
use App\Notice;
use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Input;
use View;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if (Input::has('lang')) {
            $lang = Input::get('lang');
            \App::setLocale($lang);
        } // else use default locale set in laravel

        $labels = Label::all();

        return response()->json([
            'error' => false,
            'labels' => $labels,
            'status_code' => 200,
        ]);
    }
}
