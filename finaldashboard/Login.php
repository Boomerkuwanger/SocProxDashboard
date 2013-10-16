<?php 
$request = "login";
?>
<!DOCTYPE html>
<html lang="en" ng-app="">
  <head>
    <meta charset="utf-8">
    <title>Social Proximity Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<script type="text/javascript" src="./assets/foundation/javascripts/foundation.min.js"></script>
    <script type="text/javascript" src="./assets/foundation/javascripts/app.js"></script>
    <link rel="stylesheet" href="./assets/foundation/stylesheets/foundation.css">
    <script type="text/javascript" src="./assets/js/addUser.js"></script>
    <script type="text/javascript" src="./assets/js/angular.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Exo|Open+Sans' rel='stylesheet' type='text/css'>
   </head>
   
<body ng-controller="addUser">
<style>
     .row.display {
         background: #eee;
         font-size: 11px;
         margin-bottom: 10px;
     }
     .row.display .columns, .row.display .column {
         background: #e7e7e7;
         border: 1px solid #ddd;
         font-size: 13px;
         font-weight: bold;
         text-indent: 3px;
         padding-top: 8px;
         color: #444;
         padding-bottom: 8px;
     }
</style>
<?php
	echo "
		<div class='rowboat'>
		    <div class='four columns centered'>
		        <ul class='breadcrumbs centered'>
		            <li><a href='#' ng-click='init()' data-reveal-id='accountModal'>Login / Register</a></li>
		            <li class='unavailable'><a href='#'>About</a></li>
		            <li class='unavailable'><a href='#'>Contact</a></li>
		        </ul>
		    </div>
		</div>
		<div id='accountModal' class='reveal-modal [expand, xlarge, large, medium, small]'>
		    <div class='rowboat'>
		        <form id='loginForm' class='twelve columns centered' ng-submit='login()'>
		            <fieldset class ='row'>
		                <legend>Login</legend>
		                <div class='row collapse {{alertUser}}'>
		                    <label>Username</label>
		                    <div class='twelve column'>
		                        <input id='focusUserLogin' ng-model='username' type='text' placeholder='Username' />
		                    </div>
		                </div>
		                <div class='row collapse '>
		                    <label>Password</label>
		                    <div class='nine columns {{alertPwd}}'>
		                        <input ng-model='confirm' type='password'>
		                    </div>
		                    <div class='three columns'>
		                        <input type='submit' class='button expand postfix' value='Submit'/>
		                    </div>
		                </div>
		                <div class='row collapse alert-box {{errorStatus}}'>
                    		{{errorReport}}
               			</div>
		            </fieldset>
		        </form>
		        <h1 id='regSuccesslogin' class='success' style='display:none; color:#50ff36;' >'Successfully Logged In!'</h1>
		    </div>
		    <a href='#' ng-click='init()' data-reveal-id='registerModal' >Need to Register?</a></li>
		    <a class='close-reveal-modal'>&#215;</a>
		</div>
		
		<!-- Register Modal (called by Login Modal)-->
		<div id='registerModal' class='reveal-modal [expand, xlarge, large, medium, small]'>
		    <!-- Registration form -->
		    <div class='rowboat'>
		        <form id='registerForm' class='twelve columns centered' ng-submit='register()'>
		            <fieldset class='row'>
		                <legend>Register</legend>
		                <div class='row collapse {{alertUser}}'>
		                    <label>Username</label>
		                    <div class='twelve column'>
		                        <input id='focusUser' ng-model='username' type='text' placeholder='Desired Username' />
		                    </div>
		                </div>
		                <div class='row collapse {{alertEmail}}'>
		                    <label>Email</label>
		                    <div class='twelve column'>
		                        <input id='focusEmail' ng-model='email' type='text' placeholder='example@your.domain' />
		                    </div>
		                </div>
		                <div class='row collapse {{alertPwd}}'>
		                    <label>Password</label>
		                    <div class='twelve column'>
		                        <input id='focusPwd' class='alert-box secondary' ng-model='password' type='password' />
		                    </div>
		                </div>
		                <div class='row collapse '>
		                    <label>Confirm Password</label>
		                    <div class='nine columns {{alertPwd}}'>
		                        <input ng-model='confirm' type='password'>
		                    </div>
		                    <div class='three columns'>
		                        <input type='submit' class='button expand postfix' value='Submit'/>
		                    </div>
		                </div>
		                <div class='row collapse alert-box {{errorStatus}}'>
                    		{{errorReport}}
               			</div>
		            </fieldset>
		        </form>
		        <h1 id='regSuccess' class='success' style='display:none; color:#50ff36;' >'Successfully Registered!'</h1>
		    </div>
		    <a class='close-reveal-modal'>&#215;</a>
		</div>
	";	
?>
</body>
</html>