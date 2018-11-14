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
                        <li class="breadcrumb-item active">Weekly Commission Report</li>
                    </ol>
                    <h4 class="page-title">Weekly Commission Report</h4>
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
                            <table id="commission" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">
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
                                        <th class='text-center'>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($commission as $c)
                                    <tr>
                                        <td><a href="/weekly-commission-reports/therapist/{!! $c->id !!}">{{ $c->fullname }}</a></td>
                                        <td class='text-center'>{{ $c->Fri }}.00</td>
                                        <td class='text-center'>{{ $c->Sat }}.00</td>
                                        <td class='text-center'>{{ $c->Sun }}.00</td>
                                        <td class='text-center'>{{ $c->Mon }}.00</td>
                                        <td class='text-center'>{{ $c->Tue }}.00</td>
                                        <td class='text-center'>{{ $c->Wed }}.00</td>
                                        <td class='text-center'>{{ $c->Thurs }}.00</td>
                                        <td class='text-center'>
                                            @php
                                                $day = '0';
                                                if($c->Thurs) {
                                                $day += '1';
                                                } else {
                                                $day += '0';
                                                }

                                                if($c->Fri) {
                                                $day += '1';
                                                } else {
                                                $day += '0';
                                                }

                                                if($c->Sat) {
                                                $day += '1';
                                                } else {
                                                $day += '0';
                                                }

                                                if($c->Sun) {
                                                $day += '1';
                                                } else {
                                                $day += '0';
                                                }

                                                if($c->Mon) {
                                                $day += '1';
                                                } else {
                                                $day += '0';
                                                }

                                                if($c->Tue) {
                                                $day += '1';
                                                } else {
                                                $day += '0';
                                                }

                                                if($c->Wed) {
                                                $day += '1';
                                                } else {
                                                $day += '0';
                                                }
                                                echo $day;
                                            @endphp
                                        </td>
                                        <td class='text-center'>{{ $c->total }}.00</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right">Total</th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
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

        var table = $('#commission').DataTable({
            paging: false,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    text: 'Print',
                    header: true,
                    footer: true,
                    message: '<h3>Weekly Commission Report</h3><strong>For the period: {{ $startDate }} - {{ $endDate }}</strong>'
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

                total1 = api
                .column(1)
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                }, 0);

                total2 = api
                .column(2)
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                }, 0);

                total3 = api
                .column(3)
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                }, 0);

                total4 = api
                .column(4)
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                }, 0);

                total5 = api
                .column(5)
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                }, 0);

                total6 = api
                .column(6)
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                }, 0);

                total7 = api
                .column(7)
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                }, 0);

                total9 = api
                .column(9)
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                }, 0);

                pagetotal1 = api
                .column(1, {page: 'current'})
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                pagetotal2 = api
                .column(2, {page: 'current'})
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                pagetotal3 = api
                .column(3, {page: 'current'})
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                pagetotal4 = api
                .column(4, {page: 'current'})
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                pagetotal5 = api
                .column(5, {page: 'current'})
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                pagetotal6 = api
                .column(6, {page: 'current'})
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                pagetotal7 = api
                .column(7, {page: 'current'})
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                pagetotal9 = api
                .column(9, {page: 'current'})
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
                $(api.column(7).footer()).html(pagetotal7+'.00');
                $(api.column(9).footer()).html(pagetotal9+'.00');
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