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
                                    <input type="hidden" name="startDate" id="startDate" value="{{ $startDate . ' 00:00:00' }}"/>
                                    <input type="hidden" name="endDate" id="endDate" value="{{ $endDate . ' 23:59:59' }}"/>
                                    <label>Date Range Filter</label>
                                    <div class="input-group">
                                        <input class="form-control input-daterange-datepicker" id="daterange" type="text"value="{{ $startDate . ' 00:00:00' }} - {{ $endDate . ' 23:59:59' }}"/>
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
                                        <td> <!-- Day 1 -->
                                            @if (!count($a->attendances))
                                                @if ($day == '1')
                                                    <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                    <div class="clearfix"></div>
                                                    <div><button class="btn btn-block btn-sm btn-danger">Time Out</button></div>
                                                @else
                                                    <div><button class="btn btn-block btn-sm btn-success time_in" disabled>Time In</button></div>
                                                    <div class="clearfix"></div>
                                                    <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>
                                                @endif
                                            @else
                                                @forelse ($a->attendances->where('created_at', '>=', $startDate . ' 00:00:00')->where('created_at', '<=', $endDate . ' 23:59:59')->where('day', '1') as $attendance)
                                                    @if ($attendance->day == '1')
                                                        @if ($attendance->time_in AND $attendance->time_out)
                                                            <table class="table table-bordered" id="attendance_table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="bg-success font-white">{{ $attendance->time_in }}</td>
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
                                                                        <td class="bg-danger font-white">{{ $attendance->time_out }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        @else
                                                            @if (!$attendance->time_in)
                                                                <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                            @else
                                                                {{ $attendance->time_in }}
                                                            @endif
                                                            <div class="clearfix"></div>
                                                            @if (!$attendance->time_out)
                                                                <div><button class="btn btn-block btn-sm btn-danger time_out" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time Out</button></div>
                                                            @else
                                                                {{ $attendance->time_out }}
                                                            @endif
                                                        @endif                                                                                          
                                                    @else
                                                        @if (!$attendance->time_in)
                                                            <div><button class="btn btn-block btn-sm btn-success" disabled>Time In</button></div>
                                                        @else
                                                            {{ $attendance->time_in }}
                                                        @endif
                                                        <div class="clearfix"></div>
                                                        @if (!$attendance->time_out)
                                                            <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>
                                                        @else
                                                            {{ $attendance->time_out }}
                                                        @endif                                                            
                                                    @endif
                                                @empty
                                                    @if ($day == '1')
                                                        <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                        <div class="clearfix"></div>
                                                        <div><button class="btn btn-block btn-sm btn-danger">Time Out</button></div>
                                                    @else
                                                        <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}" disabled>Time In</button></div>
                                                        <div class="clearfix"></div>
                                                        <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>                     
                                                    @endif
                                            @endforelse
                                            @endif
                                        </td>
                                        <td> <!-- Day 2 -->
                                            @if (!count($a->attendances))
                                                @if ($day == '2')
                                                    <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                    <div class="clearfix"></div>
                                                    <div><button class="btn btn-block btn-sm btn-danger">Time Out</button></div>
                                                @else
                                                    <div><button class="btn btn-block btn-sm btn-success time_in" disabled>Time In</button></div>
                                                    <div class="clearfix"></div>
                                                    <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>
                                                @endif
                                            @else
                                                @forelse ($a->attendances->where('created_at', '>=', $startDate . ' 00:00:00')->where('created_at', '<=', $endDate . ' 23:59:59')->where('day', '2') as $attendance)
                                                    @if ($attendance->day == '2')
                                                        @if ($attendance->time_in AND $attendance->time_out)
                                                            <table class="table table-bordered" id="attendance_table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="bg-success font-white">{{ $attendance->time_in }}</td>
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
                                                                        <td class="bg-danger font-white">{{ $attendance->time_out }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        @else
                                                            @if (!$attendance->time_in)
                                                                <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                            @else
                                                                {{ $attendance->time_in }}
                                                            @endif
                                                            <div class="clearfix"></div>
                                                            @if (!$attendance->time_out)
                                                                <div><button class="btn btn-block btn-sm btn-danger time_out" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time Out</button></div>
                                                            @else
                                                                {{ $attendance->time_out }}
                                                            @endif
                                                        @endif                                                                                          
                                                    @else
                                                        @if (!$attendance->time_in)
                                                            <div><button class="btn btn-block btn-sm btn-success" disabled>Time In</button></div>
                                                        @else
                                                            {{ $attendance->time_in }}
                                                        @endif
                                                        <div class="clearfix"></div>
                                                        @if (!$attendance->time_out)
                                                            <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>
                                                        @else
                                                            {{ $attendance->time_out }}
                                                        @endif                                                            
                                                    @endif
                                                @empty
                                                    @if ($day == '2')
                                                        <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                        <div class="clearfix"></div>
                                                        <div><button class="btn btn-block btn-sm btn-danger">Time Out</button></div>
                                                    @else
                                                        <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}" disabled>Time In</button></div>
                                                        <div class="clearfix"></div>
                                                        <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>                     
                                                    @endif
                                            @endforelse
                                            @endif
                                        </td>
                                        <td> <!-- Day 3 -->
                                            @if (!count($a->attendances))
                                                @if ($day == '3')
                                                    <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                    <div class="clearfix"></div>
                                                    <div><button class="btn btn-block btn-sm btn-danger">Time Out</button></div>
                                                @else
                                                    <div><button class="btn btn-block btn-sm btn-success time_in" disabled>Time In</button></div>
                                                    <div class="clearfix"></div>
                                                    <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>
                                                @endif
                                            @else
                                                @forelse ($a->attendances->where('created_at', '>=', $startDate . ' 00:00:00')->where('created_at', '<=', $endDate . ' 23:59:59')->where('day', '3') as $attendance)
                                                    @if ($attendance->day == '3')
                                                        @if ($attendance->time_in AND $attendance->time_out)
                                                            <table class="table table-bordered" id="attendance_table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="bg-success font-white">{{ $attendance->time_in }}</td>
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
                                                                        <td class="bg-danger font-white">{{ $attendance->time_out }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        @else
                                                            @if (!$attendance->time_in)
                                                                <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                            @else
                                                                {{ $attendance->time_in }}
                                                            @endif
                                                            <div class="clearfix"></div>
                                                            @if (!$attendance->time_out)
                                                                <div><button class="btn btn-block btn-sm btn-danger time_out" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time Out</button></div>
                                                            @else
                                                                {{ $attendance->time_out }}
                                                            @endif
                                                        @endif                                                                                          
                                                    @else
                                                        @if (!$attendance->time_in)
                                                            <div><button class="btn btn-block btn-sm btn-success" disabled>Time In</button></div>
                                                        @else
                                                            {{ $attendance->time_in }}
                                                        @endif
                                                        <div class="clearfix"></div>
                                                        @if (!$attendance->time_out)
                                                            <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>
                                                        @else
                                                            {{ $attendance->time_out }}
                                                        @endif                                                            
                                                    @endif
                                                @empty
                                                    @if ($day == '3')
                                                        <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                        <div class="clearfix"></div>
                                                        <div><button class="btn btn-block btn-sm btn-danger">Time Out</button></div>
                                                    @else
                                                        <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}" disabled>Time In</button></div>
                                                        <div class="clearfix"></div>
                                                        <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>                     
                                                    @endif
                                            @endforelse
                                            @endif
                                        </td>
                                        <td> <!-- Day 4 -->
                                            @if (!count($a->attendances))
                                                @if ($day == '4')
                                                    <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                    <div class="clearfix"></div>
                                                    <div><button class="btn btn-block btn-sm btn-danger">Time Out</button></div>
                                                @else
                                                    <div><button class="btn btn-block btn-sm btn-success time_in" disabled>Time In</button></div>
                                                    <div class="clearfix"></div>
                                                    <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>
                                                @endif
                                            @else
                                                @forelse ($a->attendances->where('created_at', '>=', $startDate . ' 00:00:00')->where('created_at', '<=', $endDate . ' 23:59:59')->where('day', '4') as $attendance)
                                                    @if ($attendance->day == '4')
                                                        @if ($attendance->time_in AND $attendance->time_out)
                                                            <table class="table table-bordered" id="attendance_table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="bg-success font-white">{{ $attendance->time_in }}</td>
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
                                                                        <td class="bg-danger font-white">{{ $attendance->time_out }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        @else
                                                            @if (!$attendance->time_in)
                                                                <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                            @else
                                                                {{ $attendance->time_in }}
                                                            @endif
                                                            <div class="clearfix"></div>
                                                            @if (!$attendance->time_out)
                                                                <div><button class="btn btn-block btn-sm btn-danger time_out" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time Out</button></div>
                                                            @else
                                                                {{ $attendance->time_out }}
                                                            @endif
                                                        @endif                                                                                          
                                                    @else
                                                        @if (!$attendance->time_in)
                                                            <div><button class="btn btn-block btn-sm btn-success" disabled>Time In</button></div>
                                                        @else
                                                            {{ $attendance->time_in }}
                                                        @endif
                                                        <div class="clearfix"></div>
                                                        @if (!$attendance->time_out)
                                                            <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>
                                                        @else
                                                            {{ $attendance->time_out }}
                                                        @endif                                                            
                                                    @endif
                                                @empty
                                                    @if ($day == '4')
                                                        <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                        <div class="clearfix"></div>
                                                        <div><button class="btn btn-block btn-sm btn-danger">Time Out</button></div>
                                                    @else
                                                        <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}" disabled>Time In</button></div>
                                                        <div class="clearfix"></div>
                                                        <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>                     
                                                    @endif
                                            @endforelse
                                            @endif
                                        </td>
                                        <td> <!-- Day 5 -->
                                            @if (!count($a->attendances))
                                                @if ($day == '5')
                                                    <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                    <div class="clearfix"></div>
                                                    <div><button class="btn btn-block btn-sm btn-danger">Time Out</button></div>
                                                @else
                                                    <div><button class="btn btn-block btn-sm btn-success time_in" disabled>Time In</button></div>
                                                    <div class="clearfix"></div>
                                                    <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>
                                                @endif
                                            @else
                                                @forelse ($a->attendances->where('created_at', '>=', $startDate . ' 00:00:00')->where('created_at', '<=', $endDate . ' 23:59:59')->where('day', '5') as $attendance)
                                                    @if ($attendance->day == '5')
                                                        @if ($attendance->time_in AND $attendance->time_out)
                                                            <table class="table table-bordered" id="attendance_table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="bg-success font-white">{{ $attendance->time_in }}</td>
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
                                                                        <td class="bg-danger font-white">{{ $attendance->time_out }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        @else
                                                            @if (!$attendance->time_in)
                                                                <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                            @else
                                                                {{ $attendance->time_in }}
                                                            @endif
                                                            <div class="clearfix"></div>
                                                            @if (!$attendance->time_out)
                                                                <div><button class="btn btn-block btn-sm btn-danger time_out" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time Out</button></div>
                                                            @else
                                                                {{ $attendance->time_out }}
                                                            @endif
                                                        @endif                                                                                          
                                                    @else
                                                        @if (!$attendance->time_in)
                                                            <div><button class="btn btn-block btn-sm btn-success" disabled>Time In</button></div>
                                                        @else
                                                            {{ $attendance->time_in }}
                                                        @endif
                                                        <div class="clearfix"></div>
                                                        @if (!$attendance->time_out)
                                                            <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>
                                                        @else
                                                            {{ $attendance->time_out }}
                                                        @endif                                                            
                                                    @endif
                                                @empty
                                                    @if ($day == '5')
                                                        <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                        <div class="clearfix"></div>
                                                        <div><button class="btn btn-block btn-sm btn-danger">Time Out</button></div>
                                                    @else
                                                        <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}" disabled>Time In</button></div>
                                                        <div class="clearfix"></div>
                                                        <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>                     
                                                    @endif
                                            @endforelse
                                            @endif
                                        </td>
                                        <td> <!-- Day 6 -->
                                            @if (!count($a->attendances))
                                                @if ($day == '6')
                                                    <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                    <div class="clearfix"></div>
                                                    <div><button class="btn btn-block btn-sm btn-danger">Time Out</button></div>
                                                @else
                                                    <div><button class="btn btn-block btn-sm btn-success time_in" disabled>Time In</button></div>
                                                    <div class="clearfix"></div>
                                                    <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>
                                                @endif
                                            @else
                                                @forelse ($a->attendances->where('created_at', '>=', $startDate . ' 00:00:00')->where('created_at', '<=', $endDate . ' 23:59:59')->where('day', '6') as $attendance)
                                                    @if ($attendance->day == '6')
                                                        @if ($attendance->time_in AND $attendance->time_out)
                                                            <table class="table table-bordered" id="attendance_table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="bg-success font-white">{{ $attendance->time_in }}</td>
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
                                                                        <td class="bg-danger font-white">{{ $attendance->time_out }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        @else
                                                            @if (!$attendance->time_in)
                                                                <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                            @else
                                                                {{ $attendance->time_in }}
                                                            @endif
                                                            <div class="clearfix"></div>
                                                            @if (!$attendance->time_out)
                                                                <div><button class="btn btn-block btn-sm btn-danger time_out" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time Out</button></div>
                                                            @else
                                                                {{ $attendance->time_out }}
                                                            @endif
                                                        @endif                                                                                          
                                                    @else
                                                        @if (!$attendance->time_in)
                                                            <div><button class="btn btn-block btn-sm btn-success" disabled>Time In</button></div>
                                                        @else
                                                            {{ $attendance->time_in }}
                                                        @endif
                                                        <div class="clearfix"></div>
                                                        @if (!$attendance->time_out)
                                                            <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>
                                                        @else
                                                            {{ $attendance->time_out }}
                                                        @endif                                                            
                                                    @endif
                                                @empty
                                                    @if ($day == '6')
                                                        <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                        <div class="clearfix"></div>
                                                        <div><button class="btn btn-block btn-sm btn-danger">Time Out</button></div>
                                                    @else
                                                        <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}" disabled>Time In</button></div>
                                                        <div class="clearfix"></div>
                                                        <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>                     
                                                    @endif
                                            @endforelse
                                            @endif
                                        </td>
                                        <td> <!-- Day 7 -->
                                            @if (!count($a->attendances))
                                                @if ($day == '7')
                                                    <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                    <div class="clearfix"></div>
                                                    <div><button class="btn btn-block btn-sm btn-danger">Time Out</button></div>
                                                @else
                                                    <div><button class="btn btn-block btn-sm btn-success time_in" disabled>Time In</button></div>
                                                    <div class="clearfix"></div>
                                                    <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>
                                                @endif
                                            @else
                                                @forelse ($a->attendances->where('created_at', '>=', $startDate . ' 00:00:00')->where('created_at', '<=', $endDate . ' 23:59:59')->where('day', '7') as $attendance)
                                                    @if ($attendance->day == '7')
                                                        @if ($attendance->time_in AND $attendance->time_out)
                                                            <table class="table table-bordered" id="attendance_table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="bg-success font-white">{{ $attendance->time_in }}</td>
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
                                                                        <td class="bg-danger font-white">{{ $attendance->time_out }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        @else
                                                            @if (!$attendance->time_in)
                                                                <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                            @else
                                                                {{ $attendance->time_in }}
                                                            @endif
                                                            <div class="clearfix"></div>
                                                            @if (!$attendance->time_out)
                                                                <div><button class="btn btn-block btn-sm btn-danger time_out" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time Out</button></div>
                                                            @else
                                                                {{ $attendance->time_out }}
                                                            @endif
                                                        @endif                                                                                          
                                                    @else
                                                        @if (!$attendance->time_in)
                                                            <div><button class="btn btn-block btn-sm btn-success" disabled>Time In</button></div>
                                                        @else
                                                            {{ $attendance->time_in }}
                                                        @endif
                                                        <div class="clearfix"></div>
                                                        @if (!$attendance->time_out)
                                                            <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>
                                                        @else
                                                            {{ $attendance->time_out }}
                                                        @endif                                                            
                                                    @endif
                                                @empty
                                                    @if ($day == '7')
                                                        <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}">Time In</button></div>
                                                        <div class="clearfix"></div>
                                                        <div><button class="btn btn-block btn-sm btn-danger">Time Out</button></div>
                                                    @else
                                                        <div><button class="btn btn-block btn-sm btn-success time_in" data-employeeid="{{ $a->id }}" data-day="{{ $day }}" disabled>Time In</button></div>
                                                        <div class="clearfix"></div>
                                                        <div><button class="btn btn-block btn-sm btn-danger" disabled>Time Out</button></div>                     
                                                    @endif
                                            @endforelse
                                            @endif
                                        </td>
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