<script>
    systemCommon();
    dropDownRefresh();
    let frmDataGridValidationStatus;

    $("#btnSearch").on('click', (e) => {
        e.preventDefault();

        
            $("#{{ $dataTableId }}").DataTable().ajax.reload();

            

            
            
        

    })

    $("#btnExport").on('click', (e) => {
        e.preventDefault();

        $("#frmDataGrid").attr('action', '{{route("report.saleAndProfitDailyExport")}}')

        if (frmDataGridValidationStatus.form()) {
            $("#frmDataGrid").attr('action', '{{route("report.inventory_export")}}')  
            // console.log("hello current inventory export");          
            // console.log('{{route("report.inventory_export")}}');
            $("#frmDataGrid").submit();
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
