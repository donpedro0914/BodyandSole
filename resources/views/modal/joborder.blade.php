<div id="joborder" class="modal hide fade" aria-labelledby="addTherapist">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Job Order</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			</div>
			<div class="modal-body">
				<form id="clientsForm" action="{{ URL::to('joborder/store') }}" method="post" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="room_no" id="room_no_form" value="" />
					<div class="form-row">
						<div class="form-group col-md-12 col-xs-12">
							<label>Date</label>
							<input type="text" class="form-control" value="{!! date('Y-m-d') !!}" disabled/>
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<label>Client</label>
							<input type="text" class="form-control" name="last_name" placeholder="Enter last name.."/>
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<label>Therapist</label>
							<select class="form-control select2 select2-selection__rendered">
								<option value="">--Select Therapist--</option>
								@foreach($therapists as $t)
								<option value="{{ $t->id }}">{{ $t->fullname }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-6 col-xs-12">
							<label>Phone</label>
							<input type="text" class="form-control" name="phone" placeholder="Enter valid phone number.."/>
						</div>
						<div class="form-group col-md-6 col-xs-12">
							<label>Email</label>
							<input type="text" class="form-control" name="email" placeholder="Enter valid email address.."/>
						</div>
						<div class="form-group col-md-4 col-xs-12">
							<label>Date of Birth</label>
							<input type="text" class="form-control" name="dob" placeholder="mm/dd/yyyy" id="datepicker-autoclose">
						</div>
						<div class="form-group col-md-4 col-xs-12">
							<label>Occupation</label>
							<input type="text" class="form-control" name="occupation" placeholder="Enter occupation.."/>
						</div>
						<div class="form-group col-md-4 col-xs-12">
							<label>Senior Citizen ID</label>
							<input type="text" class="form-control" name="sc_id" placeholder="Enter occupation.."/>
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<div class="clearfix text-right mt-3">
								<button type="submit" id="clientsFormBtn" class="btn btn-success">
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