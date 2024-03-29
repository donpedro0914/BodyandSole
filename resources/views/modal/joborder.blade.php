<div id="joborder" class="modal hide fade" aria-labelledby="addTherapist">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Job Order</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			</div>
			<div class="modal-body">
				<form id="jobOrderForm" action="{{ URL::to('joborder/store') }}" method="post" novalidate>
					@csrf
					@php
						if(empty($jobOrderCount->job_order)) {
							$orderCount2 = '00001';
						} else {
							$jobOrderCount = $jobOrderCount->job_order;
							$orderCount = explode("-", $jobOrderCount);
							$orderCount2 = $orderCount[1] + 1;
							$orderCount2 = sprintf("%05d", $orderCount2);
						}
					@endphp
					<input type="hidden" name="job_order" value="{!! date('y') !!}-{!! $orderCount2 !!}"/>
					<input type="hidden" name="room_no" id="room_no_form" value="" />
					<input type="hidden" name="day" id="day" value="day{{ $day }}" />
					<input type="hidden" name="commmission" id="commission" value="" />
					<input type="hidden" name="addon" id="addon" />
					<div class="form-row">
						<div class="form-group row col-md-12 col-xs-12">
							<label class="col-sm-4 col-form-label">Date</label>
							<div class="col-sm-8">
								<div class="input-group m-b-30">
                                <input type="text" class="form-control" name="date" id="datepicker-autoclose" data-date-format="yyyy-mm-dd" value="{!! date('Y-m-d') !!}">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-calendar"></i>
                                    </span>
                                </div>
                            </div>
							</div>
						</div>
						<div class="form-group row col-md-12 col-xs-12">
							<label class="col-sm-4 col-form-label">Client</label>
							<div class="col-sm-8">
								<select name="client_fullname" class="form-control select2 select2-selection__rendered">
									<option value="Cash">Cash</option>
									@foreach($client as $c)
									<option value="{{ $c->fullname }}">{{ $c->fullname }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row col-md-12 col-xs-12">
							<label class="col-sm-4 col-form-label">Therapist</label>
							<div class="col-sm-8">
								<select class="form-control select2 select2-selection__rendered" name="therapist_fullname" required="">
								<option value="">--Select Therapist--</option>
									@foreach($therapists as $t)
									<option value="{{ $t->id }}">{{ $t->fullname }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div id="Service" class="form-group row col-md-12 col-xs-12">
							<div class="form-group row col-md-12 col-xs-12">
							<input type="hidden" id="services" name="services" />
								<label class="col-sm-4 col-form-label">Services</label>
	                            <div class="col-sm-8">
	                            	<div class="input-group">
		                                <select id="package_services_front" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ..." name="service" required="">
		                                    @foreach($service as $s)
		                                    <option value="{{ $s->id }}" data-price="{{ $s->charge }}" data-name="{{ $s->service_name }}">{{ $s->service_name }}</option>
		                                    @endforeach
		                                </select>
		                                <div class="input-group-append">
	                                		<button type="button" id="package_servicec_btn_front" class="btn btn-sm btn-primary waves-effect waves-light" disabled="">Apply Service(s)</button>
		                                </div>
	                            	</div>
	                            </div>
							</div>
							<div class="form-group row col-md-12 col-xs-12">
								<label class="col-sm-4 col-form-label"></label>
	                            <div class="col-sm-8">
	                                <table class="table m-t-50" id="package_inclusion">
	                                    <thead>
	                                        <tr>
	                                            <th>ID</th>
	                                            <th>Service Name</th>
	                                            <th>Labor</th>
	                                            <th>Price</th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                        <tr>
	                                            <td class="text-center" colspan="4">
	                                                No Services Yet
	                                            </td>
	                                        </tr>
	                                    </tbody>
	                                    <tfoot>
	                                        <tr>
	                                            <th></th>
	                                            <th class="text-right">Total</th>
	                                            <th id="package_labor_total">₱ 0.00</th>
	                                            <th id="package_total">₱ 0.00</th>
	                                        </tr>
	                                    </tfoot>
	                                </table>
	                            </div>
                            </div>
						</div>
						<div class="form-group row col-md-12 col-xs-12">
							<label class="col-sm-4 col-form-label">Payment Method</label>
							<div class="col-sm-8">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio3" name="payment" class="custom-control-input" value="Cash" required="">
                                    <label class="custom-control-label" for="customRadio3">Cash</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio4" name="payment" class="custom-control-input" value="Gift Cert">
                                    <label class="custom-control-label gc_checker" for="customRadio4">Gift Cert</label>
                                </div>
                                <input type="text" class="form-control" id="gc_no" name="gcno" placeholder="Enter gift cert number.." style="display:none;"/>
								<div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio5" name="payment" class="custom-control-input" value="Gcash">
                                    <label class="custom-control-label gcash_checker" for="customRadio5">Gcash</label>
                                </div>
								<input type="text" class="form-control" id="gcash" name="gcash" placeholder="Enter gcash reference number.." style="display:none;"/>

								<div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio6" name="payment" class="custom-control-input" value="Care of">
                                    <label class="custom-control-label" for="customRadio6">Care of</label>
                                </div>

                                <input type="text" class="form-control" id="careof" name="care_of" placeholder="Enter name.." style="display:none;"/>
							</div>
						</div>
						<div class="form-group row col-md-12 col-xs-12">
							<label class="col-sm-4 col-form-label">Senior</label>
							<div class="col-sm-8">
								<select id="senior" class="form-control select2 select2-selection__rendered" name="senior" required="">
									<option value="No">No</option>
									<option value="Yes">Yes</option>
								</select>
							</div>
						</div>
						<div class="form-group row col-md-12 col-xs-12">
							<label class="col-sm-4 col-form-label">Price</label>
							<div class="col-sm-8">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class='input-group-text'>₱</span>
									</div>
									<input type="text" class="form-control" name="price" id="price" readonly="" />
									<div class="input-group-prepend">
										<span class='input-group-text'>.00</span>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<div class="clearfix text-right mt-3">
								<button type="submit" id="jobOrderFormBtn" class="btn btn-success">
									Add Job Order
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>