<?php
$request = "game";
include "templates/head.php"; 
//include "../REST/testcontroller.php"; 
?>
<body>
	<?php include "templates/navbar.php"; ?>
	<?php echo '<script type="text/javascript" src="./assets/js/jquery.min.js"></script>'; 
		  echo '<script type="text/javascript" src="./assets/js/game.js"></script>' ?>
	<div id="content" class="container">
	<div class="row">
		<button id="newGame" type="button" class="btn btn-primary" data-loading-text="Loading...">New Game</button>
		<button id="allgames" type="button" class="btn btn-primary" data-loading-text="Loading...">All Games</button>
		<p id='numGames' hidden='true'>0</p>
	</div>
			
	<?php
		$uGames = json_decode(file_get_contents("http://cjcornell.com/bluegame/REST/getAllGames"), true); 
		$games = $uGames['body'];	
		echo "<table class='toptable'>";
		$gameid = 0;
		foreach($games as $game)
		{
			$gameid += 1;
			$name = $game["m_strName"];
			$desc = $game["m_strDesc"];
			$points = $game["m_iWinningPoints"];
			$desc = $game["m_strDesc"];
			//request the standings for 'this' game	
			$fixedName = str_replace(" ", "%20", $name);
			$uStandings = @file_get_contents("http://cjcornell.com/bluegame/REST/getStandings/gamename/".$fixedName);
			if($uStandings === FALSE){
				;
			}else{
				$standings = json_decode($uStandings, true);
				if($standings['success']){
					$standing = $standings['body'][0]["m_aStandings"];
					$ranking = 1;
				}
			}
			echo"<tr><td>
				<table class='listings'>
				<tbody>
				<tr><td>Game Name</td><td>$name</td></tr>
				<tr><td>Description</td><td>$desc</td></tr>
				<tr><td>Points</td><td>$points</td></tr>
				<tr><td><button id='editGame' type='button' class='btn btn-primary' data-loading-text='Loading...'>Edit</button></td>
				<td><button id='newChallenge$gameid' type='button' class='btn btn-primary' data-loading-text='Loading...'>Add Challenge</button></td>
				<td><button id='removeGame' type='button' class='btn btn-primary' data-loading-text='Loading...'>Remove</button></td></tr>
				</tbody></table>
			 	</td><td>
				<table class='listings'>
				<thread><tr><th scope='col'>Ranking</th><th scope='col'>Username</th><th scope='col'>Points</th></tr></thread>
				<tbody>";
			
			if($standing){
				foreach($standing as $s)
				{
					$user = $s['username'];
					$points = $s['points'];
					echo "<tr><td>$ranking</td><td>$user</td><td>$points</td></tr>";
					$ranking += 1;
				}
			}
			echo "</tbody></table>
				 </td></tr>";
		}
		echo "</table>";

	echo "</div>
		  <form id='newgame'>
	      <div class='submission'>
	      	<h1>Create Game :</h1>
	        <label>
	           <span>Game Name</span>
	           <input type='text' class='input_text' name='name' id='name'/>
	        </label>
	         <label>
	           <span>Description</span>
	           <textarea class='message' name='description' id='description'></textarea>
	        </label> 
	        <label>
	            <span>Reward</span>
	            <input type='text' class='input_text' name='points' id='point'/>
	        </label>
	        <label>
	            <span>Criteria</span>
	            <textarea class='message' name='criteria' id='criteria'></textarea>
	            <input type='submit' class='button' value='Submit Form' />
	        </label>
	     </div>
	</form>
	";
	
	for($i = 1; $i <= $gameid; $i++)
	{
		echo "<form class='subForms' id='newchallenge$i'>
				<div class='submission'>
					<h1>Create Challenge :</h1>
			        <label>
			           <span>Challenge Name</span>
			           <input type='text' class='input_text' name='name' id='cName$i' />
			        </label>
			        <label>
			           <span>Instructions</span>
			           <textarea class='message' name='instructions' id='cInstructions$i'></textarea>
			        </label>
			        <label>
			            <span>Game Number</span>
			            <input type='text' class='input_text' name='gameid' id='gameid$i' value='$i'>
			        </label>
			        <label>
			            <span>Minimum Players</span>
			            <input type='text' class='input_text' name='minplayers' id='min$i'>
			        </label>
			        <label>
			            <span>Maximum Players</span>
			            <input type='text' class='input_text' name='maxplayers' id='max$i'/>
			        </label>
			        <label>
			            <span>Verification Type</span>
			            <input type='text' class='input_text' name='verificationid' id='verify$i'/>
			            <br/>
			            <input type='submit' class='button' value='Submit Form' />
			        </label>
			     </div>
			</form>
			";
	}
	 echo "
            <script type=\"text/javascript\">
            $(document).ready(function(){
          ";
	for($i = 1; $i <= $gameid; $i++)
	{
			
			echo "
				 $(\"form#newchallenge$i\").submit(function(){
					";
					echo "
					var sql = 'http://cjcornell.com/bluegame/REST/addChallenge/' + $(\"#cName$i\").val() + '/' + $(\"#cInstructions$i\").val() + '/' + $(\"#gameid$i\").val() + '/' + $(\"#min$i\").val() + '/' + $(\"#max$i\").val() + '/' + $(\"#verify$i\").val();
					$.get(sql, function(data){
						alert('Data Loaded: ' + data);
					});
					alert('Challenge Created!');
					return reloadpage();
				 });
				 ";
				 
			echo "
				 $('#newChallenge$i').click(function(){
					$('.toptable').hide();
					$('.subForms').hide();
					$('form#newchallenge$i').show();
				});
				";
	}
	echo "
		 });
		 function reloadpage(){
				window.location.replace(\"cjcornell.com/bluegame/finaldashboard/game.php\");
		 };
		 </script>
		 ";
	?>
	
	
<?php include "templates/foot.php"; ?>
</body>
</html>