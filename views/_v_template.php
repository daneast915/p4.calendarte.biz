<!DOCTYPE html>
<html>
<head>
	<title><?=APP_NAME?>
        <?php if ($title): ?>
        - <?=$title?>
        <?php endif; ?>
    </title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
					
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>

    <?php include("includes/common-meta.php"); ?>
    
    <!-- favicon -->
    <link rel="icon" href="/images/cclef16.png" type="image/png">

    <?php include("includes/common-stylescript.php"); ?>

    <script src="js/lean-slider/lean-slider.js"></script>
    <link rel="stylesheet" href="js/lean-slider/lean-slider.css" type="text/css" />

	<script type="text/javascript">
        $(document).ready(function() {
            var slider = $('#slider').leanSlider({
                directionNav: '#slider-direction-nav',
                controlNav: '#slider-control-nav',
    			pauseTime: 4000
            });
        });
    </script>	
</head>

<body 
    <?php if (isset($body_id)): ?>
        id="<?=$body_id?>"
    <?php endif; ?>
>	
<div class="container">
 
<!--
	<header>
    	<h1>
    		<a class="header_link" title="<?=APP_NAME?>" href="/">
    			"<?=APP_NAME?>"
    		</a>
    	</h1>
	</header>
-->
    <?php include("includes/header.php"); ?>

    <?php include("includes/site-navigation.php"); ?>
    <?php include("includes/category-navigation.php"); ?>

<!--
    <?php if ($user): ?>
-->
    
    <!-- Menu for users who are logged in -->
<!--
	<nav class='site_navigation'>
        
        <ul class='user_links'>
			<li class='user_name'><?=$user->first_name?></li>
            <li><a href='/users/profile'>Profile</a></li>
            <li><a href='/users/logout'>Logout</a></li>
    	</ul>

    	<ul>
			<li><a href='/'>Home</a></li>
		
            <li><a href='/posts/add'>Add Post</a></li>
            <li><a href='/posts/index'>See Posts</a></li>
            <li><a href='/posts/users'>Follow Users</a></li>
        </ul>
        
        <hr class="clearme"/>
	
	</nav>
-->

<!--
    <?php endif; ?>
-->
	
	<br/>

	<?php if(isset($content)) echo $content; ?>
	
	<?php include("includes/footer.php"); ?>

	<?php if(isset($client_files_body)) echo $client_files_body; ?>

</div>
</body>
</html>