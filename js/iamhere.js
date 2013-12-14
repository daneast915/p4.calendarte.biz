$(document).ready(function() {
	/* set id of navpart */
    var mybodyid = $('body').attr('id');
    var mynavid = '#navpart-' + mybodyid;
    /* e.g. for iii.php:
      mybodyid is 'iii'
      mynavid  is '#navpart-iii'
    */
    $(mynavid).attr('id','iamhere');
});

