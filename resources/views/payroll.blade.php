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
                                        <td class="text-right">{{ $p->basic }}.00</td>
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
                                        <td class="text-right">{{ $totalAllowance }}.00</td>
                                        <td class="text-right">{{ $p->total }}.00</td>
                                        <td>{{ $p->lodging + $p->sss + $p->phealth + $p->hdf + $p->others }}.00</td>
                                        <td class="text-right">{{ $p->basic + $totalAllowance + $p->total }}.00</td>
                                        <td>
                                            @php
                                            $totalDeduction = $p->lodging + $p->sss + $p->phealth + $p->hdf + $p->others;
                                            $gross = $p->basic + $totalAllowance + $p->total;
                                            @endphp
                                            {{ $gross - $totalDeduction }}.00
                                        </td>
                                    </tr>
                                    @endforeach
                                    @foreach($payroll_frontdesk as $p)
                                    <tr>
                                        <td>{{ $p->fullname }}</td>
                                        @php
                                            $day = '0';
                                            if($p->day1 >= 9) {
                                            $day += '1';
                                            } else {
                                            $day += '0';
                                            }

                                            if($p->day2 >= 9) {
                                            $day += '1';
                                            } else {
                                            $day += '0';
                                            }

                                            if($p->day3 >= 9) {
                                            $day += '1';
                                            } else {
                                            $day += '0';
                                            }

                                            if($p->day4 >= 9) {
                                            $day += '1';
                                            } else {
                                            $day += '0';
                                            }

                                            if($p->day5 >= 9) {
                                            $day += '1';
                                            } else {
                                            $day += '0';
                                            }

                                            if($p->day6 >= 9) {
                                            $day += '1';
                                            } else {
                                            $day += '0';
                                            }

                                            if($p->day7 >= 9) {
                                            $day += '1';
                                            } else {
                                            $day += '0';
                                            }
                                        @endphp
                                        <td class="text-right">{{ $p->basic * $day }}.00</td>
                                        <td class="text-right">0.00</td>
                                        <td class="text-right">0.00</td>
                                        <td>{{ $p->lodging + $p->sss + $p->phealth + $p->hdf + $p->others }}.00</td>
                                        <td class="text-right">{{ $p->basic * $day }}.00</td>
                                        <td>
                                            @php
                                            $totalDeduction = $p->lodging + $p->sss + $p->phealth + $p->hdf + $p->others;
                                            $gross = $p->basic * $day;
                                            @endphp
                                            {{ $gross - $totalDeduction }}.00
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
        $('.ajax-table-payroll').DataTable({
            keys: true
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