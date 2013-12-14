        <div class="content">
		    <!-- breadcrumb navigation -->
		    <nav class="breadcrumb_navigation">
			    <ul>
				    <li class="breadcrumb_root">
					    <a href="/">Home</a>
					    <ul>
						    <li class="breadcrumb_child">Event Directory</li>
					    </ul>
				    </li>
			    </ul>
		    </nav>
		    <!-- end breadcrumb navigation -->             
            
            <h2 class="before-summaries">Events</h2>
            
            <section class="event-summaries">

       			<?php if(isset($events)) echo $events; ?>

            </section>
            
        </div>