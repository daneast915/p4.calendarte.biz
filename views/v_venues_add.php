
<section id="venue-add">
	
	<h2>Add a Venue</h2>

	<form class='add-form' method='POST' action='/venues/add'>
	
		<?php if (isset($error) && strlen($error) > 0): ?>
			<div class='error'>
				<?=$error?>
			</div>
			<br/>
		<?php endif; ?>
	
		<label for='name'>Name *</label>
		<input type='text' name='name' id='name' class='textbox' autofocus
				value='<?=$name?>' />
		<br>
		<label for='description'>Description</label>
		<textarea name='description' id='description'><?=$description?></textarea>
		<br>
		<label for='address_street'>Address - Street *</label>
		<input type='text' name='address_street' id='address_street' class='textbox'
				value='<?=$address_street?>' />
		<br>
		<label for='address_city'>City *</label>
		<input type='text' name='address_city' id='address_city' class='city textbox'
				value='<?=$address_city?>' />
		<br>
		<label for='address_state'>State *</label>
		<!--
		<input type='text' name='address_state' id='address_state' class='state textbox'
				value='<?=$address_state?>' />
		-->
		<select name='address_state' id='address_state' class='state textbox' value='<?=$address_state?>' > 
			<option value="" selected="selected">Select a State</option> 
			<option value="AL">Alabama</option> 
			<option value="AK">Alaska</option> 
			<option value="AZ">Arizona</option> 
			<option value="AR">Arkansas</option> 
			<option value="CA">California</option> 
			<option value="CO">Colorado</option> 
			<option value="CT">Connecticut</option> 
			<option value="DE">Delaware</option> 
			<option value="DC">District Of Columbia</option> 
			<option value="FL">Florida</option> 
			<option value="GA">Georgia</option> 
			<option value="HI">Hawaii</option> 
			<option value="ID">Idaho</option> 
			<option value="IL">Illinois</option> 
			<option value="IN">Indiana</option> 
			<option value="IA">Iowa</option> 
			<option value="KS">Kansas</option> 
			<option value="KY">Kentucky</option> 
			<option value="LA">Louisiana</option> 
			<option value="ME">Maine</option> 
			<option value="MD">Maryland</option> 
			<option value="MA">Massachusetts</option> 
			<option value="MI">Michigan</option> 
			<option value="MN">Minnesota</option> 
			<option value="MS">Mississippi</option> 
			<option value="MO">Missouri</option> 
			<option value="MT">Montana</option> 
			<option value="NE">Nebraska</option> 
			<option value="NV">Nevada</option> 
			<option value="NH">New Hampshire</option> 
			<option value="NJ">New Jersey</option> 
			<option value="NM">New Mexico</option> 
			<option value="NY">New York</option> 
			<option value="NC">North Carolina</option> 
			<option value="ND">North Dakota</option> 
			<option value="OH">Ohio</option> 
			<option value="OK">Oklahoma</option> 
			<option value="OR">Oregon</option> 
			<option value="PA">Pennsylvania</option> 
			<option value="RI">Rhode Island</option> 
			<option value="SC">South Carolina</option> 
			<option value="SD">South Dakota</option> 
			<option value="TN">Tennessee</option> 
			<option value="TX">Texas</option> 
			<option value="UT">Utah</option> 
			<option value="VT">Vermont</option> 
			<option value="VA">Virginia</option> 
			<option value="WA">Washington</option> 
			<option value="WV">West Virginia</option> 
			<option value="WI">Wisconsin</option> 
			<option value="WY">Wyoming</option>
		</select>

		<br>
		<label for='address_zipcode'>Zip Code *</label>
		<input type='text' name='address_zipcode' id='address_zipcode' class='zipcode textbox'
				value='<?=$address_zipcode?>' />
		<br>
		<label for='website'>Website *</label>
		<input type='text' name='website' id='website' class='textbox'
				value='<?=$website?>' />
		<br>
		<label for='email'>Email Address *</label>
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
	
		<input type='submit' value='Add' class='button' />

	</form>

</section>

<br>
