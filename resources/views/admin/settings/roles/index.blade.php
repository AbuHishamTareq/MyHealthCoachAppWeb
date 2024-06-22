@extends('layouts.index')
@section('title')
My Health Coach | User Roles
@endsection
@section('class')
class="nav-md footer_fixed"
@endsection
@section('content')
<div class="page-title">
    <div class="title_left">
        <h3>Settings</h3>
    </div>
    <div class="title_right">
        <div class="col-md-3 col-sm-3 form-group row pull-right top_search">
            <a href="{{ route('usertype.roles') }}" class="btn btn-success btn-xs text-uppercase" style="width: 100%"><i class="fa fa-plus mr-2"></i>Add Roles</a>
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
                <h2>User Roles Table</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table">
                        <thead>
                            <tr class="headings">
                                <th class="column-title text-center"># </th>
                                <th class="column-title">Role </th>
                                <th class="column-title">Created By </th>
                                <th class="column-title">Updated By </th>
                                <th class="column-title">Created Date </th>
                                <th class="column-title">Updated Date </th>
                                <th class="column-title no-link last text-center"><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        @if ($roles == null || empty($roles))
                        <tbody>
                            <tr class="even pointer">
                                <!-- class="odd pointer" -->
                                <td class="text-center text-uppercase" style="font-size: 14px; color: darkred; font-weight: bold;" colspan="7">!! No Roles found !!</td>
                            </tr>
                        </tbody>
                        @else
                        <tbody>
                            @foreach ($roles as $role)
                            <tr @if ($loop->iteration % 2 == 0) class="even pointer" @else class="odd pointer" @endif>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class=" ">{{ $role['role'] }}</td>
                                <td class=" ">@if (empty($role['get_created_by']['name']))
                                ---
                                @else
                                {{ $role['get_created_by']['name'] }}
                                @endif
                                </td>
                                <td class=" ">@if (empty($role['get_updated_by']['name']))
                                ---
                                @else
                                {{ $role['get_updated_by']['name'] }}
                                @endif
                                </td>
                                <td>{{ Carbon\Carbon::parse($role['created_at'])->format('d-m-Y H:i') }}</td>
                                <td>{{ Carbon\Carbon::parse($role['updated_at'])->format('d-m-Y H:i') }}</td>
                                <td class="text-center">
                                    <a href="#" title="Add Roles"><i class="fa fa-plus mr-2" style="color: blue; font-size: 18px"></i></a>
                                    <a href="#" title="Edit Roles"><i class="fa fa-edit mr-2" style="color: darkgreen; font-size: 18px"></i></a>
                                    <a href="#" title="View Roles"><i class="fa fa-eye" style="color: darkred; font-size: 18px"></i></a>
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