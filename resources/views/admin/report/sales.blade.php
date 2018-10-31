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
                        <li class="breadcrumb-item active">Sales Report</li>
                    </ol>
                    <h4 class="page-title">Sales Report</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <table class="table table-bordered dataTable no-footer table-striped ajax-table-sales">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($job_orders as $j)
                                    <tr>
                                        <td>Job Order - {{ $j->job_order }}</td>
                                        <td>{{ $j->price }}</td>
                                        <td>{{ $j->created_at }}</td>
                                    </tr>
                                    @endforeach 
                                    @foreach($gc as $g)
                                    <tr>
                                        <td>Gift Cert - {{ $g->gc_no }}</td>
                                        <td>{{ $g->value }}</td>
                                        <td>{{ $g->created_at }}</td>
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
        $('.ajax-table-sales').DataTable({
            keys: true
        });
    });
</script>
@endpush