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
                        <li class="breadcrumb-item active">Job Orders</li>
                    </ol>
                    <h4 class="page-title">Job Orders</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <table class="table table-bordered dataTable no-footer table-striped ajax-table-joborder">
                                <thead>
                                    <tr>
                                        <th>Job Order</th>
                                        <th>Client's Name</th>
                                        <th>Therapist</th>
                                        <th>Category</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                    @foreach($joborder as $j)
                                    <tr>
                                        <td>{{ $j->job_order }}</td>
                                        <td>{{ $j->client_fullname }}</td>
                                        <td>{{ $j->therapistname }}</td>
                                        <td>{{ $j->category }}</td>
                                        <td>{{ $j->payment }}</td>
                                        <td class="text-center">
                                            @if($j->status == 'Active')
                                            <span class="badge badge-primary">Active</span>
                                            @elseif($j->status == 'Done')
                                            <span class="badge badge-success">Done</span>
                                            @else
                                            <span class="badge badge-danger">Cancelled</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-xs btn-default btn-edit"><i class="mdi mdi-pencil"></i></a>
                                            <a href="#" class="btn btn-xs btn-default btn-edit"><i class="mdi mdi-delete"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                <tbody>
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
        $('.ajax-table-joborder').DataTable({
            keys: true
        });
    });
</script>
@endpush