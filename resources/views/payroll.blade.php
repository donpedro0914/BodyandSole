@extends('layouts.appfront')

@section('content')
    @include('global.front_topnav')
    <div class="wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
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
                                    @foreach($payroll as $p)
                                    <tr>
                                        <td>{{ $p->fullname }}</td>
                                        <td>{{ $p->basic }}</td>
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
</script>
@endpush