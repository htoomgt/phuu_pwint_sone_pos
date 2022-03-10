<script>
    $(document).ready(function() {
        $("#btnSystemSettingCreate").on('click', function() {
            console.log(productMeasureUnitValidationStatus.form());
            if (productMeasureUnitValidationStatus.form()) {
                let dataToPost = $("#frmSystemSettings").serialize();
                let url = "{{ route('system_settings.addNew') }}";

                axios({
                    url: url,
                    method: "POST",
                    data: dataToPost,
                    type: 'application/json'
                }).then(function(response) {
                    if (response.data.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Creating a system setting',
                            text: response.data.messages.request_msg,
                            confirmButtonText: "OK"
                        }).then((result) => {
                            $("#mdlSystemSettings").modal('hide');
                            $("#frmSystemSettings")[0].reset();
                        })

                        $("{{$dataTableIdSelector}}").DataTable().ajax.reload();
                    }
                }).catch(function(error) {
                    console.log(error);
                })


            }
        })

        productMeasureUnitValidationStatus = $("#frmSystemSettings").validate({
            rules: {
                system_setting_name: {
                    required: true
                },
                system_setting_value: {
                    required: true
                }
            },
            messages: {
                system_setting_name: {
                    required: "The system settting name is required!"
                },
                system_setting_value: {
                    required: "The system setting value is required!"
                }
            }
        })
    });
</script>
