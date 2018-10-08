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
                        <li class="breadcrumb-item active"><a href="/rooms">Rooms</a></li>
                        <li class="breadcrumb-item">{{ $rooms->room_name }}</li>
                    </ol>
                    <h4 class="page-title">{{ $rooms->room_name }}</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <form id="roomsFormUpdate" action="{{ URL::to('rooms/update', $rooms->id) }}" method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label>Room Name</label>
                                        <input type="text" class="form-control" name="room_name" id="room_name" value="{{ $rooms->room_name }}"/>
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label>Status</label>
                                        <select name="status" class="form-control" id="status">
                                            <option value="{{ $rooms->status }}">{{ $rooms->status }}</option>
                                            <option value="Available">Available</option>
                                            <option value="Not Available">Not Available</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <div class="clearfix text-right mt-3">
                                            <button type="submit" id="roomsFormBtnUpdate" class="btn btn-success">
                                                Update Room
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