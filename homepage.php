<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php
$profpic = "bg.jpg";
?>
<head>
    <title>HomePage</title>
    <style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        body h1{
            color: #7c795d; 
			font-family: 'Trocchi', serif; 
			font-size: 45px; 
			font-weight: normal; 
			line-height: 48px; 
			margin: 0; 
			background-color: inherit;
        }
		body {
			background-image: url("bg.jpg");
			opacity: 1;
			background-size: cover;
			background-repeat:   no-repeat;
		}
		
        .button{
			font-size: 18pt;
			color: black;
			border: 5px solid #dccfa3;
			border-radius: 5px;
			vertical-align: center;
			height: 70px;
			width: 300px;
			margin-top: 15%;
			margin-left: 20%;
			margin-right: 20%;
			background-color: inherit;
			text-shadow: 1px 1px 1px #bcbcbc;
		}

		.button:hover {
            -webkit-transition-duration: 0.4s; /* Safari */
            transition-duration: 0.1s;
	    	background-color: #e1d6a9;
            color: black;
            border: 2px solid #ae170f;
	    	box-shadow: 0 2px 6px 0 rgba(0,0,0,0.24),0 0px 0px 0 rgba(0,0,0,0.19);
		}
		ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
			overflow: hidden;
			
		}
		ul li {
			float: left;
			margin-top: 17%;
			margin-left: 18%;
		}
		
		a{
			text-decoration: none;
			color: #660000; 
			font-weight: 200;
		}
		a:hover {
				color: #3c1806;
				text-shadow: 1px 1px 1px #3c1806;
		}
    </style>
</head>

<body>
    <h1 style = " color: #7c795d; 
			font-family: 'Trocchi', serif; 
			font-size: 45px; 
			font-weight: 600px; 
			line-height: 48px; 
			text-align: center;
			margin-top: 50px; 
			text-shadow: 2px 2px 2px #CCCCCC;">Birthday & Birthday Events</h1>
	<ul>
        <li><button class="button" type="button" ><a href="view.php">View All Birthday Records</a></button></li>
        <li><button class="button" type="button"><a href="view-events.php">View All Events</a></button></li>

	</ul>	
</body>
</html>
