
<section id="venue-edit">
	
	<h2>Edit a Venue</h2>

	<form class='edit-form' method='POST' action='/venues/p_edit'>
	
		<?php if (isset($error) && strlen($error) > 0): ?>
			<div class='error'>
				<?=$error?>
			</div>
			<br/>
		<?php endif; ?>

		<input type="hidden" name="venue_id" value="<?=$venue->venue_id?>" >
	
		<label for='name'>Name *</label>
		<input type='text' name='name' id='name' class='textbox' autofocus
				value='<?=$venue->name?>' />
		<br>
		<label for='description'>Description</label>
		<textarea name='description' id='description'><?=$venue->description?></textarea>
		<br>
		<label for='address_street'>Address - Street *</label>
		<input type='text' name='address_street' id='address_street' class='textbox'
				value='<?=$venue->address->street?>' />
		<br>
		<label for='address_city'>City *</label>
		<input type='text' name='address_city' id='address_city' class='city textbox'
				value='<?=$venue->address->city?>' />
		<br>
		<label for='address_state'>State *</label>

		<select name='address_state' id='address_state' class='state textbox' value='<?=$venue->address->state?>' > 
			<option value="" selected="selected">Select a State</option> 
			<?php
			$default = $venue->address->state;
			$states = array('AL'=>"Alabama",  
			            'AK'=>"Alaska",  
			            'AZ'=>"Arizona",  
			            'AR'=>"Arkansas",  
			            'CA'=>"California",  
			            'CO'=>"Colorado",  
			            'CT'=>"Connecticut",  
			            'DE'=>"Delaware",  
			            'DC'=>"District Of Columbia",  
			            'FL'=>"Florida",  
			            'GA'=>"Georgia",  
			            'HI'=>"Hawaii",  
			            'ID'=>"Idaho",  
			            'IL'=>"Illinois",  
			            'IN'=>"Indiana",  
			            'IA'=>"Iowa",  
			            'KS'=>"Kansas",  
			            'KY'=>"Kentucky",  
			            'LA'=>"Louisiana",  
			            'ME'=>"Maine",  
			            'MD'=>"Maryland",  
			            'MA'=>"Massachusetts",  
			            'MI'=>"Michigan",  
			            'MN'=>"Minnesota",  
			            'MS'=>"Mississippi",  
			            'MO'=>"Missouri",  
			            'MT'=>"Montana",
			            'NE'=>"Nebraska",
			            'NV'=>"Nevada",
			            'NH'=>"New Hampshire",
			            'NJ'=>"New Jersey",
			            'NM'=>"New Mexico",
			            'NY'=>"New York",
			            'NC'=>"North Carolina",
			            'ND'=>"North Dakota",
			            'OH'=>"Ohio",  
			            'OK'=>"Oklahoma",  
			            'OR'=>"Oregon",  
			            'PA'=>"Pennsylvania",  
			            'RI'=>"Rhode Island",  
			            'SC'=>"South Carolina",  
			            'SD'=>"South Dakota",
			            'TN'=>"Tennessee",  
			            'TX'=>"Texas",  
			            'UT'=>"Utah",  
			            'VT'=>"Vermont",  
			            'VA'=>"Virginia",  
			            'WA'=>"Washington",  
			            'WV'=>"West Virginia",  
			            'WI'=>"Wisconsin",  
			            'WY'=>"Wyoming");

			foreach($states as $key=>$val) {
			    echo ($key == $default) ? "<option selected=\"selected\" value=\"$key\">$val</option>":"<option value=\"$key\">$val</option>";
			}
			?>
		</select>

		<br>
		<label for='address_zipcode'>Zip Code *</label>
		<input type='text' name='address_zipcode' id='address_zipcode' class='zipcode textbox'
				value='<?=$venue->address->zipcode?>' />
		<br>
		<label for='website'>Website *</label>
		<input type='text' name='website' id='website' class='textbox'
				value='<?=$venue->website?>' />
		<br>
		<label for='email'>Email Address *</label>
		<input type='text' name='email' id='email' class='textbox'
				value='<?=$venue->email?>' />
		<br>
		<label for='phone'>Phone</label>
		<input type='text' name='phone' id='phone' class='textbox'
				value='<?=$venue->phone?>' />		
		<br>
		<label for='phone'>Image</label>
		<input type='text' name='image_url' id='image_url' class='textbox'
				value='<?=$venue->image_url?>' />		

		<br>
	
		<input type='submit' value='Update' class='button' />

	</form>

</section>

<br>
