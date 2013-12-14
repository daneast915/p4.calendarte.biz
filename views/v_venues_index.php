
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
            
            <h2>Venues</h2>
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
						   		<a href="/venues/detail/<?=$venue->id?>"><?=$venue->name?></a>
						   	</td>
						   	<td>
						    	<?=$venue->address->city?>, <?=$venue->address->state?>
						   	</td>
						</tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

