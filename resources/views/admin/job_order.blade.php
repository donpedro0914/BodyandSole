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
                        <li class="breadcrumb-item active">Job Orders</li>
                    </ol>
                    <h4 class="page-title">Job Orders</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs tabs-bordered nav-justified">
                            <li class="nav-item">
                                <a href="#job_order_list" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                    <i class="mdi mdi-view-list"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#job_order_grid" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    <i class="mdi mdi-grid-large"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="job_order_list">
                                <div class="card-box">
                                    <table class="table table-bordered dataTable no-footer table-striped ajax-table-joborder">
                                        <thead>
                                            <tr>
                                                <th>Job Order</th>
                                                <th>Client's Name</th>
                                                <th>Therapist</th>
                                                <th>Service</th>
                                                <th>Payment</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                            @foreach($joborder as $j)
                                            <tr>
                                                <td>{{ $j->job_order }}</td>
                                                <td>{{ $j->client_fullname }}</td>
                                                <td>{{ $j->therapistname }}</td>
                                                @if($j->category == 'Single')
                                                <td>{{ $j->service_name }} ({{ $j->price }})</td>
                                                @else
                                                    @if($j->addon)
                                                    @php
                                                    $addon = str_replace(",", "\r\n", $j->addon);
                                                    @endphp
                                                    <td>{{ $j->package_name }} ({{ $j->price }})<br /><strong>Addon:</strong><br />{{ $addon }}</td>
                                                    @else
                                                    <td>{{ $j->package_name }} ({{ $j->price }})</td>
                                                    @endif
                                                @endif
                                                <td>
                                                    @if($j->care_of)
                                                    {{ $j->payment }} - {{ $j->care_of }}
                                                    @elseif($j->gcno)
                                                    {{ $j->payment }} - {{ $j->gcno }}
                                                    @else
                                                    {{ $j->payment }}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($j->status == 'Active')
                                                    <span class="badge badge-primary">Active</span>
                                                    @elseif($j->status == 'Done')
                                                    <span class="badge badge-success">Done</span>
                                                    @else
                                                    <span class="badge badge-danger">Cancelled</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="/joborder/edit/{{ $j->job_order }}" class="btn btn-xs btn-default btn-edit"><i class="mdi mdi-pencil"></i></a>
                                                    <a data-module="joborder" id="{{ $j->job_order }}" data-name="{{ $j->job_order }}" class="btn btn-xs btn-default btn-delete"><i class="mdi mdi-delete"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="job_order_grid">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-xl-6" style="border-right:1px solid #ccc">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <h2 class="text-center">Rooms</h2>
                                                </div>
                                            @foreach($rooms as $r)
                                                <div class="col-xl-3">
                                                    @if($r->status == 'Active')
                                                        @php
                                                            $room = "style_occupied";
                                                        @endphp
                                                    @else
                                                        @php
                                                            $room = "room";
                                                        @endphp
                                                    @endif
                                                    <div class="card-box ribbon-box {{ $room }}">
                                                        @if($r->status == 'Active')
                                                            <p class="header-title">{{ $r->roomname}}</p>
                                                            <button type="button" class="btn btn-success btn-block btn-sm doneJobOrder" data-id="{{ $r->job_order }}">Done</button>
                                                            <button type="button" class="btn btn-default btn-block btn-sm cancelJobOrder" data-id="{{ $r->job_order }}">Cancel</button>
                                                        @else
                                                        <p class="header-title float-left">{{ $r->roomname}}</p>
                                                        @endif
                                                        <div class="clearfix"></div>
                                                        <form class="form-horizontal" id="room_id_{{ $r->roomid }}" data-room="{{ $r->roomid }}">
                                                            <input type="hidden" id="room_no" value="{{ $r->roomid }}" />
                                                            <div class="form-group">
                                                                <label>Time</label>
                                                                <div id="enter_time">
                                                                    @if($r->status == 'Active')
                                                                    <div class="input-group">
                                                                        @if($r->duration)
                                                                            <div id="countdown" data-room="{{ $r->roomid }}" data-timer="{{ $r->duration }}"></div>
                                                                        @else
                                                                            <input type="text" class="col-sm-6 form-control" id="time_in_hr" placeholder="H"/>
                                                                            <input type="text" class="col-sm-6 form-control" id="time_in_min" placeholder="M"/>
                                                                        @endif
                                                                    </div>
                                                                    @php
                                                                        if($r->duration) {
                                                                            $duration = "none";
                                                                        } else {
                                                                            $duration = "block";
                                                                        }
                                                                    @endphp
                                                                    <button data-room="{{ $r->roomid }}" data-id="{{ $r->job_order }}" id="start_timer" class="btn btn-primary waves-effect btn-block waves-light" style="display:{{ $duration }}" type="button">Start</button>
                                                                    @else
                                                                    <div class="input-group">
                                                                        <input type="text" class="col-sm-6 form-control" placeholder="H" readonly="" />
                                                                        <input type="text" class="col-sm-6 form-control" placeholder="M" readonly="" />
                                                                    </div>
                                                                    <button class="btn btn-primary waves-effect waves-light btn-block" type="button" disabled>Start</button>
                                                                    @endif
                                                                </div>
                                                                <div id="show_timer" style="display: none">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <h2 class="text-center">Lounges</h2>
                                                </div>
                                            @foreach($lounge as $r)
                                                <div class="col-xl-3">
                                                    @if($r->status == 'Active')
                                                        @php
                                                            $room = "style_occupied";
                                                        @endphp
                                                    @else
                                                        @php
                                                            $room = "room";
                                                        @endphp
                                                    @endif
                                                    <div class="card-box ribbon-box {{ $room }}">
                                                        @if($r->status == 'Active')
                                                            <p class="header-title">{{ $r->roomname}}</p>
                                                            <button type="button" class="btn btn-success btn-block btn-sm doneJobOrder" data-id="{{ $r->job_order }}">Done</button>
                                                            <button type="button" class="btn btn-default btn-block btn-sm cancelJobOrder" data-id="{{ $r->job_order }}">Cancel</button>
                                                        @else
                                                        <p class="header-title float-left">{{ $r->roomname}}</p>
                                                        @endif
                                                        <div class="clearfix"></div>
                                                        <form class="form-horizontal" id="room_id_{{ $r->roomid }}" data-room="{{ $r->roomid }}">
                                                            <input type="hidden" id="room_no" value="{{ $r->roomid }}" />
                                                            <div class="form-group">
                                                                <label>Time</label>
                                                                <div id="enter_time">
                                                                    @if($r->status == 'Active')
                                                                    <div class="input-group">
                                                                        @if($r->duration)
                                                                            <div id="countdown" data-room="{{ $r->roomid }}" data-timer="{{ $r->duration }}"></div>
                                                                        @else
                                                                            <input type="text" class="col-sm-6 form-control" id="time_in_hr" placeholder="H"/>
                                                                            <input type="text" class="col-sm-6 form-control" id="time_in_min" placeholder="M"/>
                                                                        @endif
                                                                    </div>
                                                                    @php
                                                                        if($r->duration) {
                                                                            $duration = "none";
                                                                        } else {
                                                                            $duration = "block";
                                                                        }
                                                                    @endphp
                                                                    <button data-room="{{ $r->roomid }}" data-id="{{ $r->job_order }}" id="start_timer" class="btn btn-primary waves-effect btn-block waves-light" style="display:{{ $duration }}" type="button">Start</button>
                                                                    @else
                                                                    <div class="input-group">
                                                                        <input type="text" class="col-sm-6 form-control" placeholder="H" readonly="" />
                                                                        <input type="text" class="col-sm-6 form-control" placeholder="M" readonly="" />
                                                                    </div>
                                                                    <button class="btn btn-primary waves-effect waves-light btn-block" type="button" disabled>Start</button>
                                                                    @endif
                                                                </div>
                                                                <div id="show_timer" style="display: none">
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
                            </div>
                        </div>
                    </div>
                </div>
    		</div>
    	</div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('.ajax-table-joborder').DataTable({
            keys: true,
            order: [[0, 'desc']]
        });
    });
</script>
@endpush