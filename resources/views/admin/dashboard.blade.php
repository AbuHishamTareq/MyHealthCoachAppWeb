@extends('layouts.index')
@section('title')
My Health Coach | Dashboard
@endsection
@section('content')
<!-- top tiles -->
<div class="row" style="display: flex; justify-content: center;" >
    <div class="tile_count">
        <div class="col-md-4 col-sm-6  tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Patients</span>
            <div class="count">2500</div>
            <span class="count_bottom"><i class="green">4% </i> From last Week</span>
        </div>
        <div class="col-md-4 col-sm-6  tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Males</span>
            <div class="count green">2,500</div>
            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
        </div>
        <div class="col-md-4 col-sm-6  tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Females</span>
            <div class="count">4,567</div>
            <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection