<script>
    productMeasureUnitEdit = async (id=0) => {

        // Modal Show
        $("#mdlUpdateProductMeasureUnit").modal('show');

        // Form reset
        $("#frmUpdateProductMeasureUnit").trigger('reset');

        // Get data by Id and load to form
        let productMeasureUnit = null;

        let resp = await axios.get("{{route('productMeasureUnit.getDataRowById')}}", { params : {id : id}});

        productMeasureUnit = resp.data.data;


        $("#txtProductMeasureUnitUpdate").val(productMeasureUnit.name);
        $("#hProductMeasureUnitUpdateId").val(productMeasureUnit.id);
    }

    $("#btnProductMeasureUnitUpdate").on('click', function(){
        if(productMeasureUnitValidationStatus.form()){
            let dataToPost = $("#frmUpdateProductMeasureUnit").serialize();
            let url = "{{route('productMeasureUnit.updateById')}}";

            axios({
                url : url,
                method : "PUT",
                data : dataToPost,
                type : 'application/json'
            }).then(function(response){
                if(response.data.status == 'success')
                {
                    Swal.fire({
                        icon : 'success',
                        title : 'Updating a product measure unit',
                        text : response.data.messages.request_msg,
                        confirmButtonText : "OK"
                    }).then((result)=>{
                        $("#mdlUpdateProductMeasureUnit").modal('hide');
                    })

                    $("#dtProductMeasureUnit").DataTable().ajax.reload();
                }
            }).catch(function(error){
                console.log(error);
            })


        }
    })


    productMeasureUnitValidationStatus = $("#frmUpdateProductMeasureUnit").validate({
        rules : {
            name : {
                required : true
            }
        },
        messages : {
            name : {
                required : "The product measure unit is required!"
            }
        }
    })
</script>
