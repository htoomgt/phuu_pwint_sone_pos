<div class="modal fade" id="mdlCreateProductCategory" tabindex="-1" role="dialog"
    aria-labelledby="mdlCreateProductCategoryCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlCreateProductCategoryLongTitle">Create Product Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmCreateProductCategory" method="POST" action="{{route('productCategory.addNew')}}">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="txtProductCategoryNameCreate">Product Category Name :</label>
                        <input type="text" class="form-control" id="txtProductCategoryNameCreate" name="name"
                            aria-describedby="emailHelp" placeholder="Enter product category name" autocomplete="off">
                        <small id="hTextProductCategoryNameCreate" class="form-text text-muted">Please enter the prodcut
                            category.</small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnProductCategoryCreate">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


</div>
