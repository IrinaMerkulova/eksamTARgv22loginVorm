<?php
require_once("konf.php");
session_start();
if (!isset($_SESSION["error"])) {
    $_SESSION["error"] = "";
}
if (!isset($_SESSION["admin"])) {
    $_SESSION["admin"] = false;
}


if(!empty($_REQUEST["vormistamine_id"])){
    global $yhendus;
    $kask=$yhendus->prepare(
        "UPDATE jalgrattaeksam SET luba=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["vormistamine_id"]);
    $kask->execute();
}
$kask=$yhendus->prepare(
    "SELECT id, eesnimi, perekonnanimi, teooriatulemus,  
 slaalom, ringtee, t2nav, luba FROM jalgrattaeksam;");
$kask->bind_result($id, $eesnimi, $perekonnanimi, $teooriatulemus,   $slaalom, $ringtee, $t2nav, $luba);
$kask->execute();

function asenda($nr){
    if($nr==-1){return ".";} //tegemata
    if($nr== 1){return "korras";}
    if($nr== 2){return "ebaõnnestunud";}
    return "Tundmatu number";
}
?>
<!doctype html>
<html>
<head>
    <title>Lõpetamine</title>
</head>
<body>
<header>
    <h1>Jalgrattaeksam</h1>
    <header>
        <?php
        if(isset($_SESSION['kasutaja'])){
            ?>
            <h1>Tere, <?="$_SESSION[kasutaja]"?></h1>
            <a href="logout.php">Logi välja</a>
            <?php
        } else {
            ?>
            <a href="login.php">Logi sisse</a>
            <?php
        }
        ?>
    </header>
<nav>
    <?php
    include ('navigation.php');
    ?>
</nav>
<h1>Lõpetamine</h1>
    <?php
    if (isset($_SESSION["kasutaja"])) {
    ?>
    <table>
        <tr>
            <th>Eesnimi</th>
            <th>Perekonnanimi</th>
            <th>Teooriaeksam</th>
            <th>Slaalom</th>
            <th>Ringtee</th>
            <th>Tänavasõit</th>
            <th>Lubade väljastus</th>
        </tr>
        <?php
        while($kask->fetch()){
            $asendatud_slaalom=asenda($slaalom);
            $asendatud_ringtee=asenda($ringtee);
            $asendatud_t2nav=asenda($t2nav);
            $loalahter=".";
            if($luba==1){$loalahter="Väljastatud";}
            if($luba==-1 and $t2nav==1 and $_SESSION['admin']==true){
                $loalahter="<a href='?vormistamine_id=$id'>Vormista load</a>";
            }
            echo " 
 <tr> 
 <td>$eesnimi</td> 
 <td>$perekonnanimi</td> 
 <td>$teooriatulemus</td> 
 <td>$asendatud_slaalom</td> 
 <td>$asendatud_ringtee</td> 
 <td>$asendatud_t2nav</td> 
 <td>$loalahter</td> 
 </tr> 
 ";
        }

        }
    ?>
</table>
</body>
</html>
