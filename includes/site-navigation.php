	<!-- site navigation -->
	<nav class="site_navigation">

        <ul class='user_links'>

		<?php if ($user): ?>
			<li class='user_name'><?=$user->first_name?></li>
            <li id="navpart-profile"><a href='/users/profile'>Profile</a></li>
            <li><a href='/users/logout'>Logout</a></li>
        <?php else: ?>    
          	<li id="navpart-login" class="login"><a href="/users/login">Login</a></li>
		<?php endif; ?>

    	</ul>
 
		<ul id="mainnav">
		<!--
			<li class="youarehere"><a href="/">Music</a></li>
			<li><a href="#">Visual Arts</a></li>
			<li><a href="#">Theatre</a></li>
			<li><a href="#">Festivals</a></li>
		-->
            <li id="navpart-index"><a href="/">Home</a></li>
            <li id="navpart-events"><a href="/events">Events</a></li>
            <li id="navpart-organizations"><a href="/organizations">Organizations</a></li>
            <li id="navpart-venues"><a href="/venues">Venues</a></li>

			<li id="navpart-about"><a href="/index/about">About</a></li>
 		</ul>
	</nav>			
	<!-- end site navigation -->