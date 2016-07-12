

</div>
</header>
<div class="col_12 column">
    <!-- Menu Horizontal -->
    <ul class="menu">
        <?php

        $obecna_strona = basename($_SERVER["SCRIPT_FILENAME"]);

        ?>
        <li class="<?php if ($obecna_strona == "index.php") echo 'current';?>"><a href="index.php" class="current"><i class="fa fa-home"></i> Strona główna</a></li>
        <li class="<?php if ($obecna_strona == "jobs.php") echo 'current';?>"><a href="jobs.php"><i class="fa fa-desktop"></i> Ogłoszenia</a></li>
        <?php if($_SESSION['zalogowany'] == 'nie') { ?>
        <li class="<?php if ($obecna_strona == "register.php") echo 'current';?>"><a href="register.php"><i class="fa fa-user"></i> Zarejestruj się</a></li>
        <li class="<?php if ($obecna_strona == "login.php") echo 'current';?>"><a href="login.php"><i class="fa fa-key"></i> Zaloguj się</a></li>
        <?php } else if($_SESSION['zalogowany'] == 'tak') { ?>
        <?php if($_SESSION['user_type'] != 'Admin') {?>
            <li class="<?php if ($obecna_strona == "editjob.php") echo 'current';?>"><a href="editjob.php"><i class="fa fa-edit"></i> Twoje oferty</a></li>
            <?php } ?>
            <?php if($_SESSION['user_type'] == 'Admin') {?>
            <li class="<?php if ($obecna_strona == "editjob.php") echo 'current';?>"><a href="editjob.php"><i class="fa fa-edit"></i> Zarządzaj ofertami</a></li>
                <?php } ?>
        <li><a href="index.php?status=1"><i class="fa fa-sign-out"></i> Wyloguj się</a></li>
        <?php } ?>
    </ul>



</div>

