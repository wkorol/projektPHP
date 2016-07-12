<?php
include "baza_danych.php";

?>

<?php include "gora.php" ?>


<?php include "navbar.php" ?>
<?php

$kategorie_zapytanie = "SELECT * FROM categories";
$wynik_kategorie = mysqli_query($polaczenie, $kategorie_zapytanie);

?>

<div class="col_12">
<?php
$sprawdz = $_GET['status'];
if ($sprawdz == 1) {


    $user_id = $_SESSION['user_id'];
    $firma = $_POST['firma'];
    $kategoria = $_POST['kategoria_wybierz'];
    $tytul = $_POST['tytul'];
    $lokalizacja = $_POST['lokalizacja'];
    $opis = $_POST['opis'];
    $opis = nl2br($opis);
    $typ = $_POST['wymiar'];
    $wojewodztwo = $_POST['wojewodztwo'];
    $user_email = $_SESSION['user_email'];
    //Zabezpieczenie przed 'wstrzykiwaniem kodu' do bazy danych
    mysqli_real_escape_string($polaczenie, $firma);
    mysqli_real_escape_string($polaczenie, $tytul);
    mysqli_real_escape_string($polaczenie, $lokalizacja);
    mysqli_real_escape_string($polaczenie, $opis);

    $niepowodzenie = 0;

    if (isset($_POST['submit'])) {
        if ($kategoria == 0) {
            echo 'Nie wybrałeś żadnej kategorii!<br>';
            $niepowodzenie = 1;
        }

        if (empty($firma)) {
            echo 'Nazwa firmy nie może być pusta!<br>';
            $niepowodzenie = 1;
        }

        if (empty($tytul)) {
            echo 'Tytuł nie może być pusty!<br>';
            $niepowodzenie = 1;
        }

        if (empty($lokalizacja)) {
            echo 'Lokalizacja nie może być pusta!<br>';
            $niepowodzenie = 1;
        }

        if ($wojewodztwo == '0') {
            echo 'Nie wybrałeś województwa!<br>';
            $niepowodzenie = 1;
        }

        if (empty($opis)) {
            echo 'Opis nie może być pusty!<br>';
            $niepowodzenie = 1;
        }

        if(empty($typ)) {
            echo 'Nie wybrałeś wymiaru pracy!<br>';
            $niepowodzenie = 1;

        }
        if($niepowodzenie == 1)
        echo '<a href="addjob.php">Powrót</a>';
    }

    if($niepowodzenie == 0) {
    $zapytanie = "INSERT INTO jobs(category_id, user_id, type_id, company_name, title, description, city, wojewodztwo, contact_email, created) VALUES ($kategoria,$user_id,$typ,'$firma','$tytul','$opis','$lokalizacja','$wojewodztwo','$user_email',NOW() + INTERVAL 1 HOUR)";
    $wynik = mysqli_query($polaczenie, $zapytanie);
    echo '<h1 style="text-align: center;">Dodano ofertę</h1>';
    header("Refresh:2; url=index.php");
    }
}
else {
?>

<form action="addjob.php?status=1" method="post">
    <fieldset>
        <legend>Dodaj ofertę pracy</legend>
        <p>
            <label for="kategoria_wybierz">Kategoria</label>
            <select id="kategoria_wybierz" name="kategoria_wybierz" style="width: 600px; height: 30px; margin: 0;">
                <option value="nie">Wybierz kategorię</option>

                <?php while ($wiersze_kategorie = mysqli_fetch_assoc($wynik_kategorie)) echo '<option value=' . $wiersze_kategorie['id'] . '>' . $wiersze_kategorie['name'] . '</option>';
                mysqli_data_seek($wynik_kategorie, 0); ?>


            </select>
        </p>
        <p>
            <label for="firma">Nazwa firmy</label>
            <input type="text" name="firma" id="firma" style="width: 600px;">
        </p>
        <p>
            <label for="tytul">Tytuł ogłoszenia</label>
            <input type="text" name="tytul" id="tytul" style="width: 600px;">

        </p>
        <p>
            <label for="lokalizacja">Lokalizacja</label>
            <input type="text" name="lokalizacja" id="lokalizacja" style="width: 600px;">

        </p>

        <p>
            <label for="wojewodztwo">Województwo</label>
            <select id="wojewodztwo" name="wojewodztwo" style="width: 600px; height: 30px;">
                <option value="0">Wybierz województwo</option>
                <option>Dolnośląskie</option>
                <option>Kujawsko-Pomorskie</option>
                <option>Lubelskie</option>
                <option>Lubuskie</option>
                <option>Łódzkie</option>
                <option>Małopolskie</option>
                <option>Mazowieckie</option>
                <option>Opolskie</option>
                <option>Podkarpackie</option>
                <option>Podlaskie</option>
                <option>Pomorskie</option>
                <option>Śląskie</option>
                <option>Świętokrzyskie</option>
                <option>Warmińsko-Mazurskie</option>
                <option>Wielkopolskie</option>
                <option>Zachodniopomorskie</option>

            </select>

        </p>

        <p>
            <label for="login">Opis pracy</label>
            <textarea name="opis" style="width: 600px; resize: none"></textarea>

        </p>

        <p>
            <label for="email">Wybierz wymiar pracy</label>
            <select name="wymiar" id="wymiar" style="   height: 30px; width: 600px;">
                <option value="0">Wybierz</option>
                <option value="1">Pełny etat</option>
                <option value="2">Pół etatu</option>
            </select>

        </p>
        <p>
            <input type="submit" value="Dodaj ofertę" name="submit">
        </p>
        <?php


        }
        ?>


    </fieldset>
</form>
    </div>

<?php include "footer.php"; ?>


