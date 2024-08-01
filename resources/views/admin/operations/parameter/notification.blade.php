@extends('layouts.index')
@section('title')
My Health Coach | Notifications
@endsection
@section('class')
class="nav-md"
@endsection
@section('content')
<div class="page-title">
    <div class="title_left">
        <h3>Notifications</h3>
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
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Notifications Table</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table">
                        <thead>
                            <tr class="headings">
                                <th class="column-title text-center">Image</th>
                                <th class="column-title">Sender</th>
                                <th class="column-title text-center">Sent Date</th>
                                <th class="column-title no-link last text-center"><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        @if (Auth::user()->notifications == null || empty(Auth::user()->notifications))
                        <tbody>
                            <tr class="even pointer">
                                <!-- class="odd pointer" -->
                                <td class="text-center text-uppercase" style="font-size: 14px; color: darkred; font-weight: bold;" colspan="7">!! No Notifications found !!</td>
                            </tr>
                        </tbody>
                        @else
                        <tbody>
                            @foreach (Auth::user()->unreadNotifications as $notification)
                            <tr @if ($loop->iteration % 2 == 0) class="even pointer" @else class="odd pointer" @endif>
                                <td class="text-center" style="vertical-align: middle">
                                    @if ($notification['data']['sender_image'] == null || empty($notification['data']['sender_image']))
                                    <img src="{{ asset('assets/admin/images/user.png') }}" alt="" class="img-circle" style="width: 35px;">
                                    @else
                                    <img src="{{ asset('assets/admin/upload/' . $notification['data']['sender_image']) }}" alt="" class="img-circle" style="width: 35px;">
                                    @endif
                                </td>
                                <td class=" " style="vertical-align: middle">{{ $notification['data']['sender'] }}</td>
                                <td class="text-center" style="vertical-align: middle">{{ Carbon\Carbon::parse($notification['created_at'])->format('d-m-Y') }}</td>
                                <td class="text-center" style="vertical-align: middle">
                                    <a href="{{ route('parameter.read.notification', ['id' => $notification['id'], 'notifyId' => $notification['notifiable_id']]) }}" title="Read Notification"><i class="fa fa-book" style="color: darkred; font-size: 18px"></i></a>
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