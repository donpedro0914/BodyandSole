@extends('layouts.appfront')

@section('content')
    @include('global.front_topnav')
    <div class="wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @php
                        $i = $settings->rooms;
                        for($x=1;$x<=$i;$x++) {
                    @endphp
                    <div class="col-xl-4">
                        <div class="card-box ribbon-box room">
                            <div class="ribbon ribbon-success">Available</div>
                            <p class="header-title">Room # {!! $x !!}</p>
                            <form class="form-horizontal">
                                <input type="hidden" id="room_no" value=" {!! $x !!}" />
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
                    @php
                        }
                    @endphp
                </div>
            </div>
        </div>
    </div>
@endsection
