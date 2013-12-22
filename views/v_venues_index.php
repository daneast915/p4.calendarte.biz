
        <div class="content">
		    <!-- breadcrumb navigation -->
		    <nav class="breadcrumb_navigation">
			    <ul>
				    <li class="breadcrumb_root">
					    <a href="/">Home</a>
					    <ul>
						    <li class="breadcrumb_child">Venue Directory</li>
					    </ul>
				    </li>
			    </ul>
		    </nav>
		    <!-- end breadcrumb navigation -->             
            
            <?php if ($user): ?>
	            <div class='add-link'>
	            	<form method='POST' action='/venues/add'>
						<input type='submit' value='Add Venue' class='detail-button' />
					</form>
	            </div>
			<?php endif; ?>          

            <h2 class="before-list">Venues</h2>

            <hr class="clearme"/>
	
			<?php if (isset($message)): ?>
				<div class='message'>
					<?=$message?>
				</div>
				<br/>
			<?php endif; ?>
    
            <?php if (isset($error) && strlen($error) > 0): ?>
                <div class='error'>
                    <?=$error?>
                </div>
                <br/>
            <?php endif; ?>
            
            <table id="directory-table" class="pretty">
	            <thead>
		            <tr>
			            <th>Venue</th>
			            <th>City</th>
		            </tr>
	            </thead>
	            <tbody>            
                    <?php foreach ($venues as $venue): ?>

                    	<tr>
							<td>
						   		<a href="/venues/detail/<?=$venue->venue_id?>"><?=$venue->name?></a>
						   	</td>
						   	<td>
						    	<?=$venue->address->city?>, <?=$venue->address->state?>
						   	</td>
						</tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

