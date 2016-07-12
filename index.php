<?php
include "baza_danych.php";

?>

<?php include "gora.php" ?>


<?php include "navbar.php" ?>


<div class="col_12">


    <?php
    $sprawdz = $_GET['status'];
    if ($sprawdz == 1) {
        echo '<h1 style="text-align: center;">Zostałeś wylogowany</h1>';
        $_SESSION['zalogowany'] = 'nie';
        header("Refresh:2; url=index.php");
    }
    else if ($sprawdz == 2) {
        echo '<h1 style="text-align: center;">Zostałeś zalogowany!</h1>';
        $_SESSION['zalogowany'] = 'tak';
        header("Refresh:2; url=index.php");
    }
    else {
    $zapytanie = "SELECT * FROM jobs ORDER BY created DESC LIMIT 5";
    $wynik = mysqli_query($polaczenie, $zapytanie);
    ?>
    <h3>5 Ostatnio dodanych ofert</h3>
    <ul id="lista">
        <?php

        while ($wiersz = mysqli_fetch_assoc($wynik)) {
            ?>


            <li>
                <div class="type hide-phone">
                    <?php
                    if ($wiersz['category_id'] == 1)
                        echo '<span class="green">Pełny etat</span>';
                    else
                        echo '<span class="blue">Pół etatu</span>';
                    ?>

                </div>


                <h5><?php echo substr($wiersz['company_name'],0,10) . ' - ' . $wiersz['title'] . ', ' . $wiersz['city'] . ', ' . $wiersz['wojewodztwo']; ?></h5>
                <?php echo 'Dodano: ' . $wiersz['created']; ?>
                <?php

                echo '<div class="description">' . substr($wiersz['description'], 0, 50) . '...';
                echo '<a
                            href="details.php?id=' . $wiersz['id'] . '&poprz=1"><i class="fa fa-plus"></i>Czytaj więcej </a><br>';
                if ($_SESSION['user_type'] == 'Admin' || $_SESSION['user_id'] == $wiersz['user_id']) {
                    echo '<form action="index.php?id_action=' . $wiersz['id'] . '" method="post">';


                    ?>


            </li>

            <?php
        }

        } }


        ?>

</div>


<?php include "footer.php"; ?>
