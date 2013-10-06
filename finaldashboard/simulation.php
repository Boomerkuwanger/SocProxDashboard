<?php
	$request = "simulation";
	include "templates/head.php"; 
	echo '<script type="text/javascript" src="./assets/js/jquery.min.js"></script>';
						?>
						
<body>
	<?php include "templates/navbar.php"; 
		  require_once '../REST/testcontroller.php'; ?>
	
	<div id="content" class="container">
		<div class="row">
			<button id="restart" type="button" class="btn btn-primary" data-loading-text="Loading...">Restart</button>	
		</div>
		<?php 
			echo "
				<table class='listings'>
				 ";
			$uUsers = json_decode(file_get_contents("http://cjcornell.com/bluegame/REST/users"), true);
			$users = $uUsers['body'];

			
			if(isset($_GET["mac"])):
				$sListed = $_GET["mac"];
				$aUsers = explode(" ", $sListed);
				$mMac0 = $aUsers[0];
				$mMac1 = $aUsers[1];

				if(isset($_GET["cid"])):
					if(isset($_GET["update1"]) && isset($_GET["update2"])):
						
						$sUpdate1 = $_GET["update1"];
						$sInstanceID1 = explode(" ", $sUpdate1);
						$sUpdate2 = $_GET["update2"];
						$sInstanceID2 = explode(" ", $sUpdate2);
						if(strcmp($sInstanceID1[0], "fail") && strcmp($sInstanceID1[0], "success"))
						{
							TestController::updateChallenge($mMac0, $sInstanceID1[1], $sInstanceID1[0]);
							TestController::updateChallenge($mMac1, $sInstanceID2[1], $sInstanceID2[0]);
							echo "
								<thread><tr><th scope='col'>Active Challenge</th><th scope='col'>User's Mac</th><th scope='col'>Success or Fail</th></tr></thread>
								<tbody>
								<tr>
								<td>$sInstanceID1[1]</td><td>$mMac0</td>
								<td><input class='selected' type='radio' name='update1' value='success+$sInstanceID1[1]'>Success</input></br>
								<input class='selected' type='radio' name='update1' value='fail+$sInstanceID1[1]'>Fail</input>
								</td>
								<tr>
								<td><button id='updateChallenge' type='button' class='btn btn-primary' disabled='disabled' data-loading-text='Loading...'>Submit</button></td>
								<td>$mMac1</td>
								<td><input class='selected' type='radio' name='update2' value='success+$sInstanceID1[1]'>Success</input></br>
								<input class='selected' type='radio' name='update2' value='fail+$sInstanceID1[1]'>Fail</input>
								</td>
								</tr>
								</tbody>
								</table>
								";
						} else {
							TestController::updateChallenge($mMac0, $sInstanceID1[1], $sInstanceID1[0]);
							TestController::updateChallenge($mMac1, $sInstanceID2[1], $sInstanceID2[0]);
							echo "<h1 align='center'>Successful Simulation!</h1>";
						};

					else:
					$oInstance = TestController::simChallenge($mMac0, $mMac1, $_GET["cid"]);
					$instance = explode("/", $oInstance);
					
					$uReturned = json_decode(file_get_contents("http://cjcornell.com/bluegame/REST/getChallengeInstance/".$mMac0."/".$instance[0]),true);
					
					echo "
						<thread><tr><th scope='col'>Pending Challenge</th><th scope='col'>User Names</th><th scope='col'>Accept or Deny</th></tr></thread>
						<tbody>
						<tr>
						<td>$instance[0]</td><td>$instance[1]</td>
						<td><input class='selected' type='radio' name='update1' value='accepted+$instance[0]'>Accept</input></br>
						<input class='selected' type='radio' name='update1' value='denied+$instance[0]'>Deny</input>
						</td>
						<tr><td><button id='updateChallenge' type='button' class='btn btn-primary' disabled='disabled' data-loading-text='Loading...'>Submit</button></td>
						<td>$instance[2]</td>
						<td><input class='selected' type='radio' name='update2' value='accepted+$instance[0]'>Accept</input></br>
						<input class='selected' type='radio' name='update2' value='denied+$instance[0]'>Deny</input>
						</td>
						</tr>
						</tbody>
						</table>
						";
					endif;
				else:
			echo "
				<thread><tr><th scope='col'>Challenge</th><th scope='col'>ID</th><th scope='col'>Choice</th></tr></thread>
				<tbody>
				";

			$sListed = $mMac0.'/'.$mMac1;
			$uReturned = json_decode(file_get_contents("http://cjcornell.com/bluegame/REST/listChallenges/".$sListed), true);
			//echo "<h1>http://cjcornell.com/bluegame/REST/listChallenges/$sListed</h1>";
			$uList = $uReturned["body"];
			foreach($uList as $u)
			{
				$cName = $u["m_strName"];
				$cID = $u["m_iID"];
				echo "
				<tr>
				<td>$cName</td>
				<td>$cID</td>
				<td><input class='selected' type='radio' name='chalChoice' value='$cID'></td>
				</tr>
				";
			}
				echo"
					<tr><td></td><td></td>
					<td><button id='selChallenges' type='button' class='btn btn-primary' disabled='disabled' data-loading-text='Loading...'>Submit</button></td></tr>
					</tbody></table>
					";
				endif;
		else: 
			echo "
				<thread><tr><th scope='col'>User</th><th scope='col'>MAC Address</th><th scope='col'>Include</th></tr></thread>
				<tbody>
				";
			$uUsers = json_decode(file_get_contents("http://cjcornell.com/bluegame/REST/users"), true);
			$users = $uUsers['body'];
			$total = 0;
		
			foreach($users as $u)
			{
				$total++;
				$mac = $u["m_strMac"];
				$name = $u["m_strUsername"];
				echo "
				<tr>
				<td>$name</td>
				<td>$mac</td>
				<td><input class='selected' type='checkbox' name='inclusion' value='$mac'></td>
				</tr>
				";
			}
			echo "<tr><td></td><td></td>
				<td><button id='getChallenges' type='button' class='btn btn-primary' disabled='disabled' data-loading-text='Loading...'>Get Challenges</button></td></tr>
				</tbody>
				</table>
				";
		endif;
		
		
						?>
	</div>

	<?php  include "templates/foot.php";	
        echo "
        	 <script type=\"text/javascript\">
        	 $(document).ready(function(){
        	 	var usrNum = 0;
        	 	var u1 = 0, u2 = 0;
        	 	var mac = new Array();
        	 	mac[0] = -1;
        	 	mac[1] = -1;
    	 		$('input.selected').change(function(){
    	 			if ($(this).is(':radio[name=chalChoice]'))
    				{
				        $('#selChallenges').removeAttr('disabled');
				        return;
				    }
				    
				    if ($(this).is(':radio[name=update1]'))
    				{
    					u1 = 1;
    					if(u2){
    						$('#finalizeChallenge').removeAttr('disabled');
    						$('#updateChallenge').removeAttr('disabled');
    					}	
				        return;
				    }
					if ($(this).is(':radio[name=update2]'))
    				{
    					u2 = 1;
    					if(u1){
    						$('#finalizeChallenge').removeAttr('disabled');
    						$('#updateChallenge').removeAttr('disabled');
    					}					
				        return;
				    }
				    
    				if(this.checked)
    				{
    					usrNum++;
    					if(usrNum > 2)
    					{
    						this.checked = false;
							usrNum--;
						} else {
							$('#getChallenges').removeAttr('disabled');
						}
    				} else {
    					usrNum--;
    					if(!usrNum)
    						$('#getChallenges').attr('disabled', 'disabled');
    				}
				});
				
				$('#getChallenges').click(function(){
					var mac = new Array();
					var i = 0;
					$('input.selected:checkbox[name=inclusion]:checked').each(function(){
						mac[i] = \$(this).val();
						//alert(mac[i] + \"   \" + i);
						i++;
					});
					window.location.href = './simulation.php?mac=' + mac[0] + '+' + mac[1];
				});
				
				$('#selChallenges').click(function(){
					var challengeID = $('input:radio[name=chalChoice]:checked').val();
					window.location.href = window.location.href + '&cid=' + challengeID;
					//alert(window.location.href + '&cid=' + challengeID);
				});
				
				$('#updateChallenge').click(function(){
					var updater1 = $('input:radio[name=update1]:checked').val();
					var updater2 = $('input:radio[name=update2]:checked').val();
					window.location.href = window.location.href + '&update1=' + updater1 + '&update2=' + updater2;
				});
				$('#restart').click(function(){
					window.location.href = './simulation.php';
				});
        	 });
          </script>";
						?>

</body>
</html>