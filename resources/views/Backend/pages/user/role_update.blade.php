<!-- Add New Credit Card Modal -->
<div class="modal fade" id="upgradeRoleModal">
    <div class="modal-dialog" style="
        position: absolute;
        right: 0;
        top: 0;
        height: 100vh;
        margin: 0;
        max-width: none;
        width: 400px; /* Adjust as needed */
    ">
        <div class="modal-content" style="height: 100%; overflow-y: auto;">
            <div class="modal-header">
                <h4 class="modal-title">Assign a New Role</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <input type="hidden" name="userId" id="upgradeRoleModalUserId" value="">
                    <div class="col-sm-12">
                        <label class="form-label" for="chooseRole">Select Role</label>
                        <select id="chooseRole" name="chooseRole" class="form-control" aria-label="Select Role">
                            <!-- Options will be populated here -->
                        </select>
                    </div>
                </div>
            </div>
            <hr class="mx-md-n5 mx-n3">
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" id="upgradeRoleBtn" class="btn btn-primary">Apply Changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--/ Add New Credit Card Modal -->
