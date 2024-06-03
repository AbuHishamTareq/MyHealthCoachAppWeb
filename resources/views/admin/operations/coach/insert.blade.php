@extends('layouts.index')
@section('title')
My Health Coach | Insert Health Coach
@endsection
@section('content')
<div class="page-title">
    <div class="title_left mb-2">
        <h3>Operations | Health Coach</h3>
    </div>
</div>
<div class="clearfix"></div>
@if (Session::has('success'))
<div class="alert alert-success" role="alert">
    <strong>Success: </strong>{{ Session::get('success') }}
    <hr>
</div>
@endif
<form action="" method="POST">
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <div class="form-group row pull-right">
                        <div>
                            <button type="button" class="btn btn-primary">Cancel</button>
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
                                <div class="col-md-6 col-sm-12  form-group">
                                    <input type="text" class="form-control" name="uid" id="uid" placeholder="UID">
                                </div>
                                <div class="col-md-12 col-sm-12  form-group">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Coach Name">
                                </div>
                                <div class="col-md-12 col-sm-12  form-group">
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Email Address">
                                </div>
                                <div class="col-md-12 col-sm-12  form-group">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                </div>
                                <div class="col-md-6 col-sm-6  form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="First Name">
                                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <div class="col-md-6 col-sm-6  form-group has-feedback">
                                    <input type="text" class="form-control" id="inputSuccess3" placeholder="Last Name">
                                    <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                                </div>
                                <div class="col-md-6 col-sm-6  form-group has-feedback">
                                    <input type="email" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Email">
                                    <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <div class="col-md-6 col-sm-6  form-group has-feedback">
                                    <input type="tel" class="form-control" id="inputSuccess5" placeholder="Phone">
                                    <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="x_panel">
                            <div class="x_content">
                                <br />
                                <div class="form-group row ">
                                    <label class="control-label col-md-3 col-sm-3 ">Default Input</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" class="form-control" placeholder="Default Input">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Disabled Input </label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" class="form-control" disabled="disabled" placeholder="Disabled Input">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Read-Only Input</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" class="form-control" readonly="readonly" placeholder="Read-Only Input">
                                    </div>
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