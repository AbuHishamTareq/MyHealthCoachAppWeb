<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChatRoomRequest;
use App\Models\ChatRoom;
use Illuminate\Http\Request;

class ChatRoomController extends Controller
{
    public function index() {
        if(auth()->guard('admin')->user()->id <= 1) {
            $chatRooms = ChatRoom::with('getCreatedBy')->get()->toArray();
        } else {
            $chatRooms = ChatRoom::with('getCreatedBy')->where('created_by', auth()->guard('admin')->user()->id)->get()->toArray();
        }
        
        return view('admin.chatroom.index', compact('chatRooms'));
    }

    public function show() {
        return view('admin.chatroom.insert');
    }

    public function insert(ChatRoomRequest $request) {
        try {
            $room['name'] = $request->input('name');
            $room['created_by'] = auth()->guard('admin')->user()->id;
            

            if($request->has('photo')) {
                $request->validate([
                    'photo' => 'mimes:png,jpg,jpeg|max:1000'
                ]);

                $file_path = uploadImage('assets/admin/upload', $request->photo);

                $room['image'] = $file_path;
            }

            ChatRoom::create($room);

            return redirect()->route('chat-room.index')->with([
                'success' => 'Data Saved Successfully !!'
            ]);

        } catch(\Exception $ex) {
            return redirect()->back()->withInput($request->input())->with('error', $ex->getMessage());
        }
    }

    public function updateStatus(Request $request) {
        if($request->ajax()) {
            $data = $request->all();

            if($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }

            ChatRoom::where('id', $data['room_id'])->update([
                'status' => $status
            ]);

            return response()->json(([
                'status' => $status,
                'room_id' => $data['room_id']
            ]));
        }
    }
}
