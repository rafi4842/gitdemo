<?php
// This file will check the current disk usage with the du command and save it to a text file. It will also remove itself once complete. 
// Run the du -sch command and have it append to the disk-usage.txt file. 
$cmd = "du -sch >> disk-usage.txt";
shell_exec($cmd);

//Find the URL being used in the request
$url = 'http://' . $_SERVER['HTTP_HOST'];            // Get the server
$url .= rtrim(dirname($_SERVER['PHP_SELF']), '/\\'); // Get the current directory
$url .= '/disk-usage.txt?nocache'; // <-- add the file name at the end - this is a static file so varnish WILL cache it - added ?nocache to bypass

// removes the file by filename used (you can change the name, and it will still find it)
header('Location: ' . $url);  // redirect to the file before removing script
unlink(__FILE__);  // removes the file
?>