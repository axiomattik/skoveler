<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">

	<title>Skoveler</title>

	<link rel="stylesheet" href="/assets/css/style.css">
	<link rel="stylesheet" href="/assets/css/print.css" media="print">

	<meta name="description" content="A tool for outlining novels.">

	<link rel="icon" href="/favicon.svg" type="image/svg+xml">

	<meta name="theme-color" content="#ffffff">

	<script type="module">
		document.documentElement.classList.remove('no-js');
	</script>

	<script type="module" src="/assets/js/skoveler-min.js"></script>

</head>
<body>
<div id="main">
	<div id="head">
		<?php
		if ( $user->get_role() == "guest" ) {
			?>
			<p>Welcome, guest!</p>
			<a href="/login">login | create account</a>
			<?php
		} else {
			$uname = $user->get_username();
			?>
			<p>Welcome, <a href="/user/<?php echo $uname; ?>">
				<?php echo $uname; ?>
			</a>
			<div>
				<form action="/logout" method="post">
					<?php do_nonce(); ?>
					<input type="submit" value="Log Out">
				</form>
			</div>
			<?php
		}
		?>
	</div>
	<div id="content">
