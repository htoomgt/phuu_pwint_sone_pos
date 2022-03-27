<script>
    systemCommon();
    dropDownRefresh();
    let frmDataGridValidationStatus;

    $("#btnSearch").on('click', (e) => {
        e.preventDefault();

        if (frmDataGridValidationStatus.form()) {
            $("#{{ $dataTableId }}").DataTable().ajax.reload();

            let dataToPost = $("#frmDataGrid").serialize();

            $.ajax({
                url : "{{route('report.totalAmountSaleAndProfit')}}",
                method : "GET",
                data: dataToPost,
                success : (response) => {
                    console.log(response);
                    $("#total_sale_amount_label").html(response.data.total_amount);
                    $("#total_profit_label").html(response.data.total_profit);
                },
                
            })
            
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
