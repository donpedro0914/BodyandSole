@extends('layouts.appfront')

@section('content')
    @include('global.front_topnav')
    <div class="wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card-box m-b-30">
                            <form action="{{ route('f_payroll_filter') }}" method="get" class="m-b-30">
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
                            <table class="table table-bordered dataTable no-footer table-striped ajax-table-payroll">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Basic Pay</th>
                                        <th>Allowance</th>
                                        <th>Comm Earning</th>
                                        <th>Deduction</th>
                                        <th>Gross Pay</th>
                                        <th>Net</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payroll_therapist as $p)
                                    <tr>
                                        <td>{{ $p->fullname }}</td>
                                        <td class="text-right">{{ $p->basic }}</td>
                                        @php
                                            $day = '0';
                                            if($p->Thurs) {
                                            $day += '1';
                                            } else {
                                            $day += '0';
                                            }

                                            if($p->Fri) {
                                            $day += '1';
                                            } else {
                                            $day += '0';
                                            }

                                            if($p->Sat) {
                                            $day += '1';
                                            } else {
                                            $day += '0';
                                            }

                                            if($p->Sun) {
                                            $day += '1';
                                            } else {
                                            $day += '0';
                                            }

                                            if($p->Mon) {
                                            $day += '1';
                                            } else {
                                            $day += '0';
                                            }

                                            if($p->Tue) {
                                            $day += '1';
                                            } else {
                                            $day += '0';
                                            }

                                            if($p->Wed) {
                                            $day += '1';
                                            } else {
                                            $day += '0';
                                            }

                                            $totalAllowance = $p->allowance * $day;
                                        @endphp
                                        <td class="text-right">{{ $totalAllowance }}</td>
                                        <td class="text-right">{{ $p->total }}</td>
                                        <td>{{ $p->lodging + $p->sss + $p->phealth + $p->hdf + $p->others }}</td>
                                        <td class="text-right">{{ $p->basic + $totalAllowance + $p->total }}</td>
                                        <td>
                                            @php
                                            $totalDeduction = $p->lodging + $p->sss + $p->phealth + $p->hdf + $p->others;
                                            $gross = $p->basic + $totalAllowance + $p->total;
                                            @endphp
                                            {{ $gross - $totalDeduction }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    @foreach(App\Therapist::whereNotNull('basic')->get() as $employee)
                                        @for ($i = 1; $i <= 7; $i++)
                                            @foreach (\App\Attendance::whereRaw('user_id = '. $employee->id.' AND day = '.$i.' AND DATE_FORMAT(created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")')->get() as $attendance)
                                                <tr>
                                                    <td>{{ $employee->fullname }}</td>
                                                    <td>
                                                        @php
                                                            $ot = '0';
                                                            $days = '0';
                                                            
                                                            $hourdiff = round((strtotime($attendance->time_out) - strtotime($attendance->time_in))/3600, 1);
                                                            if($hourdiff == 9) {
                                                                $days += '1';
                                                            } else if($hourdiff > 9) {
                                                                $hourdiff2 = $hourdiff - 1;
                                                                $ot += $hourdiff2 % 8;
                                                                $days += '1';
                                                            } else {
                                                                $days += '0';
                                                                $ot += '0';
                                                            }
                                                            
                                                            $otFormula = (int)($employee->basic / 8);
                                                            $basicPay = $employee->basic * $days;
                                                            $otPay = $otFormula * $ot;
                                                            $finalBasic = $basicPay + $otPay;
                                                        @endphp
                                                        {{ $finalBasic }}
                                                    </td>
                                                    <td class="text-right">0</td>
                                                    <td class="text-right">0</td>
                                                    <td>{{ $employee->lodging + $employee->sss + $employee->phealth + $employee->hdf + $employee->uniform + $employee->fare + $employee->others }}</td>
                                                    <td class="text-right">{{ $finalBasic }}</td>
                                                    <td>
                                                        @php
                                                        $totalDeduction = $employee->lodging + $employee->sss + $employee->phealth + $employee->hdf + $employee->uniform + $employee->fare + $employee->others;
                                                        $gross = $finalBasic;
                                                        @endphp
                                                        {{ $gross - $totalDeduction }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endfor
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right">Grand Total</th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                    </tr>
                                </tfoot>
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

        jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
            return this.flatten().reduce( function ( a, b ) {
                if ( typeof a === 'string' ) {
                    a = a.replace(/[^\d.-]/g, '') * 1;
                }
                if ( typeof b === 'string' ) {
                    b = b.replace(/[^\d.-]/g, '') * 1;
                }

                return a + b;
            }, 0 );
        } );

        $('.ajax-table-payroll').DataTable({
            keys: true,
            "footerCallback": function (row,data,start,end,display) {
                var api = this.api(), data;

                var intVal = function(i) {
                    return typeof i === 'string'?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                    i:0;
                };

                pagetotal1 = api
                .column(1)
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                pagetotal2 = api
                .column(2)
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                pagetotal3 = api
                .column(3)
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                pagetotal4 = api
                .column(4)
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                pagetotal5 = api
                .column(5)
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                pagetotal6 = api
                .column(6)
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                $(api.column(1).footer()).html(pagetotal1+'.00');
                $(api.column(2).footer()).html(pagetotal2+'.00');
                $(api.column(3).footer()).html(pagetotal3+'.00');
                $(api.column(4).footer()).html(pagetotal4+'.00');
                $(api.column(5).footer()).html(pagetotal5+'.00');
                $(api.column(6).footer()).html(pagetotal6+'.00');
            }
        });
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
</script>
@endpush