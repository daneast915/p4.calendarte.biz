    $(document).ready(function(){
        $("input.date").datepicker();
        $("input#enddate").datepicker({ defaultDate: +7 });
			
        $("input[type=submit]").button();

        $("input.time").timepicker({ 
        	'timeFormat': 'h:i A',
        	'scrollDefaultTime': '19:00',
        	'step': 15
         });
    })


