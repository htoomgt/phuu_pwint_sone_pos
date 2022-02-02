<script>
    dropDownRefresh();
    let breakdownMultiplier = 0;
    let resetBreakdownForm;
    let frmBreakdownValidationStatus = null;

    $(document).ready(function(){
        $("#dlProductFromBreakdown").change(async (e)=>{
            let productId = $("#dlProductFromBreakdown").val();

            let result  = await $.ajax({
                url: "{{route('product.getByParentProductId')}}",
                type: "GET",
                data: {
                    id: productId,
                    _token: "{{csrf_token()}}"
                },

            });

            if(result.status === "success"){
                let fetchedProduct = result.data;
                breakdownMultiplier = fetchedProduct.breadown_parent_full_multiplier;
                $("#dlProductToBreakdown").append(`<option selected value="${fetchedProduct.id}">${fetchedProduct.name}</option>`);
            }
            else{
                alert('Error at fetching product of breakdown')
            }








        })

        $("#txtQuantityToBreakdown").change(() => {

            let multiplier = breakdownMultiplier;
            let quantity = $("#txtQuantityToBreakdown").val();
            let total = quantity * multiplier;
            $("#txtTotalQuantityToAdd").val(total);


        })

        $("#btnMakeProductBreakdown").on('click', () => {



            let productFromId = $("#dlProductFromBreakdown").val();


            if(frmBreakdownValidationStatus.form()){
                alert("it is valid to submit")
            }




        });

        frmBreakdownValidationStatus = $("#frmMakeProductBreakdown").validate({
            rules : {
                dlProductFromBreakdown : {
                    required : true
                },
                txtQuantityToBreakdown : {
                    required : true,
                }
            },
            messages : {
                dlProductFromBreakdown : {
                    required : "Please choose product from list"
                },
                txtQuantityToBreakdown : {
                    required : "Please enter quantity",

                }

            }
        });





        $("#btnResetForm").on('click', () => {
            $("#dlProductFromBreakdown").val('').trigger('change');
            $("#dlProductToBreakdown").val('').trigger('change');
            $("#txtQuantityToBreakdown").val('');
            $("#txtTotalQuantityToAdd").val('');


        })
    });
</script>
