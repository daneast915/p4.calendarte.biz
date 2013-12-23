		<?php
			$default = $venue_id;
			foreach($venues as $key=>$val) {
			    echo ($key == $default) ? "<option selected=\"selected\" value=\"$key\">$val</option>":"<option value=\"$key\">$val</option>";
			}
		?>