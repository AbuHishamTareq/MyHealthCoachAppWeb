<?php
    $age = \Carbon\Carbon::parse($patient['birth_date'])->diff(\Carbon\Carbon::now())->format('%y');
    $bmiResult = number_format($avgBmi[0]['bmi'], 2);
    $systolicResult = number_format($avgBp[0]['systolic']);
    $distolicResult = number_format($avgBp[0]['distolic']);
    $minWeight = 18.5 * (($patient['height'] / 100)^2);
    $maxWeight = 24.9 * (($patient['height'] / 100)^2);

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
                            <td style="font-size: 16px;">{{ number_format(($systolicResult - $distolicResult) * 1.6 + 80) . ' bpm' }}</td>
                            @else
                            <td style="font-size: 16px;">{{ number_format(0) . ' bpm' }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td style="font-size: 16px; width: 43%;">Blood Pressure Average:</td>
                            <td style="font-size: 16px;">{{ $systolicResult  . ' / ' . $distolicResult . ' mm Hg' }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 16px; width: 43%;">Body Mass Index (BMI) Average:</td>
                            <td style="font-size: 16px;">{{ $bmiResult }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 16px; width: 43%;">Body Fat Percentage %:</td>
                            @if ($bmiResult != 0)
                                @if ($patient['gender'] == 'M')
                                <td style="font-size: 16px;">{{ number_format((1.20 * $bmiResult) + (0.23 * $age) - 16.2, 2) . '%' }}</td>
                                @elseif ($patient['gender'] == 'F')
                                <td style="font-size: 16px;">{{ number_format((1.20 * $bmiResult) + (0.23 * $age) - 5.4, 2) . '%' }}</td>
                                @endif
                            @else
                            <td style="font-size: 16px;">{{ number_format(0.00, 2) . '%' }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td style="font-size: 16px; width: 43%;">Recommended Weight:</td>
                            <td style="font-size: 16px;">{{ $minWeight . ' kg - ' . $maxWeight . ' kg' }}</td>
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
                <h2>Health Parameters</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="{{ route('parameter.insert', $patient['id']) }}" method="POST">
                    @csrf
                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label for="bpSystolic" style="font-size: 14px;">Blood Pressure Systolic (mm Hg):</label>
                            <input type="text" name="bpSystolic" id="bpSystolic" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label for="bpDistolic" style="font-size: 14px;">Blood Pressure Distolic (mm Hg):</label>
                            <input type="text" name="bpDistolic" id="bpDistolic" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label for="rbs" style="font-size: 14px;">Blood Suger Level (mg/dL):</label>
                            <input type="text" name="rbs" id="rbs" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label for="pHeight" style="font-size: 14px;">Patient Height (cm):</label>
                            <input type="text" name="pHeight" id="pHeight" class="form-control" value="{{ $patient['height'] }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label for="pWeight" style="font-size: 14px;">Patient Weight (kg):</label>
                            <input type="text" name="pWeight" id="pWeight" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label for="bmi" style="font-size: 14px;">Body Mass Index (BMI):</label>
                            <input type="text" name="bmi" id="bmi" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success pull-right" style="margin-top: 28px;">Save Parameters</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Blood Pressure Report</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive col-md-6 col-sm-6">
                    <table class="table table-striped jambo_table">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Systolic</th>
                                <th class="column-title">Distolic</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Date</th>
                                <th class="column-title">Time</th>
                                <th class="column-title no-link last text-center"><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        @if ($bp == null || empty($bp))
                        <tbody>
                            <tr class="even pointer">
                                <!-- class="odd pointer" -->
                                <td class="text-center text-uppercase" style="font-size: 14px; color: darkred; font-weight: bold;" colspan="6">!! No Data found !!</td>
                            </tr>
                        </tbody>
                        @else
                        <tbody>
                            @foreach ($bp as $value)
                                @if (!empty($value['bp_systolic']) && !empty($value['bp_distolic']))
                                <tr @if ($loop->iteration % 2 == 0) class="even pointer" @else class="odd pointer" @endif>
                                    <td class=" " style="vertical-align: middle">{{ $value['bp_systolic'] . ' mm Hg' }}</td>
                                    <td class=" " style="vertical-align: middle">{{ $value['bp_distolic'] . ' mm Hg' }}</td>
                                    <td class=" " style="vertical-align: middle">
                                        @if ($value['bp_systolic'] < 120 && $value['bp_distolic'] < 80)
                                        Optimal<
                                        @elseif (($value['bp_systolic'] >= 120 && $value['bp_systolic'] <= 129) && ($value['bp_distolic'] >= 80 && $value['bp_distolic'] <= 84))
                                        Normal
                                        @elseif (($value['bp_systolic'] >= 130 && $value['bp_systolic'] <= 139) && ($value['bp_distolic'] >= 85 && $value['bp_distolic'] <= 89))
                                        High-Normal
                                        @else
                                        High
                                        @endif
                                    </td>
                                    <td class=" " style="vertical-align: middle">{{ $value['read_date'] }}</td>
                                    <td class=" " style="vertical-align: middle">{{ $value['read_time'] }}</td>
                                    <td class="text-center" style="vertical-align: middle">
                                        <a href="#" title="Edit Patient Information"><i class="fa fa-edit mr-2" style="color: darkgreen; font-size: 18px"></i></a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                    {{ $bp->links() }}
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="flex">
                        <div class="w-4/2">
                            {{ $cSystolic->container() }}
                        </div>
                    </div>
                    {{ $cSystolic->script() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Blood Suger Level Report</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive col-md-6 col-sm-6">
                    <table class="table table-striped jambo_table">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">RBS</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Date</th>
                                <th class="column-title">Time</th>
                                <th class="column-title no-link last text-center"><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        @if ($rbs == null || empty($rbs))
                        <tbody>
                            <tr class="even pointer">
                                <!-- class="odd pointer" -->
                                <td class="text-center text-uppercase" style="font-size: 14px; color: darkred; font-weight: bold;" colspan="6">!! No Data found !!</td>
                            </tr>
                        </tbody>
                        @else
                        <tbody>
                            @foreach ($rbs as $value)
                            @if (!empty($value['rbs']))
                            <tr @if ($loop->iteration % 2 == 0) class="even pointer" @else class="odd pointer" @endif>
                            <td class=" " style="vertical-align: middle">{{ $value['rbs']. ' mg/dL' }}</td>
                            <td class=" " style="vertical-align: middle">
                                @if ($value['rbs'] >= 110 && $value['rbs'] < 140)
                                Normal
                                @elseif ($value['rbs'] >= 140 && $value['rbs'] < 200)
                                Prediabetes
                                @elseif ($value['rbs'] >= 200)
                                Diabetes
                                @endif
                            </td>
                            <td class=" " style="vertical-align: middle">{{ $value['read_date'] }}</td>
                            <td class=" " style="vertical-align: middle">{{ $value['read_time'] }}</td>
                            <td class="text-center" style="vertical-align: middle">
                                <a href="#" title="Edit Patient Information"><i class="fa fa-edit mr-2" style="color: darkgreen; font-size: 18px"></i></a>
                            </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                    {{ $rbs->links() }}
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="flex">
                        <div class="w-4/2">
                            {{ $cRbs->container() }}
                        </div>
                    </div>
                    {{ $cRbs->script() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Body Mass Index Report</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive col-md-6 col-sm-6">
                    <table class="table table-striped jambo_table">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Weight</th>
                                <th class="column-title">BMI</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Date</th>
                                <th class="column-title">Time</th>
                                <th class="column-title no-link last text-center"><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        @if ($bmi == null || empty($bmi))
                        <tbody>
                            <tr class="even pointer">
                                <!-- class="odd pointer" -->
                                <td class="text-center text-uppercase" style="font-size: 14px; color: darkred; font-weight: bold;" colspan="6">!! No Data found !!</td>
                            </tr>
                        </tbody>
                        @else
                        <tbody>
                            @foreach ($bmi as $value)
                            @if (!empty($value['bmi']) && !empty($value['weight']))
                            <tr @if ($loop->iteration % 2 == 0) class="even pointer" @else class="odd pointer" @endif>
                            <td class=" " style="vertical-align: middle">{{ $value['weight']. ' kg' }}</td>
                            <td class=" " style="vertical-align: middle">{{ $value['bmi'] }}</td>
                            <td class=" " style="vertical-align: middle">
                                @if ($value['bmi'] < 18.5)
                                Underweight
                                @elseif ($value['bmi'] >= 18.5 && $value['bmi'] <= 24.9)
                                Normal Weight
                                @elseif ($value['bmi'] >= 25 && $value['bmi'] <= 29.9)
                                Overweight
                                @elseif ($value['bmi'] >= 30)
                                Obesity
                                @endif
                            </td>
                            <td class=" " style="vertical-align: middle">{{ $value['read_date'] }}</td>
                            <td class=" " style="vertical-align: middle">{{ $value['read_time'] }}</td>
                            <td class="text-center" style="vertical-align: middle">
                                <a href="#" title="Edit Patient Information"><i class="fa fa-edit mr-2" style="color: darkgreen; font-size: 18px"></i></a>
                            </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                    {{ $bmi->links() }}
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="flex">
                        <div class="w-4/2">
                            {{ $cBmi->container() }}
                        </div>
                    </div>
                    {{ $cBmi->script() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<!-- Chart.js -->
<script src="{{ url('assets/admin/vendors/Chart.js/dist/Chart.min.js') }}"></script>
@endsection