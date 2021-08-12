<script>
    systemCommon();
    dropDownRefresh();
    let frmDataGridValidationStatus;

    $("#btnSearch").on('click', (e) => {
        e.preventDefault();

        if (frmDataGridValidationStatus.form()) {
            $("#dtInventory").DataTable().ajax.reload();
        }

    })

    $("#btnExport").on('click', (e) => {
        e.preventDefault();

        if (frmDataGridValidationStatus.form()) {
            alert("Your form is ready to export file");
        }

    })

    $("input").on('change', function() {
        $(this).valid();
    });

    $("#aggerate_date").on('click', function() {
        $(".select2Product").val("");
        $(".select2Product").trigger("change");

    })

    frmDataGridValidationStatus = $("#frmDataGrid").validate({
        rules: {
            start_date: {
                required: true
            },
            end_date: {
                required: true
            }
        },
        messages: {

            start_date: {
                required: "Please enter start date for action"
            },
            end_date: {
                required: "Please enter end date for action"
            }
        }
    })
</script>
