<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Label;
use Dimsav\Translatable\Translatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Input;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $labelsNoon = Label::where('noon', 1)->orderBy('order', 'desc')->get();
        $labelsEvening = Label::where('noon', 0)->orderBy('order', 'desc')->get();

        return view('labels.index', compact('labelsNoon', 'labelsEvening'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('labels.create');
    }

    public function form($action, $id = 0)
    {
        if ($id != 0) {
            $label = Label::find($id);

            return view('labels.'.$action, compact('label'));
        } else {
            return view('labels.create');
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
            'price' => Input::get('price'),
            'order' => Input::get('order'),
            'noon' => Input::get('noon'),
            'description' => Input::get('description'),
            'fr'  => Input::get('fr'), // returns an array ['name' => value]
            'de'  => Input::get('de'),
        ];
        Label::create($data);

        return redirect('labels')->with('msg', 'Le libellé a bien été créé!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $label = Label::find($id);

        return view('labels.show', compact('label'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $label = Label::find($id);

        return view('labels.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $label = Label::findOrFail($id);
        $label->price = Input::get('price');
        $label->order = Input::get('order');
        $label->description = Input::get('description');
        $label->noon = Input::get('noon');

        $label->translate('fr')->name = Input::get('fr')['name']; // get('en') returns an array ['name' => value]
        $label->translate('de')->name = Input::get('de')['name'];

        $label->save();

        return redirect('labels')->with('msg', 'le libellé a bien été enregistré!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $label = Label::findOrFail($id);

        $label->delete();

        return redirect('labels')->with('msg', 'Le label a été supprimé !');
    }
}
