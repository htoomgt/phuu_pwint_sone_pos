<div class="modal fade" id="mdlUpdateProductCategory" tabindex="-1" role="dialog"
    aria-labelledby="mdlUpdateProductCategoryCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlUpdateProductCategoryLongTitle">Update Product Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmUpdateProductCategory" method="POST" action="{{route('productCategory.updateById')}}">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="txtProductCategoryNameCreate">Product Category Name :</label>
                        <input type="text" class="form-control" id="txtProductCategoryNameUpdate" name="name"
                            aria-describedby="emailHelp" placeholder="Enter product category name" autocomplete="off">
                        <small id="hTextProductCategoryNameUpdate" class="form-text text-muted">Please enter the prodcut
                            category.</small>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" value="" name="id" id="h_product_category_update_id" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnProductCategoryUpdate">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


</div>
