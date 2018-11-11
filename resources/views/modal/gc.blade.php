<div id="addgc" class="modal fade" aria-labelledby="addGC">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Gift Certificate</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			</div>
			<div class="modal-body">
				<form id="gcForm" action="{{ URL::to('gc/store') }}" method="post">
					@csrf
					@php
						$gcCount = $gcCount + 1;
						$gcCount = sprintf("%05d", $gcCount);
					@endphp
					<div class="form-row">
						<div class="form-group col-md-12 col-xs-12">
							<label>Reference No.</label>
							<input type="text" class="form-control" name="ref_no" value="{!! $gcCount !!}" readonly="" />
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<label>Gift Cert No</label>
							<input type="text" class="form-control" name="gc_no" placeholder="Enter gift cert no.."/>
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<label>Purchased By</label>
							<input type="text" class="form-control" name="purchased_by" placeholder="Enter name.."/>
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<label>Service</label>
							<select name="service" class="form-control">
								<option value="">--Select Service--</option>
								@foreach($services as $s)
								<option value="{{ $s->id }}">{{ $s->service_name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-6 col-xs-12">
							<label>Value</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class='input-group-text'>₱</span>
								</div>
								<input type="text" class="form-control" name="value" placeholder="Enter value.."/>
								<div class="input-group-prepend">
									<span class='input-group-text'>.00</span>
								</div>
							</div>
						</div>
						<div class="form-group col-md-6 col-xs-12">
							<label># of use</label>
							<input type="text" class="form-control" name="use" placeholder="Enter value.."/>
						</div>
						<div class="form-group col-md-6 col-xs-12">
							<label>Date Issued</label>
							<input type="text" class="form-control date" name="date_issued" placeholder="mm/dd/yyyy" id="date_issued">
						</div>
						<div class="form-group col-md-6 col-xs-12">
							<label>Expiry Date</label>
							<input type="text" class="form-control date" name="expiry_date" placeholder="mm/dd/yyyy" id="expiry_date">
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<div class="clearfix text-right mt-3">
								<button type="submit" id="gcFormBtn" class="btn btn-success">
									Add Gift Certificate
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>