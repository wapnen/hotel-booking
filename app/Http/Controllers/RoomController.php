<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\Hotel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json(Room::all());
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
        $room = new Room($request->all());
        $room->hotel_id = $request->hotel_id;
        $room->room_type_id = $request->room_type_id;
        $room->save();
        return response()->json($room);
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
        $room = Room::find($id);
        $room->update($request->all());
        $room->room_type_id = $request->room_type_id;
        $room->save();
        return response()->json($request->all());
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
        $room = Room::find($id);
        $room->delete();
        return response()->json(['status' => 'deleted']);
    }

    public function image(Request $request, $room){
      $room = Room::find($room);
      $cover = $request->file('file');
      $extension = $cover->getClientOriginalExtension();
      Storage::disk('public')->put( Str::slug($room->name, '-').'-'.$room->id.'.'.$extension,  File::get($cover));
      $room->image = Str::slug($room->name, '-').'-'.$room->id.'.'.$extension;

      $room->save();
      return response()->json($room);
    }
}
