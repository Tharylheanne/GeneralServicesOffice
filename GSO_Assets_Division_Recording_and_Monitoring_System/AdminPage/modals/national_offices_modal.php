<div id="national_offices_modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">National Offices Details</h4>
			</div>
			<div class="modal-body">
				<form method="post" id="insert_formnationaloffices" autocomplete="off">
					<label>National Office Name</label>
					<input type="text" class="form-control" id="nationaloffice_name" name="nationaloffice_name" placeholder="National Office Name" required><br>
					<input type="text" class="form-control" id="nationaloffice_code" name="nationaloffice_code" placeholder="National Office Code Number" required><br><br>
					<input type="submit" name="insertnationaloffice" id="insertnationaloffice" value="Add National Office" class="btn btn-success" onClick="return confirm('Are you sure that you want to add this  national office?')">
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
				<h4 class="modal-title">National Offices Details</h4>
			</div>
			<div class="modal-body" id="national_offices_details"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>