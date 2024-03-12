<!-- Add High School Modal -->
<div class="modal fade" id="add_clearancePurpose_modal" tabindex="-1" role="dialog" aria-labelledby="add_clearancePurpose_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Clearance Purpose</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your form inputs here -->
                <form method="post" id="insert_form_clearancePurpose" autocomplete="off">
                    <div class="form-group">
                        <label for="purposeName">Clearance Purpose:</label>
                        <input type="text" class="form-control" id="purposeName" name="purposeName" placeholder="Clearance Purpose" required>
                    </div>
                    <input type="submit" name="insert_purpose" id="insert_purpose" value="Add Clearance Purpose" class="btn btn-success">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>