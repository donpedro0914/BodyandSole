@extends('layouts.app')

@section('content')
    @include('global.topnav')
    @include('global.sidemenu')
    <div class="content-page">
    	<div class="content">
    		<div class="container-fluid">
    			<div class="page-title-box">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Body and Sole</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Reports</a></li>
                        <li class="breadcrumb-item"><a href="/weekly-commission-reports">Weekly Commission Report</a></li>
                        <li class="breadcrumb-item active">Detailed Commission Report</li>
                    </ol>
                    <h4 class="page-title">Detailed Commission Report for {!! $therapistInfo->fullname !!}</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <div class="form-group">
                                <label>Date Range</label>
                                    <input class="form-control input-daterange-datepicker" id="daterange" type="text" name="daterange" value="{{ $startDate }} - {{ $endDate }}" readonly/>
                            </div>
                            <table id="commission" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">
                                <thead>
                                    <tr>
                                        <th class='text-center'>Day 1</th>
                                        <th class='text-center'>Day 2</th>
                                        <th class='text-center'>Day 3</th>
                                        <th class='text-center'>Day 4</th>
                                        <th class='text-center'>Day 5</th>
                                        <th class='text-center'>Day 6</th>
                                        <th class='text-center'>Day 7</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="table">
                                            @foreach($day1 as $d1)
                                                <tr>
                                                    <td>
                                                        @if($d1->service == '-')
                                                            {{ $d1->addon }} - {{ $d1->day5 }}
                                                        @else
                                                            {{ $d1->service_name }} - {{ $d1->day5 }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </table>
                                        </td>
                                        <td>
                                            <table class="table">
                                            @foreach($day2 as $d2)
                                                <tr>
                                                    <td>
                                                        @if($d2->service == '-')
                                                            {{ $d2->addon }} - {{ $d2->day6 }}
                                                        @else
                                                            {{ $d2->service_name }} - {{ $d2->day6 }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </table>
                                        </td>
                                        <td>
                                            <table class="table">
                                            @foreach($day3 as $d3)
                                                <tr>
                                                    <td>
                                                        @if($d3->service == '-')
                                                            {{ $d3->addon }} - {{ $d3->day0 }}
                                                        @else
                                                            {{ $d3->service_name }} - {{ $d3->day0 }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </table>
                                        </td>
                                        <td>
                                            <table class="table">
                                            @foreach($day4 as $d4)
                                                <tr>
                                                    <td>
                                                        @if($d4->service == '-')
                                                            {{ $d4->addon }} - {{ $d4->day1 }}
                                                        @else
                                                            {{ $d4->service_name }} - {{ $d4->day1 }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </table>
                                        </td>
                                        <td>
                                            <table class="table">
                                            @foreach($day5 as $d5)
                                                <tr>
                                                    <td>
                                                        @if($d5->service == '-')
                                                            {{ $d5->addon }} - {{ $d5->day2 }}
                                                        @else
                                                            {{ $d5->service_name }} - {{ $d5->day2 }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </table>
                                        </td>
                                        <td>
                                            <table class="table">
                                            @foreach($day6 as $d6)
                                                <tr>
                                                    <td>
                                                        @if($d6->service == '-')
                                                            {{ $d6->addon }} - {{ $d6->day3 }}
                                                        @else
                                                            {{ $d6->service_name }} - {{ $d6->day3 }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </table>
                                        </td>
                                        <td>
                                            <table class="table">
                                            @foreach($day7 as $d7)
                                                <tr>
                                                    <td>
                                                        @if($d7->service == '-')
                                                            {{ $d7->addon }} - {{ $d7->day4 }}
                                                        @else
                                                            {{ $d7->service_name }} - {{ $d7->day4 }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
    		</div>
    	</div>
    </div>
@endsection