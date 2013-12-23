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

</head>

<body 
    <?php if (isset($body_id)): ?>
        id="<?=$body_id?>"
    <?php endif; ?>
>	
<div class="container">
 
    <?php include("includes/header.php"); ?>

    <?php include("includes/site-navigation.php"); ?>

    <?php include("includes/category-navigation.php"); ?>
	
	<br/>

	<?php if(isset($content)) echo $content; ?>
	
	<?php include("includes/footer.php"); ?>

	<?php if(isset($client_files_body)) echo $client_files_body; ?>

</div>
</body>
</html>