<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<style type="text/css">
	html, body {
		height: 100%;
		width: 100%;
		margin: 0;
		padding: 0;
		font-family: sans-serif;
		background: #628fce;
	}
	.wrapper {
		height: 400px;
		width: 400px;
		position: absolute;
		top:0;bottom:0;right:0;left:0;margin:auto;
		/*background: red;*/
	}
	.content {
		left: 10%;
		width: 80%;
		height: 120px;
		top:0;bottom:0;margin:auto;
		position: absolute;
	}
	.inputbar {
		position: relative;
		width: 100%;
		height: 60px;
		/*background: blue;*/
		margin-bottom: 30px;
	}
	.userlabel {
		color: white;
	}
	.userinfo {
		color: white;
		font-size: 110%;
		width: 100%;
		background: transparent;
		border: none;
		border-bottom: 2px solid rgba(255,255,255,.1);
		padding: 7px 0;
		text-indent: 10px;
	}
	input:active,
	input:focus {
		outline: 0 none;
	}
	.placeholder-userinfo {
		color: white;
		position: absolute;
		top: 11px;
		left: 10px;
		cursor: text;
		user-select: none;
		-webkit-transition: all .2s ease;
        transition: all .2s ease;
	}
	.input-underline {
		margin-top: -2px;
		position: absolute;
		height: 2px;
		width: 0;
		left: 50%;
		background: #2b65ec;
		-webkit-transition: all .2s ease;
        transition: all .2s ease;
	}
	.userinfo:focus ~ .input-underline {
		width: 100%;
		left: 0;
	}
	.userinfo:focus ~ .placeholder-userinfo {
		top: -14px;
		left: 0;
		font-size: 70%;
	}
	.userinfo[empty="false"] ~ .placeholder-userinfo {
		top: -14px;
		left: 0;
		font-size: 70%;
	}
	.nosel {
		-webkit-touch-callout: none;
	    -webkit-user-select: none;
	    -khtml-user-select: none;
	    -moz-user-select: none;
	    -ms-user-select: none;
	    user-select: none;
	}
</style>
</head>
<body>

<section class="wrapper">
	<section class="content">
		<div class="inputbar nosel">
			<label class="userlabel">
				<input class="userinfo" id="username" type="text" onblur="if ($(this).val() != '') $(this).attr('empty', 'false'); else $(this).attr('empty', 'true');">
				<span class="placeholder-userinfo nosel">Username</span>
				<div class="input-underline"></div>
			</label>
		</div>
		<div class="inputbar nosel">
			<label class="userlabel">
				<input class="userinfo" id="userpass" type="password" onblur="if ($(this).val() != '') $(this).attr('empty', 'false'); else $(this).attr('empty', 'true');">
				<span class="placeholder-userinfo nosel">Password</span>
				<div class="input-underline"></div>
			</label>
		</div>
	</section>
</section>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
</body>
</html>