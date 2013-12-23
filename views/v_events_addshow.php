
<section id="show-add">
	
	<h2>Add a Show for Event</h2>

	<form class='add-form' method='POST' action='/events/addshow'>
	
		<?php if (isset($error) && strlen($error) > 0): ?>
			<div class='error'>
				<?=$error?>
			</div>
			<br/>
		<?php endif; ?>

		<input type="hidden" name="event_id" value="<?=$show->event_id?>" >

		<label for='venue_id'>Venue *</label>
		<select name='venue_id' id='venue_id' class='venue textbox' value='<?=$show->venue_id?>' > 
			<option value="" selected="selected">Select a Venue</option> 
    		<?php 
    			$venue_id = $show->venue_id;
    			include("includes/venues-for-select.php"); 
    		?>
		</select>
		<br>
		<label for='showdate'>Date *</label>
		<input class="date" type="text" size="12" name="showdate" id="showdate" value="<?=$show->dateString?>" />
		<br>
		<label for='showtime'>Time *</label>
		<input class="time" type="text" size="12" name="showtime" id="showtime" value="<?=$show->timeString?>" />

		<br>
	
		<input type='submit' value='Add' class='button' />

	</form>

</section>

<br>
