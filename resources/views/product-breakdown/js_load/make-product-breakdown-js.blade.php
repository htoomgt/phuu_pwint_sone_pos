<script>
    dropDownRefresh();

    $(document).ready(function(){
        $("#dlProductFromBreakdown").change((e)=>{
            let productId = $("#dlProductFromBreakdown").val();

            $.ajax({
                url: "{{route('product.getByParentProductId')}}",
                type: "GET",
                data: {
                    id: productId,
                    _token: "{{csrf_token()}}"
                },
                success: function(response){
                    console.log(response);
                    let fetchedProduct = response.data;
                    console.log(fetchedProduct);

                    $("#dlProductToBreakdown").append(`<option selected value="${fetchedProduct.id}">${fetchedProduct.name}</option>`);
                    $("#hdnProductBreakdownMultiplier").val(fetchedProduct.breadown_parent_full_multiplier);

                    // console.log(data);
                }
            });


        })

        $("#txtQuantityToBreakdown").change(() => {

            let multiplier = $("#hdnProductBreakdownMultiplier").val();
            let quantity = $("#txtQuantityToBreakdown").val();
            let total = quantity * multiplier;
            $("#txtTotalQuantityToAdd").val(total);


            // alert("it can calculate the result product quantity");
        })
    });
</script>
