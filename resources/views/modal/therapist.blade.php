<div id="addTherapist" class="modal fade" aria-labelledby="addTherapist">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Therapist</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			</div>
			<div class="modal-body">
				<form id="therapistForm" action="{{ URL::to('therapist/store') }}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-row">
						<div class="form-group col-md-6 col-xs-12">
							<label>First Name</label>
							<input type="text" class="form-control" name="first_name" placeholder="Enter first name.."/>
						</div>
						<div class="form-group col-md-6 col-xs-12">
							<label>Last Name</label>
							<input type="text" class="form-control" name="last_name" placeholder="Enter last name.."/>
						</div>
						<div class="form-group col-md-6 col-xs-12">
							<label>E-mail Address</label>
							<input type="text" class="form-control" name="email" placeholder="Enter valid email address.."/>
						</div>
						<div class="form-group col-md-6 col-xs-12">
							<label>Phone</label>
							<input type="text" class="form-control" name="phone" placeholder="Enter valid phone number.."/>
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<label>Address</label>
							<input type="text" class="form-control" name="address" placeholder="Enter address.." />
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<label>Photo</label>
							<input type="file" class="form-control" name="avatar" />
						</div>
						<div class="form-group col-md-12 col-xs-12">
						<div class="clearfix text-right mt-3">
							<button type="submit" id="therapistFormBtn" class="btn btn-success">
								<i class="mdi mdi-send mr-l">
								</i>
								Submit
							</button>
						</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>