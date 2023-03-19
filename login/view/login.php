<?php session_start();
?>
<!doctype html>
<html lang="fr">

<head>
	<style>
		body {
			margin: 0;
			color: #000000;
			background: #ffffff;
			font: 600 16px/18px 'Open Sans', sans-serif;
		}

		*,
		:after,
		:before {
			box-sizing: border-box
		}

		.clearfix:after,
		.clearfix:before {
			content: '';
			display: table
		}

		.clearfix:after {
			clear: both;
			display: block
		}

		a {
			color: inherit;
			text-decoration: none
		}

		.login-wrap {
			width: 100%;
			margin: auto;
			max-width: 525px;
			min-height: 670px;
			position: relative;
			background: url(/logobloc.png) no-repeat center;
			box-shadow: 0 12px 15px 0 rgba(0, 0, 0, .24), 0 17px 50px 0 rgba(0, 0, 0, .19);
		}

		.login-html {
			width: 100%;
			height: 100%;
			position: absolute;
			padding: 90px 70px 50px 70px;
			background: rgba(65, 44, 44, 0.9);
		}

		.login-html .sign-in-htm,
		.login-html .sign-up-htm {
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			position: absolute;
			transform: rotateY(180deg);
			backface-visibility: hidden;
			transition: all .4s linear;
		}

		.login-html .sign-in,
		.login-html .sign-up,
		.login-form .group .check {
			display: none;
		}

		.login-html .tab,
		.login-form .group .label,
		.login-form .group .button {
			text-transform: uppercase;
		}

		.login-html .tab {
			font-size: 22px;
			margin-right: 15px;
			padding-bottom: 5px;
			margin: 0 15px 10px 0;
			display: inline-block;
			border-bottom: 2px solid transparent;
		}

		.login-html .sign-in:checked+.tab,
		.login-html .sign-up:checked+.tab {
			color: rgb(255, 255, 255);
			border-color: #a2af2a;
		}

		.login-form {
			min-height: 345px;
			position: relative;
			perspective: 1000px;
			transform-style: preserve-3d;
		}

		.login-form .group {
			margin-bottom: 15px;
		}

		.login-form .group .label,
		.login-form .group .input,
		.login-form .group .button {
			width: 100%;
			color: #fff;
			display: block;
		}

		.login-form .group .input,
		.login-form .group .button {
			border: none;
			padding: 15px 20px;
			border-radius: 25px;
			background: rgba(255, 255, 255, 0.1);
		}

		.login-form .group input[data-type="password"] {
			-webkit-text-security: circle;
		}

		.login-form .group .label {
			color: rgb(255, 255, 255);
			font-size: 12px;
		}

		.login-form .group .button {
			background: #d1c131;
		}

		.login-form .group label .icon {
			width: 15px;
			height: 15px;
			border-radius: 2px;
			position: relative;
			display: inline-block;
			background: rgba(253, 253, 253, 0.1);
		}

		.login-form .group label .icon:before,
		.login-form .group label .icon:after {
			content: '';
			width: 10px;
			height: 2px;
			background: #fff;
			position: absolute;
			transition: all .2s ease-in-out 0s;
		}

		.login-form .group label .icon:before {
			left: 3px;
			width: 5px;
			bottom: 6px;
			transform: scale(0) rotate(0);
		}

		.login-form .group label .icon:after {
			top: 6px;
			right: 0;
			transform: scale(0) rotate(0);
		}

		.login-form .group .check:checked+label {
			color: #fff;
		}

		.login-form .group .check:checked+label .icon {
			background: #cac700;
		}

		.login-form .group .check:checked+label .icon:before {
			transform: scale(1) rotate(45deg);
		}

		.login-form .group .check:checked+label .icon:after {
			transform: scale(1) rotate(-45deg);
		}

		.login-html .sign-in:checked+.tab+.sign-up+.tab+.login-form .sign-in-htm {
			transform: rotate(0);
		}

		.login-html .sign-up:checked+.tab+.login-form .sign-up-htm {
			transform: rotate(0);
		}

		.hr {
			height: 2px;
			margin: 60px 0 50px 0;
			background: rgba(255, 255, 255, .2);
		}

		.foot-lnk {
			text-align: center;
		}
	</style>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">

	<title>login-BlocBlox</title>

	<link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">
	<link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="/logobloc.png" sizes="48px,48px">
</head>

<body>

	<div class="login-wrap">
		<div class="login-html">
			<input id="tab-1" type="radio" name="tab" class="sign-in" value="yes" checked><label for="tab-1"
				class="tab">Connecte-toi</label>
			<input id="tab-2" type="radio" name="tab" class="sign-up" value="no" ><label for="tab-2"
				class="tab">Inscription</label>
			<div class="login-form">
				<div class="sign-in-htm">
					<form action="/login/controllers/loginfonc.php" method="POST">
						<div class="group">
							<label class="label text-white"></label>
							<input name="form" type="hidden" value="connection" class="input">

							<label class="label text-white">Nom d'utilisateur</label>
							<input name="name_connection" type="text" class="input" required>
						</div>
						<div class="group">
							<label class="label text-white">Mot de passe</label>
							<input name="pass_connection" type="password" class="input" data-type="password" required>
						</div>
						<div class="group">
							<input type="submit" class="button" value="Connecter">
						</div>
					</form>
				</div>
				<div class="sign-up-htm">
					<form action="/login/controllers/loginfonc.php" method="POST">
						<div class="group">
							<label class="label text-white"></label>
							<input name="form" type="hidden" value="inscription" class="input">

							<label class="label">Nom d'utilisateur</label>
							<input name="name_inscription" type="text" class="input" required>
						</div>
						<div class="group">
							<label class="label">E-mail</label>
							<input name="mail_inscription" type="email" class="input" required>
						</div>
						<div class="group">
							<label class="label">Mot de passe</label>
							<input name="pass_inscription" type="password" class="input" data-type="password" required>
						</div>
						<div class="group">
							<input type="submit" class="button" value="M'inscrire">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>













	<script src="js/bootstrap.min.js"></script>
	<script src="js/all.min.js"></script>
	<script src="js/jquery-3.6.0.min.js"></script>
	<script src="js/inscrire.js"></script>
</body>

</html>
