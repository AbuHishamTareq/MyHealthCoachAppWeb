@extends('layouts.index')
@section('title')
My Health Coach | Health Coach
@endsection
@section('class')
class="nav-md footer_fixed"
@endsection
@section('content')
<div class="page-title">
    <div class="title_left">
        <h3>Operations</h3>
    </div>
    <div class="title_right">
        <div class="col-md-4 col-sm-4 form-group row pull-right top_search">
            <a href="{{ route('coach.show.insert') }}" class="btn btn-success btn-xs text-uppercase" style="width: 100%"><i class="fa fa-plus mr-2"></i>Add Health Coach</a>
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
                <h2>Users Table</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table">
                        <thead>
                            <tr class="headings">
                                <th class="column-title text-center"></th>
                                <th class="column-title">Coach UID</th>
                                <th class="column-title">Coach Name </th>
                                <th class="column-title">Specialist </th>
                                <th class="column-title">Complex Name </th>
                                <th class="column-title">Phone Number </th>
                                @if (Auth::guard('admin')->user()->user_type == 0)
                                <th class="column-title">Role </th>
                                @endif
                                <th class="column-title">Status </th>
                                <th class="column-title no-link last text-center"><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        @if ($coaches == null || empty($coaches))
                        <tbody>
                            <tr class="even pointer">
                                <!-- class="odd pointer" -->
                                <td class="text-center text-uppercase" style="font-size: 14px; color: darkred; font-weight: bold;" colspan="9">!! No Health Coaches found !!</td>
                            </tr>
                        </tbody>
                        @else
                        <tbody>
                            @foreach ($coaches as $coach)
                            <tr @if ($loop->iteration % 2 == 0) class="even pointer" @else class="odd pointer" @endif>
                                <td class="text-center">
                                    @if ($coach['image_url'] == null || empty($coach['image_url']))
                                    <img src="{{ asset('assets/admin/images/user.png') }}" alt="..." class="img-circle profile_img">
                                    @else
                                    <img src="{{ asset('assets/admin/upload/'. $coach['image_url']) }}" alt="..." class="img-circle" style="width: 35px;">
                                    @endif
                                </td>
                                <td class=" " style="vertical-align: middle">{{ $coach['uid'] }}</td>
                                <td class=" " style="vertical-align: middle">{{ $coach['name'] }}</td>
                                <td class=" " style="vertical-align: middle">{{ $coach['specialist'] }}</td>
                                <td class=" " style="vertical-align: middle">{{ $coach['get_complex_name']['name'] }}</td>
                                <td class=" " style="vertical-align: middle">@if (empty($coach['mobile']))
                                    ---
                                    @else
                                    {{ $coach['mobile'] }}
                                    @endif
                                </td>
                                @if (Auth::guard('admin')->user()->user_type == 0)
                                <td class=" " style="vertical-align: middle">{{ $coach['get_role']['role'] }} </td>
                                @endif
                                <td class="text-center" style="vertical-align: middle">
                                    @if ($coach['status'] == 1)
                                        <a href="javascript:void(0)" class="updateCoachStatus" id="coach-{{ $coach['id'] }}" coach-id= {{ $coach['id'] }}>
                                            <i class="fa fa-toggle-on" status="Active" title="Active"></i>
                                        </a>
                                    @elseif ($coach['status'] == 0)
                                    <a href="javascript:void(0)" class="updateCoachStatus" id="coach-{{ $coach['id'] }}" coach-id= {{ $coach['id'] }}>
                                        <i class="fa fa-toggle-off" status="Inactive" title="Inactive"></i>
                                    </a>
                                    @endif
                                </td>
                                <td class="text-center" style="vertical-align: middle">
                                    <a href="{{ route('coach.update.show', $coach['id']) }}" title="Edit Coach Information"><i class="fa fa-edit mr-2" style="color: darkgreen; font-size: 18px"></i></a>
                                    <a href="#" title="View Coach Information"><i class="fa fa-eye" style="color: darkred; font-size: 18px"></i></a>
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