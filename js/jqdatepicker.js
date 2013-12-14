    $(document).ready(function(){
        $("input.date").datepicker();
        $("input.date").datepicker( "option", "dateFormat", "yy-mm-dd" );
			
        $("input[type=submit]").button();
    })


