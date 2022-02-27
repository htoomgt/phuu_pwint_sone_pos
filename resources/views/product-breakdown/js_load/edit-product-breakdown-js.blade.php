<script>
    dropDownRefresh();
    let resetForm;
    let breakdownMultiplier = 0;
    let resetBreakdownForm;
    let frmBreakdownValidationStatus = null;

    $(document).ready(function(){
        $("#dlProductFromBreakdown").change(async (e)=>{
            let productId = $("#dlProductFromBreakdown").val();
            console.log(productId);

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
                $("#dlProductToBreakdown1").html(`<option selected value="${fetchedProduct.id}">${fetchedProduct.name}</option>`);
            }
            else{
                alert('Error at fetching product of breakdown')
            }








        })
        console.log('{{$productBreakdownRecord->product_from}}');

        $("#dlProductFromBreakdown").trigger('change');

        $("#txtQuantityToBreakdown").change(() => {

            let multiplier = breakdownMultiplier;
            let quantity = $("#txtQuantityToBreakdown").val();
            let total = quantity * multiplier;
            $("#txtTotalQuantityToAdd").val(total);


        })

        setTimeout(() => {
            $("#txtQuantityToBreakdown").trigger('change');
        }, 800);


        $("#btnUpdateProductBreakdown").on('click', (e) => {
            e.preventDefault();



            let productFromId = $("#dlProductFromBreakdown").val();


            if(frmBreakdownValidationStatus.form()){
                let dataToPost = $("#frmUpdateProductBreakdown").serialize();
                let url = "{{route('productBreakdown.updateById')}}";

                axios({
                    url : url,
                    method : "PUT",
                    data : dataToPost,
                })
                .then((response) => {
                    if(response.data.status  === "success"){
                        Swal.fire({
                            'icon' : 'success',
                            'title' : 'Product Breakdown ',
                            'text' : response.data.messages.request_msg,
                            'confirmButtonText' : "OK"
                        })
                        .then((result)=>{
                            if(result.isConfirmed){
                                window.location = "{{ route('productBreakdown.showList') }}";
                            }
                        });
                    }
                })


                // alert("it is valid to submit");
            }




        });

        frmBreakdownValidationStatus = $("#frmUpdateProductBreakdown").validate({
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



        resetForm = () => {
            $("#dlProductFromBreakdown").val('').trigger('change');
            $("#txtQuantityToBreakdown").val('');
            $("#txtTotalQuantityToAdd").val('');

            setTimeout(() => {
                $("#dlProductToBreakdown").html('<option selected value="">Select Product</option>');
            }, 1000);
        }

        $("#btnResetForm").on('click', resetForm);



    });
</script>
