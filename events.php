<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 11-Dec-2016
 * Time: 12:00 AM
 */

/*
Allows the user to both create new records and edit existing records
*/

// connect to the database
require_once("connect-db.php");

// creates the new/edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
// function renderForm($first = '', $last = '', $error = '', $id = '')
function renderForm($theme = '', $location = '', $eventDate = '', $eventTime = '', $description = '',$error = '', $id = '')
{ ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    <html>
    <head>
        <title>
            <?php if ($id != '') {
                echo "Edit Event";
            } else {
                echo "New Event";
            } ?>
        </title>
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
			background-image: url("single.jpg");
			opacity: 1;
			background-size: 75%;
			background-position: center top;
			background-repeat:   no-repeat;
		}
		div{
			color: #660000; 	
			margin-top: 80px;
			margin-left: 26%; 
			margin-right: 30%
			text-shadow: 2px 2px 2px #CCCCCC;
			font-size: 20px;
		}
		p{
			text-shadow: 2px 2px 2px #CCCCCC; 
			font-size: 20px;
			font-family:Georgia,serif; 
			color:#4E443C; 
			font-variant: small-caps; 
			text-transform: none; 
			font-weight: 200; 
			margin-bottom: 10px;
		}
        .button{
		  width: 500px;
		  height: 40px;
		  margin-bottom: 10px;
		  padding-left: 10px;
		  margin-left: 30px;
		  margin-right: 10%;
		  margin-top: 20px;
		  font-weight: 800px;
		  font-family:Georgia,serif; 
			font-size: 20px;
			color: #ffd3dd;
			border: 3px solid #e7ad77;
			border-radius: 5px;
			vertical-align: center;
			background-color: #cc6600;
			text-shadow: 1px 1px 1px #3c1806;
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
		form {
			vertical-align: center;
			margin-left: 2%;
			margin-top: 10px;
			font-family:Georgia,serif; 
			font-size: 16px;
		}
		form input[type=text] {
		  width: 500px;
		  height: 30px;
		  padding-left: 10px;
		  margin-left: 10px;
		  background: #fff; /* #44454a  */
		  border: none;
		  color: #7c795d;   /* e74c3c e9e9e9  */
		  outline: none;
		}
		form input[type=submit] {
		  width: 500px;
		  height: 40px;
		  margin-bottom: 10px;
		  padding-left: 10px;
		  margin-left: 30px;
		  margin-right: 10%;
		  margin-top: 10px;
		  font-weight: 800px;
			color: #ffd3dd;
			border: 3px solid #e7ad77;
			border-radius: 5px;
			vertical-align: center;
			background-color: #cc6600;
			text-shadow: 1px 1px 1px #ffd3dd;
		}

    </style>
    </head>
    <body>
    <h1 style = " color: #7c795d; 
			font-family: 'Trocchi', serif; 
			font-size: 45px; 
			font-weight: 600px; 
			line-height: 48px; 
			padding-right: 10%;
			text-align: center;
			margin-top: 50px; 
			text-shadow: 2px 2px 2px #CCCCCC;"><?php if ($id != '') {
            echo "Edit Event";
        } else {
            echo "New Event";
        } ?></h1>
    

    <form action="" method="post">
	
        <div>
		<?php if ($error != '') {
        echo "<p style='text-align: center; padding-top: 5px; width: 500px;  color:red'>" . $error
            . "</p>";
    } ?>
            <?php if ($id != '') { ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                <p>ID: <?php echo $id; ?></p>
            <?php } ?>

            <strong>*</strong> <input style="font-size:16px" type="text" name="theme" placeholder="Event Theme"
                                                  value="<?php echo $theme; ?>"/><br/><br/>
            <strong>*</strong> <input style="font-size:16px"  type="text" name="location" placeholder="Event Location"
                                                value="<?php echo $location; ?>"/><br/><br/>
            <strong>*</strong> <input style="font-size:16px"  type="text" name="eventDate" placeholder="Event Date"
                                                      value="<?php echo $eventDate; ?>"/><br/><br/>
            <strong>*</strong> <input style="font-size:16px"  type="text" name="eventTime" placeholder="Event Time"
                                                      value="<?php echo $eventTime; ?>"/><br/><br/>
            <strong>*</strong> <input style="font-size:16px"  type="text" name="description" placeholder="Event Description"
                                                      value="<?php echo $description; ?>"/><br/>
            <p>* &nbsp;&nbsp;represents required area</p>
            <input style="font-size:16px"  type="submit" name="submit" value="Submit"/>
			<button class="button" type="button"><a href="view-events.php">BACK</a></button>
        </div>
    </form>
    </body>
    </html>

<?php }


