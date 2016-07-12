<?php
include "baza_danych.php";

?>

<?php include "gora.php" ?>


<?php include "navbar.php" ?>


    <div class="col_12 column">


        <form action="details.php" method="get">

            <?php
            $id = $_GET['id'];

            $query = "SELECT * FROM jobs WHERE id=$id";
            $result = mysqli_query($polaczenie, $query);

            $wiersz = mysqli_fetch_assoc($result);



            ?>



        </form>

        <?php if($wiersz == NULL) echo '<h3>Nie znalazłem takiej pracy!</h3>'; else { ?>


        <h3><?php echo $wiersz['company_name'].' - '.$wiersz['title']; ?></h3>
        <ul>
            <li><strong>Lokacja: </strong><?php echo $wiersz['city'].', '.$wiersz['wojewodztwo']; ?></li>
            <li><strong>Wymiar pracy: </strong><?php if($wiersz['type_id'] == 1){ echo 'Pełny etat';} else echo 'Pół etatu' ; ?></li>
            <li><strong>Opis: </strong> <p><?php echo $wiersz['description']; ?></p></li>
            <li><strong>Kontakt Email: </strong><a href="mailto:<?php echo $wiersz['contact_email'];?>"><?php echo $wiersz['contact_email'];?></a></li>
        </ul>

        <?php if($_GET['poprz'] == 1) { ?>
        <p><a href="index.php">Powrót do strony głównej</a></p>
        <?php }  else if($_GET['poprz'] == 2){  ?>
        <p><a href="jobs.php">Powrót do wyszukiwarki</a></p>
        <?php }  else if($_GET['poprz'] == 3){  ?>
            <p><a href="editjob.php">Powrót do edycji ofert</a></p>
        <?php } ?>


            
        </ul>

    </div>
<?php } ?>

</div>

<?php include "footer.php"; ?>
