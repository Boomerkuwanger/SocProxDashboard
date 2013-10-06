$(document).ready(function(){
	$('.subForms').hide();
	$("#newgame").hide();
	
	$("#newGame").click(function(){
		$(".toptable").hide();
		$('.subForms').hide();
		$("#newgame").show();
	});
	
	$("#allgames").click(function(){
		$(".toptable").show();
		$('.subForms').hide();
		$("#newgame").hide();
	});
	
	$("form#newgame").submit(function(){
		var sql = 'http://cjcornell.com/bluegame/REST/addGame/' + $("#name").val() + '/' + $("#description").val() + '/' + $("#point").val() + '/' + $("#criteria").val();
		$.get(sql, function(data){
			alert("Data Loaded: " + data);
		});
		alert("Game Added!");
		return init();
	});
	function init(){
		window.location.replace("cjcornell.com/bluegame/finaldashboard/game.php");
	};
	/*
	 echo"<script>
				$('#newChallenge$gameid').click(function(){
					$('.toptable').hide();
					$('.subForms').hide();
					$('#newchallenge$gameid').show();
				});
				</script>";
				
	$('form#newchallenge1').submit(function(){
		//alert('http://cjcornell.com/bluegame/REST/addChallenge/' + $('#cName1').val() + '/' + $('#cInstructions1').val() + '/' + 1 + '/' + $('#min1').val() + '/' + $('#max1').val() + '/' + $('#verify1').val());
		var sql = 'http://cjcornell.com/bluegame/REST/addChallenge/' + $("#cName1").val() + '/' + $("#cInstructions1").val() + '/' + $("#gameid1").val() + '/' + $("#min1").val() + '/' + $("#max1").val() + '/' + $("#verify1").val();
		alert(sql);
		$.get(sql, function(data){
			alert('Data Loaded: ' + data);
		});
		alert("Challenge Added!");
		return init();
	});

	echo "<script>
		$('form#newchallenge$i').submit(function(){
					var sql = 'cjcornell.com/bluegame/REST/addChallenge/' + $('#cName$i').val() + '/' + $('#cInstructions$i').val() + '/' + $('#gameid$i').val() + '/' + $('#min$i').val() + '/' + $('#max$i').val() + '/' + $('#verify$i').val();
					alert(sql);
					$.get(sql, function(data){
						alert('Data Loaded: ' + data);
					});
				});
		</script>";
	*/
});
