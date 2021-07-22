<script>
    let productInputIndex = 0;

    $(document).ready(function() {

        $('[data-toggle="tooltip"]').tooltip()

        dropDownRefresh();

        $("#btnProductPurchaseMake").on('click', function(e) {
            e.preventDefault();

            let datatToPost = $("#frmProductPurchaseMake").serialize();

            let url = "{{ route('productPurchase.addNew') }}";

            axios({
                    url: url,
                    method: "POST",
                    data: datatToPost
                })
                .then((response) => {
                    console.log(response.data)
                })
                .catch((error) => {

                })



        })


        $("#input_area").on('change', '.select2Product', function() {
            let productId = $(this).val();
            let selectorId = $(this).attr('id');
            alert(productId)


            let inputIndex = selectorId.substring(11);
            let productCodeId = "#product_code_" + inputIndex;
            let productMeasureUnitId = "#product_measure_unit_" + inputIndex;


            axios({
                    url: "{{ route('product.getDataRowById') }}",
                    method: "GET",
                    params: {
                        id: productId
                    },
                })
                .then((response) => {
                    let row = response.data.data;

                    $(productCodeId).val(row.product_code);
                    $(productMeasureUnitId).val(row.measure_unit.name);
                })
                .catch((error) => {
                    console.log(error)
                })






        })





        $('#input_area').on('click', '.add-product', function() {
            productInputIndex++;
            let productAddingHtml = `
        <div class="container-fluid mb-4" id="purchase_product_whole_block_` + productInputIndex + `">
                                        <div class="row">
                                            <div class="purchase_product_input_block col-10" >
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="product_id[` + productInputIndex + `]">Product Name: </label>
                                                        <select name="product_id[` + productInputIndex +
                `]" class="form-control select2Product col-12" id="product_id_` + productInputIndex + `">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="product_code[` + productInputIndex + `]">Product Code: </label>
                                                        <input type="text" class="form-control" id="product_code_` +
                productInputIndex + `" placeholder="Product Code"
                                                            name="product_code[` + productInputIndex + `]" autocomplete="off" readonly="true">

                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="purchase_date[` + productInputIndex +
                `]" class="width_100P">Purchase Date:</label>

                                                        <input type="text" class="form-control datePicker" id="purchase_date[` + productInputIndex + `]"  name="purchase_date[` +
                productInputIndex + `]" />


                                                    </div>
                                                    <div class="form-group col-md-6">


                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="quantity[` + productInputIndex + `]">Quantity: </label>
                                                        <input type="number" class="form-control" id="quantity[` +
                productInputIndex + `]" name="quantity[` + productInputIndex + `]"
                                                            autocomplete="off">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="product_measure_unit_` + productInputIndex +
                `">Product Measure Unit: </label>
                                                        <input type="text" class="form-control" id="product_measure_unit_` + productInputIndex + `" placeholder="Product Measure Unit"
                                                            name="product_measure_unit[` + productInputIndex + `]" autocomplete="off" readonly="true">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <button class="btn btn-default add-product" type="button" >
                                                    <i class="fas fa-plus-circle"></i>
                                                </button>
                                                <button class="btn btn-default remove-product" type="button" data-toggle="tooltip" data-placement="top" title="Remove Product" productInputIndex="` + productInputIndex + `">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
        `;

            $("#input_area").append(productAddingHtml);

            dropDownRefresh();

        })


        $('#input_area').on('click', '.remove-product', function() {
            let productInputIndexFromBtn =  $(this).attr('productInputIndex');
            let purchaseProductBlockId = "#purchase_product_whole_block_"+productInputIndexFromBtn;

            $(purchaseProductBlockId).remove();

        })
    })
</script>
