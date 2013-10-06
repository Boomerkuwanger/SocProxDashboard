
<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">SocProx</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li <?if($request=="index"){echo "class='active'";}?>><a href="./index.php">Overview</a></li>
              <li <?if($request=="users"){echo "class='active'";}?>><a href="./users.php">Users</a></li>
              <li <?if($request=="game"){echo "class='active'";}?>><a href="./game.php">Games & Challenges</a></li>
              <li <?if($request=="simulation"){echo "class='active'";}?>><a href="./simulation.php">Simulation</a></li>
              <li <?if($request=="stats"){echo "class='active'";}?>><a href="./stats.php">Stats</a></li>
              <!--li><a href="./activity.php">Activity</a></li>
              <li><a href="./challengeinstance.php">Challenge Instance</a></li>
              <li><a href="./challengeacceptance.php">Challenge Acceptance</a></li>
              <li><a href="./game.php">Game</a></li>
              <li><a href="./payoffs.php">Payoffs</a></li>
              <li><a href="./verification.php">Verification</a></li>
              <li><a href="./parameters.php">Parameters</a></li>
              <li><a href="./points.php">Points</a></li-->
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>