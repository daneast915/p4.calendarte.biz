
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
            
            <h2>Organizations</h2>
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
