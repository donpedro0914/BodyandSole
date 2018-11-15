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
                                    <div class="form-group col-md-12 col-xs-12" style="" id="joborder_single">
                                        <label>Service</label>
                                        {{ Form::select('service', $service, '', ['class' => 'form-control select2', 'id' => 'opt_single']) }}
                                    </div>
                                    @if($joborder->category == 'Single')
                                    <div class="form-group col-md-6 col-xs-12 selectedservice">
                                        <label>Service</label>
                                        {{ Form::select('service', $service, $joborder->sname, ['class' => 'form-control select2', 'id' => 'opt_selectedservice']) }}
                                    </div>
                                    @endif
                                    <div class="form-group col-md-4 col-xs-12">
                                        <label>Payment</label>
                                        <input type="text" class="form-control" name="payment" id="payment" value="{{ $joborder->payment }}" readonly="" />
                                    </div>
                                    <div class="form-group col-md-4 col-xs-12">
                                        <label>Price</label>
                                        <input type="text" class="form-control" name="price" id="price" value="{{ $joborder->price }}"/>
                                    </div>
                                    <div class="form-group col-md-4 col-xs-12">
                                        <label>Labor</label>
                                        @php
                                            if($joborder->day0) {
                                                $labor = $joborder->day0;
                                                $day = 'day0';
                                            } else if($joborder->day1) {
                                                $labor = $joborder->day1;
                                                $day = 'day1';
                                            } else if($joborder->day2) {
                                                $labor = $joborder->day2;
                                                $day = 'day2';
                                            } else if($joborder->day3) {
                                                $labor = $joborder->day3;
                                                $day = 'day3';
                                            } else if($joborder->day4) {
                                                $labor = $joborder->day4;
                                                $day = 'day4';
                                            } else if($joborder->day5) {
                                                $labor = $joborder->day5;
                                                $day = 'day5';
                                            } else if($joborder->day6) {
                                                $labor = $joborder->day6;
                                                $day = 'day6';
                                            }
                                        @endphp
                                        <input type="text" class="form-control" name="labor" id="labor" value="{{ $labor }}"/>
                                        <input type="hidden" name="day" value="{{ $day }}" />
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