<?php
/*
Allows the user to both create new records and edit existing records
*/

// connect to the database
include("connect-db.php");

// creates the new/edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($first = '', $last = '', $error = '', $id = '')
{ ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    <html>
    <head>
        <title>
            <?php if ($id != '') {
                echo "Edit Record";
            } else {
                echo "New Record";
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
			margin-top: 20px; 
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
			margin-bottom: 20px;
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
			margin-left: 2%;
			margin-top: 20px;
			font-family:Georgia,serif; 
			font-size: 20px;
		}
		form input[type=text] {
		  width: 500px;
		  height: 40px;
		  margin-bottom: 10px;
		  padding-left: 10px;
		  margin-left: 10px;
		  margin-right: 10%;
		  margin-top: 20px;
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
		  margin-top: 20px;
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
			padding-top: 20px;
			text-shadow: 2px 2px 2px #CCCCCC;"><?php if ($id != '') {
            echo "Edit Record";
        } else {
            echo "New Record";
        } ?></h1>
	<div style = " color: #660000; 	
			margin-top: 80px;
			margin-left: 26%; 
			margin-right: 50%
			text-shadow: 2px 2px 2px #CCCCCC;">
    <?php if ($error != '') {
        echo "<p style='padding:4px; text-align: center; padding-top: 20px; width: 500px;  color:red'>" . $error
            . "</p>";
    } ?>
	
		<form action="" method="post">
        
            <?php if ($id != '') { ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                <p>ID: <?php echo $id; ?></p>
            <?php } ?>

            <strong>*</strong> <input style="font-size:20px" type="text" name="firstname" placeholder="Name"
                                                  value="<?php echo $first; ?>"/><br/>
            <strong>*</strong> <input style="font-size:20px" type="text" name="birthday" placeholder="Birthday"
                                                 value="<?php echo $last; ?>"/>
            <p>* &nbsp;&nbsp;represents required area</p>
            <input style="font-size:20px; font-weight: 800px;" type="submit" name="submit" value="Submit"/>
			<button class="button" type="button"><a href="view.php">BACK</a></button>
		</form>
	</div>
    </body>
    </html>

<?php }


/*

EDIT RECORD

*/
// if the 'id' variable is set in the URL, we know that we need to edit a record
if (isset($_GET['id'])) {
// if the form's submit button is clicked, we need to process the form
    if (isset($_POST['submit'])) {
// make sure the 'id' in the URL is valid
        if (is_numeric($_POST['id'])) {
// get variables from the URL/form
            $id = $_POST['id'];
            $firstname = htmlentities($_POST['firstname'], ENT_QUOTES);
            $birthday = htmlentities($_POST['birthday'], ENT_QUOTES);

// check that firstname and lastname are both not empty
            if ($firstname == '' || $birthday == '') {
// if they are empty, show an error message and display the form
                $error = 'ERROR: Please fill in all required fields!';
                renderForm($firstname, $birthday, $error, $id);
            } else {
// if everything is fine, update the record in the database
                if ($stmt = $mysqli->prepare("UPDATE players SET firstname = ?, birthday = ?
WHERE id=?")
                ) {
                    $stmt->bind_param("ssi", $firstname, $birthday, $id);
                    $stmt->execute();
                    $stmt->close();
                } // show an error message if the query has an error
                else {
                    echo "ERROR: could not prepare SQL statement.";
                }

// redirect the user once the form is updated
                header("Location: view.php");
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
            if ($stmt = $mysqli->prepare("SELECT * FROM players WHERE id=?")) {
                $stmt->bind_param("i", $id);
                $stmt->execute();

                $stmt->bind_result($id, $firstname, $birthday);
                $stmt->fetch();

// show the form
                renderForm($firstname, $birthday, NULL, $id);

                $stmt->close();
            } // show an error if the query has an error
            else {
                echo "Error: could not prepare SQL statement";
            }
        } // if the 'id' value is not valid, redirect the user back to the view.php page
        else {
            header("Location: view.php");
        }
    }
}



/*

NEW RECORD

*/
// if the 'id' variable is not set in the URL, we must be creating a new record
else {
// if the form's submit button is clicked, we need to process the form
    if (isset($_POST['submit'])) {
// get the form data
        $firstname = htmlentities($_POST['firstname'], ENT_QUOTES);
        $birthday = htmlentities($_POST['birthday'], ENT_QUOTES);

// check that firstname and lastname are both not empty
        if ($firstname == '' || $birthday == '') {
// if they are empty, show an error message and display the form
            $error = 'ERROR: Please fill in all required fields!';
            renderForm($firstname, $birthday, $error);
        } else {
            // insert the new record into the database
            if ($stmt = $mysqli->prepare("INSERT players (firstname, birthday) VALUES (?, ?)")) {
                echo "insert statement";
                $stmt->bind_param("ss", $firstname, $birthday);
                $stmt->execute();
                $stmt->close();
            } // show an error if the query has an error
            else {
                echo "ERROR: Could not prepare SQL statement.";
            }

// redirec the user
            header("Location: view.php");
        }

    } // if the form hasn't been submitted yet, show the form
    else {
        renderForm();
    }
}

// close the mysqli connection
$mysqli->close();
?>