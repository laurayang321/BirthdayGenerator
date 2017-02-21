<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>View Birthdays</title>
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
			background-image: url("eventbg.jpg");
			opacity: 1;
			background-repeat:   repeat;
		}
		div{
			color: #660000; 	

			margin-left: 12%; 
			margin-right: 12%;
			text-shadow: 2px 2px 2px #CCCCCC;
		}
		p{
			margin-left: 12%; 
			margin-right: 12%;
			text-shadow: 2px 2px 2px #CCCCCC; 
			background-color: white;
			opacity: 0.8;
			font-size: 20px;
			font-family:Georgia,serif; 
			color:#4E443C; 
			font-variant: small-caps; 
			text-transform: none; 
			font-weight: 200; 
		}
		table{

			 background: white;
			border-top: none;
			border-radius:3px;
			border-collapse: collapse;			
			height: 100px;
			margin-left: 0;
			width: 100%;
			padding:5px;
			box-shadow: 3px 3px 5px 5px rgba(0, 0, 0, 0.4);
			animation: float 5s infinite;
		}
		th {
		  color:#660000;
		  background:#febb79;
		  border-bottom:4px solid #9ea7af;
		  font-size:20px;
		  font-weight: 300px;
		  padding:10px;
		  text-align:center;
		  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
		  vertical-align:middle;
		}

		th:first-child {
		  border-top-left-radius:3px;
		}
		 
		th:last-child {
		  border-top-right-radius:3px;
		  border-right:none;
		}
		  
		tr {
		  border-top: 1px solid #C1C3D1;
		  border-bottom: 1px solid #C1C3D1;
		  color:#666B85;
		  font-size:14px;
		  text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
		}
		 

		tr:first-child {
		  border-top:none;
		}

		tr:last-child {
		  border-bottom:none;
		}
		 
		tr:nth-child(odd) td {
		  background:	#fffcee;
		}

		tr:last-child td:first-child {
		  border-bottom-left-radius:3px;
		}
		 
		tr:last-child td:last-child {
		  border-bottom-right-radius:3px;
		}
		 
		td {
		  background:#FFFFFF;
		  padding:20px;
		  text-align:left;
		  vertical-align:middle;
		  font-weight:300;
		  font-size:18px;
		  text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
		  border-right: 1px solid #C1C3D1;
		}

		td:last-child {
		  border-right: 0px;
		}

		.button{
			font-size: 15pt;
			color: #ffd3dd;
			border: 3px dashed #e7ad77;
			border-radius: 5px;
			vertical-align: center;
			height: 50px;
			width: 200px;
			margin-top: 50px;
			margin-left: 50px;
			margin-right: 35px;
			background-color: #febb79;
			text-shadow: 1px 1px 1px #bcbcbc;
		}
		.button1{
			font-weight: 800px;
			font-size: 15pt;
			color: #ffd3dd;
			border: 3px solid #e7ad77;
			border-radius: 5px;
			vertical-align: center;
			height: 50px;
			width: 200px;
			margin-top: 50px;
			margin-left: 50px;
			margin-right: 35px;
			background-color: #cc6600;
			text-shadow: 1px 1px 1px #3c1806;
		}
		.button:hover {
            -webkit-transition-duration: 0.4s; /* Safari */
            transition-duration: 0.1s;
	    	background-color: #fffcee;
            color: black;
            border: 3px dashed #e7ad77;
	        box-shadow: 0 2px 6px 0 rgba(0,0,0,0.24),0 0px 0px 0 rgba(0,0,0,0.19);
		}
		ul {
			list-style-type: none;
			margin: -20px;
			padding: 0;
			overflow: hidden;
			
		}
		ul li {
			float: left;
			margin-left: 2%;
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

<h1 style = " color: #6f634b; 
			font-family: 'Trocchi', serif; 
			font-size: 45px; 
			font-weight: 600px; 
			line-height: 48px; 
			text-align: center;
			margin-top: 50px; 
			background-color: white;
			opacity: 0.8;
			text-shadow: 2px 2px 2px #CCCCCC;">View Events</h1>

<?php
// connect to the database
include('connect-db.php');

// number of results to show per page
$per_page = 3;

// figure out the total pages in the database
if ($result = $mysqli->query("SELECT * FROM events ORDER BY id")) {
    if ($result->num_rows != 0) {
        $total_results = $result->num_rows;
        // ceil() returns the next highest integer value by rounding up value if necessary
        $total_pages = ceil($total_results / $per_page);

        // check if the 'page' variable is set in the URL (ex: view-paginated.php?page=1)
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $show_page = $_GET['page'];

            // make sure the $show_page value is valid
            if ($show_page > 0 && $show_page <= $total_pages) {
                $start = ($show_page - 1) * $per_page;
                $end = $start + $per_page;
            } else {
                // error - show first set of results
                $start = 0;
                $end = $per_page;
            }
        } else {
            // if page isn't set, show first set of results
            $start = 0;
            $end = $per_page;
        }

        // display pagination
        echo "<p>
		<a href='view-events.php'>View All Events</a> | <b>View Page:</b> ";
        for ($i = 1; $i <= $total_pages; $i++) {
            if (isset($_GET['page']) && $_GET['page'] == $i) {
                echo $i . " ";
            } else {
                echo "<a href='view-events-paginated.php?page=$i'>$i</a> ";
            }
        }
        echo "</p>";

        // display data in table
		echo "<div>";
        echo "<table>";
        echo "<tr>
				 <th>ID</th>
				 <th>Theme</th>
				 <th>Location</th>
				 <th>Date</th>
				 <th>Time</th>
				 <th>Description</th>
				 <th></th>
				 <th></th>
				 <th></th>
				</tr>";

        // loop through results of database query, displaying them in the table
        for ($i = $start; $i < $end; $i++) {
            // make sure that PHP doesn't try to show results that don't exist
            if ($i == $total_results) {
                break;
            }

            // find specific row
            $result->data_seek($i);
            $row = $result->fetch_row();

            // echo out the contents of each row into a table
            echo "<tr>";
            echo '<td>' . $row[0] . '</td>';
            echo '<td>' . $row[1] . '</td>';
            echo '<td>' . $row[2] . '</td>';
            echo '<td>' . $row[3] . '</td>';
            echo '<td>' . $row[4] . '</td>';
            echo '<td>' . $row[5] . '</td>';
            echo '<td>
					<a href="events.php?id=' . $row[0] . '">Edit</a>
					</td>';
            echo '<td>
					<a href="delete-event.php?id=' . $row[0] . '">Delete</a>
					</td>';
            echo '<td>
					<a href="view-event.php?id=' . $row[0] . '">Event Link</a>
					</td>';
            echo "</tr>";
        }

        // close table>
        echo "</table>";
		echo "</div>";
    } else {
        echo "No results to display!";
    }
} else { // error with the query
    echo "Error: " . $mysqli->error;
}

// close database connection
$mysqli->close();

?>

<div style = " color: #660000; 	
			margin-top: 20px;
			margin-left: 12%; 
			margin-right: 12%;
			text-shadow: 2px 2px 2px #CCCCCC;">
	<ul>
			<li><button class="button" type="button"><a href="events.php">Create Event</a></button></li>
			<li><button class="button" type="button"><a href="view.php">View All Birthdays</a></button></li>
			<li><button class="button1" type="button"><a href="homepage.php">HOMEPAGE</a></button></li>
	</ul>
</div>
</body>
</html>
</html>