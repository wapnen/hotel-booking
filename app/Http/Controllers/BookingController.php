<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use App\Room;
use App\Price;
use App\RoomType;
use DateTime;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json(Booking::all());
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

        $validator = Validator::make($request->all(),
        [ 'start' => 'date|after_or_equal:today',
          'end' => 'required|date|after:start']);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()]);
        }

        //
        $booking = new Booking($request->all());
        $start = new DateTime($request->start);
        $end = new DateTime($request->end);

        $booking->total_nights = $end->diff($start)->format("%a");
        $price = Price::where('room_type_id', RoomType::find(Room::find($request->room_id)->room_type_id)->id)->first()->price;
        $booking->total_price = $price * $booking->total_nights;
        $booking->save();
        return response()->json($booking);

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
        $validator = Validator::make($request->all(),
        [ 'start' => 'date|after_or_equal:today',
          'end' => 'required|date|after:start']);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()]);
        }

        //
        $booking = Booking::find($id);
        $booking->update($request->all());
        $start = new DateTime($request->start);
        $end = new DateTime($request->end);

        $booking->total_nights = $end->diff($start)->format("%a");
        $price = Price::where('room_type_id', RoomType::find(Room::find($request->room_id)->room_type_id)->id)->first()->price;
        $booking->total_price = $price * $booking->total_nights;
        $booking->save();
        return response()->json($booking);
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
        $booking = Booking::find($id);
        $booking->delete($id);

    }
}
