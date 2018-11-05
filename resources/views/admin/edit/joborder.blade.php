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
                        <li class="breadcrumb-item active"><a href="/job-order">Job Order</a></li>
                        <li class="breadcrumb-item">{{ $joborder->job_order }}</li>
                    </ol>
                    <h4 class="page-title">{{ $joborder->job_order }}</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <form id="jobOrderFormUpdate" action="{{ URL::to('joborder/update', $joborder->job_order) }}" method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label>Job Order</label>
                                        <input type="text" class="form-control" name="job_order" id="job_order" value="{{ $joborder->job_order }}" readonly="" />
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Client Name</label>
                                        <input type="text" class="form-control" name="client_fullname" id="client_fullname" value="{{ $joborder->client_fullname }}" readonly="" />
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Therapist</label>
                                        {{ Form::select('therapist_fullname', $therapists, $joborder->therapist_fullname, ['class' => 'form-control select2']) }}
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Category</label>
                                        <select name="category" class="form-control" id="joborder_category">
                                            @if($joborder->category == 'Single')
                                            <option value="Single" selected>Single</option>
                                            <option value="Package">Package</option>
                                            @else
                                            <option value="Single">Single</option>
                                            <option value="Package" selected>Package</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12" style="display:none;" id="joborder_single">
                                        <label>Service</label>
                                        {{ Form::select('service', $service, '', ['class' => 'form-control select2', 'id' => 'opt_single']) }}
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12" style="display:none;" id="joborder_package">
                                        <label>Service</label>
                                        {{ Form::select('service', $packages, '', ['class' => 'form-control select2', 'id' => 'opt_package']) }}
                                    </div>
                                    @if($joborder->category == 'Single')
                                    <div class="form-group col-md-6 col-xs-12 selectedservice">
                                        <label>Service</label>
                                        {{ Form::select('service', $service, $joborder->sname, ['class' => 'form-control select2', 'id' => 'opt_selectedservice']) }}
                                    </div>
                                    @else
                                    <div class="form-group col-md-6 col-xs-12 selectedservice">
                                        <label>Service</label>
                                        {{ Form::select('service', $packages, $joborder->pname, ['class' => 'form-control select2', 'id' => 'opt_selectedservice']) }}
                                    </div>
                                    @endif
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Payment</label>
                                        <input type="text" class="form-control" name="payment" id="payment" value="{{ $joborder->payment }}" readonly="" />
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Price</label>
                                        <input type="text" class="form-control" name="price" id="price" value="{{ $joborder->price }}"/>
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <div class="clearfix text-right mt-3">
                                            <button type="submit" id="jobordersFormBtnUpdate" class="btn btn-success">
                                                Update joborder
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
    		</div>
    	</div>
    </div>
@endsection