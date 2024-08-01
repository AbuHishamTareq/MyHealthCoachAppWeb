@extends('layouts.index')
@section('title')
My Health Coach | View Coach
@endsection
@section('class')
class="nav-md"
@endsection
@section('content')
<div class="page-title">
    <div class="title_left">
        <h3>Operation | Coach Details</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="col-md-12 col-sm-12  ">
    <div class="x_panel">
        <div class="x_content">
            <br/>
            <table class="table table-bordered">
                <tr>
                    <td style="width: 20%"><strong>Coach ID:</strong></td>
                    <td>{{ $coach['uid'] }}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><strong>Coach Name:</strong></td>
                    <td>{{ $coach['name'] }}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><strong>Email:</strong></td>
                    <td>{{ $coach['email'] }}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><strong>Address:</strong></td>
                    <td>{{ $coach['address'] }}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><strong>Phone Number:</strong></td>
                    <td>{{ $coach['mobile'] }}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><strong>Complex Name:</strong></td>
                    <td>{{ $coach['getComplexName']['name'] }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Coach Team Details</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped jambo_table">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">Patient UID</th>
                            <th class="column-title">Patient Name</th>
                            <th class="column-title">Gender</th>
                            <th class="column-title">Age</th>
                            <th class="column-title">Mobile</th>
                        </tr>
                    </thead>
                    @if ($patients == null || empty($patients))
                    <tbody>
                        <tr class="even pointer">
                            <!-- class="odd pointer" -->
                            <td class="text-center text-uppercase" style="font-size: 14px; color: darkred; font-weight: bold;" colspan="8">!! No Patients found !!</td>
                        </tr>
                    </tbody>
                    @else
                    <tbody>
                        @foreach ($patients as $patient)
                        <tr @if ($loop->iteration % 2 == 0) class="even pointer" @else class="odd pointer" @endif>
                            <td class=" " style="vertical-align: middle">{{ $patient['uid'] }}</td>
                            <td class=" " style="vertical-align: middle">{{ $patient['name'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($patient['birth_date'])->diff(\Carbon\Carbon::now())->format('%y years'); }}</td>
                            <td class=" " style="vertical-align: middle">
                                @if ($patient['gender'] == 'M')
                                    Male
                                @else
                                    Female
                                @endif
                            </td>
                            <td class=" " style="vertical-align: middle">@if (empty($patient['mobile']))
                                ---
                                @else
                                {{ $patient['mobile'] }}
                                @endif
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
@endsection