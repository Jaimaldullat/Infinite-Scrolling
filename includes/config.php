<?php
// Constants for database connectivity
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_DATABSE', 'infinite_scrolling');

// Connect to database
function db_connect(){
    $connection  = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABSE);
    confirm_db_connect();
    return $connection;
}

// Confirm if connection to the database is succeed
function confirm_db_connect(){
    if(mysqli_connect_errno()) {
        echo "Database connetion failed.";
        exit();
    }
}

// Close a connection to the database
function db_disconnect($connection){
    if(isset($connection)){
        mysqli_close($connection);
    }
}

// Global database variable
$db = db_connect();

// Confirm if query is executed successfully
function confirm_result($result_set){
    if(!$result_set) {
        exit("Database query failed.");
    }
}
// Get posts from database
function get_posts($limit = 4, $offset = 0){
    GLOBAL $db;

    $qry = "SELECT * FROM posts ";
    $qry .= "ORDER BY id ASC ";
    $qry .= "LIMIT " . mysqli_real_escape_string($db,$limit) ." ";
    $qry .= "OFFSET " . mysqli_real_escape_string($db,$offset);

    $result = mysqli_query($db, $qry);
    confirm_result($result);
    return $result;
}
?>

