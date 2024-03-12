<div id="city_offices_modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">City Offices Details</h4>
			</div>
			<div class="modal-body">
				<form method="post" id="insert_formcityoffices" autocomplete="off">
					<label>City Office Name</label>
					<!-- <select class="form-control">
						<option value="">---Select Office Type</option>
						<option value="city">City Office</option>
						<option value="national">National Office</option>
					</select><br> -->
					<input type="text" class="form-control" id="cityoffice_name" name="cityoffice_name" placeholder="City Office Name" required><br>
					<input type="text" class="form-control" id="cityoffice_code" name="cityoffice_code" placeholder="City Office Code Number" required><br><br>
					<input type="submit" name="insertcityoffice" id="insertcityoffice" value="Add City Office" class="btn btn-success" onClick="return confirm('Are you sure that you want to add this city office?')">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div id="dataModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">City Offices Details</h4>
			</div>
			<div class="modal-body" id="city_offices_details"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>