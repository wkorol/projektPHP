<?php
include "baza_danych.php";

?>
<?php include "gora.php" ?>

<?php include "navbar.php" ?>

<?php include "funkcje.php" ?>

<?php

$kategorie_zapytanie = "SELECT * FROM categories ORDER BY name ASC";
$wynik_kategorie = mysqli_query($polaczenie, $kategorie_zapytanie);

?>

    <div id="search_area" class="col_12 column">
        <form action="jobs.php" class="horizontal" method="post">
            <input type="text" id="keywords" placeholder="Czego szukasz?" name="szukaj">
            <select id="wojewodztwo_wybierz" name="wojewodztwo_wybierz">
                <option value="nie">Wybierz województwo</option>
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

            <select id="kategoria_wybierz" name="kategoria_wybierz">
                <option value="nie">Wybierz kategorię</option>
                <?php pokazKategorie_1(); ?>



            </select>

            <button type="submit" name="submit">Szukaj</button>


        </form>


    </div>

    <div id="category_block" class="col_12 column">

        <h3>Wybierz kategorię</h3>
        <ul>
            <?php pokazKategorie_2(); ?>
        </ul>




    </div>





    <div class="col_12 column">

        <?php
        $zapytanie_koncowe = "";
        if(isset($_POST['submit'])) {
            $tekst = $_POST['szukaj'];
            if($tekst != NULL) {

                $zapytanie_koncowe = "SELECT * FROM jobs WHERE (title LIKE '%$tekst%' OR company_name LIKE '%$tekst%') ";
                if($_POST['wojewodztwo_wybierz'] != 'nie') {
                    $wojewodztwo = $_POST['wojewodztwo_wybierz'];

                    $zapytanie_koncowe .= "AND  wojewodztwo='$wojewodztwo' ";
                }

                if($_POST['kategoria_wybierz'] != 'nie') {
                    $kategoria = $_POST['kategoria_wybierz'];

                    $zapytanie_koncowe .= "AND  category_id=$kategoria";
                }
                $znaleziono = 1;
            }
            else {

                $zapytanie_koncowe = "SELECT * FROM jobs";


                if($_POST['wojewodztwo_wybierz'] != 'nie') {
                    $wojewodztwo = $_POST['wojewodztwo_wybierz'];

                    $zapytanie_koncowe .= " WHERE wojewodztwo='$wojewodztwo' ";
                }

                if($_POST['kategoria_wybierz'] != 'nie') {
                    $kategoria = $_POST['kategoria_wybierz'];
                    if($_POST['wojewodztwo_wybierz'] != 'nie')
                    $zapytanie_koncowe .= "AND  category_id=$kategoria";
                    else
                        $zapytanie_koncowe .= " WHERE category_id=$kategoria";
                }
                $znaleziono = 1;
            }

            $zapytanie_koncowe .= " ORDER BY created DESC";

            $wynik_szukaj = mysqli_query($polaczenie, $zapytanie_koncowe);



            ?>
            <?php if($znaleziono == 1) { ?>
            <h3>Wyszukane prace</h3>
            <ul id="lista">
            <?php

            $wiersze_szukaj = mysqli_fetch_assoc($wynik_szukaj);
            if($wiersze_szukaj == NULL) {
                echo '<div class="notice warning"><i class="icon-warning-sign icon-large"></i> Nie ma takich ofert prac!
<a href="#close" class="icon-remove"></a></div>';
            } else {
                mysqli_data_seek($wynik_szukaj,0);
            while($wiersze_szukaj = mysqli_fetch_assoc($wynik_szukaj)) {



                ?>

                <li>
                    <div class="type hide-phone">
                        <?php
                        if ($wiersze_szukaj['category_id'] == 1)
                            echo '<span class="green">Pełny etat</span>';
                        else
                            echo '<span class="blue">Pół etatu</span>';
                        ?>

                    </div>


                    <h5><?php echo $wiersze_szukaj['company_name'] . ' - ' . $wiersze_szukaj['title'] . ', ' . $wiersze_szukaj['city'] . ', ' . $wiersze_szukaj['wojewodztwo']; ?></h5>
                    <?php echo 'Dodano: ' . $wiersze_szukaj['created']; ?>
                    <?php

                    echo '<div class="description">' . substr($wiersze_szukaj['description'], 0, 50) . '...';
                    echo '<a
                            href="details.php?id=' . $wiersze_szukaj['id'] . '&poprz=2"><i class="fa fa-plus"></i>Czytaj więcej </a>';
                    echo '</div>';



                    ?>



                </li>


                <?php
            } }



            ?>
                </ul>
              <?php }  ?>




        <?php } else {?>



                <?php
                if(isset($_GET['search_cat'])) {
                    $kategoria_id = $_GET['search_cat'];
                    $zapytanie_szukaj_kat = "SELECT * FROM jobs WHERE category_id='$kategoria_id' ORDER BY created DESC";
                    $wynik_szukaj_kat = mysqli_query($polaczenie, $zapytanie_szukaj_kat);
                }

                $wiersze_szukaj_kat = mysqli_fetch_assoc($wynik_szukaj_kat);
                if($wiersze_szukaj_kat == NULL) {
            echo '<ul id="lista">';

                    if(!$kategoria_id) {
                    echo '<div class="notice warning" style="text-align: center;"><i class="icon-warning-sign icon-large"></i> Wybierz kategorię aby wyświetlić wszystkie dostępne w niej oferty pracy, lub wyszukaj wyżej.
                       <a href="#close" class="icon-remove"></a></div>';
                    }
                    else {
                        echo '<div class="notice warning rozszerz" style="text-align: center;"><i class="icon-warning-sign icon-large"></i> W tej kategorii nie ma żadnych ofert
                       <a href="#close" class="icon-remove"></a></div>';

                    }
                } else {
                   $zapytanie = "SELECT name FROM categories WHERE id=$kategoria_id";
                    $result = mysqli_query($polaczenie, $zapytanie);
                    $name =  mysqli_fetch_assoc($result);



                    echo '<h3>Prace w kategorii '.$name['name'].'</h3>';
                    echo '<ul id="lista">';

                    mysqli_data_seek($wynik_szukaj_kat,0);


                    while($wiersze_szukaj_kat = mysqli_fetch_assoc($wynik_szukaj_kat)) {



                        ?>

                        <li>
                            <div class="type hide-phone">
                                <?php
                                if ($wiersze_szukaj_kat['category_id'] == 1)
                                    echo '<span class="green">Pełny etat</span>';
                                else
                                    echo '<span class="blue">Pół etatu</span>';
                                ?>

                            </div>


                            <h5><?php echo substr($wiersze_szukaj_kat['company_name'],0,10) . ' - ' . $wiersze_szukaj_kat['title'] . ', ' . $wiersze_szukaj_kat['city'] . ', ' . $wiersze_szukaj_kat['wojewodztwo']; ?></h5>
                            <?php echo 'Dodano: ' . $wiersze_szukaj_kat['created']; ?>
                            <?php

                            echo '<div class="description">' . substr($wiersze_szukaj_kat['description'], 0, 50) . '...';
                            echo '<a
                            href="details.php?id=' . $wiersze_szukaj_kat['id'] . '&poprz=2"><i class="fa fa-plus"></i>Czytaj więcej </a>';
                            echo '</div>';



                            ?>



                        </li>


                        <?php
                    } }



                ?>
            </ul>


            <?php } ?>


</div>

<?php include "footer.php"; ?>
