<?php
$request = "index";
 include "templates/head.php"; ?>
<body>
<?php include "templates/navbar.php"; ?>
<div id="content" class="container">
<div class="row">
	<button id="redraw" type="button" class="btn btn-primary" data-loading-text="Loading...">Redraw</button>
</div>
<div id="container" class="container">
	<div id="viscanvas">
		
	</div>
</div>

<?php include "templates/foot.php"; ?>
<script src="./assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./assets/js/raphael-min.js"></script>
<script type="text/javascript" src="./assets/js/dracula_graffle.js"></script>
    <script type="text/javascript" src="./assets/js/dracula_graph.js"></script>
<script>
	$(function(){
		var width = $("#container").width();
	    var height = $(document).height()*.9;
	    var g = new Graph();
	    g.edgeFactory.template.style.directed = true;
	    
	   // /* var userrender = function(r, n) {
        // /* the Raphael set is obligatory, containing all you want to display */
		        // var set = r.set().push(
		            // /* custom objects go here */
		            // r.circle(n.point[0], n.point[1], 250)
		                // .attr({"fill": "#fa8", "stroke-width": 2, r : "9px"}))
		                // .push(r.text(n.point[0], n.point[1] + 30, n.label)
		                    // .attr({"font-size":"20px"}));
		        // return set;
		    // };
		// var gamerender = function(r, n) {
        // /* the Raphael set is obligatory, containing all you want to display */
        	// var set = r.set().push(
		            // /* custom objects go here */
		            // r.circle(n.point[0], n.point[1], 250)
		                // .attr({"fill": "#ddd", "stroke-width": 2, r : "9px"}))
		                // .push(r.text(n.point[0], n.point[1] + 30, n.label)
		                    // .attr({"font-size":"20px"}));
		        // return set;
		    // };
	    
	    <?php include "php/persontree.php";?>
	    
		$("#redraw").click(function() {
		        layouter.layout();
		        renderer.draw();
		    });
    	var layouter = new Graph.Layout.Spring(g);
   		var renderer = new Graph.Renderer.Raphael('viscanvas', g, width, height);

	});
</script>
</div>
</body>
</html>