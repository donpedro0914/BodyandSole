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
                                                    {{ $d1->service_name }} - 
                                                    {{ $d1->day5 }}
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
                                                    {{ $d2->service_name }} - 
                                                    {{ $d2->day6 }}
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
                                                    {{ $d3->service_name }} - 
                                                    {{ $d3->day0 }}
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
                                                    {{ $d4->service_name }} - 
                                                    {{ $d4->day1 }}
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
                                                    {{ $d5->service_name }} - 
                                                    {{ $d5->day2 }}
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
                                                    {{ $d6->service_name }} - 
                                                    {{ $d6->day3 }}
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
                                                    {{ $d7->service_name }} - 
                                                    {{ $d7->day4 }}
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