<?php
include_once 'classes/Birthday.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');
$list = new Birthday();
$list->getAllBirthdays();
?>

<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.6.3/css/foundation.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Geburtstage bei Angela Bruderer</title>
</head>
<body style="background-image: url('<?php echo $list->getBackgroundImage() ?>')">
	<div class="grid-container">
		<!-- <div class="grid-x grid-padding-x">
			<div class="small-3 cell float-left">
				<header>
					<img src="img/AB_Logo_Rot_rgb.png" alt="Logo Angela Bruderer" class="logo">
				</header>
			</div>
		</div> -->
		<div class="grid-x grid-padding-x">
			<div class="small-12 cell">
				<div class="innerWrapper">
					<?php	
						echo $list->render();
					?>
				</div>

			</div>
		</div>
	</div>
</body>
</html>