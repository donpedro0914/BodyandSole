@extends('layouts.appfront')

@section('content')
    @include('global.front_topnav')
    <div class="wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <form action="{{ route('f_attendance_filter') }}" method="get">
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
                        <div class="table-responsive">
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
                                            @forelse ($a->attendances->where('created_at', '>', $startDate)->where('created_at', '<', $endDate)->where('day', '1') as $attendance)
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
                                            @forelse ($a->attendances->where('created_at', '>', $startDate)->where('created_at', '<', $endDate)->where('day', '2') as $attendance)
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
                                            @forelse ($a->attendances->where('created_at', '>', $startDate)->where('created_at', '<', $endDate)->where('day', '3') as $attendance)
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
                                            @forelse ($a->attendances->where('created_at', '>', $startDate)->where('created_at', '<', $endDate)->where('day', '4') as $attendance)
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
                                            @forelse ($a->attendances->where('created_at', '>', $startDate)->where('created_at', '<', $endDate)->where('day', '5') as $attendance)
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
                                            @forelse ($a->attendances->where('created_at', '>', $startDate)->where('created_at', '<', $endDate)->where('day', '6') as $attendance)
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
                                            @forelse ($a->attendances->where('created_at', '>', $startDate)->where('created_at', '<', $endDate)->where('day', '7') as $attendance)
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