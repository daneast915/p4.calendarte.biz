    $(document).ready(function(){
        $("input.date").datepicker();
        $("input.date").datepicker();
			
        $("input[type=submit]").button();

        $("input.time").timepicker({ 
        	'timeFormat': 'h:i A',
        	'scrollDefaultTime': '19:00'
         });
    })


