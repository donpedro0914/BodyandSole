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
                        <li class="breadcrumb-item active">Daily Commissions</li>
                    </ol>
                    <h4 class="page-title">Daily Commissions</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <div class="input-group col-xl-5 m-b-30">
                                <input type="text" class="form-control" id="jo_From" value="{{ $day }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            <table class="table table-bordered dataTable no-footer ajax-table-sales">
                                <thead>
                                    <tr>
                                        <th>Job Order</th>
                                        <th>Therapist</th>
                                        <th>Service/Package</th>
                                        <th>Sales</th>
                                        <th>Commission</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($job_orders as $j)
                                    <tr>
                                        <td>{{ $j->job_order }}</td>
                                        <td>{{ $j->fullname }}</td>
                                        <td>{{ $j->service_name }}</td>
                                        <td>{{ $j->price }}</td>
                                        <td>{{ $j->labor }}</td>
                                        <td>{{ $j->created_at }}</td>
                                    </tr>
                                    @endforeach 
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right">Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
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
        $searchVal = '{{ $day }}';
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

        var groupColumn = 1;
        var oTable = $('.ajax-table-sales').DataTable({
            paging: false,
            keys: true,
            columnDefs: [{ targets:[5], visible: false, searchable: true }, { targets:groupColumn, visible: false }],
            order: [[ groupColumn, 'asc' ]],
            "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
            var subTotal = new Array();
            var groupID = -1;
            var aData = new Array();
            var index = 0;
            
            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                
              // console.log(group+">>>"+i);
            
              var vals = api.row(api.row($(rows).eq(i)).index()).data();
              var salary = vals[4] ? parseFloat(vals[4]) : 0;
               
              if (typeof aData[group] == 'undefined') {
                 aData[group] = new Array();
                 aData[group].rows = [];
                 aData[group].salary = [];
              }
          
                aData[group].rows.push(i); 
                    aData[group].salary.push(salary); 
                
            } );
    

            var idx= 0;

      
            for(var office in aData){
       
                                     idx =  Math.max.apply(Math,aData[office].rows);
      
                   var sum = 0; 
                   $.each(aData[office].salary,function(k,v){
                        sum = sum + v;
                   });
                                    console.log(aData[office].salary);
                   $(rows).eq( idx ).after(
                        '<tr class="group td-header"><td colspan="3">'+office+'</td>'+
                        '<td>'+sum+'</td></tr>'
                    );
                    
            };

        },
            "footerCallback": function (row,data,start,end,display) {
                var api = this.api(), data;

                var intVal = function(i) {
                    return typeof i === 'string'?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                    i:0;
                };

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

                $(api.column(3).footer()).html(pagetotal3+'.00');
                $(api.column(4).footer()).html(pagetotal4+'.00');
            }
        }).columns(5).search($searchVal).draw();

        $("#jo_From").datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            clearBtn: true,
        });

        $('#jo_From').on('change', function() {
            $searchVal = $(this).val().replace(/\\/g, '');
            $('.ajax-table-sales').DataTable().columns(5).search($searchVal).draw();
        });
    });
</script>
@endpush