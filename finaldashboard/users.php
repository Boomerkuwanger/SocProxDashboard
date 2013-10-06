<?php
$request = "users";
include "templates/head.php"; ?>
<body>
<?php include "templates/navbar.php"; ?>
<div id="content" class="container">
	<div class="row">
		<ul id="org" style="display:none;">
			<li>
				<?php if(isset($_GET["mac"])):
					$uReturn = json_decode(file_get_contents("http://cjcornell.com/bluegame/REST/userStats/".$_GET["mac"]), true);
                    $u = $uReturn['body'];
					echo $u["m_oUserID"]["m_strUsername"];
					echo "<ul>";
						echo "<li class='collapsed'>";
							echo "Games";
							echo "<ul>";
							foreach($u["m_aUserGameStats"] as $game){
								echo "<li>";
								echo $game["m_strGameName"]."<br />";
								echo "Points: ".$game["m_iTotalPoints"];
								echo "</li>";
							}
							echo "</ul>";
						echo "</li>";
					echo "</ul>";
				else: ?>
				Users
				<?php 
					$usersReturn = json_decode(file_get_contents("http://cjcornell.com/bluegame/REST/users"), true);
                    $users = $usersReturn['body'];
					
					echo "<ul>";
					foreach($users as $u){
						echo "<li class='collapsed'>";
						echo "<a href='./users.php?mac=".$u["m_strMac"]."'>".$u["m_strUsername"]."</a>";
						/*echo "<ul>";
						foreach($u as $key => $value){
							echo "<li class='collapsed'>";
								echo $key;
								echo "<ul>";
									echo "<li>";
									echo $value;
									echo "</li>";
								echo "</ul>";
							echo "</li>";
						}
						echo "</ul>";*/
						echo "</li>";
					}
					echo "</ul>";
				endif;
				?>
			</li>
		</ul>
		<div class="container" id="chartdiv">
			
		</div>
	</div>
<?php include "templates/foot.php"; ?>
<script type="text/javascript" src="./assets/js/jquery.jOrgChart.js"></script>
<script>
	$(function(){
		$("#org").jOrgChart({chartElement : "#chartdiv"});
	});
</script>
</div>
</body>
</html>