<?php
include "baza_danych.php";

?>

<?php include "gora.php" ?>


<?php include "navbar.php" ?>




    <div class="col_12">

<h3 class="left">Oferty</h3>
<ul id="lista">
    <?php
    $sprawdz = $_GET['status'];
    $id_delete = $_GET['id_action'];
    $wynik = mysqli_query($polaczenie, "SELECT user_id FROM jobs WHERE id=$id_delete");
    $id = mysqli_fetch_assoc($wynik);
    if ($sprawdz == 1 && (($_SESSION['zalogowany'] == 'tak' && ($_SESSION['user_id'] == $id['user_id'])) || $_SESSION['user_type'] == 'Admin')) {



        echo '<h5 style="text-align: center;">Czy napewno chcesz usunąć tą ofertę?</h5>';
        echo '<form method="post">';
        echo '<div class="center">';
        echo '<button class="medium green" name="tak">Tak</button>';
        echo ' ';
        echo '<button class="medium red" name="nie">Nie</button>';
        echo '</form>';
        echo '</div>';

        if(isset($_POST['tak'])) {
            echo $id_delete;
            mysqli_query($polaczenie, "DELETE FROM jobs WHERE id=$id_delete");
            header('Location: editjob.php');
        }
        else if (isset($_POST['nie'])){
            header('Location: editjob.php');
        }




    }
    else if ($sprawdz == 2) {
    echo '<h1 style="text-align: center;">Zostałeś zalogowany!</h1>';
    $_SESSION['zalogowany'] = 'tak';
    header("Refresh:2; url=index.php");
    } else {
    ?>

    <?php
    $id_user = $_SESSION['user_id'];
    if($_SESSION['user_type'] != 'Admin')
    $zapytanie = "SELECT * FROM jobs WHERE user_id=$id_user ORDER BY created DESC";
    else
        $zapytanie = "SELECT * FROM jobs ORDER BY created DESC";
        $wynik = mysqli_query($polaczenie, $zapytanie);
    ?>
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
                            href="details.php?id=' . $wiersz['id'] . '&poprz=3"><i class="fa fa-plus"></i>Czytaj więcej </a><br>';
            if ($_SESSION['user_type'] == 'Admin' || $_SESSION['user_id'] == $wiersz['user_id']) {
                echo '<form action="editjob.php?id_action=' . $wiersz['id'] . '&status=1" method="post">';
                echo '<button class="small red" name="delete"><i class="fa fa-remove"></i></button>';
                echo '</form>';
                echo '</div>';

                ?>
                <?php


            }
        }
                ?>

                 </li>

            <?php
        }


    ?>




    </div>



<?php include "footer.php"; ?>