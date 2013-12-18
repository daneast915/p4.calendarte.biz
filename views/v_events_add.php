
<section id="event-add">
	
	<h2>Add an Event</h2>

	<form class='add-form' method='POST' action='/events/add'>
	
		<?php if (isset($error) && strlen($error) > 0): ?>
			<div class='error'>
				<?=$error?>
			</div>
			<br/>
		<?php endif; ?>

		<input type="hidden" name="organization_id" value="<?=$organization_id?>" >

		<label for='name'>Name *</label>
		<input type='text' name='name' id='name' class='textbox' autofocus
				value='<?=$name?>' />
		<br>
		<label for='description'>Description *</label>
		<textarea name='description' id='description'><?=$description?></textarea>
		<br>
		<label for='website'>Website</label>
		<input type='text' name='website' id='website' class='textbox'
				value='<?=$website?>' />
		<br>
		<label for='purchase_link'>Purchase Link</label>
		<input type='text' name='purchase_link' id='purchase_link' class='textbox'
				value='<?=$purchase_link?>' />
		<br>
		<label for='admission_info'>Admission Information</label>
		<input type='text' name='admission_info' id='admission_info' class='textbox'
				value='<?=$admission_info?>' />		

		<br>
	
		<input type='submit' value='Add' class='button' />

	</form>

</section>

<br>
