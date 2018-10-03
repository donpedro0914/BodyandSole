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
                        <li class="breadcrumb-item"><a href="/packages">Package</a></li>
                        <li class="breadcrumb-item active">Add Packages</li>
                    </ol>
                    <h4 class="page-title">Add Package</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                        </div>
                    </div>
                </div>
    		</div>
    	</div>
    </div>
@endsection
