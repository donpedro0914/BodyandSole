@extends('layouts.appfront')

@section('content')
    @include('global.front_topnav')
    <div class="wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <form action="" method="get">
                                <input type="hidden" name="startDate" id="startDate" value="{{ $startDate }}"/>
                                <input type="hidden" name="endDate" id="endDate" value="{{ $endDate }}"/>
                                <label>Date Range Filter</label>
                                <div class="input-group">
                                    <input class="form-control input-daterange-datepicker" id="daterange" type="text" value="{{ $startDate }} - {{ $endDate }}"/>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary waves-effect waves-light" id="date_filter" type="submit">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table id="attendance" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Mon</th>
                                    <th>Tue</th>
                                    <th>Wed</th>
                                    <th>Thurs</th>
                                    <th>Fri</th>
                                    <th>Sat</th>
                                    <th>Sun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(App\Therapist::all() as $a)
                                <tr>
                                    <td>{{ $a->fullname }}</td>
                                    @for ($i = 1; $i <= 7; $i++)
                                    <td>
                                        @forelse (\App\Attendance::whereRaw('user_id = '. $a->id.' AND DATE_FORMAT(created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")')->get() as $attendance)
                                        @if ($day == $i)
                                            @if ($attendance->time_in AND $attendance->time_out)
                                                <table class="table table-bordered" id="attendance_table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="bg-success font-white">
                                                                @php
                                                                    $date = \Carbon\Carbon::parse($attendance->time_in);
                                                                @endphp
                                                                {{ date_format($date, 'Y-m-d h:i:s A') }}
                                                            </td>
                                                            <td class="bg-primary font-white v-align-mid" rowspan="2">
                                                                @php
                                                                    $hourdiff = round((strtotime($attendance->time_out) - strtotime($attendance->time_in))/3600, 1);
                                                                    $hourdiff2 = $hourdiff - 1;
                                                                @endphp
                                                                {{ $hourdiff }}hrs
                                                                <div class="clearfix"></div>
                                                                {{ $hourdiff2 % 8 }}hrs(ot)
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bg-danger font-white">
                                                                @php
                                                                    $date = \Carbon\Carbon::parse($attendance->time_out);
                                                                @endphp
                                                                {{ date_format($date, 'Y-m-d h:i:s A') }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>                                                                
                                            @else
                                                @if (!$attendance->time_in)
                                                    <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                @else
                                                    @php
                                                        $date = \Carbon\Carbon::parse($attendance->time_in);
                                                    @endphp
                                                    {{ date_format($date, 'Y-m-d h:i:s A') }}
                                                @endif
                                                <div class="clearfix"></div>
                                                @if (!$attendance->time_out)
                                                    <div><button class="btn btn-block btn-sm btn-danger time_out" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time Out</button></div>
                                                @else
                                                    @php
                                                        $date = \Carbon\Carbon::parse($attendance->time_out);
                                                    @endphp
                                                    {{ date_format($date, 'Y-m-d h:i:s A') }}
                                                @endif
                                            @endif
                                        @else
                                            <div><button class="btn btn-block btn-sm btn-success time_in" disabled>Time In</button></div>
                                            <div class="clearfix"></div>
                                            <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>
                                        @endif
                                        @empty
                                            @if ($day == $i)
                                                <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                <div class="clearfix"></div>
                                                <div><button class="btn btn-block btn-sm btn-danger">Time Out</button></div>
                                            @else
                                                <div><button class="btn btn-block btn-sm btn-success time_in" disabled>Time In</button></div>
                                                <div class="clearfix"></div>
                                                <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>
                                            @endif
                                        @endforelse
                                    </td>
                                    @endfor
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">

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
</script>
@endpush