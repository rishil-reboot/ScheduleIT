<?php
/*
-----------------------------------------------------------------------------------------------------------------
START OF CODE TO INCLUDE REQUIRED FILES. YOU SHOULD ADD THIS CODE TO YOUR SCRIPT.
-----------------------------------------------------------------------------------------------------------------
*/

/*
-----------------------------------------------------------------------------------------------------------------
END OF CODE TO INCLUDE REQUIRED FILES. YOU SHOULD ADD THIS CODE TO YOUR SCRIPT.
-----------------------------------------------------------------------------------------------------------------
*/

/*
-----------------------------------------------------------------------------------------------------------------
START OF DEMO SCRIPT CODE. THIS CODE IS ONLY USED BY DEMO SCRIPT. YOU DO NOT NEED TO ADD THIS CODE TO YOUR SCRIPT.
-----------------------------------------------------------------------------------------------------------------
*/

//Get current url, so user doesn't need to enter it manually
$demo_page_url=str_ireplace('/install.php', '', 'http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

//Get all variables submitted by user
if (!empty($_POST) && is_array($_POST))
    {
    extract(array_map("trim", $_POST), EXTR_SKIP); //automatically make a variable from each argument submitted by user (don't overwrite existing variables)
    }

/*
-----------------------------------------------------------------------------------------------------------------
END OF DEMO SCRIPT CODE. THIS CODE IS ONLY USED BY DEMO SCRIPT. YOU DO NOT NEED TO ADD THIS CODE TO YOUR SCRIPT.
-----------------------------------------------------------------------------------------------------------------
*/

/*
-----------------------------------------------------------------------------------------------------------------
START OF REQUIRED AUTO PHP LICENSER INSTALLATION FUNCTIONS. YOU SHOULD ADD THIS CODE TO YOUR SCRIPT.
-----------------------------------------------------------------------------------------------------------------
*/

if (isset($submit_ok))
    {
    //Function can be provided with root URL of this script, licensed email address/license code and MySQLi link (only when database is used).
    //Function will return array with 'notification_case' and 'notification_text' keys, where 'notification_case' contains action status and 'notification_text' contains action summary.
    set_time_limit(0);
    $license_notifications_array= aplInstallLicense($ROOT_URL, $CLIENT_EMAIL, $LICENSE_CODE);

    if ($license_notifications_array['notification_case']=="notification_license_ok") //'notification_license_ok' case returned - operation succeeded
        {
        $demo_page_message="Demo Script (Minimal) is installed and ready to use!";
        }
    else //Other case returned - operation failed
        {
        $demo_page_message="Demo Script (Minimal) installation failed because of this reason: ".$license_notifications_array['notification_text'];
        }
    }

/*
-----------------------------------------------------------------------------------------------------------------
END OF REQUIRED AUTO PHP LICENSER INSTALLATION FUNCTIONS. YOU SHOULD ADD THIS CODE TO YOUR SCRIPT.
-----------------------------------------------------------------------------------------------------------------
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Install License - Demo Script (Minimal) - Auto PHP Licenser</title>
</head>
<body>
    <?php if (!empty($demo_page_message)) {echo "<center><b>$demo_page_message</b></center><br><br>";} ?>
    <center><form action="<?php echo basename(__FILE__); ?>" method="post">
        Licensed email address (for personal license)<br>
        <input type="email" name="CLIENT_EMAIL" size="50"><br><br>
        License code (for anonymous license)<br>
        <input type="text" name="LICENSE_CODE" size="50"><br><br>
        Installation URL (without / at the end)<br>
        <input type="text" name="ROOT_URL" size="50" value="<?php echo $demo_page_url; ?>"><br><br>
        <button type="submit" name="submit_ok">Submit</button><br>
    </form></center>
</body>
</html>
