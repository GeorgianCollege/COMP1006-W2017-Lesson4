<?php
// connection string

/*Add at the begining of the file*/

$connectstr_dbhost = '';
$connectstr_dbname = '';
$connectstr_dbusername = '';
$connectstr_dbpassword = '';

foreach ($_SERVER as $key => $value) {
    if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
        continue;
    }

    $connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
    $connectstr_dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
    $connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
    $connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
}

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', $connectstr_dbname);

/** MySQL database username */
define('DB_USER', $connectstr_dbusername);

/** MySQL database password */
define('DB_PASSWORD', $connectstr_dbpassword);

/** MySQL hostname : this contains the port number in this format host:port . Port is not 3306 when using this feature*/
define('DB_HOST', $connectstr_dbhost);

$dsn = 'mysql:host=DB_HOST;dbname=DB_NAME';
$userName = 'DB_USER';
$password = 'DB_PASSWORD';

/* for Heroku
$dsn = 'mysql:host=ryvdxs57afyjk41z.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=g98f1x54cht5g0ms';
$userName = 's969adv5fd5oyr79';
$password = 'gvwp5mzeiarwhaa6';
*/

// exception handling - use a try / catch
try {
    // instantiates a new pdo - an db object
    $db = new PDO($dsn, $userName, $password);

}
catch(PDOException $e) {
    $message = $e->getMessage();
    echo "An error occurred: " . $message;
}

$query = "SELECT * FROM games"; // SQL statement
$statement = $db->prepare($query); // encapsulate the sql statement
$statement->execute(); // run on the db server
$games = $statement->fetchAll(); // returns an array
$statement->closeCursor(); // close the connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>COMP1006</title>
    <!-- CSS Section -->
    <link rel="stylesheet" href="./Scripts/lib/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./Scripts/lib/bootstrap/dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="./Scripts/lib/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="./Content/app.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <h1>PHP with MySQL</h1>

            <ul>
                <?php
                foreach($games as $game) {
                    echo '<li>' . $game['Id'] . " " . $game['Name'] . " " . $game['Cost'] .'</li>';
                }
                ?>
            </ul>

        </div>
    </div>
</div>

<!-- JavaScript Section -->
<script src="./Scripts/lib/jquery/dist/jquery.min.js"></script>
<script src="./Scripts/lib/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="./Scripts/app.js"></script>
</body>
</html>
