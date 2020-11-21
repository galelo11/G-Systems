<!-- uses forms.css -->
<!-- uses profiles.css -->
<?php require "_head.php";
require "_verifylogin.php";
require "_verifyregister.php";
validate_user();

if (isset($_POST["login"])) {
    login_validation();
}



?>

<body>
    <!-- Login form -->
    <?php if (isset($_GET['register_success'])) : ?>
        <h3 class="notify">Account Has been created successfully You may login</h3>
    <?php endif; ?>


    <?php if (isset($_GET['user_login'])) : ?>

        <?php if (!isset($_SESSION['user_name'])) :  ?>
            <div class="user_panel">

                <div class="user_panel_head">
                    <h2>User Login</h2>
                </div>
                <a class="notify" href="account.php?user_register=true">New here ? Register A New Account</a><br><br>
                <input type="hidden" name="token" value="<?= get_token(); ?>">
                <form id="login-form" name="login" action="" method="post">
                    <label class="account_input_label" for="">Email Adress</label><input class="account_input" onkeyup="checkform1()" name="email" id="email" type="email" placeholder="Enter Email" value="<?= $_POST['email'] ?? "";  ?>">
                    <p class="g_vald register_error"></p>

                    <?php echo isset($login_errors[1]) ? "<p class='register_error' >$login_errors[1]</p>" : "";  ?> <br>
                    <label class="account_input_label" for="">Password</label> <input class="account_input" onkeyup="checkform1()" name="pass" id="pass" type="password" placeholder="Password" value="<?= $_POST['pass'] ?? "";  ?>">
                    <p class="g_vald register_error"></p>
                    <?php echo isset($login_errors[2]) ? "<p class='register_error' >$login_errors[2]</p>" : "";  ?>
                    <?php echo isset($login_errors[3]) ? "<p class='register_error' >$login_errors[3]</p>" : ""; ?>
                    <button class="wide_btn" name="login" value="login" type="submit">Log in</button><br>


                </form>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['user_name'])) :  ?>
            <div style="margin-top: 20px;" class="user_panel">
                <div class="user_panel_head">
                    <h2>Logged in as <?= $_SESSION['user_name'] ?> </h2>
                </div>
                <a class="wide_a" href="index.php">Go to Home page to start posting</a>
                <a class="wide_a" href="editprofile.php">Edit your profile</a>
                <a class="wide_a" href="index.php?logout=true">Sign Out</a>
            </div>

    <?php endif;
    endif; ?>
    <!-- End of Login form -->

    <!-- Register form -->
    <?php if (isset($_POST["register"])) {
        form_validation();
    } ?>
    <?php if (isset($_GET['user_register'])) : ?>
        <div class="user_panel">
            <div class="user_panel_head">
                <h2>Create an Account</h2>
            </div>
            <a class="notify" href="account.php?user_login=true">Already have an Account? Sign in</a><br><br>
            <input type="hidden" name="token" value="<?= get_token(); ?>">
            <form id="register-form" name="register" action="" method="post" enctype="multipart/form-data">
                <label class="account_input_label" for="">User Name</label> <input class="account_input" onkeyup="checkform()" name="fname" id="fname" type="text" placeholder="Enter Name" value="<?= $_POST['fname'] ?? "";  ?>">
                <p class="g_vald register_error"></p>
                <?php echo isset($errors[1]) ? "<p class='register_error' >$errors[1]</p>" : "";    ?><br>
                <label class="account_input_label" for="">Email Adress</label><input class="account_input" onkeyup="checkform()" name="email" id="email" type="email" placeholder="Enter Email" value="<?= $_POST['email'] ?? "";  ?>">
                <p class="g_vald register_error"></p>
                <?php echo isset($errors[2]) ? "<p class='register_error' >$errors[2]</p>" : "";
                echo isset($errors[3]) ? "<p class='register_error' >$errors[3]</p>" : ""; ?><br>
                <label class="account_input_label" for="">Password</label><input class="account_input" onkeyup="checkform()" name="pass" id="pass" type="password" placeholder="Password" value="<?= $_POST['pass'] ?? "";  ?>">
                <p class=" g_vald register_error"></p>
                <?php echo isset($errors[4]) ? "<p class='register_error' >$errors[4]</p>" : "";     ?><br>
                <label class="account_input_label" for="">Browse Profile image </label><input class="account_input file_pick" type="file" id="" name="post_profile">
                <?php echo isset($errors[5]) ? "<p class='register_error' >$errors[5]</p>" : ""; ?>
                <button class="wide_btn" name="register" value="register" type="submit">Register</button>
                <?php

                ?>
            </form>
        </div>
    <?php endif; ?>

    <!--End of Register form -->




    <?php require "_footer.php";
    ?>