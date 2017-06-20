<html>
	<head>
		<title>{$title|default:'PS'}{#title_seperator#}{#app_name#}</title>
		<meta http-equiv="Content-Type" content="text/html; charset={#charset#}" />
		<meta name="viewport" content="width=1000">
		<link href="{#views_path#}css/style.css" title="Main Stylesheet" rel="stylesheet"/>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?api=AIzaSyCWak2jZCKcmUO_3wZhGJtiXcyrpKoHP2I&sensor=false&language=el&libraries=places"></script>
		<script type="text/javascript" src="{#views_path#}javascript/infobox.js" charset="utf-8"></script>
		<script type="text/javascript" src="{#views_path#}javascript/mainScript.js" charset="utf-8"></script>
		<script type="text/javascript" src="{#views_path#}javascript/validate.js" charset="utf-8"></script>
		<script type="text/javascript" src="{#views_path#}javascript/imageInfo.js"></script>
		<script type="text/javascript" src="{#views_path#}javascript/tooltip.js"></script>
		<script type="text/javascript" src="{#views_path#}javascript/autocomplete.js"></script>
		<script type="text/javascript" src="{#views_path#}javascript/geolocation.js"></script>
		<script type="text/javascript" src="{#views_path#}javascript/geo.js"></script>
	</head>
	<body>
	<body>
	<div id="stickyFooter">
		<div id="stickyContent">
		<div id="header">
			<div id="wrapper">
				<a href="index.php" title="Photo Sharing Home Page"><img src="{#images_path#}/logo.jpg" class="logo" alt="Photo Sharing"></a>
				<div class="fright" id="welcome">
						Καλωσήλθατε 
						{if isset($member)}
							<q>{$member->username}</q>
							<br/>
							<a href='profile.php'>Ο λογαριασμός μου</a>
							&nbsp;&bull;&nbsp;
							<a href='photos.php'>Άλμπουμ</a>
						{else}
							επισκέπτη
							<br/>
							<a href='login.php'>Σύνδεση</a>
							&nbsp;&bull;&nbsp;
							<a href='register.php'>Εγγραφή</a>
						{/if}
						

				</div>
			</div><!-- wrapper -->
		</div><!--  header -->