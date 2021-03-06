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
                        <li class="breadcrumb-item active">Payroll Report</li>
                    </ol>
                    <h4 class="page-title">Payroll Report</h4>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <div class="form-group">
                                <form action="{{ route('payroll_filter') }}" method="get">
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
                            <button type="button" class="btn btn-primary" id="print_btn">Payslip</button>
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
                                        <td class="text-right">{{ $p->total }}.00</td>
                                        <td>{{ $p->lodging + $p->sss + $p->phealth + $p->hdf + $p->uniform + $p->fare + $p->others }}</td>
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
                                    @foreach(App\Therapist::whereNotNull('basic')->where('status', 'Active')->get() as $employee)
                                        @foreach(\App\Attendance::selectRaw('sum(time_format(timediff(time_out,time_in),"%H")) as timediff, count(day) as days')->whereRaw('user_id = '. $employee->id.' AND DATE_FORMAT(created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")')->get() as $attendance)
                                        <tr>
                                            <td>{{ $employee->fullname }}</td>
                                            <td class="text-right">
                                                @php
                                                    $otFormula = (int)($employee->basic / 8);
                                                    $basicPay = $employee->basic * $attendance->days;
                                                    $getOt = $attendance->days * 8;
                                                    $finalOTCount = $attendance->timediff - $attendance->days - $getOt;
                                                    $finalOT = $otFormula * $finalOTCount;
                                                    $finalBasic = $basicPay + $finalOT;
                                                @endphp
                                                {{ $finalBasic }}
                                            </td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">0</td>
                                            <td class="text-right">{{ $employee->lodging + $employee->sss + $employee->phealth + $employee->hdf + $employee->uniform + $employee->fare + $employee->others }}</td>
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
                            <div id="payroll_printout" style="display:none;">
                                @foreach($payroll_therapist as $p)
                                    <div class="card-box col-xl-12 table-bordered" style="overflow:auto;">
                                        <h4>Body and Sole Spa</h4>
                                        <h5>Payroll Period : {{ $startDate }} - {{ $endDate }}</h5>
                                        <hr style="border-top:1px solid #9a9a9a"/>
                                        <table class="table">
                                            <tr>
                                                <td>Employee No.:</td>
                                                <td>{{ $p->id }}</td>
                                                <td width="20%"></td>
                                                <td>Branch:</td>
                                                <td>Balibago</td>
                                            </tr>
                                            <tr>
                                                <td>Name:</td>
                                                <td>{{ $p->fullname }}</td>
                                                <td width="20%"></td>
                                                <td>Rate:</td>
                                                <td>0.00</td>
                                            </tr>
                                        </table>
                                        <hr style="border-top:1px solid #9a9a9a"/>
                                        <div class="col-6 float-left">
                                            <h5>EARNINGS</h5>
                                            <div class="col-6 text-right float-left">Regular Pay:</div>
                                            <div class="col-6 text-right float-right">{{ $p->basic }}.00</div>
                                            <div class="col-6 text-right float-left">Overtime Pay:</div>
                                            <div class="col-6 text-right float-right">0.00</div>
                                            <div class="col-6 text-right float-left">Holiday Pay:</div>
                                            <div class="col-6 text-right float-right">0.00</div>
                                            <div class="col-6 text-right float-left">Allowance:</div>
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
                                            <div class="col-6 text-right float-right">{{ $totalAllowance }}.00</div>
                                            <div class="col-6 text-right float-left">Commission:</div>
                                            <div class="col-6 text-right float-right">{{ $p->total }}.00</div>
                                            <div class="col-6 text-right float-left">Incent/Others:</div>
                                            <div class="col-6 text-right float-right" >0.00</div>
                                            <div class="col-6 text-right float-left">13th Month:</div>
                                            <div class="col-6 text-right float-right m-b-30">0.00</div>
                                            <hr style="border-top:1px solid #9a9a9a;clear:both"/>
                                            <strong class="col-6 text-right float-left">Gross Pay:</strong>
                                            <strong class="col-6 text-right float-right">{{ $p->basic + $totalAllowance + $p->total }}.00</strong>
                                        </div>
                                        <div class="col-6 float-right">
                                            <h5>DEDUCTIONS</h5>
                                            <div class="col-6 text-right float-left">Cash Advance:</div>
                                            <div class="col-6 text-right float-right">0.00</div>
                                            <div class="col-6 text-right float-left">W/Tax:</div>
                                            <div class="col-6 text-right float-right">0.00</div>
                                            <div class="col-6 text-right float-left">SSS Contrib:</div>
                                            <div class="col-6 text-right float-right">{{ $p->sss }}.00</div>
                                            <div class="col-6 text-right float-left">Phil Health:</div>
                                            <div class="col-6 text-right float-right">{{ $p->phealth }}.00</div>
                                            <div class="col-6 text-right float-left">SSS Loan:</div>
                                            <div class="col-6 text-right float-right">0.00</div>
                                            <div class="col-6 text-right float-left">HDMF Contrib:</div>
                                            <div class="col-6 text-right float-right">{{ $p->hdf }}.00</div>
                                            <div class="col-6 text-right float-left">HDMF Loan:</div>
                                            <div class="col-6 text-right float-right">0.00</div>
                                            <div class="col-6 text-right float-left">Lodging:</div>
                                            <div class="col-6 text-right float-right">{{ $p->lodging }}.00</div>
                                            <div class="col-6 text-right float-left">Others<small>(Uniform, Fare, Others Included)</small>:</div>
                                            <div class="col-6 text-right float-right">{{ $p->uniform + $p->fare + $p->others }}.00</div>
                                            <hr style="border-top:1px solid #9a9a9a;clear:both"/>
                                            <strong class="col-6 text-right float-left">Total Deduction:</strong>
                                            @php
                                            $totalD = $p->sss + $p->phealth + $p->hdf + $p->lodging + $p->others;
                                            @endphp
                                            <div class="col-6 text-right float-right">{{ $totalD }}.00</div>
                                            <strong class="col-6 text-right float-left">Net Pay:</strong>
                                            @php
                                            $gross = $p->basic + $totalAllowance + $p->total;
                                            @endphp
                                            <div class="col-6 text-right float-right">{{ $gross - $totalD }}.00</div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="col-12">
                                            <div class="m-t-30 text-right signature">___________________________<br />SIGNATURE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                        </div>
                                    </div>
                                @endforeach
                                @foreach(App\Therapist::whereNotNull('basic')->where('status', 'Active')->get() as $employee)
                                    @foreach(\App\Attendance::selectRaw('sum(time_format(timediff(time_out,time_in),"%H")) as timediff, count(day) as days')->whereRaw('user_id = '. $employee->id.' AND DATE_FORMAT(created_at, "%Y-%m-%d") BETWEEN DATE_FORMAT("'.$startDate.'", "%Y-%m-%d") AND DATE_FORMAT("'.$endDate.'", "%Y-%m-%d")')->get() as $attendance)
                                            <div class="card-box col-xl-12 table-bordered" style="overflow:auto;">
                                                <h4>Body and Sole Spa</h4>
                                                <h5>Payroll Period : {{ $startDate }} - {{ $endDate }}</h5>
                                                <hr style="border-top:1px solid #9a9a9a"/>
                                                <table class="table">
                                                    <tr>
                                                        <td>Employee No.:</td>
                                                        <td>{{ $employee->id }}</td>
                                                        <td width="20%"></td>
                                                        <td>Branch:</td>
                                                        <td>Balibago</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Name:</td>
                                                        <td>{{ $employee->fullname }}</td>
                                                        <td width="20%"></td>
                                                        <td>Rate:</td>
                                                        <td>0.00</td>
                                                    </tr>
                                                </table>
                                                <hr style="border-top:1px solid #9a9a9a"/>
                                                <div class="col-6 float-left">
                                                    <h5>EARNINGS</h5>
                                                    @php
                                                        $otFormula = (int)($employee->basic / 8);
                                                        $basicPay = $employee->basic * $attendance->days;
                                                        $getOt = $attendance->days * 8;
                                                        $finalOTCount = $attendance->timediff - $attendance->days - $getOt;
                                                        $finalOT = $otFormula * $finalOTCount;
                                                        $finalBasic = $basicPay + $finalOT;
                                                    @endphp
                                                    <div class="col-6 text-right float-left">Regular Pay:</div>
                                                    <div class="col-6 text-right float-right">{{ $basicPay }}.00</div>
                                                    <div class="col-6 text-right float-left">Overtime Pay:</div>
                                                    <div class="col-6 text-right float-right">{{ $finalOT }}.00</div>
                                                    <div class="col-6 text-right float-left">Holiday Pay:</div>
                                                    <div class="col-6 text-right float-right">0.00</div>
                                                    <div class="col-6 text-right float-left">Allowance:</div>
                                                    <div class="col-6 text-right float-right">0.00</div>
                                                    <div class="col-6 text-right float-left">Commission:</div>
                                                    <div class="col-6 text-right float-right">0.00</div>
                                                    <div class="col-6 text-right float-left">Incent/Others:</div>
                                                    <div class="col-6 text-right float-right" >0.00</div>
                                                    <div class="col-6 text-right float-left">13th Month:</div>
                                                    <div class="col-6 text-right float-right m-b-30">0.00</div>
                                                    <hr style="border-top:1px solid #9a9a9a;clear:both"/>
                                                    <strong class="col-6 text-right float-left">Gross Pay:</strong>
                                                    <strong class="col-6 text-right float-right">{{ $finalBasic }}.00</strong>
                                                </div>
                                                <div class="col-6 float-right">
                                                    <h5>DEDUCTIONS</h5>
                                                    <div class="col-6 text-right float-left">Cash Advance:</div>
                                                    <div class="col-6 text-right float-right">0.00</div>
                                                    <div class="col-6 text-right float-left">W/Tax:</div>
                                                    <div class="col-6 text-right float-right">0.00</div>
                                                    <div class="col-6 text-right float-left">SSS Contrib:</div>
                                                    <div class="col-6 text-right float-right">{{ $employee->sss }}.00</div>
                                                    <div class="col-6 text-right float-left">Phil Health:</div>
                                                    <div class="col-6 text-right float-right">{{ $employee->phealth }}.00</div>
                                                    <div class="col-6 text-right float-left">SSS Loan:</div>
                                                    <div class="col-6 text-right float-right">0.00</div>
                                                    <div class="col-6 text-right float-left">HDMF Contrib:</div>
                                                    <div class="col-6 text-right float-right">{{ $employee->hdf }}.00</div>
                                                    <div class="col-6 text-right float-left">HDMF Loan:</div>
                                                    <div class="col-6 text-right float-right">0.00</div>
                                                    <div class="col-6 text-right float-left">Lodging:</div>
                                                    <div class="col-6 text-right float-right">{{ $employee->lodging }}.00</div>
                                                    <div class="col-6 text-right float-left">Others<small>(Uniform, Fare, Others Included)</small>:</div>
                                                    <div class="col-6 text-right float-right">{{ $employee->uniform + $employee->fare + $employee->others }}.00</div>
                                                    <hr style="border-top:1px solid #9a9a9a;clear:both"/>
                                                    <strong class="col-6 text-right float-left">Total Deduction:</strong>
                                                    @php
                                                    $totalD = $employee->sss + $employee->phealth + $employee->hdf + $employee->lodging + $employee->others;
                                                    @endphp
                                                    <div class="col-6 text-right float-right">{{ $totalD }}.00</div>
                                                    <strong class="col-6 text-right float-left">Net Pay:</strong>
                                                    @php
                                                    $gross = $finalBasic;
                                                    @endphp
                                                    <div class="col-6 text-right float-right">{{ $gross - $totalD }}.00</div>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="col-12">
                                                    <div class="m-t-30 text-right signature">___________________________<br />SIGNATURE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                                </div>
                                            </div>
                                        @endforeach
                                @endforeach
                            </div>
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
        $('#print_btn').on("click", function () {
            $('#payroll_printout').printThis({
                removeInline: true,
                header: null,
                footer: null,
                pageTitle: null
            });
        });

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
        var oTable = $('.ajax-table-payroll').dataTable({
            paging: false,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    text: 'Print',
                    header: true,
                    footer: true,
                    message: '<h3>Payroll Report</h3><strong>For the period: {{ $startDate }} - {{ $endDate }}</strong>',
                    messageBottom: null
                }
            ],
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