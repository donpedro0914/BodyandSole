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
                        <li class="breadcrumb-item active">Therapist</li>
                    </ol>
                    <h4 class="page-title">Therapist</h4>
    			</div>
    			<div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addTherapist" data-animation="blur" data-overlayspeed="100" data-overlaycolor="#36404a"><i class="mdi mdi-account-plus"></i> Add Therapist</button>
                            @include('modal.therapist')
                        </div>
                    </div>
    			</div>
                <div class="row">
                    @foreach($therapist as $t)
                    <div class="col-lg-6 col-xl-3">
                        <div class="card m-b-30">
                            <img src="avatar/{{ $t->avatar }}" class="card-img-top img-fluid" style="width: 100%;" alt="Default User">
                            <div class="card-body">
                                <div class="float-right">
                                    <span class="badge badge-success">Available</span>
                                </div>
                                <h5 class="card-title">{{ $t->fullname }}</h5>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
    		</div>
    	</div>
    </div>
@endsection