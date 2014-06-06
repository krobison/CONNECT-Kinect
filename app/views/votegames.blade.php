<?php  
				echo "<div>";
				echo "<table border='2'>";
				echo "<tr><th>Name</th><th>Votes</th><th>VOTE</th></tr>";
				//Display the games and vote buttons
				$i=0;
				foreach ($kinectGames as $games) {
					echo "<tr>";
					echo "<td >" . $games->name . "</td><td>"  .  $games->upVotes."</td><td><div id=vote_".$i."> <button type=button class=btn btn-default> Vote</button><div></td>";
					echo "</tr>";
					$i++;
				}
				echo "</table>";
				echo "</div>";
				
				//Function for checking whether or not the player has voted for a particular game
				function checkVote($newVote, $allVote) {
					$hasVoted = "false";
					foreach ($allVote as $vote) {
						if ($newVote == $vote->idGame) {
							$hasVoted = "true";
							break;
						}
					}
					echo $hasVoted;
				}
			?>
<script>
		//Functions for vote button clicks that increments the databases votes if user hasn't voted
		$('#vote_0').click(function() {//Brick_Breaker
			var name = "<?php echo $kinectGames[0]->name; ?>";
			var votes = parseInt("<?php echo $kinectGames[0]->upVotes; ?>");
			var id = "<?php echo $user->id ?>";
			var hasVoted = "<?php checkVote($user->id.$kinectGames[0]->name, $votes); ?>";
			if (hasVoted == "false") {
				votes++;
				vote(name,votes, id);
				location.reload();
			} else {
				alert("You have already voted for "+name+"!");
			}
		});
		$('#vote_1').click(function() {//Bug_Squash
			var name = "<?php echo $kinectGames[1]->name; ?>";
			var votes = parseInt("<?php echo $kinectGames[1]->upVotes; ?>");
			var id = "<?php echo $user->id ?>";
			var hasVoted = "<?php checkVote($user->id.$kinectGames[1]->name, $votes); ?>";
			if (hasVoted == "false") {
				votes++;
				vote(name,votes, id);
				location.reload();
			} else {
				alert("You have already voted for "+name+"!");
			}
		});
		$('#vote_2').click(function() {//Pong
			var name = "<?php echo $kinectGames[2]->name; ?>";
			var votes = parseInt("<?php echo $kinectGames[2]->upVotes; ?>");
			var id = "<?php echo $user->id ?>";
			var hasVoted = "<?php checkVote($user->id.$kinectGames[2]->name, $votes); ?>";
			if (hasVoted == "false") {
				votes++;
				vote(name,votes, id);
				
			} else {
				alert("You have already voted for "+name+"!");
			}
		});
</script>
<script>
		var vote = function(name, votes, id) {
			$.ajax({
				url: '{{ URL::to("votegames") }}',
				type: 'POST',
				data: {'name':name,'upVotes':votes,'id':id},
				dataType: 'html',
				success: function(data){
					if(data){
					}
				}});
		}
		
</script>