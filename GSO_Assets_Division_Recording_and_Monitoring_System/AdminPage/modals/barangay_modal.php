<!-- The "Barangay" modal -->
<div class="modal fade" id="add_barangay_modal" tabindex="-1" role="dialog" aria-labelledby="add_barangay_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Barangay</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="insert_form_barangay" autocomplete="off">
                    <div class="form-group">
                        <label for="barangayName">Barangay Name</label>
                        <input type="text" class="form-control" id="barangayName" name="barangayName" placeholder="Barangay" required>
                    </div>
                    <input type="submit" name="insert_barangay" id="insert_barangay" value="Add Barangay" class="btn btn-success">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>