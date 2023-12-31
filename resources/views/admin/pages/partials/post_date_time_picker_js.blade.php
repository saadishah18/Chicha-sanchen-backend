<script>
    function postDateTimePicker(date = new Date()){
        $('#schedule_calendar').datetimepicker({
            date,
            viewMode: 'YMDHM',
            onDateChange: function(){
                $("#is_schedule_lbl").text(this.getText('YYYY-MM-DD hh:m:ss'));
                $('#schedule_date').val(this.getText('YYYY-MM-DD hh:m:ss'));
            },
            onOk: function() {
                $("#toggle_calendar").toggleClass('d-none');
            },
        });
        $(document).on('change','#is_scheduled',function (){
            if($(this).prop("checked") == true){
                $("#is_schedule_val").val('1');
                $('#toggle_calendar').removeClass('d-none');
            }
            else if($(this).prop("checked") == false){
                $("#is_schedule_val").val('0');
                $('#toggle_calendar').addClass('d-none');
            }
        });
    }
</script>
