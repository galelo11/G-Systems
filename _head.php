<!-- uses style.css -->
<!-- uses profiles.css -->

<?php
if (session_status() < 2) {
    session_start();
}
require "_config.php";
?>

<!DOCTYPE html>
<html lang="en">
<meta content="width=device-width, initial-scale=1" name="viewport" />

<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">

    <div id="main-head">
        <a href="index.php">
            <h1 class="main-logo">G-Blog</h1>
        </a>
        <a href="index.php">
            <h1 class="mobile-logo">G</h1>
        </a>

        <?php if (!isset($_SESSION['user_name'])) :  ?>
            <div>
                <ul class="pos_right">
                    <li> <a href="account.php?user_login=true">Login</a>
                    <li> <a href="account.php?user_register=true">Register</a>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_name'])) :  ?>
            <img onclick="userprofilemore()" class="login_img" src="uploads/<?= $_SESSION["user_img"] ?>" alt="">
            <div class="profile_hidden">
                <h1 class="profile_item"><?= $_SESSION['user_name'] ?></h1>
                <hr>
                <a class="profile_item" href="editprofile.php">
                    Edit Profile
                </a>
                <hr>
                <a class="profile_item" href="index.php?logout=true">
                    Sign Out
                </a>

            </div>
        <?php endif; ?>

        </ul>
    </div>
    <div onclick="mobilemenu()" class="mobile-button">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="mobile-menu">
        <ul>

            <li><a href="info.php?about_us=true">About</a></li>
            <li><a href="info.php?contact_us=true">Contact us</a></li>
        </ul>

    </div>

</head>