<!-- Add High School Modal -->
<div class="modal fade" id="add_highschool_modal" tabindex="-1" role="dialog" aria-labelledby="add_highschool_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add High School</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your form inputs here -->
                <form method="post" id="insert_form_highschool" autocomplete="off">
                    <div class="form-group">
                        <label for="highSchoolName">High School Name:</label>
                        <input type="text" class="form-control" id="highSchoolName" name="highSchoolName" placeholder="High School Name" required>
                    </div>
                    <input type="submit" name="insert_highschool" id="insert_highschool" value="Add High School" class="btn btn-success">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>