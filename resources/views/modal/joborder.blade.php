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
						$jobOrderCount = $jobOrderCount + 1;
						$jobOrderCount = sprintf("%05d", $jobOrderCount);
					@endphp
					<input type="hidden" name="job_order" value="{!! date('y') !!}-{!! $jobOrderCount !!}"/>
					<input type="hidden" name="room_no" id="room_no_form" value="" />
					<input type="hidden" name="day" id="day" value="day{{ $day }}" />
					<input type="hidden" name="commmission" id="commission" value="" />
					<div class="form-row">
						<div class="form-group row col-md-12 col-xs-12">
							<label class="col-sm-4 col-form-label">Date</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" value="{!! date('Y-m-d') !!}" readonly/>
							</div>
						</div>
						<div class="form-group row col-md-12 col-xs-12">
							<label class="col-sm-4 col-form-label">Client</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="client_fullname" placeholder="Enter client name.." required="required" />
							</div>
						</div>
						<div class="form-group row col-md-12 col-xs-12">
							<label class="col-sm-4 col-form-label">Therapist</label>
							<div class="col-sm-8">
								<select class="form-control select2 select2-selection__rendered" name="therapist_fullname" required="">
									@foreach($therapists as $t)
									<option value="{{ $t->id }}">{{ $t->fullname }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row col-md-12 col-xs-12">
							<label class="col-sm-4 col-form-label">Category</label>
							<div class="col-sm-8">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio1" name="category" class="custom-control-input" value="Single" required>
                                    <label class="custom-control-label" for="customRadio1">Single</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio2" name="category" class="custom-control-input" value="Package">
                                    <label class="custom-control-label" for="customRadio2">Package</label>
                                </div>
							</div>
						</div>
						<div id="Service" class="form-group row col-md-12 col-xs-12" style="display: none;">
							<div class="form-group row col-md-12 col-xs-12">
								<label class="col-sm-4 col-form-label">Services</label>
	                            <div class="col-sm-8">
	                            	<div class="input-group">
		                                <select id="package_services_front" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ..." name="service" required="">
		                                    @foreach($service as $s)
		                                    <option value="{{ $s->id }}" data-price="{{ $s->charge }}" data-name="{{ $s->service_name }}">{{ $s->service_name }}</option>
		                                    @endforeach
		                                </select>
		                                <div class="input-group-append">
	                                		<button type="button" id="package_servicec_btn_front" class="btn btn-primary waves-effect waves-light" disabled="">Apply Service(s)</button>
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
						<div id="Package" class="form-group row col-md-12 col-xs-12" style="display: none;">
							<label class="col-sm-4 col-form-label">Package</label>
                            <div class="col-sm-8">
							<select class="form-control select2 select2-selection__rendered" id="package_id" name="service" required="">
								<option value="">--Select Package--</option>
								@foreach($packages as $p)
								<option value="{{ $p->id }}">{{ $p->package_name }}</option>
								@endforeach
							</select>
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
                                    <input type="radio" id="customRadio5" name="payment" class="custom-control-input" value="Care of">
                                    <label class="custom-control-label" for="customRadio5">Care of</label>
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