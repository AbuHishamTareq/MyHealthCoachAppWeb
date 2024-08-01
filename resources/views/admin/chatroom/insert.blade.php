@extends('layouts.index')
@section('title')
My Health Coach | Insert Chat Group
@endsection
@section('class')
class="nav-md footer_fixed"
@endsection
@section('content')
<div class="page-title">
    <div class="title_left mb-2">
        <h3>Chat | Chat Group</h3>
    </div>
</div>
<div class="clearfix"></div>
@if ($errors->any())
<div class="alert alert-danger" role="alert">
    <h4 class="alert-heading">Failed to Save & Send:</h4>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <hr>
</div>
@endif
@if (Session::has('error'))
<div class="alert alert-danger" role="alert">
    <strong>Error: </strong>{{ Session::get('error') }}
    <hr>
</div>
@endif
<form action="{{ route('chat-room.insert') }}" method="POST" enctype="multipart/form-data">@csrf
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <div class="form-group row pull-right">
                        <div>
                            <a href="{{ route('chat-room.index') }}" class="btn btn-primary">Cancel</a>
                            <button type="submit" class="btn btn-success">Save & Send</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="col-md-6 ">
                        <div class="x_panel">
                            <div class="x_content">
                                <br />
                                <div class="col-md-12 col-sm-12  form-group">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Chat Group Name" value="{{ old('name') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="x_panel">
                            <div class="x_content">
                                <br />
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6">
                                        <img src="{{ asset('assets/admin/images/user.png') }}" name="room_image" id="room_image" alt="..." class="img-circle" style="width: 150px">
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <button type="button" class="btn btn-success" id="change-image">Change Room Image</button>
                                        <button type="button" class="btn btn-danger" style="display: none" id="cancel-change">Cancel changes</button>
                                    </div>
                                    <div id="old-image"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection