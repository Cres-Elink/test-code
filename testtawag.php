<?php

$number = "7360";
$key= "grasya";
$pass= "grasya";
if($key == $pass)
{
#ip address that asterisk is on.

$strHost = "192.168.2.178";//test
$port = "5038";// port AMI 

$strUser = "cresmanager"; //specify the asterisk manager username you want to login with

$strSecret = $pass;#specify the password for the above user

#specify the channel (extension) you want to receive the call requests with
#e.g. SIP/XXX, IAX2/XXXX, ZAP/XXXX, etc
# $strChannel = "SIP/100";
$strChannel = "PJSIP/".$number;

$strContext = "default";
#specify the amount of time you want to try calling the specified channel before hanging up
$strWaitTime = "30";
#specify the priority you wish to place on making this call
$strPriority = "1";
#specify the maximum amount of retries
$strMaxRetry = "2";

//$//redir = htmlentities($_GET['rdr']);

//echo $number;
//return;
$pos=strpos ($number,"local");
if ($number == null) :
exit() ;
endif ;
if ($pos===false) :
$errno=0 ;
$errstr=0 ;
$strCallerId = "Web Call $number";
//$oSocket = fsockopen ("localhost", 8080, $errno, $errstr, 20);
$oSocket = fsockopen ("192.168.2.178", "5038", $errno, $errstr, 20);
if (!$oSocket) {
echo "$errstr ($errno)<br>\n";
} else {


//user credentials
fputs($oSocket, "Action: login\r\n");
fputs($oSocket, "Username: $strUser\r\n");
fputs($oSocket, "Secret: $strSecret\r\n\r\n");
//event filter
fputs($oSocket, "Action: Events\r\n");
fputs($socket, "Eventmask: on\r\n\r\n");
fputs($oSocket, "Events: on\r\n");
//
$response = fgets($socket, 4096);
if (strpos($response, "Event: Newchannel") !== false) {
    // Handle incoming call event
    // Extract relevant information from the response
    $channel = 'betty colon'; // channel name
    $callerid = 'some id'; // caller ID
    $context = 'default'; // context
    $extension = 'ext ari dri'; // extension

    // Do something with the information, such as send a notification
    // via email, SMS, or push notification
    // ...

    // Break out of the loop to wait for the next incoming call event
    
}else{
     echo "kalooy way tawag hahaha";
}
fputs($oSocket, "Action: originate\r\n");
fputs($oSocket, "Channel: $strChannel\r\n");
fputs($oSocket, "WaitTime: $strWaitTime\r\n");
fputs($oSocket, "CallerId: $strCallerId\r\n");
fputs($oSocket, "Exten: $number\r\n");
fputs($oSocket, "Context: $strContext\r\n");
fputs($oSocket, "Priority: $strPriority\r\n\r\n");
fputs($oSocket, "Action: Logoff\r\n\r\n");
sleep(2);
fclose($oSocket);
}
$x2 = " Extension $strChannel should be calling$number.";

//$numfor = str_replace(array(' '), '', $number);
$x  = header("Location: sip:$number");


//$redirect = header("Location: $redirecting");//document.location=''//for deploy softphone pwede ni zoiper kung nanay support sa zoiper 
//echo "<script>alert('calling $number using Extension $strChannel'); document.location='sip:$number'; window.location.href='index.php?module=Home';</script>";
echo $x2 ;
// /header("location: ");

else :
exit() ;
endif ;

}
else
{
echo "BAD : login details incorrect";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="tawag" id="">
    </form>
</body>
</html>