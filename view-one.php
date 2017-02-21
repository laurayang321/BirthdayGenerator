<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 10-Dec-2016
 * Time: 11:38 PM
 */

/*
Allows the user to both create new records and edit existing records
*/

// connect to the database
include("connect-db.php");

// creates the new/edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($first = '', $birthday = '', $error = '', $id = ''){ ?>

    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    <html>
    <head>
        <title>
            <?php if ($id != '') {
                echo "View Birthday";
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
			background-image: url("onebg.jpg");
			opacity: 1;
			background-size: cover;
			background-position: center top;
			background-repeat:   no-repeat;
		}
		div{
			width: 300px;
			height: 250px;
			color: #660000; 	
			text-shadow: 2px 2px 2px #CCCCCC;
			font-size: 20px;
			background-color: #fffcee;
		}
		p{
			text-shadow: 2px 2px 2px #CCCCCC; 
			font-size: 20px;
			font-family:Georgia,serif; 
			color:#4E443C; 
			font-variant: small-caps; 
			text-transform: none; 
			font-weight: 200; 
			margin-top: 50px;
			margin-bottom: 10px;
			margin-left: 15%;
		}
        button{
		  width: 300px;
		  height: 40px;
		  margin-top: 20px;
		  font-weight: 800px;
		  font-family:Georgia,serif; 
			font-size: 20px;
			color: #ffd3dd;
			border: 3px solid #e7ad77;
			border-radius: 5px;			
			margin-left: 38%;/*40%;*/
			background-color: #febb79;
			text-shadow: 1px 1px 1px #3c1806;
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
			background-color: #fffcee;
			margin-top: 100px;
			margin-left: auto;
			margin-right: auto;
			background: #fff;
			box-shadow: 
			0px 0px 0px 5px rgba( 255,255,255,0.4 ), 
			0px 4px 20px rgba( 0,0,0,0.33 );
			-moz-border-radius: 5px;
			-webkit-border-radius: 5px;
			border-radius: 5px;
			display: table;
			position: static;
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
			text-shadow: 2px 2px 2px #CCCCCC;"><?php if ($id != '') {
            echo "View Birthday";
        } else {
            echo "New Record";
        } ?></h1>
    <?php if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error
            . "</div>";
    } ?>
	
    <form style="background-color: #fffcee;" action="" method="post">
        <div>
            <?php if ($id != '') { ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                <p>Birthday ID: <?php echo $id; ?></p>
            <?php } ?>

            <p><strong>Name: </strong> <?php echo $first; ?><br/></p>
            <p><strong>Birthday: </strong>  <?php echo $birthday; ?><br/><br/></p>

        </div>
    </form>
	<?php echo "<button><a href='delete.php?id=" . $id . "'>Delete</a></button>"; ?>
	<button class="button" type="button"><a href="view.php">BACK</a></button>
    </body>
    </html>

<?php }


/*

View RECORD

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
                if ($stmt = $mysqli->prepare("UPDATE players SET firstname = ?, birthday = ? WHERE id=?")) {
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

// close the mysqli connection
$mysqli->close();
?>