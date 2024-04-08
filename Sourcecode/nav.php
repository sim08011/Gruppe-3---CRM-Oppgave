<nav>
    <a href="index.php"><h2>Hjem</h2></a> <!-- Lenke til startsiden -->
    <a href="login.php"><h2><?php  session_start();  if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == true){echo "Logg ut";} else{echo "Logg inn";}  ?></h2></a> <!-- Lenke til innloggingssiden. Teksten endres basert på om brukeren er logget inn eller ikke -->
</nav>

<style>
    nav {
        overflow: hidden;
        padding: 5px;
        background-color: #FFF;
        position: fixed;
        top: 0;
        width: 100%;
        border-bottom: 2px solid #000;
        margin-bottom: 25px;
    }

    nav a {
        float: left;
        display: block;
        color: #000;
        text-align: center;
        text-decoration: none;
        padding-right: 50px;
        padding-left: 50px;
    }

    nav a:hover {
        background: #ddd;
        color: black;
    }
</style>
