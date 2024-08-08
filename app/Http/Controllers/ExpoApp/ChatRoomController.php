<?php

namespace App\Http\Controllers\ExpoApp;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\Patient;
use Illuminate\Http\Request;

class ChatRoomController extends Controller
{
    public function getChatData(Request $request) {
        $coach = Patient::select('coach_id')->where('id', $request->patientId)->first();

        $rooms = ChatRoom::with('getCreatedBy')
        ->where('created_by', $coach['coach_id'])
        ->orWhere('created_by', 1)
        ->orWhere('created_by', 0)
        ->get();

        return response()->json($rooms);
    }

    public function insertMessage(Request $request) {
        $parameter['room_id'] = $request->room_id;
        $parameter['sender_id'] = $request->room_id;
        $parameter['message'] = $request->message;

        Chat::create($parameter);
    
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function getChatMessage(Request $request) {
        $messages = Chat::with('getSender')
            ->where('room_id', $request->room_id)
            ->orderBy('created_at', 'ASC')
            ->latest()->first();

        if($messages) {
            return response()->json($messages);
        } else {
            return null;
        }
    }
}
