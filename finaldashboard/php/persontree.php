<?php
	$userReturn = json_decode(file_get_contents("http://cjcornell.com/bluegame/REST/users"), true);
	$nodes = array(); // Array of nodes
	$edges = array(); // Array of edges
	$users = $userReturn['body']; 
	foreach($users as $u){
		// id = UserID
		$id = "user".$u["m_iID"];
		// node elements are arrays of [userid, username]
		$nodes[$id] = array("id"=>$id, "name" => $u["m_strUsername"]);
		try{
		$res = @file_get_contents("http://cjcornell.com/bluegame/REST/getChallengeInstances/".$u["m_strMac"]);
		if($res === FALSE){
			;
		}else{
			$challenges = json_decode($res, true);
			if($challenges['success']){
				// Draw a user only if they have challenges associated with them.
				echo "g.addNode('".$id."', { label : '".$u["m_strUsername"]."'});\n";	
				$games = $challenges['body']["Games"][0]["challenges"];
				foreach($games as $g){
					$gid = "game".$g["m_iID"];
					$nodes[$gid] = array("id"=>$gid, "name" => $g["m_oChallenge"]["m_strName"]);
					echo "g.addNode('".$gid."', { label : '".$g["m_oChallenge"]["m_strName"]."'});\n";
					//array_push($edges, array("from"=>$id, "to"=>$gid));
					echo "g.addEdge('".$id."','".$gid."');\n";
				}
			}
		}
		}catch(exception $e){
			
		}
	}
	
	/*foreach($nodes as $n){
		echo "g.addNode('".$n["id"]."', { stroke : '#bfa', fill : '#56f', label : '".$n["name"]."'});\n";
	}*/
	/*foreach($edges as $e){
		echo "g.addEdge('".$e["from"]."','".$e["to"]."');\n";
	}*/
	
?>