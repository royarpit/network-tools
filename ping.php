<html>
<head>
    <title>Ping and Trace Route Tool</title>
</head>
<body>
<form method="post" action="">
    Enter the destination Domain Name or IP Address :- <br>
    <input type="text" name="ip" value="<?php if(isset($_POST['ip'])){echo $_POST['ip'];} ?>"> <br><br>
    <button type="submit" name="ping">Ping</button><br>
    <button type="submit" name="tracert">Trace Route</button><br>
    <button type="submit" name="mac">Get your MAC Address</button><br>
    <button type="submit" name="ipconfig">Basic IP Configuration</button><br>
    <button type="submit" name="ipconfig/all">Detailed IP Configuration</button><br>
</form>
</body>
</html>

<?php
set_time_limit(90);

if(isset($_POST['ping']))
   echo "<pre>".shell_exec('ping "'.$_POST['ip'].'"')."</pre>";

if(isset($_POST['tracert']))
    echo "<pre>".shell_exec('tracert -d "' . $_POST['ip'] . '"')."</pre>";

if(isset($_POST['ipconfig']))
    echo "<pre>".shell_exec('ipconfig')."</pre>";

if(isset($_POST['ipconfig/all']))
    echo "<pre>".shell_exec('ipconfig /all')."</pre>";

if(isset($_POST['mac']))
{
    $ipconfig = shell_exec('ipconfig/all');

    for($i=0;$i<strlen($ipconfig);$i++)
    {
        if($i == strpos($ipconfig,': Media disconnected'))
        {
            $ipconfig = substr($ipconfig,$i+=250);
            $i = 0;
        }
        else if($i == strpos($ipconfig,'Physical Address'))  //Physical Address. . . . . . . . . : 60-45-CB-BF-E0-8B
        {
            echo "MAC Address of your device \"";
            for($j=36+strpos($ipconfig,'Description');$j<$i-4;$j++)
                echo $ipconfig[$j];
            echo "\" is ";
            for($j=36+$i;$j<strpos($ipconfig,'DHCP Enabled');$j++)
                echo $ipconfig[$j];
            echo "<br>";
            $ipconfig = substr($ipconfig,strpos($ipconfig,'DHCP Enabled'));
        }
    }
}
?>