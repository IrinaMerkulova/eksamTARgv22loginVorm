<?php
require_once("konf.php");
session_start();
if (!isset($_SESSION["error"])) {
    $_SESSION["error"] = "";
}
if (!isset($_SESSION["admin"])) {
    $_SESSION["admin"] = false;
}


if(!empty($_REQUEST["teooriatulemus"])  ) {
            //näitab ainult need õpilased kellel tulemus on sisestamata
        global $yhendus;
        $kask = $yhendus->prepare(
            "UPDATE jalgrattaeksam SET teooriatulemus=? WHERE id=?");
        $kask->bind_param("ii", $_REQUEST["teooriatulemus"], $_REQUEST["id"]);
        $kask->execute();
    }
$kask=$yhendus->prepare("SELECT id, eesnimi, perekonnanimi   FROM jalgrattaeksam WHERE teooriatulemus=-1");
$kask->bind_result($id, $eesnimi, $perekonnanimi);
$kask->execute();
?>
<!doctype html>
<html lang="et">
<head>
    <title>Teooriaeksam</title>
</head>
<body>
<header>
    <h1>Jalgrattaeksam</h1>

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
<h1>Teooriaeksami tulemuste sisestamine</h1>
<table>
    <?php
    while($kask->fetch()){
        echo " 
 <tr> 
 <td>$eesnimi</td> 
 <td>$perekonnanimi</td> 
 <td><form action=''> 
 <input type='hidden' name='id' value='$id' /> 
 <input type='text' name='teooriatulemus' />
 <input type='submit' value='Sisesta tulemus' /> 
 </form> 
 </td> 
</tr> 
 ";
    }
    ?>
</table>
</body>
</html>