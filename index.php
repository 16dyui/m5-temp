<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>temp beta</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
		<script async src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
		<script async src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
		<script async src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<style>
			.nix{
				width: 100px;
				height: 100px;
				display: inline-block;
				vertical-align: middle;
				background: no-repeat;
				background-size: 500px;
				background-image: url(nix.png);
			}
			.nix-0{
				background-position: 0 0;
			}
			.nix-1{
				background-position: -100px 0;
			}
			.nix-2{
				background-position: -200px 0;
			}
			.nix-3{
				background-position: -300px 0;
			}
			.nix-4{
				background-position: -400px 0;
			}
			.nix-5{
				background-position: 0 -100px;
			}
			.nix-6{
				background-position: -100px -100px;
			}
			.nix-7{
				background-position: -200px -100px;
			}
			.nix-8{
				background-position: -300px -100px;
			}
			.nix-9{
				background-position: -400px -100px;
			}
		</style>
	</head>

	<body>
		<canvas id="myChart"></canvas>
		<table>
			<thead>
				<tr>
					<th>温度</th>
					<th>湿度</th>
					<th>気圧</th>
				</tr>
			</thead>
			<tbodyt>
				<tr>
					<td><i class="nix nix-0"></i><i class="nix nix-0"></i></td>
					<td><i class="nix nix-0"></i><i class="nix nix-0"></i></td>
					<td><i class="nix nix-0"></i><i class="nix nix-0"></i><i class="nix nix-0"></i><i class="nix nix-0"></i></td>
				</tr>
			</tbodyt>
		</table>
		<script>
			window.addEventListener('load', function() {
				var ctx = document.getElementById('myChart').getContext('2d');
				var chart;
				$.get("temp.txt").then(function(data) {
					json = data.split('\n');
					temp = [];
					v = [];
					humid = [];
					pressure = [];
					for(i=-32;i<-1;i++) {
						t = $.parseJSON(json[json.length+i]);
						v.push(-i-2+'s');
						temp.push(t.data['temp']);
						humid.push(t.data['humid']);
						pressure.push(t.data['pressure']);
					}
					chart = new Chart(ctx, {
				    type: 'line',
				    data: {
			        labels: v,
			        datasets: [{
		            label: "temp",
		            backgroundColor: '',
		            borderColor: 'rgb(255, 0, 0)',
		            data: temp,
								yAxisID: "y1"
			        },{
		            label: "humid",
		            backgroundColor: '',
		            borderColor: 'rgb(0, 255, 0)',
		            data: humid,
								yAxisID: "y2"
			        },{
		            label: "pressure",
		            backgroundColor: '',
		            borderColor: 'rgb(0, 0, 255)',
		            data: pressure,
								yAxisID: "y3"
			        },]
				    },
				    // Configuration options go here
				    options: {
							scales: {
								yAxes: [{
									id: "y1",
									type: "linear",
									position: "right",
								}, {
									id: "y2",
									type: "linear",
									position: "right",
								}, {
									id: "y3",
									type: "linear",
									position: "right",
								}],
							},
						}
					});
				});
				var jqxhr;
				func = function() {
					if (jqxhr) return;
					jqxhr = $.get("temp.txt").then(function(data) {
						s = data.split('\n');
						e = $.parseJSON(s[s.length-2]);
						$(".nix").removeClass(function(index, className) {
						  return (className.match(/\bnix-\S+/g) || []).join(' ');
						});
						$('td:nth-of-type(1)>i:first-of-type').addClass('nix-'+e.data.temp.substring(0,1));
						$('td:nth-of-type(1)>i:last-of-type').addClass('nix-'+e.data.temp.substring(1,2));
						$('td:nth-of-type(2)>i:first-of-type').addClass('nix-'+e.data.humid.substring(0,1));
						$('td:nth-of-type(2)>i:last-of-type').addClass('nix-'+e.data.humid.substring(1,2));
						$('td:nth-of-type(3)>i:nth-of-type(1)').addClass('nix-'+e.data.pressure.substring(0,1));
						$('td:nth-of-type(3)>i:nth-of-type(2)').addClass('nix-'+e.data.pressure.substring(1,2));
						$('td:nth-of-type(3)>i:nth-of-type(3)').addClass('nix-'+e.data.pressure.substring(2,3));
						$('td:nth-of-type(3)>i:nth-of-type(4)').addClass('nix-'+e.data.pressure.substring(3,4));
						jqxhr = false;
						chart.data.datasets[0].data.push(e.data.temp);
						chart.data.datasets[0].data.shift();
						chart.data.datasets[1].data.push(e.data.humid);
						chart.data.datasets[1].data.shift();
						chart.data.datasets[2].data.push(e.data.pressure);
						chart.data.datasets[2].data.shift();
				    chart.update();
					}, function(data) {
						jqxhr = false;
					});
				}
				func();
				setInterval(func, 1000);
			});
		</script>
	</body>

</html>
