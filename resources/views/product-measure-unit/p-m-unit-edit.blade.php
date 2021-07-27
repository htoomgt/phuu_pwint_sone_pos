<div class="modal fade" id="mdlUpdateProductMeasureUnit" tabindex="-1" role="dialog"
    aria-labelledby="mdlUpdateProductMeasureUnitCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlUpdateProductMeasureUnitLongTitle">Create Product Measure Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmUpdateProductMeasureUnit" method="POST" action="{{route('productMeasureUnit.updateById')}}">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="txtProductMeasureUnitUpdate">Product Measure Unit:</label>
                        <input type="text" class="form-control" id="txtProductMeasureUnitUpdate" name="name"
                            aria-describedby="emailHelp" placeholder="Enter product measure unit" autocomplete="off">
                        <small id="hTextProductCategoryNameCreate" class="form-text text-muted">Please enter the prodcut
                            measure unit.</small>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="hProductMeasureUnitUpdateId" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnProductMeasureUnitUpdate">Save Record</button>
                </div>
            </form>
        </div>
    </div>
</div>


</div>
