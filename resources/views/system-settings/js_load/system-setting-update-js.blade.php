<script>
    systemSettingEdit = async (id=0) => {

        // Modal Show
        $("#mdlSystemSettingsEdit").modal('show');

        // Form reset
        $("#frmSystemSettingsUpdate").trigger('reset');

        // Get data by Id and load to form
        let systemSettingToEdit = null;

        let resp = await axios.get("{{route('system_settings.getDataRowById')}}", { params : {id : id}});

        systemSettingToEdit = resp.data.data;


        $("#textSystemSettingnameEdit").val(systemSettingToEdit.setting_name);
        $("#txtSystemSettingValueEdit").val(systemSettingToEdit.setting_name);
        $("#hvSystemSettingId").val(systemSettingToEdit.id);
    }

    $("#btnSystemSettingUpdate").on('click', function(){
        if(productMeasureUnitValidationStatus.form()){
            let dataToPost = $("#frmSystemSettingsUpdate").serialize();
            let url = $("#frmSystemSettingsUpdate").attr('action');

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
                        title : 'Updating A System Setting',
                        text : response.data.messages.request_msg,
                        confirmButtonText : "OK"
                    }).then((result)=>{
                        $("#frmSystemSettingsUpdate")[0].reset();
                        $("#mdlSystemSettingsEdit").modal('hide');
                    })

                    $("{{$dataTableIdSelector}}").DataTable().ajax.reload();
                }
            }).catch(function(error){
                console.log(error);
            })


        }
    })


    productMeasureUnitValidationStatus = $("#frmSystemSettingsUpdate").validate({
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
