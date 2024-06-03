@extends('layouts.index')
@section('title')
My Health Coach | Complex
@endsection
@section('content')
<div class="page-title">
    <div class="title_left">
        <h3>Operations</h3>
    </div>
    <div class="title_right">
        <div class="col-md-3 col-sm-3 form-group row pull-right top_search">
            <a href="{{ route('complex.show') }}" class="btn btn-success btn-xs text-uppercase" style="width: 100%"><i class="fa fa-plus mr-2"></i>Add Complex</a>
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
                <h2>Complexes Table</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table">
                        <thead>
                            <tr class="headings">
                                <th class="column-title text-center"># </th>
                                <th class="column-title">Complex Name </th>
                                <th class="column-title">Region </th>
                                <th class="column-title">City </th>
                                <th class="column-title">Phone Number </th>
                                <th class="column-title">Status </th>
                                <th class="column-title no-link last text-center"><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        @if ($complexes == null || empty($complexes))
                        <tbody>
                            <tr class="even pointer">
                                <!-- class="odd pointer" -->
                                <td class="text-center text-uppercase" style="font-size: 14px; color: darkred; font-weight: bold;" colspan="7">!! No Comlexes found !!</td>
                            </tr>
                        </tbody>
                        @else
                        <tbody>
                            @foreach ($complexes as $complex)
                            <tr @if ($loop->iteration % 2 == 0) class="even pointer" @else class="odd pointer" @endif>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class=" ">{{ $complex['name'] }}</td>
                                <td class=" ">@if (empty($complex['region']))
                                ---
                                @else
                                {{ $complex['region'] }}
                                @endif
                                </td>
                                <td class=" ">{{ $complex['city'] }}</td>
                                <td class=" ">@if (empty($complex['phone_number']))
                                    ---
                                    @else
                                    {{ $complex['phone_number'] }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($complex['status'] == 1)
                                        <a href="javascript:void(0)" class="updateComplexStatus" id="complex-{{ $complex['id'] }}" complex-id= {{ $complex['id'] }}>
                                            <i class="fa fa-toggle-on" status="Active" title="Active"></i>
                                        </a>
                                    @elseif ($complex['status'] == 0)
                                    <a href="javascript:void(0)" class="updateComplexStatus" id="complex-{{ $complex['id'] }}" complex-id= {{ $complex['id'] }}>
                                        <i class="fa fa-toggle-off" status="Inactive" title="Inactive"></i>
                                    </a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('complex.update.show', $complex['id']) }}" title="Edit Complex"><i class="fa fa-edit mr-2" style="color: darkgreen; font-size: 18px"></i></a>
                                    <a href="#" title="View Complex"><i class="fa fa-eye" style="color: darkred; font-size: 18px"></i></a>
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