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
@if (Session::has('error'))
<div class="alert alert-danger" role="alert">
    <strong>Error: </strong>{{ Session::get('error') }}
    <hr>
</div>
@endif
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Notifications</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-1 col-sm-1 col-xs-1">
                        @if ($notification['data']['sender_image'] == null || empty($notification['data']['sender_image']))
                        <img src="{{ asset('assets/admin/images/user.png') }}" alt="" class="img-circle" style="width: 70px;">
                        @else
                        <img src="{{ asset('assets/admin/upload/' . $notification['data']['sender_image']) }}" alt="" class="img-circle" style="width: 70px;">
                        @endif
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8" style="display: flex; justfiy-content: center; flex-direction: column;">
                        <div>
                            <span style="font-weight: bold; font-size: 20px;">{{ $notification['data']['sender'] }}</span>
                        </div>
                        <div>
                            <span style="font-size: 18px;">{{ $notification['data']['message'] }}</span>
                        </div>
                        <div>
                            <span style="font-size: 14px;">{{ Carbon\Carbon::parse($notification['created_at'])->format('d-m-Y h:i a') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3" style="display: flex; justfiy-content: center; align-items: center">
                        <div class="ml-4">
                            <a href="{{ route('parameter.accept', ['id' => $notification['id'], 'notifyId' => $notification['notifiable_id']]) }}" class="btn btn-sm btn-success" style="width: 100px">Accept</a>
                        </div>
                        <div class="ml-4">
                            <a href="{{ route('parameter.reject', ['id' => $notification['id'], 'notifyId' => $notification['notifiable_id']]) }}" class="btn btn-sm btn-danger" style="width: 100px">Reject</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection