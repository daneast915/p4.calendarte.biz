	<!-- site navigation -->
	<nav class="site_navigation">

        <ul class='user_links'>

		<?php if ($user): ?>
			<li class='user_name'><?=$user->first_name?></li>
            <li><a href='/users/profile'>Profile</a></li>
            <li><a href='/users/logout'>Logout</a></li>
        <?php else: ?>    
          	<li class="login"><a href="/users/login">Login</a></li>
		<?php endif; ?>

    	</ul>
 
		<ul>
			<li class="youarehere"><a href="/">Music</a></li>
			<li><a href="#">Visual Arts</a></li>
			<li><a href="#">Theatre</a></li>
			<li><a href="#">Festivals</a></li>
			<li><a href="#">About Us</a></li>
 		</ul>
	</nav>			
	<!-- end site navigation -->