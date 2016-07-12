<?php
session_start();
if(!isset($_SESSION['zalogowany'])) {
    $_SESSION['zalogowany'] = 'nie';
}

?>

<!DOCTYPE html>
<html lang="pl">
<html>

<head>
    <!-- META -->
    <title>SzukajPracy | Witamy!</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content=""/>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/kickstart.css" media="all"/>
    <link rel="stylesheet" type="text/css" href="style.css" media="all"/>

    <!-- Javascript -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/kickstart.js"></script>
</head>
<body>

<div id="container" class="grid">
    <header>
        <div class="col_6 column">
            <h1><a href="index.php"><strong>Szukaj</strong>Pracy</a></h1>
        </div>
        <div class="col_6 column right">
            <form action="" id="add_job_link">
                <button class="large green" name="dodaj" formmethod="post"><i class="fa fa-plus"></i> Dodaj ofertę<br></button>

            </form>
<?php
if(isset($_POST['dodaj'])) {
    if($_SESSION['zalogowany'] == 'nie') {
        print '<div class="notice error zmniejsz"><i class="fa fa-remove"></i> Najpierw się zaloguj!
<a href="#close" class="icon-remove"></a></div>';;
    }
    else {
        header("Location: addjob.php");
    }
}

?>