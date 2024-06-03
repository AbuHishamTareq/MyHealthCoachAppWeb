@extends('layouts.index')
@section('title')
My Health Coach | Insert Complex
@endsection
@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left" style="margin-bottom: 10px;">
            <h3>Operations</h3>
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
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Failed to Save:</h4>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <hr>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <form action="{{ route('complex.insert') }}" method="POST">
                @csrf
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Complex</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 ">
                            <div class="x_panel">
                                <div class="x_content">
                                    <br />
                                    <div class="col-md-12 col-sm-12  form-group">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Complex Name">
                                    </div>
                                    <div class="col-md-12 col-sm-12  form-group">
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone Number">
                                    </div>
                                    <div class="col-md-6 col-sm-6  form-group">
                                        <input type="text" class="form-control" name="city" id="city" placeholder="City">
                                    </div>
                                    <div class="col-md-6 col-sm-6  form-group">
                                        <input type="text" class="form-control" name="region" id="region" placeholder="Region">
                                    </div>
                                    <div class="col-md-12 col-sm-12  form-group">
                                        <input type="text" class="form-control" name="address" id="address" placeholder="Address">
                                    </div>
                                </div>
                            </div>
                            <div class="item form-group">
                                <div class="col-md-6 col-sm-6 offset-md-4">
                                    <a href="{{ route('complex.index') }}" class="btn btn-primary" type="button">Cancel</a>
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection