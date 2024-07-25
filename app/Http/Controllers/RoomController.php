<?php

namespace App\Http\Controllers;

Use App\Models\Room;
Use App\Models\Message;
//Use App\Jobs\SendMessage;
Use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function store(Request $request) {
        $room_code = "";     
        for ($x=0;$x<6;$x++) {
            $room_code .= substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1);
        }

        $room = Room::create([
            'name' => $request->get('name',),
            'code' => $room_code,
        ]);

        $text = 'Your room code is: ' . $room_code . '. Only share this with people you want to join!';

        $message = Message::create([
            'user_id' => '1',
            'room_id' => $room->id,
            'text' => $text,
        ]);

        return response()->json(['redirect_url' => route('home', [
            'room' => $room,
        ])])->cookie('room_code', $room_code, 1440);
    }

    public function join(Request $request) {

        $room = Room::where('code', $request->name)->first();

        return response()->json([
            'redirect_url' => route('home', ['room' => $room])
        ])->cookie('room_code', $request->name, 1440);
    }
}