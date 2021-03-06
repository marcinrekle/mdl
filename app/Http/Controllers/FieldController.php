<?php

namespace App\Http\Controllers;

use App\Field;
use Illuminate\Http\Request;
use Validator;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = Field::all();
        return view('fields.index', compact('fields'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$opts = ['method' => 'POST', 'route' => 'field.store', 'btn_text' => 'Dodaj', 'panel_title' => 'Dodawanie pola'];
        $field = new Field();
        $field->options = ['attrs' => ['class' => 'form-control']];
        return view('fields.create',compact('field'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = $this->validator($data);
        if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        $data['options'] = json_decode($data['options'],true);
        $field = Field::create($data);
        return redirect()->route('field.index')->withSuccess('Pole utworzono');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function show(Field $field)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function edit(Field $field)
    {
        //$opts = ['method' => 'PATCH', 'route' => 'field.update', 'btn_text' => 'Aktualizuj', 'panel_title' => 'Aktualizacja pola'];
        return view('fields.edit', compact('field'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Field $field)
    {
        $data = $request->all();
        $validator = $this->validator($data);
        if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        $data['options'] = json_decode($data['options'],true);
        $field = Field::findOrFail($field->id);
        $field->fill($data)->save();
        return redirect()->route('field.index')->withSuccess('Edycja zakończona pomyślnie');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function destroy(Field $field)
    {
        $field->delete();
        return redirect()->route('field.index')->withSuccess('Pole usunięte');
    }

     protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'          => 'required|max:64',
            'slug'          => 'required|max:32',
            'description'   => 'required',
            'type'          => 'required',
            'order'         => 'required|max:32',
            'active'        => '',
            'visible'       => '',
            'required'      => '',
        ]);
    }
}
