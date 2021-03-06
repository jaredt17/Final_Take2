<?php
/**
 *  Script for setting up database and tables.
 *  Set database name in config.php
 *  Tables created (Users, Comments, Followers)
 */
require('config.php');

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully<br />";

// Create database
$sql = "CREATE DATABASE " . $dbname;
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br />";
} else {
    echo "Error creating database: " . $conn->error . "<br />";
}

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo 'Connected successfully to database<br />';

// Create <Users> table
$sql = "CREATE TABLE users (
        userid INT AUTO_INCREMENT, 
        username VARCHAR(30) NOT NULL,
        email VARCHAR(50) NOT NULL,
        password VARCHAR(60) NOT NULL,
        reg_date TIMESTAMP,
        city VARCHAR(30) NOT NULL,
        coutnry VARCHAR(5) NOT NULL,
        PRIMARY KEY(userid),
        UNIQUE(email))";

if ($conn->query($sql) === TRUE) {
    echo "Table <Users> created successfully<br />";
} else {
    echo "Error creating table: " . $conn->error . "<br />";
}

// Create <Comments> table
$sql = "CREATE TABLE comments (
        commentid INT AUTO_INCREMENT,
        userid INT NOT NULL,
        comment VARCHAR(200) NOT NULL,
        commentdate TIMESTAMP,
        likes INT(11) NOT NULL,
        PRIMARY KEY (commentid),
        FOREIGN KEY (userid) REFERENCES Users(userid));";

if ($conn->query($sql) === TRUE) {
    echo "Table <Comments> created successfully<br />";
} else {
    echo "Error creating table: " . $conn->error . "<br />";
}

// Create <Followers> table
$sql = "CREATE TABLE followers (
        follower_userid INT NOT NULL,
        following_userid INT NOT NULL,
        followerdate TIMESTAMP,
        CONSTRAINT pk_Followerid PRIMARY KEY (follower_userid, following_userid),
        FOREIGN KEY (follower_userid) REFERENCES Users(userid),
        FOREIGN KEY (following_userid) REFERENCES Users(userid))";

if ($conn->query($sql) === TRUE) {
    echo "Table <Followers> created successfully<br />";
} else {
    echo "Error creating table: " . $conn->error . "<br />";
}


// Create <profileimg> table
$sql = "CREATE TABLE profileimg (
    id int(11) not null PRIMARY KEY AUTO_INCREMENT,
    userid int(11) not null, 
    status int(11) not null
    );";

if ($conn->query($sql) === TRUE) {
echo "Table <Followers> created successfully<br />";
} else {
echo "Error creating table: " . $conn->error . "<br />";
}



//Insert test <User>
$sql = "INSERT INTO Users (userid, username, email, password, reg_date) 
        VALUES ('1', 'john123', 'john@example.com', 'password', CURRENT_TIMESTAMP)";

if ($conn->query($sql) === TRUE) {
    echo "New <User> record created successfully<br />";
} else {
    echo "Error: " . $sql . " " . $conn->error . "<br />";
}

//Insert test <Comment>
$sql = "INSERT INTO Comments (commentid, userid, comment, commentdate) VALUES ('1', '1', 'Hello World!', CURRENT_TIMESTAMP)";
if ($conn->query($sql) === TRUE) {
    echo "New <Comments> record created successfully<br />";
} else {
    echo "Error: " . $sql . " " . $conn->error . "<br />";
}

$conn->close();
?>