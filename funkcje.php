<?php

function pokazKategorie_1() {
global $wynik_kategorie;
 while($wiersze_kategorie = mysqli_fetch_assoc($wynik_kategorie)) echo '<option value='.$wiersze_kategorie['id'].'>'.$wiersze_kategorie['name'].'</option>';
    mysqli_data_seek($wynik_kategorie, 0);
}

function pokazKategorie_2() {
    global $wynik_kategorie;
    while($wiersze_kategorie = mysqli_fetch_assoc($wynik_kategorie)) echo '<li><a href="jobs.php?search_cat='.$wiersze_kategorie['id'].'">'.$wiersze_kategorie['name'].'</a></li>';
    mysqli_data_seek($wynik_kategorie, 0);
}

//Test
?>
