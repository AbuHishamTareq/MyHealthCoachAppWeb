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
                            <td style="font-size: 16px; width: 20%;">Coach Name:</td>
                            <td style="font-size: 16px;">{{ $patient['getCoach']['name'] }}</td>
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
                            <td style="font-size: 16px;">{{ number_format((($systolicResult - $distolicResult) * 1.6) + 80) . ' bpm' }}</td>
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
                <h2>Health Parameters</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="{{ route('parameter.transfer', $patient['id']) }}" method="POST">
                    @csrf
                    <input type="hidden" name="uid" id="uid" value="{{ $patient['uid'] }}">
                    <input type="hidden" name="name" id="name" value="{{ $patient['name'] }}">
                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label for="coach" style="font-size: 14px;">Transfer to:</label>
                            <select name="coach_name" id="coach_name" class="form-control">
                                <option value="">Select Health Coach</option>
                                @foreach ($coaches as $coach)
                                <option value="{{ $coach['id'] }}" {{ old("coach_name") == $coach['id'] ? "selected" : "" }}>
                                    {{ $coach['name'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label for="complex" style="font-size: 14px;">Complex Name:</label>
                            <input type="text" name="complex" id="complex" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success pull-right" style="margin-top: 28px;">Transfer Patient</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection