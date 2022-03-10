<div class="modal fade" id="mdlSystemSettingsEdit" tabindex="-1" role="dialog"
    aria-labelledby="mdlSystemSettingsEditCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlSystemSettingsEditLongTitle">Edit System Setting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmSystemSettingsUpdate" method="POST" action="{{route('system_settings.updateById')}}">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="txtProductMeasureUnit">System Setting Name:</label>
                        <input type="text" class="form-control" id="textSystemSettingnameEdit" name="system_setting_name"
                            aria-describedby="emailHelp" placeholder="Enter system setting name" autocomplete="off">
                        <small id="hTextProductCategoryNameCreate" class="form-text text-muted">Please enter the system setting name
                            </small>
                    </div>

                    <div class="form-group">
                        <label for="txtProductMeasureUnit">System Setting Value:</label>
                        <input type="text" class="form-control" id="txtSystemSettingValueEdit" name="system_setting_value"
                            aria-describedby="emailHelp" placeholder="Enter  system setting value" autocomplete="off">
                        <small id="hTextProductCategoryNameCreate" class="form-text text-muted">Please enter the system setting value
                           </small>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hvSystemSettingId" id="hvSystemSettingId">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSystemSettingUpdate">Update Record</button>
                </div>
            </form>
        </div>
    </div>
</div>


</div>
