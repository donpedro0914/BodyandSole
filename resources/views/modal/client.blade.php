<div id="addclient" class="modal fade" aria-labelledby="addTherapist">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Client</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			</div>
			<div class="modal-body">
				<form id="clientsForm" action="{{ URL::to('client/store') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="form-row">
						<div class="form-group col-md-12 col-xs-12">
							<label>Full Name</label>
							<input type="text" class="form-control" name="fullname" placeholder="Enter full name.."/>
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
									Add Client
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>