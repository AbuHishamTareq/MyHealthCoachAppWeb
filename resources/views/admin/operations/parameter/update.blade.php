<?php
    $age = \Carbon\Carbon::parse($patient['birth_date'])->diff(\Carbon\Carbon::now())->format('%y');
    $bmiResult = number_format($avgBmi[0]['bmi'], 2);
    $systolicResult = number_format($avgBp[0]['systolic']);
    $distolicResult = number_format($avgBp[0]['distolic']);
    $minWeight = number_format(18.5 * pow(($patient['height'] / 100), 2), 2);
    $maxWeight = number_format(24.9 * pow(($patient['height'] / 100), 2), 2);
?>

@extends('layouts.index')
@section('title')
My Health Coach | Patient Health Parameters
@endsection
@section('class')
class="nav-md"
@endsection
@section('content')
<div class="page-title">
    <div class="title_left">
        <h3>Operations | Patient Health Parameters</h3>
    </div>
    <div class="title_right">
        <div class="form-group row pull-right">
            <a href="{{ route('patient.index') }}" class="btn btn-info btn-xs text-uppercase">Cancel</a>
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
@if (Session::has('error'))
<div class="alert alert-danger" role="alert">
    <strong>Error: </strong>{{ Session::get('error') }}
    <hr>
</div>
@endif
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Patient Information</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-6 col-sm-6">
                    <table style="width: 100%">
                        <tr>
                            <td style="font-size: 16px; width: 20%;">Patient UID:</td>
                            <td style="font-size: 16px;">{{ $patient['uid'] }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 16px; width: 20%;">Patient Name:</td>
                            <td style="font-size: 16px;">{{ $patient['name'] }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 16px; width: 20%;">Gender:</td>
                            @if ($patient['gender'] == 'M')
                            <td style="font-size: 16px;">Male</td>
                            @else
                            <td style="font-size: 16px;">Female</td>
                            @endif
                        </tr>
                        <tr>
                            <td style="font-size: 16px; width: 20%;">Age:</td>
                            <td style="font-size: 16px;">{{ $age . ' years' }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 16px; width: 20%;">Patient Height:</td>
                            <td style="font-size: 16px;">{{ $patient['height'] . ' cm' }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 16px; width: 20%;">Blood Group:</td>
                            <td style="font-size: 16px;">{{ $patient['blood_group'] }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6 col-sm-6">
                    <table style="width: 100%">
                        <tr>
                            <td style="font-size: 16px; width: 43%;">Heart Rate Average:</td>
                            @if ($systolicResult != 0 && $distolicResult != 0)
                            <td style="font-size: 16px;">
                                <span id="heartRate">{{ number_format((($systolicResult - $distolicResult) * 1.6) + 80) . ' bpm' }}</span>
                            </td>
                            @else
                            <td style="font-size: 16px;">{{ number_format(0) . ' bpm' }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td style="font-size: 16px; width: 43%;">Blood Pressure Average:</td>
                            <td style="font-size: 16px;">
                                <span id="bpAvg">{{ $systolicResult  . ' / ' . $distolicResult . ' mm Hg' }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 16px; width: 43%;">Body Mass Index (BMI) Average:</td>
                            <td style="font-size: 16px;">
                                <span id="bmiAvg">{{ $bmiResult }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 16px; width: 43%;">Body Fat Percentage %:</td>
                            @if ($bmiResult != 0)
                                @if ($patient['gender'] == 'M')
                                <td style="font-size: 16px;">
                                    <span id='mFatAvg'>{{ number_format((1.20 * $bmiResult) + (0.23 * $age) - 16.2, 2) . '%' }}</span>
                                </td>
                                @elseif ($patient['gender'] == 'F')
                                <td style="font-size: 16px;">
                                    <span id='fFatAvg'>{{ number_format((1.20 * $bmiResult) + (0.23 * $age) - 5.4, 2) . '%' }}</span>
                                </td>
                                @endif
                            @else
                            <td style="font-size: 16px;">{{ number_format(0.00, 2) . '%' }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td style="font-size: 16px; width: 43%;">Recommended Weight:</td>
                            <td style="font-size: 16px;">{{ $minWeight . ' kg - ' . $maxWeight . ' kg' }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 16px; width: 43%;">Steps Target:</td>
                            <td style="font-size: 16px;">{{ $patient['step_target'] . ' steps' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Steps</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="{{ route('parameter.update', $patient['id']) }}" method="POST">
                    @csrf
                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label for="target" style="font-size: 14px;">Target:</label>
                            <input type="text" name="target" id="target" class="form-control" value={{ $patient['step_target'] }}>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success pull-right" style="margin-top: 28px;">Save Target</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Weight and Body Mass Index</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table id="weightTable" class="table table-striped jambo_table">
                        <thead>
                            <tr class="headings">
                                <th class="column-title text-center">Weight</th>
                                <th class="column-title text-center">BMI</th>
                                <th class="column-title text-center">Entry Date</th>
                                <th class="column-title text-center">Entry Time</th>
                                <th class="column-title no-link last text-center"><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        @if ($weights == null || empty($weights))
                        <tbody>
                            <tr class="even pointer">
                                <!-- class="odd pointer" -->
                                <td class="text-center text-uppercase" style="font-size: 14px; color: darkred; font-weight: bold;" colspan="5">!! No Data found !!</td>
                            </tr>
                        </tbody>
                        @else
                        <tbody>
                            @foreach ($weights as $weight)
                                <tr>
                                    <td class="text-center">
                                        <span id="weightSpan-{{ $weight['id'] }}">{{ number_format($weight['weight'], 2) }}</span>
                                        <input class="text-center" style="display: none;" type="text" name="pWeight" id="pWeight-{{ $weight['id'] }}" value="{{ number_format($weight['weight'], 2) }}">
                                    </td>
                                    <td class="text-center"><span id="bmiSpan-{{ $weight['id'] }}">{{ number_format($weight['bmi'], 2) }}</span></td>
                                    <td class="text-center">{{ $weight['read_date'] }}</td>
                                    <td class="text-center">{{ $weight['read_time'] }}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="weightEditLink" id="weightEditLink-{{ $weight['id'] }}" row-id={{ $weight['id'] }} title="Edit Weight"><i class="fa fa-edit mr-2" style="color: darkgreen; font-size: 18px"></i></a>
                                        <a href="javascript:void(0)" class="weightSaveLink" style="display: none" row-id={{ $weight['id'] }} id="weightSaveLink-{{ $weight['id'] }}" height-data={{ $patient['height'] }} patient={{ $weight['patient_id'] }} age={{ $age }} gender={{ $patient['gender'] }} title="Save Data"><i class="fa fa-check mr-2" style="color: darkgreen; font-size: 18px"></i></a>
                                        <a href="javascript:void(0)" class="weightCancelLink" style="display: none" id="weightCancelLink-{{ $weight['id'] }}" row-id={{ $weight['id'] }} title="Cancel"><i class="fa fa-times mr-2" style="color: darkred; font-size: 18px"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                    {{ $weights->links() }}
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Blood Suger Level</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table id="rbsTable" class="table table-striped jambo_table">
                        <thead>
                            <tr class="headings">
                                <th class="column-title text-center">Rbs</th>
                                <th class="column-title text-center">Entry Date</th>
                                <th class="column-title text-center">Entry Time</th>
                                <th class="column-title no-link last text-center"><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        @if ($rbs == null || empty($rbs))
                        <tbody>
                            <tr class="even pointer">
                                <!-- class="odd pointer" -->
                                <td class="text-center text-uppercase" style="font-size: 14px; color: darkred; font-weight: bold;" colspan="5">!! No Data found !!</td>
                            </tr>
                        </tbody>
                        @else
                        <tbody>
                            @foreach ($rbs as $value)
                                <tr>
                                    <td class="text-center">
                                        <span id="rbsSpan-{{ $value['id'] }}">{{ $value['rbs'] }}</span>
                                        <input class="text-center" style="display: none;" type="text" name="pRbs" id="pRbs-{{ $value['id'] }}" value="{{ $value['rbs'] }}">
                                    </td>
                                    <td class="text-center">{{ $value['read_date'] }}</td>
                                    <td class="text-center">{{ $value['read_time'] }}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="rbsEditLink" id="rbsEditLink-{{ $value['id'] }}" row-id={{ $value['id'] }} title="Edit Rbs"><i class="fa fa-edit mr-2" style="color: darkgreen; font-size: 18px"></i></a>
                                        <a href="javascript:void(0)" class="rbsSaveLink" style="display: none" row-id={{ $value['id'] }} id="rbsSaveLink-{{ $value['id'] }}" title="Save Data"><i class="fa fa-check mr-2" style="color: darkgreen; font-size: 18px"></i></a>
                                        <a href="javascript:void(0)" class="rbsCancelLink" style="display: none" id="rbsCancelLink-{{ $value['id'] }}" row-id={{ $value['id'] }} title="Cancel"><i class="fa fa-times mr-2" style="color: darkred; font-size: 18px"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                    {{ $rbs->links() }}
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Blood Pressure</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table id="bpTable" class="table table-striped jambo_table">
                        <thead>
                            <tr class="headings">
                                <th class="column-title text-center">Systolic</th>
                                <th class="column-title text-center">Distolic</th>
                                <th class="column-title text-center">Entry Date</th>
                                <th class="column-title text-center">Entry Time</th>
                                <th class="column-title no-link last text-center"><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        @if ($bps == null || empty($bps))
                        <tbody>
                            <tr class="even pointer">
                                <!-- class="odd pointer" -->
                                <td class="text-center text-uppercase" style="font-size: 14px; color: darkred; font-weight: bold;" colspan="5">!! No Data found !!</td>
                            </tr>
                        </tbody>
                        @else
                        <tbody>
                            @foreach ($bps as $bp)
                                <tr>
                                    <td class="text-center">
                                        <span id="bpSysSpan-{{ $bp['id'] }}">{{ $bp['systolic'] }}</span>
                                        <input class="text-center" style="display: none;" type="text" name="pSys" id="pSys-{{ $bp['id'] }}" value="{{ $bp['systolic'] }}">
                                    </td>
                                    <td class="text-center">
                                        <span id="bpDisSpan-{{ $bp['id'] }}">{{ $bp['distolic'] }}</span>
                                        <input class="text-center" style="display: none;" type="text" name="pDis" id="pDis-{{ $bp['id'] }}" value="{{ $bp['distolic'] }}">
                                    </td>
                                    <td class="text-center">{{ $bp['read_date'] }}</td>
                                    <td class="text-center">{{ $bp['read_time'] }}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="bpEditLink" id="bpEditLink-{{ $bp['id'] }}" row-id={{ $bp['id'] }} title="Edit Blood Pressure"><i class="fa fa-edit mr-2" style="color: darkgreen; font-size: 18px"></i></a>
                                        <a href="javascript:void(0)" class="bpSaveLink" style="display: none" row-id={{ $bp['id'] }} id="bpSaveLink-{{ $bp['id'] }}" patient={{ $bp['patient_id'] }} title="Save Data"><i class="fa fa-check mr-2" style="color: darkgreen; font-size: 18px"></i></a>
                                        <a href="javascript:void(0)" class="bpCancelLink" style="display: none" id="bpCancelLink-{{ $bp['id'] }}" row-id={{ $bp['id'] }} title="Cancel"><i class="fa fa-times mr-2" style="color: darkred; font-size: 18px"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                    {{ $bps->links() }}
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection