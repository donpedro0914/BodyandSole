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
                                <form action="{{ route('wcr_filter') }}" method="get">
                                    <input type="hidden" name="startDate" id="startDate" value="{{ $startDate }}"/>
                                    <input type="hidden" name="endDate" id="endDate" value="{{ $endDate }}"/>
                                    <label>Date Range Filter</label>
                                    <div class="input-group">
                                        <input class="form-control input-daterange-datepicker" id="daterange" type="text"value="{{ $startDate }} - {{ $endDate }}"/>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary waves-effect waves-light" id="date_filter" type="submit">Filter</button>
                                        </div>
                                    </div>
                                </form>
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
                                        <th class='text-center'>Total # of Hours</th>
                                    </tr>
                                </thead>
                                    @foreach($attendance as $a)
                                        <tr>
                                            <td>{{ $a->name }}</td>
                                            <td>
                                                @if($a->day1)
                                                    @if($a->day1 > 8)
                                                        {{ $a->day1 }} (OT: {{ $a->day1 % 8}}hrs)
                                                    @elseif($a->day1 = 8)
                                                        {{ $a->day1 }}
                                                    @endif
                                                @else
                                                {!! 0 !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if($a->day2)
                                                    @if($a->day2 > 8)
                                                        {{ $a->day2 }} (OT: {{ $a->day2 % 8}}hrs)
                                                    @elseif($a->day2 = 8)
                                                        {{ $a->day2 }}
                                                    @endif
                                                @else
                                                {!! 0 !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if($a->day3)
                                                    @if($a->day3 > 8)
                                                        {{ $a->day3 }} (OT: {{ $a->day3 % 8}}hrs)
                                                    @elseif($a->day3 = 8)
                                                        {{ $a->day3 }}
                                                    @endif
                                                @else
                                                {!! 0 !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if($a->day4)
                                                    @if($a->day4 > 8)
                                                        {{ $a->day4 }} (OT: {{ $a->day4 % 8}}hrs)
                                                    @elseif($a->day4 = 8)
                                                        {{ $a->day4 }}
                                                    @endif
                                                @else
                                                {!! 0 !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if($a->day5)
                                                    @if($a->day5 > 8)
                                                        {{ $a->day5 }} (OT: {{ $a->day5 % 8}}hrs)
                                                    @elseif($a->day5 = 8)
                                                        {{ $a->day5 }}
                                                    @endif
                                                @else
                                                {!! 0 !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if($a->day6)
                                                    @if($a->day6 > 8)
                                                        {{ $a->day6 }} (OT: {{ $a->day6 % 8}}hrs)
                                                    @elseif($a->day6 = 8)
                                                        {{ $a->day6 }}
                                                    @endif
                                                @else
                                                {!! 0 !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if($a->day7)
                                                    @if($a->day7 > 8)
                                                        {{ $a->day7 }} (OT: {{ $a->day7 % 8}}hrs)
                                                    @elseif($a->day7 = 8)
                                                        {{ $a->day7 }}
                                                    @endif
                                                @else
                                                {!! 0 !!}
                                                @endif
                                            </td>
                                            <td>{{ $a->day1 + $a->day2 + $a->day3 + $a->day4 + $a->day5 + $a->day6 + $a->day7 }} Hrs</td>
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

        $('.input-daterange-datepicker').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-success',
            cancelClass: 'btn-light',
        });

        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            var start = picker.startDate.format('YYYY-MM-DD');
            var end = picker.endDate.format('YYYY-MM-DD');

            $('#startDate').val(start);
            $('#endDate').val(end);
        });
    });
</script>
@endpush