
<section id="organization-add">
	
	<h2>Edit an Organization</h2>
	
	<?php if (isset($error) && strlen($error) > 0): ?>
		<div class='error'>
			<?=$error?>
		</div>
		<br/>
	<?php endif; ?>

	<form class='edit-form' method='POST' action='/organizations/edit'>

		<input type="hidden" name="organization_id" value="<?=$organization_id?>" >
			
		<label for='name'>Name</label>
		<input type='text' name='name' id='name' class='textbox' autofocus
				value='<?=$name?>' />
		<br>
		<label for='description'>Description</label>
		<textarea name='description' id='description'><?=$description?></textarea>
		<br>
		<label for='director'>Director</label>
		<input type='text' name='director' id='director' class='textbox'
				value='<?=$director?>' />
		<br>
		<label for='website'>Website</label>
		<input type='text' name='website' id='website' class='textbox'
				value='<?=$website?>' />
		<br>
		<label for='email'>Email Address</label>
		<input type='text' name='email' id='email' class='textbox'
				value='<?=$email?>' />
		<br>
		<label for='phone'>Phone</label>
		<input type='text' name='phone' id='phone' class='textbox'
				value='<?=$phone?>' />		
		<br>
		<label for='phone'>Image</label>
		<input type='text' name='image_url' id='image_url' class='textbox'
				value='<?=$image_url?>' />		

		<br>
	
		<input type='submit' value='Update' class='button' />

	</form>

</section>

<br>
