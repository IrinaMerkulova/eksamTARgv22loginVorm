<?php
require_once("konf.php");
session_start();
if (!isset($_SESSION["error"])) {
    $_SESSION["error"] = "";
}
if (!isset($_SESSION["admin"])) {
    $_SESSION["admin"] = false;
}

if(isSet($_REQUEST["sisestusnupp"]) && isset($_SESSION["kasutaja"])){
    if (preg_match('#[0-9]#',$_REQUEST["perekonnanimi"])
        || preg_match('#[0-9]#',$_REQUEST["eesnimi"])
        || empty($_REQUEST["eesnimi"])
        || empty($_REQUEST["perekonnanimi"])){
        echo "Valesti sisestatud ees või perekonnanimi!";
    } else {
    global $yhendus;
    $kask=$yhendus->prepare(
        "INSERT INTO jalgrattaeksam(eesnimi, perekonnanimi) VALUES (?, ?)");
    $kask->bind_param("ss", $_REQUEST["eesnimi"], $_REQUEST["perekonnanimi"]);
    $kask->execute();
    $yhendus->close();
    header("Location: $_SERVER[PHP_SELF]?lisatudeesnimi=$_REQUEST[eesnimi]");
    header("Location:teooria.php");
    exit();
}
}
?>
<!doctype html>
<html>
<head>
    <title>Kasutaja registreerimine</title>
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
    <?php
    if (isset($_SESSION['kasutaja'])){

    ?>

<form action="?">
    <dl>
        <dt>Eesnimi:</dt>
        <dd><input type="text" name="eesnimi" /></dd>
        <dt>Perekonnanimi:</dt>
        <dd><input type="text" name="perekonnanimi" /></dd>
        <dt><input type="submit" name="sisestusnupp" value="sisesta" /></dt>  </dl>
</form>

<?php
if(isSet($_REQUEST["lisatudeesnimi"])){
    echo "Lisati $_REQUEST[lisatudeesnimi]";
}
?>
        <?php
    } ?>
</body>
</html>