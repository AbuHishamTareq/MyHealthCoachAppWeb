@extends('layouts.index')
@section('title')
My Health Coach | Insert User Roles
@endsection
@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left" style="margin-bottom: 10px;">
            <h3>Settings</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    @error('user_role')
    <div class="alert alert-danger" role="alert">
        <strong>Error: </strong>{{ $message }}
        <hr>
    </div>
    @enderror
    @if (Session::has('error'))
        <div class="alert alert-danger" role="alert">
            <strong>Error: </strong>{{ Session::get('error') }}
            <hr>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>User Roles</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form data-parsley-validate class="form-horizontal form-label-left" action="{{ route('usertype.insert') }}" method="POST">@csrf
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="user_role">User Role:</label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" name="user_role" id="user_role" class="form-control">
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="item form-group">
                            <div class="col-md-6 col-sm-6 offset-md-5">
                                <a href="{{ route('usertype.index') }}" class="btn btn-primary" type="button">Cancel</a>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection