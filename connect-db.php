<?php

/*

CONNECT-DB.PHP

Allows PHP to connect to your database

*/

// Ctrl+Alt+L
//find server
$db = mysqli_connect("localhost","root","920321Jing") or die(mysqli_connect_error());

//create db
$query ="create database if not exists player";
mysqli_query($db,$query) or die(mysqli_error($db));

//find db
mysqli_select_db($db, "player") or die(mysqli_error($db));

//connect to the database
$mysqli = new mysqli("localhost", "root", "920321Jing", 'player');

//drop table
/*
$query = "drop table players";
mysqli_query($db,$query) or die(mysqli_error($db));
*/

//create table players
$query = "create table if not exists players(
		id int PRIMARY KEY NOT NULL auto_increment,
		firstname VARCHAR(32) NOT NULL,
		birthday DATE NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ";
mysqli_query($db,$query) or die(mysqli_error($db));


// Dumping data for table players
/*
$query = "INSERT INTO players VALUES(1, 'Bob', '1990-03-24')";
mysqli_query($db,$query) or die(mysqli_error($db));

$query = "INSERT INTO players VALUES(2, 'Tim', '1987-11-23')";
mysqli_query($db,$query) or die(mysqli_error($db));

$query = "INSERT INTO players VALUES(3, 'Rachel', '1996-08-26')";
mysqli_query($db,$query) or die(mysqli_error($db));

$query = "INSERT INTO players VALUES(4, 'Sam', '1989-02-01')";
mysqli_query($db,$query) or die(mysqli_error($db));
*/


//create table events
$query = "create table if not exists events(
		id int PRIMARY KEY NOT NULL auto_increment,
		theme VARCHAR(50) NOT NULL,
		location VARCHAR(200) NOT NULL,
		eventDate DATE NOT NULL,
		eventTime TIME NOT NULL,
		description VARCHAR (300) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ";
mysqli_query($db,$query) or die(mysqli_error($db));

/*
// Dumping data for table events
$query = "INSERT INTO events VALUES(1, 'Lisa birthday', 'BCIT burnaby campus, SE12-308','2016-12-21', '17:00', 'dressing code: casual outfit')";
mysqli_query($db,$query) or die(mysqli_error($db));

$query = "INSERT INTO events VALUES(2, 'John birthday', 'BCIT burnaby campus, SE12-309','2016-12-24', '17:00', 'dressing code: casual outfit')";
mysqli_query($db,$query) or die(mysqli_error($db));

$query = "INSERT INTO events VALUES(3, 'Faye birthday', 'BCIT burnaby campus, SE12-318','2016-12-27', '17:00', 'dressing code: casual outfit')";
mysqli_query($db,$query) or die(mysqli_error($db));
*/