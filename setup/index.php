<?php
$db_config_path = 'includes/user.php';

session_start();
require $db_config_path;
function sanitize($s) {
	global $dbhost, $dbuname, $dbupass, $dbname;
 	$db = mysqli_connect($dbhost,$dbuname,$dbupass,$dbname);
 	return htmlentities(preg_replace('/\<br(\s*)?\/?\>/i', "\n", mysqli_real_escape_string($db, $s)), ENT_QUOTES);
}
if(isset($_POST['connect_database'])) {
	$dbhost = $_POST['dbhost'];
	$dbuname = $_POST['dbuser'];
	$dbupass = $_POST['dbpass'];
	$dbname = $_POST['dbname'];
	$db = mysqli_connect($dbhost,$dbuname,$dbupass,$dbname);
	if (!mysqli_connect_errno()) {
		$string = '<?php 
$dbuname = "' . $dbuname . '";
$dbupass = "' . $dbupass . '";
$dbhost = "' . $dbhost . '";
$dbname = "' . $dbname . '";
';
	    $fp = fopen($db_config_path, "w");
        fwrite($fp, $string);
        fclose($fp);
		echo 0;
	} else {
		echo mysqli_connect_error();
	}
} else if (isset($_POST['create_database_user'])) {
	$db = mysqli_connect($dbhost,$dbuname,$dbupass,$dbname);
    $sql = 'CREATE TABLE USERS (
	    PID INT NOT NULL AUTO_INCREMENT, 
	    PRIMARY KEY(PID),
	    name VARCHAR(50), 
	    pass VARCHAR(512),
	    display_name VARCHAR(128),
	    email VARCHAR(128),
	    access_level INT,
	    join_date VARCHAR(50)
    )';
	if (mysqli_query($db, $sql)) {
		echo 0;
	} else {
		echo mysql_error();
	}
} else if (isset($_POST['create_user'])) {
	$db = mysqli_connect($dbhost,$dbuname,$dbupass,$dbname);
	$uname = sanitize($_POST['username']);
	$email = sanitize($_POST['email']);
	$upass = password_hash($_POST['password'], PASSWORD_BCRYPT);
	$date = date("F j, Y");
	$sql = "INSERT INTO USERS (name, pass, display_name, email, access_level, join_date)
        VALUES ('$uname', 
        '$upass',
        '$uname',
        '$email',
        '5',
        '$date')";
	if (mysqli_query($db, $sql)) {
		echo 0;
	} else {
		echo mysql_error();
	}
} else if (isset($_POST['create_database_data'])) {
	$db = mysqli_connect($dbhost,$dbuname,$dbupass,$dbname);
	$sql = 'CREATE TABLE DATA (
        PID INT NOT NULL AUTO_INCREMENT, 
        PRIMARY KEY(PID),
        owner VARCHAR(50),
        item_name VARCHAR(100),
        item_type VARCHAR(50),
        item_size DOUBLE(30, 2),
        )';
	if (mysqli_query($db, $sql)) {
		echo 0;
	} else {
		echo mysql_error();
	}
} else {
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
		overflow-x: hidden;
	}
    :selection {
        background: #2b65ec;  
    }
	.wrapper {
		width: 400px;
		left: calc(50% - 200px);
		height: 690px;
		position: absolute;
		top: 0;bottom:0;margin: auto;
		-webkit-transition: all .3s ease-in-out;
        transition: all .3s ease;
    }
	.content {
		left: 10%;
		width: 80%;
		margin:auto;
		/*position: absolute;*/
		height: 100%;
	}
	.inputbar {
		position: relative;
		width: 100%;
		height: 60px;
		margin-bottom: 30px;
/*        background: red*/
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
		-webkit-transition: all .3s ease-in-out;
        transition: all .3s ease;
	}
	.input-underline {
		margin-top: -2px;
		position: absolute;
		height: 2px;
		width: 0;
		left: 50%;
		background: #2b65ec;
		-webkit-transition: all .3s ease-in-out;
        transition: all .3s ease;
	}
	.userinfo:focus ~ .input-underline {
		width: 100%;
		left: 0;
	}
	.userinfo:focus ~ .placeholder-userinfo,
    .userinfo[empty="false"] ~ .placeholder-userinfo {
		top: -14px;
		left: 0;
		font-size: 70%;
        color: #2b65ec;
	}
	.nosel {
		-webkit-touch-callout: none;
	    -webkit-user-select: none;
	    -khtml-user-select: none;
	    -moz-user-select: none;
	    -ms-user-select: none;
	    user-select: none;
	}
    .title {
        color: white;
        font-size: 200%;
        position: relative;
        width: 100%;
        height: 50px;
        padding: 10px 0;
        text-indent: 15px;
        margin: 0;
        font-weight: normal;
        display: none;
    }
    .btn {
        background: #2b65ec;
        padding: 12px 0;
        border: none;
        outline: 0 none;
        width: 100%;
        font-size: 104%;
        color: white;
        cursor: pointer;
        -webkit-transition: all .3s ease-in-out;
        transition: all .3s ease;
    }
    .btn:hover,
    .btn:focus {
        background: #517ee8;  
    }
    .nomargin {
        margin: 0;
    }
    a {
        text-decoration: none;
        color: #2b65ec;
        -webkit-transition: all .3s ease-in-out;
        transition: all .3s ease;
    }
    a:hover,
    a:focus {
        color: #517ee8;
    }
    .inputbar a {
        font-size: 80%;   
    }
    .inputbar a:last-of-type {
        float: right;
    }
</style>
    <title>Title - Login</title>
</head>
<body>
<h1 class="title">
    StandardLogin 4
</h1>
<section class="wrapper">
	<section class="content">
    <form id="install" name="install" action="#" method="post">
		<div class="inputbar nosel">
			<label class="userlabel">
				<input required name="username" class="userinfo" id="username" type="text">
				<span class="placeholder-userinfo nosel">Admin Username</span>
				<div class="input-underline"></div>
			</label>
		</div>
		<div class="inputbar nosel">
			<label class="userlabel">
				<input required name="password" class="userinfo" id="password" type="password">
				<span class="placeholder-userinfo nosel">Admin Password</span>
				<div class="input-underline"></div>
			</label>
		</div>
		<div class="inputbar nosel">
			<label class="userlabel">
				<input required name="email" class="userinfo" id="email" type="text">
				<span class="placeholder-userinfo nosel">Admin Email</span>
				<div class="input-underline"></div>
			</label>
		</div>
		<div class="inputbar nosel">
			<label class="userlabel">
				<input required name="dbuser" class="userinfo" id="dbuser" type="text">
				<span class="placeholder-userinfo nosel">Database Username</span>
				<div class="input-underline"></div>
			</label>
		</div>
		<div class="inputbar nosel">
			<label class="userlabel">
				<input required name="dbpass" class="userinfo" id="dbpass" type="password">
				<span class="placeholder-userinfo nosel">Database Password</span>
				<div class="input-underline"></div>
			</label>
		</div>
		<div class="inputbar nosel">
			<label class="userlabel">
				<input required name="dbname" class="userinfo" id="dbname" type="text">
				<span class="placeholder-userinfo nosel">Database Name</span>
				<div class="input-underline"></div>
			</label>
		</div>
		<div class="inputbar nosel">
			<label class="userlabel">
				<input required name="dbhost" class="userinfo" id="dbhost" type="text">
				<span class="placeholder-userinfo nosel">Database Host</span>
				<div class="input-underline"></div>
			</label>
		</div>
        <section class="inputbar nosel nomargin">
            <button class="btn btn-submit" id="button-submit">Set Up</button>
        </section>
    </form>
	</section>
</section>
	<style type="text/css">
	.result {
		position: absolute;
		width: 200px;
		height: 320px;
		left: 70%;
		opacity: 0;
		/*display: none;*/
		top:0;bottom:0;margin:auto;
		-webkit-transition: all .3s ease-in-out;
        transition: all .3s ease;
	}
	.result-active {
		opacity: 1;
		left: calc(50% + 100px);
	}
	.wrapper-active {
		left: calc(50% - 400px);
	}
	.output-step {
		padding: 7px;
		color: white;
	}
	.output-status {
		text-indent: 7px;
		color: #2b65ec;
	}
	.output-status-failed {
		color: red;
	}
	.output-status-complete {
		color: lime;
	}
	</style>
	<section class="result">
		<div class="inputbar nosel" id="1">
			<div class="output-step">Connect to SQL Server</div>
			<div class="output-status">Waiting...</div>
			<div class="output-spinner"></div>
		</div>
		<div class="inputbar nosel" id="2">
			<div class="output-step">Create Users Table</div>
			<div class="output-status">Waiting...</div>
			<div class="output-spinner"></div>
		</div>
		<div class="inputbar nosel" id="3">
			<div class="output-step">Create User #0</div>
			<div class="output-status">Waiting...</div>
			<div class="output-spinner"></div>
		</div>
		<div class="inputbar nosel" id="4">
			<div class="output-step">Create Data Table</div>
			<div class="output-status">Waiting...</div>
			<div class="output-spinner"></div>
		</div>
	</section>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        var user = $('#username').val();
        $('#username').attr('empty', (user != '') ? 'false' : 'true');
        ((user == '') ? $('#username') : $('#userpass')).focus();
    });
    $('input.userinfo').change(function() {
        $(this).attr('empty', ($(this).val() != '') ? 'false' : 'true');
    });
    var done = [false, false, false, false];
    $('#install').submit(function(e) {
    	e.preventDefault()
    	install();
    })
    function install() {
    	openStat();
    	$.post('index.php',
		{
			connect_database: '',
			dbuser: $('#dbuser').val(),
			dbpass: $('#dbpass').val(),
			dbname: $('#dbname').val(),
			dbhost: $('#dbhost').val()
		},
		function(errorcode) {
			console.log(errorcode);
			if (errorcode == 0 || done[0]) {
				done[0] = true;
				success(1);
				$.post('index.php',
				{
					create_database_user: ''
				},
				function(errorcode) {
					if (errorcode == 0 || done[1]) {
						done[1] = true;
						success(2)
						$.post('index.php',
						{
							create_user: '',
							username: $('#username').val(),
							password: $('#password').val(),
							email: $('#email').val()
						},
						function(errorcode) {
							if (errorcode == 0 || done[2]) {
								done[2] = true;
								success(3);
								$.post('index.php',
								{
									create_database_data: ''
								},
								function(errorcode) {
									if (errorcode == 0 || done[3]) {
										done[3] = true;
										success(4);
										//closeStat();
										finish();
									} else {
										error(4, errorcode);
									}
								});
							} else {
								error(3, errorcode);
							}
						});
					} else {
						error(2, errorcode);
					}
				});
			} else {
				error(1, errorcode);
			}
		});
    }
    function openStat() {
    	$('.wrapper').addClass('wrapper-active');
    	$('.result').addClass('result-active');
    }
    function closeStat() {
    	$('.wrapper').removeClass('wrapper-active');
    	$('.result').removeClass('result-active');
    }
	function error(e, message) {
		$('.result #'+e+' .output-status').html(message).addClass('output-status-failed');
	}
    function success(step) {
    	$('.result #'+step+' .output-status').html("Done").addClass('output-status-complete');
    }
    function finish() {
    	$('#button-submit').html("Done!").attr('onclick', 'window.location = "../index.php"');
    }
    </script>
</body>
</html>
<?php 
	}
?>