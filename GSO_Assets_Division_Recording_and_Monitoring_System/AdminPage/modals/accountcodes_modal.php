<div id="account_codes_modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Account Codes Details</h4>
			</div>
			<div class="modal-body">
				<form method="post" id="insert_formaccountcodes" autocomplete="off">
					<label>Account Title</label>
					<input type="text" class="form-control" id="accounttitle_name" name="accounttitle_name" placeholder="Account Title" required><br>
					<input type="text" class="form-control" id="accountcode_number" name="accountcode_number" placeholder="Account Code" required><br><br>
					<input type="submit" name="insertaccountcode" id="insertaccountcode" value="Add Account Code" class="btn btn-success" onClick="return confirm('Are you sure that you want to add this  account code?')">
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
				<h4 class="modal-title">Account Code for Equipment Details</h4>
			</div>
			<div class="modal-body" id="account_codes_details"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>