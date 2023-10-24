<?php
require_once("konf.php");
session_start();
if (!isset($_SESSION["error"])) {
    $_SESSION["error"] = "";
}
if (!isset($_SESSION["admin"])) {
    $_SESSION["admin"] = false;
}


if(!empty($_REQUEST["korras_id"])){
    //uuendab tabeliandmed --> slaalom=1
    global $yhendus;
    $kask=$yhendus->prepare(
        "UPDATE jalgrattaeksam SET slaalom=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["korras_id"]);
    $kask->execute();
}
if(!empty($_REQUEST["vigane_id"])){
    //uuendab tabeliandmed --> slaalom=2 kui vajutakse ebaõnnestunud
    $kask=$yhendus->prepare(
        "UPDATE jalgrattaeksam SET slaalom=2 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["vigane_id"]);
    $kask->execute();
}
//veebileht kuvab ainult need kellel teooriatulemus>=9 AND slaalom=-1
$kask=$yhendus->prepare("SELECT id, eesnimi, perekonnanimi   FROM jalgrattaeksam 
                                    WHERE teooriatulemus>=9 AND slaalom=-1 OR slaalom=2");
$kask->bind_result($id, $eesnimi, $perekonnanimi);
$kask->execute();
?>
<!doctype html>
<html lang="et">
<head>
    <title>Slaalom</title>
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
<h1>Slaalom</h1>
<table>
    <?php
    while($kask->fetch()){
        echo " 
 <tr> 
 <td>$eesnimi</td> 
 <td>$perekonnanimi</td> 
 <td> 
 <a href='?korras_id=$id'>Korras</a>
 <a href='?vigane_id=$id'>Ebaõnnestunud</a> 
 </td> 
</tr> 
 ";
    }
    ?>
</table>
</body>
</html>
