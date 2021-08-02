<script>
    dropDownRefresh();
    let currentDateTime = moment().format('yyyy-MM-DDTHH:mm');
    $("#voucher_datetime").val(currentDateTime);

    let itemIndex = 0;

    $("#btnAddItem").on('click', function(e) {
        e.preventDefault();
        itemIndex++;


        let itemRowHtml = `
        <tr id="item_row_`+itemIndex+`">
            <td>
                <select name="product_id[`+itemIndex+`]" id="product_id_`+itemIndex+`" class="select2ProductAllByName" style="width:100%;">
                    <option></option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control" name="unit[`+itemIndex+`]" id="unit_`+itemIndex+`" readonly  />

            </td>
            <td>
                <input type="text" class="form-control" name="unit_price[`+itemIndex+`]" id="unit_price_`+itemIndex+`" readonly />
            </td>
            <td>
                <input type="number" class="form-control input_quantity" name="quantity[`+itemIndex+`]" id="quantity_`+itemIndex+`" value="" min="1"/>
            </td>
            <td>
                <input type="number"  class="form-control" name="amount[`+itemIndex+`]" id="amount_`+itemIndex+`"  value="0" readonly />

            </td>
            <td>
                <button class="btn btn-outline-danger btnRemoveItem" id="btnRemoveItem_`+itemIndex+`">
                    <i class="fas fa-times-circle"></i>
                </button>
            </td>
        </tr>
        `;
        $("#voucher_items").append(itemRowHtml);
        dropDownRefresh();
    })

    $("body").on('click', '.btnRemoveItem',function(){
        let btnRemoveItemId = $(this).attr('id');
        let itemIndex = btnRemoveItemId.substring(14);

        let selectorToRemove = "#item_row_"+itemIndex;
        $(selectorToRemove).remove();

    })

    $("#voucher_items").on('change', '.select2ProductAllByName', function(){
        let ddlProductId = $(this).attr('id');
        let itemIndex = ddlProductId.substring(11);

        let selectedProductId = $(this).val();

        $("#unit_"+itemIndex).val("");
        $("#unit_price_"+itemIndex).val("");

        axios({
            url : "{{route('product.getDataRowById')}}",
            method : "GET",
            params : { id : selectedProductId}
        })
        .then((response) => {
            if(response.data.status == 'success'){
                product = response.data.data;

                $("#unit_"+itemIndex).val(product.measure_unit.name);
                $("#unit_price_"+itemIndex).val(parseInt(product.unit_price));

            }
        })
        .catch((error) => {
            console.log(error);
        })
    })

    $("#voucher_items").on('keyup change', '.input_quantity', function(){
        let inputQuantityId = $(this).attr('id');
        let qty = $(this).val();

        let itemIndex = inputQuantityId.substring(9);

        let unitPrice = $("#unit_price_"+itemIndex).val();

        let amount = unitPrice * qty;

        $("#amount_"+itemIndex).val(amount);

        let totalAmount = 0;

        for(i=0; i<= itemIndex; i++){
            let amountToAdd = $("#amount_"+i).val();
            amountToAdd = parseInt(amountToAdd);

            totalAmount += amountToAdd;
        }

        $("#total_amount").val(totalAmount);

    })

    $("#btnPay").on('click', function(e){
        e.preventDefault();
        let url = "{{route('sale.payment')}}";
        let dataToPost = $("#frmSaleVoucher").serialize();


        axios({
            url : url,
            method : "POST",
            data : dataToPost
        })
        .then((response)=>{
            console.log(response);
        })
        .catch((error)=> {
            console.log(response);
        })



    })

    $("#btnPrint").on('click', function(){

    })

</script>
