<?php
/*
-----------------------------------------------------------------------------------------------------------------
START OF DEMO SCRIPT CODE. THIS CODE IS ONLY USED BY DEMO SCRIPT. YOU DO NOT NEED TO ADD THIS CODE TO YOUR SCRIPT.
-----------------------------------------------------------------------------------------------------------------
*/

//Set demo script name
$DEMO_PRODUCT_NAME="Demo Script (Full)";

//Set original product name
$ORIGINAL_PRODUCT_NAME="Auto PHP Licenser";

//Set original product url
$ORIGINAL_PRODUCT_URL="https://1.envato.market/c/1289024/275988/4415?u=https%3A%2F%2Fcodecanyon.net%2Fitem%2Fauto-php-licenser%2F19720092";

//Set default date to prevent errors from being displayed if user's server requires default date to be set
date_default_timezone_set(date_default_timezone_get());

/*
-----------------------------------------------------------------------------------------------------------------
END OF DEMO SCRIPT CODE. THIS CODE IS ONLY USED BY DEMO SCRIPT. YOU DO NOT NEED TO ADD THIS CODE TO YOUR SCRIPT.
-----------------------------------------------------------------------------------------------------------------
*/

/*
-----------------------------------------------------------------------------------------------------------------
START OF CODE TO INCLUDE REQUIRED FILES. YOU SHOULD ADD THIS CODE TO YOUR SCRIPT.
-----------------------------------------------------------------------------------------------------------------
*/

// //Load file with Auto PHP Licenser settings
// require_once("SCRIPT/apl_core_configuration.php");

// //Load file with Auto PHP Licenser functions
// require_once("SCRIPT/apl_core_functions.php");

/*
-----------------------------------------------------------------------------------------------------------------
END OF CODE TO INCLUDE REQUIRED FILES. YOU SHOULD ADD THIS CODE TO YOUR SCRIPT.
-----------------------------------------------------------------------------------------------------------------
*/

/*
-----------------------------------------------------------------------------------------------------------------
START OF OPTIONAL AUTO PHP LICENSER SECURITY CHECKS. THIS IS USEFUL FOR EXTRA PROTECTION.
-----------------------------------------------------------------------------------------------------------------
*/

//Check if configuration file is genuine
// if (APL_INCLUDE_KEY_CONFIG!="8dfc17e8f55b8fc9") //Secret key modified
//     {
//     echo "Unauthorized modification detected at SCRIPT/apl_core_configuration.php file.";
//     exit();
//     }   
    
//Check if hash value of "SCRIPT/apl_core_functions.php" matches previously calculated value
// if (md5_file("SCRIPT/apl_core_functions.php")!="a8473d2f3cf256eed870c3fc05a7777f") //Checksum doesn't match
//     {

//     echo "Unauthorized modification detected at SCRIPT/apl_core_functions.php file.";
//     exit();
//     }

/*
-----------------------------------------------------------------------------------------------------------------
END OF OPTIONAL AUTO PHP LICENSER SECURITY CHECKS. THIS IS USEFUL FOR EXTRA PROTECTION.
-----------------------------------------------------------------------------------------------------------------
*/
?>


@include('vendor.license.SCRIPT.apl_core_configuration')
@include('vendor.license.SCRIPT.apl_core_functions')
