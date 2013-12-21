
        <div class="content">
		    <!-- breadcrumb navigation -->
		    <nav class="breadcrumb_navigation">
			    <ul>
				    <li class="breadcrumb_root">
					    <a href="/">Home</a>
					    <ul>
						    <li class="breadcrumb_child">Organization Directory</li>
					    </ul>
				    </li>
			    </ul>
		    </nav>
		    <!-- end breadcrumb navigation -->             
            
            <?php if ($user): ?>
	            <div class='add-link'>
	            	<form method='POST' action='/organizations/add'>
						<input type='submit' value='Add Organization' class='detail-button' />
					</form>
	            </div>
 			<?php endif; ?>

            <h2 class="before-list">Organizations</h2>

            <hr class="clearme"/>
	
			<?php if (isset($message)): ?>
				<div class='message'>
					<?=$message?>
				</div>
				<br/>
			<?php endif; ?>

            <table id="directory-table" class="pretty">
	            <thead>
		            <tr>
			            <th>Organization</th>
			            <th>City</th>
		            </tr>
	            </thead>
	            <tbody>        

                    <?php foreach ($organizations as $organization): ?>

                    	<tr>
							<td>
						   		<a href="/organizations/detail/<?=$organization->id?>"><?=$organization->name?></a>
						   	</td>
						   	<td>
						    	<?=$organization->address->city?>, <?=$organization->address->state?>
						   	</td>
						</tr>

                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
