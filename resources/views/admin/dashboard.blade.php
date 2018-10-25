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
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <h4 class="page-title">Dashboard</h4>
    			</div>
    			<div clas="row">
                    <div class="col-12">
                        <h5 class="m-t-10 m-b-30">Quick Links</h5>
                    </div>
                    <div class="col-xl-3">
                        <div class="card-box">
                            <h4 class="header-title">Daily Sales</h4>
                            <p class="text-muted">{{ $day }}</p>
                            <div class="mb-3 mt-4">
                                <h2 class="font-weight-light">₱{{ $dailySales }}.00</h2>
                            </div>
                        </div>
                    </div>
    			</div>
    		</div>
    	</div>
    </div>
@endsection