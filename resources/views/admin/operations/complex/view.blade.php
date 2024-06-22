@extends('layouts.index')
@section('title')
My Health Coach | View Complex
@endsection
@section('class')
class="nav-md"
@endsection
@section('content')
<div class="page-title">
    <div class="title_left">
        <h3>Operation | Complex Details</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="col-md-12 col-sm-12  ">
    <div class="x_panel">
        <div class="x_content">
            <br/>
            <table class="table table-bordered">
                <tr>
                    <td style="width: 20%"><strong>Complex Name:</strong></td>
                    <td>{{ $complex['name'] }}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><strong>Region:</strong></td>
                    <td>{{ $complex['region'] }}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><strong>City:</strong></td>
                    <td>{{ $complex['city'] }}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><strong>Address:</strong></td>
                    <td>{{ $complex['address'] }}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><strong>Phone Number:</strong></td>
                    <td>{{ $complex['phone_number'] }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Complex Users Details</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped jambo_table">
                    <thead>
                        <tr class="headings">
                            <th class="column-title text-center">image </th>
                            <th class="column-title">Coach UID</th>
                            <th class="column-title">Coach Name </th>
                            <th class="column-title">Phone Number </th>
                            @if (Auth::guard('admin')->user()->user_type == 0)
                            <th class="column-title">Role </th>
                            <th class="column-title no-link last text-center"><span class="nobr">Action</span></th>
                            @endif
                        </tr>
                    </thead>
                    @if ($coaches == null || empty($coaches))
                    <tbody>
                        <tr class="even pointer">
                            <!-- class="odd pointer" -->
                            <td class="text-center text-uppercase" style="font-size: 14px; color: darkred; font-weight: bold;" colspan="8">!! No Health Coaches found !!</td>
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
                            <td class=" " style="vertical-align: middle">@if (empty($coach['mobile']))
                                ---
                                @else
                                {{ $coach['mobile'] }}
                                @endif
                            </td>
                            @if (Auth::guard('admin')->user()->user_type == 0 || Auth::guard('admin')->user()->user_type == 1)
                            <td class=" " style="vertical-align: middle">{{ $coach['get_role']['role'] }} </td>
                            <td class="text-center" style="vertical-align: middle">
                                <a href="#" title="Edit Coach Information"><i class="fa fa-edit mr-2" style="color: darkgreen; font-size: 18px"></i></a>
                                <a href="#" title="View Coach Information"><i class="fa fa-eye" style="color: darkred; font-size: 18px"></i></a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection