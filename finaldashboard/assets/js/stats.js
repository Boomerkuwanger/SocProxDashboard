var data;

	function startChart(){
		data = new google.visualization.DataTable();
		data.addColumn("datetime", "Time");
		data.addColumn("number", "Total Users");
		data.addColumn("number", "Games Started");
		data.addColumn("number", "Games Completed");
		data.addColumn("number", "Games in Progress");
		
		drawChart();
	}


	function drawChart() {
		$.getJSON('../REST/globalStats', function(resp) {
			  data.addRow([new Date(), parseInt(resp["body"]["m_iTotalUsers"]), parseInt(resp["body"]["m_iGamesStarted"]), parseInt(resp["body"]["m_iGamesCompleted"]), parseInt(resp["body"]["m_iGamesInProgress"])]);
			
        
	        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
	        chart.draw(data,{curveType: "function",
                       	height: 500});
	        
	        setTimeout(drawChart, 5000);
			});
      }
	
	google.load("visualization", "1", {packages: ["corechart"]});
    google.setOnLoadCallback(startChart);
