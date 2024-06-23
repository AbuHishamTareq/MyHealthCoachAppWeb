@extends('layouts.index')
@section('title')
My Health Coach | Import Patients
@endsection
@section('class')
class="nav-md footer_fixed"
@endsection
@section('content')
<div class="page-title">
    <div class="title_left mb-2">
        <h3>Operations | Import Patients</h3>
    </div>
</div>
<div class="clearfix"></div>
@if ($errors->any())
<div class="alert alert-danger" role="alert">
    <h4 class="alert-heading">Failed to Import Data:</h4>
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
<div class="container" style="width: 70%; box-shadow: 10px 10px 5px;">
    <form action="{{ route('patient.import') }}" method="POST" enctype="multipart/form-data">@csrf
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="form-group row pull-right">
                            <div>
                                <a href="{{ route('patient.template') }}" class="btn btn-info">Download Template</a>
                                <a href="{{ route('patient.index') }}" class="btn btn-primary">Cancel</a>
                                <button type="submit" class="btn btn-success">Import</button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="x_panel">
                                <div class="x_content">
                                    <br />
                                    <div class="form-group">
                                        <input type="file" name="importFile" id="importFile">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection