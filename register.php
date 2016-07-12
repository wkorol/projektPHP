<?php include "gora.php" ?>

<?php include "navbar.php" ?>
<?php include "baza_danych.php" ?>


<div class="col_12 column">

    <form action="register.php" id="reg_form" method="post">
        <fieldset>
            <legend>Załóż konto</legend>
            <p>
                <label for="imie">Imię</label>
                <input type="text" name="imie" id="imie">

            </p>
            <p>
                <label for="nazwisko">Nazwisko</label>
                <input type="text" name="nazwisko" id="nazwisko">

            </p>

            <p>
                <label for="login">Login</label>
                <input type="text" name="login" id="login">

            </p>

            <p>
                <label for="email">Email</label>
                <input type="email" name="email" id="email">

            </p>
            <p>
                <label for="haslo">Hasło</label>
                <input type="password" name="haslo" id="haslo">
            </p>
            <p>
                <label for="haslo_powt">Powtórz hasło</label>
                <input type="password" name="haslo_powt" id="haslo_powt">
            </p>
            <p>
                <input type="submit" value="Zarejestruj" name="submit">
            </p>

            <?php
            $imie = $_POST['imie'];
            $nazwisko = $_POST['nazwisko'];
            $username = $_POST['login'];
            $password = $_POST['haslo'];
            $rep_password = $_POST['haslo_powt'];
            $email = $_POST["email"];




            $niepowodzenie = 0;


            if (isset($_POST['submit'])) {
                if ($password != $rep_password) {
                    echo 'Hasła, które podałeś nie zgadzają się<br>';
                    $niepowodzenie = 1;
                }

                if (empty($imie)) {
                    echo 'Wprowadź imię!<br>';
                    $niepowodzenie = 1;
                }

                if (empty($nazwisko)) {
                    echo 'Wprowadź nazwisko!<br>';
                    $niepowodzenie = 1;
                }

                if (empty($username)) {
                    echo 'Wprowadź login!<br>';
                    $niepowodzenie = 1;
                }

                if (empty($email)) {
                    echo 'Wprowadź email!<br>';
                    $niepowodzenie = 1;
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo 'Nieprawidłowy adres email<br>';
                    $niepowodzenie = 1;
                }

                if (empty($password)) {
                    echo 'Wprowadź hasło!<br>';
                    $niepowodzenie = 1;
                }
                if ($niepowodzenie == 0) {
                    $zapytanie = mysqli_query($polaczenie, "SELECT * FROM users WHERE email='" . $email . "'");
                    if (mysqli_num_rows($zapytanie) > 0) {
                        echo 'Użytkownik o podanym mailu istnieje w bazie danych<br>';
                        $niepowodzenie = 1;
                    } else {
                        $zapytanie = mysqli_query($polaczenie, "SELECT * FROM users WHERE username='" . $login . "'");
                        if (mysqli_num_rows($zapytanie) > 0) {
                            echo 'Użytkownik o podanym loginie istnieje w bazie danych<br>';
                            $niepowodzenie = 1;
                        }
                    }
                }

                if ($niepowodzenie == 0) {
                    $hash = "$2y$10$";
                    $salt = "iusesomecrazystrings22";
                    $hashF_and_salt = $hash . $salt;
                    $password = crypt($password, $hashF_and_salt);

                   

                    $query = "INSERT INTO users(imie, nazwisko, email, username, password, role, created) VALUES('$imie', '$nazwisko', '$email', '$username', '$password', 'Pracodawca', 'NOW() + INTERVAL 1 HOUR')";
                    $result = mysqli_query($polaczenie, $query);
                    if ($result) {
                        echo 'Zostałeś zarejestrowany!';
                    } else {
                        echo 'Błąd';
                    }
                }

            }


            ?>

        </fieldset>
    </form>

</div>


</div>

<?php include "footer.php"; ?>
