<?php
/*
-----------------------------------------------------------------------------------------------------------------
START OF DEMO SCRIPT CODE. THIS CODE IS ONLY USED BY DEMO SCRIPT. YOU DO NOT NEED TO ADD THIS CODE TO YOUR SCRIPT.
-----------------------------------------------------------------------------------------------------------------
*/

//MySQL host
$DB_HOST="localhost";

//MySQL username
$DB_USER="root";

//MySQL password
$DB_PASS="Gcb1196@gmail.com";

//MySQL database
$DB_NAME="laravel_new_template";

//MySQL port
$DB_PORT="3306";


//Establish MySQL connection. It should always be local MySQL connection on user's server (never include MySQL credentials of your Auto PHP Licenser installation).
if (!empty($DB_HOST) && !empty($DB_USER) && !empty($DB_NAME) && filter_var($DB_PORT, FILTER_VALIDATE_INT))
    {
    $GLOBALS["mysqli"]=mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
    if (!$GLOBALS["mysqli"])
        {
        echo "Impossible to connect to MySQL database. Check database connection details.";
        exit();
        }
    }
else
    {
    $GLOBALS["mysqli"]=null;
    }

/*
-----------------------------------------------------------------------------------------------------------------
END OF DEMO SCRIPT CODE. THIS CODE IS ONLY USED BY DEMO SCRIPT. YOU DO NOT NEED TO ADD THIS CODE TO YOUR SCRIPT.
-----------------------------------------------------------------------------------------------------------------
*/
