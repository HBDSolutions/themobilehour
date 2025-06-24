<?php
echo "is_readable: ";
var_dump(is_readable('C:\cacert.pem'));
echo "file_exists: ";
var_dump(file_exists('C:\cacert.pem'));
echo "filesize: ";
echo filesize('C:\cacert.pem'), " bytes\n";

// Now test SSL connection
$ch = curl_init("https://repo.packagist.org/packages.json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
if(curl_errno($ch)){
    echo 'Curl error: ' . curl_error($ch);
} else {
    echo "Success!\n";
}
curl_close($ch);
?>