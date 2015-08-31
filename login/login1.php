<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Title</title>
    <style type="text/css">
    html, body {
		height: 100%;
		width: 100%;
		margin: 0;
		padding: 0;
		font-family: sans-serif;
		background: #628fce;
	}
    #wrapper {
        width: 300px;
        /*height: 250px;*/
        height: auto;
        position: absolute;
        top: 20%;
        left: 0;right: 0;margin: auto;
        font-family: 'quicksandlight', sans-serif;
        padding: 30px;
        border: 1px solid #2b65ec;
        border-radius: 10px;
    }
    .loginpage-title {
    	font-size: 300%;
        margin: 0;
        margin-bottom: 10px;
        color: white;
        text-align: center;
    }
    .login-content-title,
    .login-content,
    .btn-submit {
        width: 100%;
        margin-top: 3px;
        color: white;
        -webkit-transition: all .2s ease-in-out;
          transition: all .2s ease-in-out;
    }
    .login-content {
        background: transparent;
        border: 1px solid transparent;
        border-bottom: 1px solid rgba(255,255,255,.1);
        padding: 4px 0;
        text-indent: 5px;
    }
    .btn-submit {
        background: #2b65ec;
        padding: 10px 5px;
        margin-top: 10px;
        border: 1px solid transparent;
    }
    .btn-submit:hover {
        background: #517ee8;
        cursor: pointer;
    }
    input:active,
    input:focus,
    button:active,
    button:focus {
    outline: 0 none;
    	background: transparent !important;
	}
	.link {
		-webkit-transition: all .2s ease-in-out;
          transition: all .2s ease-in-out;
	}
	.sulink {
		margin-top: 10px;
		font-size: 70%;
        color: #2b65ec;
	}
	.sulinksub {
		font-size: 70%;
	}
	.login-nouser {
		/*display: none;*/
	}
	.login-user-show {
		display: none;
	}
	.login-user img {
		margin: 20px calc(100% - 200px);
		margin-bottom: 5px;
		width: 100px;
		border-radius: 50px;
		/*border: 1px solid;*/
	}
	.login-user .login-user-message {
		width: 100%;
		text-align: center;
	}
	a {
		color: #2b65ec;
	}
    a:hover {
        color: #517ee8;
    }
	input:focus {
		border-bottom: 1px solid #2b65ec;
	}
    </style>

    <script type="text/javascript" src="js/jquery.min.js"></script>
  </head>
<body>

	<div class="alertbox"></div>

	<div class="orangeborder" id="wrapper">
	
		<p class="loginpage-title">Title</p>
		<p class="login-nouser">
			<label class="login-content-title" for="uname"><i class="fa fa-user"></i> Username</label>
			<input class="login-content obf" name="unamesub" type="text" id="uname" value="" placeholder="" required onBlur="check_availability()" />
		</p>
		<div class="login-user login-user-show">
			<img class="orangeborder" src="http://placehold.it/100x100" />
			<input class="login-content obf" name="unamesub" type="hidden" id="uname2" value="" />
			<div class="login-user-message">USERNAME</div>
		</div>
		<p>				
			<label class="login-content-title" for="upass"><i class="fa fa-unlock-alt"></i> Password</label>
			<input class="login-content obf" name="upasssub" type="password" id="upass" placeholder="" required >
		</p>

		<button type="submit" name="login" class="btn btn-submit" onclick="check_validity()"><b>Login</b></button>
		<div class="link sulink">Need an account? <a href="register">Sign Up!</a></div>
		<div class="link sulinksub login-user-show">Not you? <a href="#" onclick="removeUser()">Change User</a></div>

	</div>

	<script type="text/javascript">
	var uexists = false;
	var using_cookie = false;
	function check_availability() {  

        var username = $('#uname').val();

        if(username.length > 0) {
  
	        $.post("uauth.php", { 
	        	check_username: 'yes',
	        	username: username
	        	},  
	            function(result) {  
	                if (result == 0) {  
	                    //$('#uname').css('border-bottom','#99c68e solid 1px'); //light green
				        setCookie("username", username, 28);
	                    uexists = true;
	                } else {  
	                    //$('#uname').css('border-bottom','#e77471 solid 1px'); //light red
	                    uexists = false;
	                }  
	        });  
	    }
	}
	function check_validity() {
		var username = $('#uname').val(),
			password = $('#upass').val();
			if (using_cookie) {
				username = $('#uname2').val();
				uexists = true;
			}
		if (username.length < 1 || password.length < 1) {
			d.warning("Please fill in both fields.");
		} else {
			if (uexists) {
				d.info("Checking validity...");
				$.post("uauth.php", {
					login: 'yes',
					username: username,
					password: password
				},
				function (result) {
					if (result == 'valid') {
						$('#uname').css('border-bottom','#99c68e solid 1px');
						$('#upass').css('border-bottom','#99c68e solid 1px');
						//d.info("Valid!");
						d.success("Logging in...");
						setTimeout(function() {
							document.location = '<?php if(isset($_GET["target"])) {echo $_GET["target"];} else {echo "browse";}?>';
						}, 1000);
					} else {
						$('#pass').css('border-bottom','#e77471 solid 1px')
						console.info(result);
						d.error(result);
					}
				});
			} else {
				d.error("Username not found.");
			}
		}
	}
	if ($('.footer').height() > 0) {
		$(".alertbox").css("bottom", 60);
	} else {
		$(".alertbox").css("bottom", 20);
	}
	$('#uname').focus();
	$(document).keydown(function(e) {
		if (e.keyCode == 13) { //enter
            check_availability()
			$('.btn-submit').click();
		}
	});

	function getCookie(c_name) {
	    var c_value = document.cookie;
	    var c_start = c_value.indexOf(" " + c_name + "=");
	    if (c_start == -1) {
	        c_start = c_value.indexOf(c_name + "=");
	    }
	    if (c_start == -1) {
	        c_value = null;
	    } else {
	        c_start = c_value.indexOf("=", c_start) + 1;
	        var c_end = c_value.indexOf(";", c_start);
	        if (c_end == -1) {
	            c_end = c_value.length;
	        }
	        c_value = unescape(c_value.substring(c_start, c_end));
	    }
	    return c_value;
	}
	function setCookie(c_name, value, exdays) {
	    var exdate = new Date();
	    exdate.setDate(exdate.getDate() + exdays);
	    var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
	    document.cookie = c_name + "=" + c_value;
	}
	function removeUser() {
		setCookie('username', '', 28);
		location.reload();
	}
	$(document).ready(function() {
		var u = getCookie("username");
	    if (u != null && u != "") {
	        using_cookie = true;
	        $('#uname2').val(u);
	        $.post('dbquery.php', {
				fullNameFromUser: u
			}, function(result) {
				if (result != 1) {
					$('.login-user-message').text(result);
				} else {
					$('.login-user-message').text(u);
				}
			});
	        $.post('dbquery.php', {
				get_user_photo: u
			}, function(result) {
				if (result != 1) {
					$('.login-user-show img').attr('src', result);
				} else {
					d.error("Failed to retrieve photo for " + username);
				}
			});
	        $('.login-user-show').css("display", 'block');
	        $('.login-nouser').css("display", 'none');
	        $('#upass').focus();
	    }
	});
</script>

  	<script type="text/javascript" src="js/showlog.js"></script>
    <script type="text/javascript" src="js/foxfile.js"></script>

</body>
</html>
