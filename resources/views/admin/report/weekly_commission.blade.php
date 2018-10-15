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
                                <label>Date Range Filter</label>
                                <div class="input-group">
                                    <input class="form-control input-daterange-datepicker" type="text" name="daterange"/>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary waves-effect waves-light" type="button">Filter</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered dataTable no-footer table-striped ajax-table-weekly-commission">
                                <thead>
                                    <tr>
                                        <th>Therapist</th>
                                        <th>Day 1</th>
                                        <th>Day 2</th>
                                        <th>Day 3</th>
                                        <th>Day 4</th>
                                        <th>Day 5</th>
                                        <th>Day 6</th>
                                        <th>Day 7</th>
                                        <th># of Days</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
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
        $('.ajax-table-weekly-commission').DataTable({
            keys: true
        });
    });
</script>
@endpush