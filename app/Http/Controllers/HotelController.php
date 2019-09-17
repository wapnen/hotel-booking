<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return response()->json(Hotel::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $hotel = Hotel::find($id);
        $rooms = $hotel->rooms()->get();
        return response()->json(['hotel' => $hotel, 'rooms' => $rooms]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $hotel = Hotel::find($id);
        $hotel->update($request->all());
        $hotel->save();
        return response()->json($request->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function image(Request $request, $hotel){
      $hotel = Hotel::find($hotel);
      $cover = $request->file('file');
      $extension = $cover->getClientOriginalExtension();
      Storage::disk('public')->put( Str::slug($hotel->name, '-').'-'.$hotel->id.'.'.$extension,  File::get($cover));
      $hotel->image = Str::slug($hotel->name, '-').'-'.$hotel->id.'.'.$extension;

      $hotel->save();
      return response()->json($hotel);
    }
}
