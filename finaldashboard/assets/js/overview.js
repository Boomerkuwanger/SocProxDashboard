$(function(){
	/*var width = $(document).width();
    var height = $(document).height();
    var g = new Graph();
    g.edgeFactory.template.style.directed = false;*/
   $.get('./php/persontree.php', function(data) {
   	alert("hi");
    	//$("#viscanvas").text(JSON.stringify(data));
	}, "json");
});
