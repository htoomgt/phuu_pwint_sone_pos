<div class="modal fade" id="mdlSystemSettings" tabindex="-1" role="dialog"
    aria-labelledby="mdlSystemSettingsCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlSystemSettingsLongTitle">Create System Setting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmSystemSettings" method="POST" action="{{route('system_settings.addNew')}}">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="txtProductMeasureUnit">System Setting Name:</label>
                        <input type="text" class="form-control" id="textSystemSettingname" name="system_setting_name"
                            aria-describedby="emailHelp" placeholder="Enter system setting name" autocomplete="off">
                        <small id="hTextProductCategoryNameCreate" class="form-text text-muted">Please enter the system setting name
                            </small>
                    </div>

                    <div class="form-group">
                        <label for="txtProductMeasureUnit">System Setting Value:</label>
                        <input type="text" class="form-control" id="txtSystemSettingValue" name="system_setting_value"
                            aria-describedby="emailHelp" placeholder="Enter  system setting value" autocomplete="off">
                        <small id="hTextProductCategoryNameCreate" class="form-text text-muted">Please enter the system setting value
                           </small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSystemSettingCreate">Save Record</button>
                </div>
            </form>
        </div>
    </div>
</div>


</div>
