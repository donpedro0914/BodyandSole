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
                                        <th class='text-center'>Monday</th>
                                        <th class='text-center'>Tuesday</th>
                                        <th class='text-center'>Wednesday</th>
                                        <th class='text-center'>Thursday</th>
                                        <th class='text-center'>Friday</th>
                                        <th class='text-center'>Saturday</th>
                                        <th class='text-center'>Sunday</th>
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