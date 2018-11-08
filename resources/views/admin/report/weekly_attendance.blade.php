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
                        <li class="breadcrumb-item active">Weekly Attendance Report</li>
                    </ol>
                    <h4 class="page-title">Weekly Attendance Report</h4>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <div class="form-group">
                                <label>Date Range Filter</label>
                                <input class="form-control input-daterange-datepicker" id="daterange" type="text" name="daterange" value="{{ $startDate }} - {{ $endDate }}"/ readonly="">
                            </div>
                            <table id="attendance" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">
                                <thead>
                                    <tr>
                                        <th class='text-center'>Therapist</th>
                                        <th class='text-center'>Day 1</th>
                                        <th class='text-center'>Day 2</th>
                                        <th class='text-center'>Day 3</th>
                                        <th class='text-center'>Day 4</th>
                                        <th class='text-center'>Day 5</th>
                                        <th class='text-center'>Day 6</th>
                                        <th class='text-center'>Day 7</th>
                                        <th class='text-center'># of Days</th>
                                    </tr>
                                </thead>
                                    @foreach($attendance as $a)
                                        <tr>
                                            <td>{{ $a->name }}</td>
                                            <td>
                                                @if($a->day1)
                                                    @php
                                                        $startTime = strtotime($a->time_in);
                                                        $endTime = strtotime($a->time_out);
                                                        $interval = abs($endTime - $startTime);
                                                        $hours = round($interval / 3600);
                                                        echo $hours;
                                                    @endphp
                                                @else
                                                {!! 0 !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if($a->day2)
                                                    @php
                                                        $startTime = strtotime($a->time_in);
                                                        $endTime = strtotime($a->time_out);
                                                        $interval = abs($endTime - $startTime);
                                                        $hours = round($interval / 3600);
                                                        echo $hours;
                                                    @endphp
                                                @else
                                                {!! 0 !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if($a->day3)
                                                    @php
                                                        $startTime = strtotime($a->time_in);
                                                        $endTime = strtotime($a->time_out);
                                                        $interval = abs($endTime - $startTime);
                                                        $hours = round($interval / 3600);
                                                        echo $hours;
                                                    @endphp
                                                @else
                                                {!! 0 !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if($a->day4)
                                                    @php
                                                        $startTime = strtotime($a->time_in);
                                                        $endTime = strtotime($a->time_out);
                                                        $interval = abs($endTime - $startTime);
                                                        $hours = round($interval / 3600);
                                                        echo $hours;
                                                    @endphp
                                                @else
                                                {!! 0 !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if($a->day5)
                                                    @php
                                                        $startTime = strtotime($a->time_in);
                                                        $endTime = strtotime($a->time_out);
                                                        $interval = abs($endTime - $startTime);
                                                        $hours = round($interval / 3600);
                                                        echo $hours;
                                                    @endphp
                                                @else
                                                {!! 0 !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if($a->day6)
                                                    @php
                                                        $startTime = strtotime($a->time_in);
                                                        $endTime = strtotime($a->time_out);
                                                        $interval = abs($endTime - $startTime);
                                                        $hours = round($interval / 3600);
                                                        echo $hours;
                                                    @endphp
                                                @else
                                                {!! 0 !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if($a->day7)
                                                    @php
                                                        $startTime = strtotime($a->time_in);
                                                        $endTime = strtotime($a->time_out);
                                                        $interval = abs($endTime - $startTime);
                                                        $hours = round($interval / 3600);
                                                        echo $hours;
                                                    @endphp
                                                @else
                                                {!! 0 !!}
                                                @endif
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('#attendance').DataTable({
            keys: true
        });
    });
</script>
@endpush