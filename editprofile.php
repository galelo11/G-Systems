<!-- uses profiles.css -->
<?php require "_head.php";
require "_verifyregister.php";
validate_user();
isloggedin();


if (isset($_POST['change_pic'])) {

    if (isset($_GET['portrait'])) {
        if ($_GET['portrait'] > 7) {
            header('Location: index.php');
        } else {
            useportrait();
        }
    } else {
        update_profile_img();
    }
}

if (isset($_POST['delete_allposts'])) {
    verify_password();
    if ($pass_verify) {
        delete_all_posts_by_userid();
    }
}

if (isset($_POST['change_name'])) {
    valid_name();
    if ($fname_valid) {
        update_name();
    }
}

if (isset($_POST['change_email'])) {
    verify_email();
    if (verify_email()) {
        update_email();
    }
}

if (isset($_POST['change_password'])) {
    verify_password();
    valid_pass();
    if ($pass_verify) {
        update_pass();
    }
}

if (isset($_POST['delete_account'])) {
    verify_password();
    if ($pass_verify) {
        delete_account_by_userid();
        session_unset();
        header("Refresh:0; url=index.php");
    }
}
?>




<body>






    <div style="margin-top: 20px;" class="user_panel">

        <div class="user_panel_head">

            <h2><?= ucfirst($_SESSION["user_name"] . "'s Profile") ?></h2>
        </div>
        <br>
        <br>
        <div class="editprofile_section">

            <form action="" method="post" enctype="multipart/form-data">

                <h1>Change Profile Picture</h1>
                <br>
                <?php for ($i = 1; $i < 8; $i++) : ?>
                    <?php if (isset($_GET['portrait'])) : ?>
                        <?php if ($_GET['portrait'] == $i) : ?>
                            <a href="?portrait=<?= $i ?>" style="display: inline-block"> <img class="profile_img_sample selected" src="<?= "uploads/profile_$i.png"  ?>" alt=""></a>
                        <?php else : ?>
                            <a href="?portrait=<?= $i ?>" style="display: inline-block"> <img class="profile_img_sample" src="<?= "uploads/profile_$i.png"  ?>" alt=""></a>
                    <?php endif;
                    endif; ?>
                    <?php if (!isset($_GET['portrait'])) : ?>
                        <a href="?portrait=<?= $i ?>" style="display: inline-block"> <img class="profile_img_sample" src="<?= "uploads/profile_$i.png"  ?>" alt=""></a>
                    <?php endif; ?>
                <?php endfor; ?>
                <br>

                <form action="" method="post" enctype="multipart/form-data">
                    or upload <input type="file" class="new_post_file" name="post_file" id=""><br>
                    <?php echo isset($errors[5]) ? "<p class='register_error' >$errors[5]</p>" : ""; ?>
                    <?php echo isset($errors[6]) ? "<p class='register_error' >$errors[6]</p>" : ""; ?>
                    <?php echo isset($errors[7]) ? "<p class='register_error' >$errors[7]</p>" : ""; ?>
                    <button class="small_btn" name="change_pic" value="true" type="submit">Update Profile Picture</button>
                    <br>
                </form>
        </div>

        <div class="editprofile_section">
            <h1 class="editprofile_h1">Change Name</h1><br>
            <form action="" method="post">
                <label class="account_input_label" for="">New Username</label> <input class="account_input" name="fname" placeholder="Enter Username" type="text">
                <?php echo isset($errors[1]) ? "<p class='register_error' >$errors[1]</p>" : "";
                ?>
                <button class="small_btn" name="change_name" value="true" type="submit">Update Username</button>
            </form>
        </div>

        <div class="editprofile_section">
            <h1 class="editprofile_h1">Update Email Address</h1><br>
            <form action="" method="post">
                <label class="account_input_label" for="">New Email Adress </label> <input class="account_input" name="email" placeholder="Enter email" type="email">
                <?php echo isset($errors[2]) ? "<p class='register_error' >$errors[2]</p>" : "";
                echo isset($errors[3]) ? "<p class='register_error' >$errors[3]</p>" : "";
                ?>
                <button class="small_btn" name="change_email" value="true" type="submit">Update Email Adress</button>
            </form>
        </div>

        <div class="editprofile_section">
            <h1 class="editprofile_h1">Change Password</h1><br>
            <form action="" method="post">
                <label class="account_input_label" for="">Current Password </label> <input class="account_input" name="pass" placeholder="Password" type="password">
                <?php echo isset($login_errors[3]) ? "<p class='register_error' > $login_errors[3]</p>" : ""; ?><br>
                <label class="account_input_label" for="">New Password </label> <input class="account_input" name="new_pass" placeholder="New Password" type="password">
                <?php echo isset($login_errors[2]) ? "<p class='register_error' > $login_errors[2]</p>" : ""; ?>
                <button class="small_btn" name="change_password" type="submit">Change Password</button>
            </form>
        </div>

        <div class="editprofile_section">
            <h1 class="editprofile_h1">Delete All of my posts</h1><br>
            <form action="" method="post">
                <label class="account_input_label" for="">Enter Your Password To Cofirm </label> <input class="account_input" name="pass" placeholder="Password" type="password">
                <?php echo isset($login_errors[3]) ? "<p class='register_error' > $login_errors[3]</p>" : ""; ?>
                <button class="small_btn" name="delete_allposts" value="true" type="submit">Delete all posts</button> <br>
            </form>

        </div>
        <div class="editprofile_section">
            <h1 class="editprofile_h1">Delete Account</h1><br>
            <form action="" method="post">
                <label class="account_input_label" for="">Enter Your Password To Cofirm </label> <input class="account_input" name="pass" placeholder="Password" type="password">
                <?php echo isset($login_errors[3]) ? "<p class='register_error' > $login_errors[3]</p>" : ""; ?>
                <button class="small_btn" name="delete_account" value="true" type="submit">Delete my Account</button> <br>
            </form>
        </div>
        <br>
    </div>


    </div>




</body>


<?php require "_footer.php";

?>