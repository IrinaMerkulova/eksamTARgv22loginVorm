<?php
$parool = '123456';
$sool = 'vagavagatekst';
$kryp = crypt($parool, $sool);
echo $kryp;