<?php
include_once 'inc/init.inc.php';
include_once 'inc/__autoload.php';
$birthdays = new Birthday();
$birthdays->getAllBirthdays();
?>

<!DOCTYPE html>
<head>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.6.3/css/foundation.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Geburtstage bei Angela Bruderer</title>
</head>
<body style="background-image: url('<?php echo $birthdays->getBackgroundImage() ?>')" width="1920px" height="1080px">
	<div class="grid-container">
		<div class="grid-x grid-padding-x">
			<div class="small-12 cell">
				<div class="innerWrapper">
					<?php echo $birthdays->render(); ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>