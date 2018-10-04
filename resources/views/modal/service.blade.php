<div id="addservice" class="modal fade" aria-labelledby="addTherapist">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Service</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			</div>
			<div class="modal-body">
				<form id="serviceForm" action="{{ URL::to('services/store') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="form-row">
						<div class="form-group col-md-12 col-xs-12">
							<label>Service Name</label>
							<input type="text" class="form-control" name="service_name" placeholder="Enter service name.."/>
						</div>
						<div class="form-group col-md-4 col-xs-12">
							<label>Labor-S</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class='input-group-text'>₱</span>
								</div>
								<input type="text" class="form-control" name="labor_s" placeholder="Enter labor s amount.."/>
								<div class="input-group-prepend">
									<span class='input-group-text'>.00</span>
								</div>
							</div>
						</div>
						<div class="form-group col-md-4 col-xs-12">
							<label>Labor-P</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class='input-group-text'>₱</span>
								</div>
								<input type="text" class="form-control" name="labor_p" placeholder="Enter labor p amount.."/>
								<div class="input-group-prepend">
									<span class='input-group-text'>.00</span>
								</div>
							</div>
						</div>
						<div class="form-group col-md-4 col-xs-12">
							<label>Charge</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class='input-group-text'>₱</span>
								</div>
								<input type="text" class="form-control" name="charge" placeholder="Enter charge amount.."/>
								<div class="input-group-prepend">
									<span class='input-group-text'>.00</span>
								</div>
							</div>
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<div class="clearfix text-right mt-3">
								<button type="submit" id="serviceFormBtn" class="btn btn-success">
									Add Service
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>