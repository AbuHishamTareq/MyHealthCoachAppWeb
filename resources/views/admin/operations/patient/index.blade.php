@extends('layouts.index')
@section('title')
My Health Coach | Patient
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
            <a href="{{ route('patient.show.insert') }}" class="btn btn-success btn-xs text-uppercase" style="width: 100%"><i class="fa fa-plus mr-2"></i>Add New Patient</a>
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
                <h2>Patients Table</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Patient UID</th>
                                <th class="column-title">Patient Name</th>
                                <th class="column-title">Complex Name</th>
                                <th class="column-title">Health Coach</th>
                                <th class="column-title">Mobile</th>
                                <th class="column-title">Status</th>
                                <th class="column-title no-link last text-center"><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        @if ($patients == null || empty($patients))
                        <tbody>
                            <tr class="even pointer">
                                <!-- class="odd pointer" -->
                                <td class="text-center text-uppercase" style="font-size: 14px; color: darkred; font-weight: bold;" colspan="7">!! No Patients found !!</td>
                            </tr>
                        </tbody>
                        @else
                        <tbody>
                            @foreach ($patients as $patient)
                            <tr @if ($loop->iteration % 2 == 0) class="even pointer" @else class="odd pointer" @endif>
                                <td class=" " style="vertical-align: middle">{{ $patient['uid'] }}</td>
                                <td class=" " style="vertical-align: middle">{{ $patient['name'] }}</td>
                                <td class=" " style="vertical-align: middle">{{ $patient['complex_id'] }}</td>
                                <td class=" " style="vertical-align: middle">{{ $patient['coach_id'] }}</td>
                                <td class=" " style="vertical-align: middle">{{ $patient['mobile'] }}</td>
                                <td class="text-center" style="vertical-align: middle">
                                    @if ($patient['status'] == 1)
                                        <a href="javascript:void(0)" class="updatePatientStatus" id="patient-{{ $patient['id'] }}" patient-id= {{ $patient['id'] }}>
                                            <i class="fa fa-toggle-on" status="Active" title="Active"></i>
                                        </a>
                                    @elseif ($patient['status'] == 0)
                                    <a href="javascript:void(0)" class="updatePatientStatus" id="patient-{{ $patient['id'] }}" patient-id= {{ $patient['id'] }}>
                                        <i class="fa fa-toggle-off" status="Inactive" title="Inactive"></i>
                                    </a>
                                    @endif
                                </td>
                                <td class="text-center" style="vertical-align: middle">
                                    <a href="#" title="Edit Patient Information"><i class="fa fa-edit mr-2" style="color: darkgreen; font-size: 18px"></i></a>
                                    <a href="#" title="View Patient Information"><i class="fa fa-eye" style="color: darkred; font-size: 18px"></i></a>
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