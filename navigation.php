<nav class="nav">
    <?php
    echo '<a href="registr.php" class="active">Registreerimine</a>';
    echo '<a href="teooria.php">Teooriaeksam</a>';
    echo '<a href="slaloom.php">Slaalom</a>';
    echo '<a href="lubadeleht.php">Lubadeleht</a>';
    ?>
</nav>
<style>
    .nav {
        font-family: Arial, sans-serif;
        font-weight: bold;
        font-size: 1.2em;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #222;
        padding: 10px;
    }

    .nav a {
        color: #fff;
        text-decoration: none;
        margin-right: 10px;
        padding: 10px;
    }
    .nav a:hover {
        transition: 0.25s;
        background-color: #444;
    }
</style>