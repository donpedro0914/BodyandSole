@extends('layouts.appfront')

@section('content')
    @include('global.front_topnav')
    @include('modal.joborder')
    <div class="wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @foreach($rooms as $r)
                    <div class="col-xl-4">
                        @if($r->status == 'Active')
                        <div class="card-box ribbon-box">
                        @else
                        <div class="card-box ribbon-box room">
                        @endif
                            @if($r->status == 'Active')
                            <div class="ribbon ribbon-danger">Occupied</div>
                            <div class="float-right">
                                <button type="button" class="btn btn-success btn-sm doneJobOrder" data-id="{{ $r->job_order }}">Done</button> <button type="button" class="btn btn-danger btn-sm cancelJobOrder" data-id="{{ $r->job_order }}">Canceled</button>
                            </div>
                            @else
                            <div class="ribbon ribbon-success">Available</div>
                            @endif
                            <div class="clearfix"></div>
                            <p class="header-title">{{ $r->roomname}}</p>
                            <form class="form-horizontal">
                                <input type="hidden" id="room_no" value="{{ $r->roomid }}" />
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Job Order #</label>
                                    <div class="col-sm-8">
                                        @if($r->status == 'Active')
                                        <input type="text" class="form-control" value="{{ $r->job_order }}" readonly />
                                        @else
                                        <input type="text" class="form-control" readonly />
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Client's Name</label>
                                    <div class="col-sm-8">
                                        @if($r->status == 'Active')
                                        <input type="text" class="form-control" value="{{ $r->client_fullname }}" readonly="" />
                                        @else
                                        <input type="text" class="form-control" readonly="" />
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Therapist</label>
                                    <div class="col-sm-8">
                                        @if($r->status == 'Active')
                                        <input type="text" class="form-control" value="{{ $r->therapistname }} "readonly="" />
                                        @else
                                        <input type="text" class="form-control" readonly="" />
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
