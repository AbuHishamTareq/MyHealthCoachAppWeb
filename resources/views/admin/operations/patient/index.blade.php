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
        <h3>Operations | Patients</h3>
    </div>
    <div class="title_right">
        <div class="form-group row pull-right">
            <a href="{{ route('patient.show.import') }}" class="btn btn-info btn-xs text-uppercase"><i class="fa fa-download mr-2"></i>Import Patients</a>
            <a href="{{ route('patient.show.insert') }}" class="btn btn-success btn-xs text-uppercase"><i class="fa fa-plus mr-2"></i>Add New Patient</a>
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
                <h2>Search Options</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_title">
                <input type="hidden" name="searchToken" id="searchToken" value="{{ csrf_token() }}">
                <input type="hidden" name="searchUrl" id="searchUrl" value="{{ route('patient.serach') }}">
                <div class="form-group col-md-4 col-sm-4">
                    <label for="searchUID">ID / Iqama No.</label>
                    <input class="form-control" type="text" name="searchUID" id="searchUID">
                </div>
                <div class="form-group col-md-4 col-sm-4">
                    <label for="searchPName">Patient Name</label>
                    <input class="form-control" type="text" name="searchPName" id="searchPName">
                </div>
                <div class="form-group col-md-4 col-sm-4">
                    <label for="searchPhone">Mobile</label>
                    <input class="form-control" type="text" name="searchPhone" id="searchPhone">
                </div>
                <div class="form-group col-md-4 col-sm-4">
                    <label for="searchGender">Gender</label>
                    <select name="searchGender" id="searchGender" class="form-control">
                        <option value="All">All Patients</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </div>
                <div class="form-group col-md-4 col-sm-4">
                    <label for="searchCoach">Health Coach</label>
                    <select name="searchCoach" id="searchCoach" class="form-control">
                        <option value="All">All Health Coach</option>
                        @foreach ($coaches as $coach)
                        <option value="{{ $coach['id'] }}">{{ $coach['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Patients Table</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive" id="ajaxSearchDiv">
                    <table class="table table-striped jambo_table">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Patient UID</th>
                                <th class="column-title">Patient Name</th>
                                <th class="column-title">Gender</th>
                                <th class="column-title">Age</th>
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
                                <td class="text-center text-uppercase" style="font-size: 14px; color: darkred; font-weight: bold;" colspan="9">!! No Patients found !!</td>
                            </tr>
                        </tbody>
                        @else
                        <tbody>
                            @foreach ($patients as $patient)
                            <tr @if ($loop->iteration % 2 == 0) class="even pointer" @else class="odd pointer" @endif>
                                <td class=" " style="vertical-align: middle">{{ $patient['uid'] }}</td>
                                <td class=" " style="vertical-align: middle">{{ $patient['name'] }}</td>
                                <td class=" " style="vertical-align: middle">
                                    @if ($patient['gender'] == 'M')
                                        Male
                                    @else
                                        Female
                                    @endif
                                </td>
                                <td class=" " style="vertical-align: middle">{{ \Carbon\Carbon::parse($patient['birth_date'])->diff(\Carbon\Carbon::now())->format('%y years'); }}</td>
                                <td class=" " style="vertical-align: middle">{{ $patient['getComplex']['name'] }}</td>
                                <td class=" " style="vertical-align: middle">{{ $patient['getCoach']['name'] }}</td>
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
                                    <a href="#" title="Add Health Parameters"><i class="fa fa-plus mr-2" style="color: darkblue; font-size: 18px"></i></a>
                                    <a href="#" title="Edit Patient Information"><i class="fa fa-edit mr-2" style="color: darkgreen; font-size: 18px"></i></a>
                                    <a href="#" title="View Patient Information"><i class="fa fa-eye mr-2" style="color: darkred; font-size: 18px"></i></a>
                                    <a href="#" title="Transfer Patient"><i class="fa fa-exchange" style="color: black; font-size: 18px"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                    {{ $patients->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection