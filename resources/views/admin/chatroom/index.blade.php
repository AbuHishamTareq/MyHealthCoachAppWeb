@extends('layouts.index')
@section('title')
My Health Coach | Chat Rooms
@endsection
@section('class')
class="nav-md footer_fixed"
@endsection
@section('content')
<div class="page-title">
    <div class="title_left">
        <h3>Chat</h3>
    </div>
    <div class="title_right">
        <div class="col-md-4 col-sm-4 form-group row pull-right top_search">
            <a href="{{ route('chat-room.show.insert') }}" class="btn btn-success btn-xs text-uppercase" style="width: 100%"><i class="fa fa-plus mr-2"></i>Add Chat Group</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>
@if (Session::has('success'))
<div class="alert alert-success" role="alert">
    <strong>Success: </strong>{{ Session::get('success') }}
    <hr>
</div>
@endif
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Chat Groups Table</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table">
                        <thead>
                            <tr class="headings">
                                <th class="column-title"></th>
                                <th class="column-title ">Chat Group Name </th>
                                <th class="column-title ">Created By </th>
                                <th class="column-title text-center">Status </th>
                                <th class="column-title no-link last text-center"><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        @if ($chatRooms == null || empty($chatRooms))
                        <tbody>
                            <tr class="even pointer">
                                <!-- class="odd pointer" -->
                                <td class="text-center text-uppercase" style="font-size: 14px; color: darkred; font-weight: bold;" colspan="7">!! No Comlexes found !!</td>
                            </tr>
                        </tbody>
                        @else
                        <tbody>
                            @foreach ($chatRooms as $room)
                                <td class="text-center">
                                    @if ($room['image'] == null || empty($room['image']))
                                    <img src="{{ asset('assets/admin/images/user.png') }}" alt="..." class="img-circle profile_img">
                                    @else
                                    <img src="{{ asset('assets/admin/upload/'. $room['image']) }}" alt="..." class="img-circle" style="width: 35px;">
                                    @endif
                                </td>
                                <td class=" " style="vertical-align: middle">{{ $room['name'] }}</td>
                                <td class=" " style="vertical-align: middle">{{ $room['get_created_by']['name'] }}</td>
                                <td class="text-center" style="vertical-align: middle">
                                    @if ($room['status'] == 1)
                                        <a href="javascript:void(0)" class="updateRoomStatus" id="room-{{ $room['id'] }}" room-id= {{ $room['id'] }}>
                                            <i class="fa fa-toggle-on" status="Active" title="Active"></i>
                                        </a>
                                    @elseif ($room['status'] == 0)
                                    <a href="javascript:void(0)" class="updateRoomStatus" id="room-{{ $room['id'] }}" room-id= {{ $room['id'] }}>
                                        <i class="fa fa-toggle-off" status="Inactive" title="Inactive"></i>
                                    </a>
                                    @endif
                                </td>
                                <td class="text-center" style="vertical-align: middle">
                                    <a href="#" title="Edit room"><i class="fa fa-edit mr-2" style="color: darkgreen; font-size: 18px"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection