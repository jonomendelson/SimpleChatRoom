<html>
<title>Jonathan's Chat Room - Version 1.1</title>
<head>
<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
	<script type="text/javascript"
    src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script>
		var username;
		function focusToChatInput(){
			document.getElementById("chatInput").focus();
		}
		function loadMessages(){
			var xmlhttp;
			if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}else{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("chatDisplay").innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET","chatText.php",true);
			xmlhttp.send();
		}
		function scrollToBottom(){
			var elem = document.getElementById('chatDisplay');
			elem.scrollTop = elem.scrollHeight;
		}
		function figureOutRegisterPage(){
			<?php
				if(($_POST["usernameInput"] == "") || !(stripos($_POST["usernameInput"], "<") === false) || !(stripos($_POST["usernameInput"], ">") === false) || !(stripos($_POST["usernameInput"], "\"") === false) || (strlen($_POST["usernameInput"]) > 20)){
					echo "displayRegisterPage();";
					$_POST["chatInput"] == "";
				}else{
					if($_POST["usernameInput"] == "Admin"){
						if($_POST["passwordInput"] == "secretsign33"){
							echo "document.getElementById('usernamePasser').value = \"" . $_POST["usernameInput"] . "\";";
							echo "document.getElementById('passwordPasser').value = \"" . $_POST["passwordInput"] . "\";";
						}else{
							echo "displayRegisterPage();";
							$_POST["chatInput"] == "";
						}
					}else{
						echo "document.getElementById('usernamePasser').value = \"" . $_POST["usernameInput"] . "\";";
						echo "document.getElementById('passwordPasser').value = \"" . $_POST["passwordInput"] . "\";";
					}
				}
				
				
	 
			?>
		}
		function displayRegisterPage(){
			var height = document.body.clientHeight;
			var width = document.body.clientWidth;
			
			window.setInterval(function(){checkForPowerLogin();}, 250);
			
			document.getElementById("menu").innerHTML = "";
			
			document.getElementById("everythingExceptRegister").style.opacity = "0.25";
			document.getElementById("chatInput").readOnly = true;
			
			document.getElementById("registerPage").style.top = (height-318)/2;
			document.getElementById("registerPage").style.left = (width-350)/2;
			
			document.getElementById("registerPage").style.display = "block";
		}
		
		function checkForPowerLogin(){
			if(document.getElementById("usernameInput").value == "Admin"){
				document.getElementById("passwordBlock").style.display = "block";
				document.getElementById("placeholder").style.display = "none";
			}else{
				document.getElementById("passwordBlock").style.display = "none";
				document.getElementById("placeholder").style.display = "block";
			}
		}
	
	</script>
</head>
<body onload="figureOutRegisterPage(); scrollToBottom(); focusToChatInput(); window.setInterval(function(){loadMessages();}, 250);"style="background-color:#273839; margin-left:0px; margin-right:0px; margin-top:0px; margin-bottom:0px; font-family: 'Roboto Condensed', sans-serif;">
	<div id="everythingExceptRegister" style="">
	<div class="menu" id="menu" style="background-color:#273839; width:98%; height:5%; color:#FFFFFF; display:block; padding-left:2%; font-size:24px;"><div style="width:100%; height:18%;"></div>Public Username: <?php echo $_POST["usernameInput"]; ?></div>
	
	<div style="height:85%; width:1.5%; background-color:#273839; position:absolute;"></div>
	
	<div id="chatDisplay" style="width:95.5%; height:85%; background-color:#1d2a2b; overflow:auto; font-size:20px; color:#8bc9cf; padding-left:3%;">
			<?php
				
				if(($_POST["chatInput"] != "") && (stripos($_POST["chatInput"], "<") === false) && (stripos($_POST["chatInput"], ">") === false) && (stripos($_POST["chatInput"], "\"") === false) && (strlen($_POST["chatInput"]) < 80)){
					if(!(($_POST["usernameInput"] == "") || !(stripos($_POST["usernameInput"], "<") === false) || !(stripos($_POST["usernameInput"], ">") === false) || !(stripos($_POST["usernameInput"], "\"") === false) || (strlen($_POST["usernameInput"]) > 20))){
						$chatfile = fopen("chat.txt", "a+") or die("Unable to open file!");
						if($_POST["usernameInput"] == "Admin"){
							if($_POST["chatInput"] == "!clear"){
								fclose($chatfile);
								$chatfile = fopen("chat.txt", "w") or die("Error!");
								fwrite($chatfile, "");
								fclose($chatfile);
							}else{
								fwrite($chatfile, "<span style='font-size:40px; color:#00FF00;'><span style=''><b>".$_POST["usernameInput"]."</b>: </span>".$_POST["chatInput"]."</span><br>");
							}
							
						}else{
							fwrite($chatfile, "<span style='color:#dbf69f'><b>".$_POST["usernameInput"]."</b>: </span>".$_POST["chatInput"]."<br>");
						}
						fclose($chatfile);
					}
				}
			
				$chatfile = fopen("chat.txt", "r") or die("Unable to load chat!");
				echo fread($chatfile, filesize("chat.txt"));
				fclose($chatfile);
			?>
	
	</div>
	
	<div id="chatType" style="width:98.5%; height:10%; background-color:#273839; padding-left:1.5%;">
		<div style="width:100%; height:30%; display:block;"></div>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" style="margin-bottom:0px;">
			<input type="text" id="chatInput" name="chatInput" style="width:98.5%; height:40%; float:left; font-size:24px; padding:15px; background-color:#1d2a2a; color:#FFFFFF; border:none; outline:none; " autocomplete="off"></input>
			<input type="text" id="usernamePasser" style="display:none;" name="usernameInput" readonly></input>
			<input type="text" id="passwordPasser" style="display:none;" name="passwordInput" readonly></input>
			<input type="submit" style="display:none;"></input>
		</form>
	</div>
	</div>
	<div id="registerPage" style="width:350px; height:318px; background-color:#273839; position:fixed; left:auto; right:auto; top:30%; padding:15px; font-size:24px; color:#FFFFFF; display:none;">
		Enter a username so people know who you are!<br><br><br>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			Username:&nbsp;&nbsp;&nbsp;<input type="text" id="usernameInput" name="usernameInput" style="font-size:24px; width:230px; margin-left:auto; margin-right:auto; padding:5px;" autocomplete="off"></input>
			<div style="width:100%; height:12px; display:block;"></div>
			<div id="passwordBlock" style="display:none; height:40px; width:100%;">Password:&nbsp;&nbsp;&nbsp;<input type="password" id="passwordInput" name="passwordInput" style="font-size:24px; width:232px; margin-left:auto; margin-right:auto; padding:5px;" autocomplete="off"></input></div><br>
			<div id="placeholder" style="height:40px; width:100%; display:block;"></div>
			<div style="width:100%; height:30px; display:block;"></div>
			<input type="submit" value="Join Room" style="width:300px; margin-left:25px; margin-right:25px; font-size:36px; background-color:#1d2a2a; color:#FFFFFF; border:none;"></input>
		</form>
	</div>
	

</body>
</html>