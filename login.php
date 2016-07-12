<?php include "baza_danych.php" ?>
<?php include "gora.php" ?>

<?php include "navbar.php" ?>


<div class="col_12 column">

    <form action="login.php" id="reg_form" method="post">
        <fieldset>
            <legend>Zaloguj się</legend>
            <p>
                <label for="login">Login</label>
                <input type="text" name="login" id="login">

            </p>
            <p>
                <label for="haslo">Hasło</label>
                <input type="password" name="haslo" id="haslo">
            </p>

            <p>
                <input type="submit" value="Zaloguj" name="submit">
            </p>

            <?php
            if (isset($_POST['submit'])) {
                $login = $_POST['login'];
                $password = $_POST['haslo'];
                mysqli_real_escape_string($polaczenie, $login);
                mysqli_real_escape_string($polaczenie, $password);

                if (empty($login) || empty($password)) {
                    echo 'Pola nie mogą być puste!<br>';

                } else {
                    $query = "SELECT * FROM users WHERE username='". $login ."'";
                    $wynik = mysqli_query($polaczenie, $query);

                    if (mysqli_num_rows($wynik) == 0) {
                        echo 'Nie znaleziono użytkownika o podanym loginie!<br>';
                    } else {
                        $znaleziony = mysqli_fetch_assoc($wynik);
                        if(password_verify($password, $znaleziony['password']) == 0) {
                            echo 'Niepoprawne hasło dla użytkownika ' . $znaleziony['username'];


                        }
                        else {
                            echo 'Zostałeś zalogowany!<br>';
                            $_SESSION['zalogowany'] = 'tak';
                            $_SESSION['user_id'] = $znaleziony['id'];
                            $_SESSION['user_email'] = $znaleziony['email'];
                            $_SESSION['user_type'] = $znaleziony['role'];
                            header('Location: index.php?status=2');

                        }
                    }
                }
            }


            ?>

        </fieldset>
    </form>

</div>


</div>

<?php include "footer.php"; ?>