/*

EDIT Events

*/
// if the 'id' variable is set in the URL, we know that we need to edit a record
if (isset($_GET['id'])) {
    // if the form's submit button is clicked, we need to process the form
    if (isset($_POST['submit'])) {
        // make sure the 'id' in the URL is valid
        if (is_numeric($_POST['id'])) {
            // get variables from the URL/form
            $id = $_POST['id'];
            $theme = htmlentities($_POST['theme'], ENT_QUOTES);
            $location = htmlentities($_POST['location'], ENT_QUOTES);
            $eventDate = htmlentities($_POST['eventDate'], ENT_QUOTES);
            $eventTime = htmlentities($_POST['eventTime'], ENT_QUOTES);
            $description = htmlentities($_POST['description'], ENT_QUOTES);
            // check that firstname and lastname are both not empty
            if ($theme == '' || $location == ''|| $eventDate == ''|| $eventTime == ''|| $description == '') {
                // if they are empty, show an error message and display the form
                $error = 'ERROR: Please fill in all required fields!';
                renderForm($theme, $location, $eventDate, $eventTime, $description, $error, $id);
            } else {
                // if everything is fine, update the record in the database
                if ($stmt = $mysqli->prepare("UPDATE events SET theme = ?, location = ?, eventDate = ?, eventTime = ?, description = ? WHERE id=?") ) {
                    //alert("hello1");
                    $stmt->bind_param("sssssi", $theme, $location, $eventDate, $eventTime, $description, $id);
                    $stmt->execute();
                    $stmt->close();
                } // show an error message if the query has an error
                else {
                    echo "ERROR: could not prepare SQL statement.";
                }

                // redirect the user once the form is updated
                header("Location: view-events.php");
            }
        } // if the 'id' variable is not valid, show an error message
        else {
            echo "Error!";
        }
    } // if the form hasn't been submitted yet, get the info from the database and show the form
    else {
        // make sure the 'id' value is valid
        if (is_numeric($_GET['id']) && $_GET['id'] > 0) {
        // get 'id' from URL
            $id = $_GET['id'];

            // get the recod from the database
            if ($stmt = $mysqli->prepare("SELECT * FROM events WHERE id=?")) {

                //$mysqli->query("INSERT INTO events (theme, location, eventDate, eventTime, description) VALUES ('".$theme."', '".$location."', '".$eventDate."', '".$eventTime."', '".$description."')");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                //alert("hello 2");
                $stmt->bind_result($id, $theme, $location, $eventDate, $eventTime, $description);
                $stmt->fetch();

                // show the form
                renderForm($theme, $location, $eventDate, $eventTime, $description, NULL, $id);

                $stmt->close();
            } // show an error if the query has an error
            else {
                echo "Error: could not prepare SQL statement";
            }
        } // if the 'id' value is not valid, redirect the user back to the view.php page
        else {
            header("Location: view-events.php");
        }
    }
}



/*

NEW Events

*/
// if the 'id' variable is not set in the URL, we must be creating a new record
else {
    // if the form's submit button is clicked, we need to process the form
    if (isset($_POST['submit'])) {
        // get the form data

        $theme = htmlentities($_POST['theme'], ENT_QUOTES);
        $location = htmlentities($_POST['location'], ENT_QUOTES);
        $eventDate = htmlentities($_POST['eventDate'], ENT_QUOTES);
        $eventTime = htmlentities($_POST['eventTime'], ENT_QUOTES);
        $description = htmlentities($_POST['description'], ENT_QUOTES);


        // check that firstname and lastname are both not empty
        if ($theme == '' || $location == ''|| $eventDate == ''|| $eventTime == ''|| $description == '') {
            // if they are empty, show an error message and display the form
            $error = 'ERROR: Please fill in all required fields!';
            renderForm($theme, $location, $eventDate, $eventTime, $description, $error);
        } else {
            // insert the new record into the database
            if ($stmt = $mysqli->prepare("INSERT events (theme, location, eventDate, eventTime, description) VALUES (?, ?, ?, ?, ?)")) {
                echo "insert statement";
                echo "I'm here: " . $theme . " " . $location . " " . $eventDate . " " . $eventTime . " ". $description . "<br>";
                $stmt->bind_param("sssss", $theme, $location, $eventDate, $eventTime, $description);
                $theme = $theme;
                $location = $location;
                $eventDate = $eventDate;
                $eventTime = $eventTime;
                $description = $description;

                $stmt->execute();
                $stmt->close();
            } // show an error if the query has an error
            else {
                echo "ERROR: Could not prepare SQL statement.";
            }

//          redirec the user
            header("Location: view-events.php");
        }

    } // if the form hasn't been submitted yet, show the form
    else {
        renderForm();
    }
}

// close the mysqli connection
$mysqli->close();
?>