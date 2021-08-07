<script>
    function systemCommon() {
        $(".datePicker").datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            autoclose: true
        });


    }

    function getDateTime() {
        var now = new Date();
        var year = now.getFullYear();
        var month = now.getMonth() + 1;
        var day = now.getDate();
        var hour = now.getHours();
        var minute = now.getMinutes();
        var second = now.getSeconds();
        if (month.toString().length == 1) {
            month = '0' + month;
        }
        if (day.toString().length == 1) {
            day = '0' + day;
        }
        if (hour.toString().length == 1) {
            hour = '0' + hour;
        }
        if (minute.toString().length == 1) {
            minute = '0' + minute;
        }
        if (second.toString().length == 1) {
            second = '0' + second;
        }
        var dateTime = year + '/' + month + '/' + day + ' ' + hour + ':' + minute + ':' + second;
        return dateTime;
    }

    function copyToClp(txt) {
        var m = document;
        txt = m.createTextNode(txt);
        var w = window;
        var b = m.body;
        b.appendChild(txt);
        if (b.createTextRange) {
            var d = b.createTextRange();
            d.moveToElementText(txt);
            d.select();
            m.execCommand('copy');
        } else {
            var d = m.createRange();
            var g = w.getSelection;
            d.selectNodeContents(txt);
            g().removeAllRanges();
            g().addRange(d);
            m.execCommand('copy');
            g().removeAllRanges();
        }
        txt.remove();
    }
</script>
