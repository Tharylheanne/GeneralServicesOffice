<!-- Add Elementary School Modal -->
<div class="modal fade" id="add_elementary_modal" tabindex="-1" role="dialog" aria-labelledby="add_elementary_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Elementary School</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your form inputs here -->
                <form method="post" id="insert_form_elementary" autocomplete="off">
                    <div class="form-group">
                        <label for="elemName">Elementary Name:</label>
                        <input type="text" class="form-control" id="elemName" name="elemName" placeholder="Elementary Name" required>
                    </div>
                    <input type="submit" name="insert_elementary" id="insert_elementary" value="Add Elementary" class="btn btn-success">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>