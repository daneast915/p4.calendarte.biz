
<section id="organization-add">
	
	<h2>Add an Organization</h2>

	<form class='add-form' method='POST' action='/organizations/add'>
	
		<?php if (isset($error) && strlen($error) > 0): ?>
			<div class='error'>
				<?=$error?>
			</div>
			<br/>
		<?php endif; ?>
	
		<label for='name'>Name *</label>
		<input type='text' name='name' id='name' class='textbox' autofocus
				value='<?=$organization->name?>' />
		<br>
		<label for='description'>Description *</label>
		<textarea name='description' id='description'><?=$organization->description?></textarea>
		<br>
		<label for='director'>Director *</label>
		<input type='text' name='director' id='director' class='textbox'
				value='<?=$organization->director?>' />
		<br>
		<label for='address_street'>Address - Street *</label>
		<input type='text' name='address_street' id='address_street' class='textbox'
				value='<?=$organization->address->street?>' />
		<br>
		<label for='address_city'>City *</label>
		<input type='text' name='address_city' id='address_city' class='city textbox'
				value='<?=$organization->address->city?>' />
		<br>
		<label for='address_state'>State *</label>

		<select name='address_state' id='address_state' class='state textbox' value='<?=$organization->address->state?>' > 
			<option value="" selected="selected">Select a State</option> 
    		<?php 
    			$address_state = $organization->address->state;
    			include("includes/states-for-select.php"); 
    		?>
		</select>

		<br>
		<label for='address_zipcode'>Zip Code *</label>
		<input type='text' name='address_zipcode' id='address_zipcode' class='zipcode textbox'
				value='<?=$organization->address->zipcode?>' />
		<br>
		<label for='website'>Website *</label>
		<input type='text' name='website' id='website' class='textbox'
				value='<?=$organization->website?>' />
		<br>
		<label for='email'>Email Address</label>
		<input type='text' name='email' id='email' class='textbox'
				value='<?=$organization->email?>' />
		<br>
		<label for='phone'>Phone</label>
		<input type='text' name='phone' id='phone' class='textbox'
				value='<?=$organization->phone?>' />		
		<br>
		<label for='phone'>Image</label>
		<input type='text' name='image_url' id='image_url' class='textbox'
				value='<?=$organization->image_url?>' />		

		<br>
	
		<input type='submit' value='Add' class='button' />

	</form>

</section>

<br>
