<?php

namespace App\Http\Controllers;

Use App\Models\Message;
Use App\Models\User;
Use App\Jobs\SendMessage;
Use Illuminate\Http\JsonReponse;
Use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $user = User::where('id', auth()->id())->select([
            'id', 'name',
        ])->first();

        $room = Room::findOrFail($request->room);

        if ($room->code === Cookie::get('room_code')) {
            return view('home', [
                'user' => $user,
                'room' => $room,
            ]);
        } else {
            return view('welcome');
        }
    }

    public function messages($roomId): JsonResponse {
        $messages = Message::where('room_id', $roomId)->with('user')->get()->append('time');
        return response()->json($messages);
    }

    public function message(Request $request): JsonResponse {
        $message = Message::create([
            'user_id' => auth()->id(),
            'room_id' => $request->get('room_id'),
            'text' => $request->get('text'),
        ]);
        SendMessage::dispatch($message);

        return response()->json([
            'success' => true,
            'message' => "Message created and job dispatched.",
            'data' => $message,
        ]);
    }
}
