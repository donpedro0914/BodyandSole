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
                        <div class="card-box ribbon-box room">
                            @if($r->status == 'Available')
                            <div class="ribbon ribbon-success">Available</div>
                            @else
                            <div class="ribbon ribbon-danger">Unvailable</div>
                            @endif
                            <p class="header-title">{{ $r->room_name}}</p>
                            <form class="form-horizontal">
                                <input type="hidden" id="room_no" value="{{ $r->id }}" />
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Job Order #</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" disabled />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Client's Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" disabled />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Therapist</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" disabled />
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
