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
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                    <h4 class="page-title">Settings</h4>
    			</div>
    			<div clas="row">
                    <div class="col-12">
                        <div class="card-box">
                            <h4 class="m-t-0 header-title">System's Settings</h4>
                            <form class="form-horizontal" method="post" action="{{ URL::to('admin/settings') }}" id="settingsForm">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">System Identity</label>
                                    <div class="col-sm-8">
                                        @if(!empty($settings->title))
                                        <input type="text" class="form-control" name="system_title" value="{{ $settings->title }}"/>
                                        @else
                                        <input type="text" class="form-control" name="system_title"/>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">No of Rooms</label>
                                    <div class="col-sm-8">
                                        @if(!empty($settings->rooms))
                                        <input type="text" class="form-control" name="system_room" value="{{ $settings->rooms }}"/>
                                        @else
                                        <input type="text" class="form-control" name="system_room"/>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-md-12 col-xs-12">
                                <div class="clearfix text-right mt-3">
                                    <button type="submit" id="settingsFormBtn" class="btn btn-success">
                                        Save Settings
                                    </button>
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