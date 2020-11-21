<?php
$link = mysqli_connect("127.0.0.1", "root", "", "G-systems");
if (!$link) {
    echo "error connecting to database! wrong ip|name|pass";
    error_log("error connecting to database! wrong ip|name|pass", 0);
}
mysqli_query($link, 'SET NAMES UTF8');




function isloggedin()
{
    if (empty($_SESSION['user_id'])) {
        session_destroy();
        header('Location: index.php');
    }
}
function validate_user()
{
    if (isset($_SESSION['user_id'])) {
        if (
            $_SESSION['user_ip'] != $_SERVER['REMOTE_ADDR'] ||
            $_SESSION['user_agent'] != $_SERVER['HTTP_USER_AGENT']
        ) {
            session_destroy();
            header('Location: index.php');
            echo 'user Verfication Failed';
            error_log("user Verfication Failed", 0);
            die();
        }
        return true;
    }
}

function check_token()
{
    if (
        empty($_SESSION['token']) ||
        empty($_POST['token']) ||
        $_SESSION['token'] !== $_POST['token']
    ) {
        session_destroy();
        header('Location: index.php');
        echo 'token Verfication Failed';
        error_log("token Verfication Failed", 0);
        die();
    }
}

function get_token()
{
    return $_SESSION['token'] = uniqid('token_', true);
}


// query // 
$errors = [];
$login_errors = [];
$getimg;
function fetch_post_by_id()
{

    if (isset($_GET['post_id'])) {
        $postid = $_GET['post_id'];
    }
    if (isset($_GET['delete_id'])) {
        $postid = $_GET['delete_id'];
    }
    if (isset($_GET['view_post'])) {
        $postid = $_GET['view_post'];
    }

    global $results;
    global $link;

    $selector = "SELECT * FROM `posts` WHERE `post_id` = $postid;";
    $myquery = mysqli_query($link, $selector);
    $results = mysqli_fetch_assoc($myquery);

    if (isset($_GET['view_post']) || (isset($_GET['post_id']))) {
        global $getimg;
        $selector1 = "SELECT `user_img` FROM `users` WHERE `user_id` = $results[post_authorid];";
        $myquery1 = mysqli_query($link, $selector1);
        $getimg = mysqli_fetch_assoc($myquery1);
    };
}

function delete_image_db()
{
    global $results;
    global $link;

    $selector = "SELECT * FROM `posts` WHERE `post_id` =  $_GET[post_id];";
    $myquery = mysqli_query($link, $selector);
    $results = mysqli_fetch_assoc($myquery);

    $dir = 'uploads';
    $filename = "/$results[post_image]";

    if (!file_exists($dir)) {
        error_log("Failed to find main uploads directory!", 0);
    } else {
        error_log("success to find main uploads directory!", 0);
        if (is_writable($dir)) {
            if (file_exists($dir . $filename)) {
                if (is_writable($dir . $filename)) {
                    error_log("$dir . $filename Has been removed from db", 0);
                    unlink($dir . $filename);
                }
            } else {
                error_log("file is not writeable or file not found!", 0);
            }
        }
    }
}




function delete_post_by_id()
{
    global $link;
    $remover = "DELETE FROM posts WHERE post_id = $_GET[delete_id] LIMIT 1;";
    mysqli_query($link, $remover);
}


function delete_all_posts_by_userid()
{
    global $link;
    $remover = "DELETE FROM `posts` WHERE `post_authorid` = $_SESSION[user_id]";
    mysqli_query($link, $remover);
}

function  delete_account_by_userid()
{
    global $link;
    $remover = "DELETE FROM `users` WHERE `user_id` = $_SESSION[user_id]";
    mysqli_query($link, $remover);
}

function verify_password()
{
    global $link;
    global $pass_verify;
    global $login_errors;
    $pass_selector = "SELECT `user_password` FROM users where `user_id` = '$_SESSION[user_id]';";
    $pass_query = mysqli_query($link, $pass_selector);
    if (mysqli_num_rows($pass_query)) {  // to make sure we got an email/pw match
        $pass_result = mysqli_fetch_assoc($pass_query);
        $pass_verify = password_verify("$_POST[pass]", "$pass_result[user_password]");
    }
    if (!$pass_verify) {
        $login_errors[3] = "Wrong password";
    }
    // eco $pass_verify to cofirm match or no match
}


function update_name()
{
    global $link;

    $sanitize_fname = trim(filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING));
    $escape_fname = mysqli_real_escape_string($link, $sanitize_fname);


    $updater = "UPDATE `users` SET `user_name`= '$escape_fname' WHERE `user_id` = '$_SESSION[user_id]'";
    mysqli_query($link, $updater);
    $_SESSION['user_name'] = $escape_fname;
}



function update_email()
{
    global $link;
    $filter_email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $escape_email = mysqli_real_escape_string($link, $filter_email);

    $updater = "UPDATE `users` SET `user_email`= '$escape_email' WHERE `user_email` = '$_SESSION[user_email]'";
    mysqli_query($link, $updater);
    $_SESSION['user_email'] = $escape_email;
}


function update_pass()
{
    global $link;


    $pw = password_hash($_POST['new_pass'], PASSWORD_DEFAULT);
    $escape_pass = mysqli_real_escape_string($link, $pw);

    $updater = "UPDATE `users` SET `user_password`= '$escape_pass' WHERE `user_email` = '$_SESSION[user_email]'";
    mysqli_query($link, $updater);
}

function valid_name()
{
    global $errors;
    global $fname_valid;
    global $patterns;

    if (isset($_POST['fname'])) {
        $fname_valid = preg_match($patterns["str"], $_POST['fname']);
        if (!$fname_valid) {
            $errors[1] = 'The first name is not valid';
        } elseif ($fname_valid) {
            return true;
        }
    }
}


function valid_email()
{ // compares format with pattern 
    global $patterns;
    global $login_errors;

    $filter_email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (isset($filter_email)) {
        $email_valid = preg_match($patterns["email"], $filter_email);
        if (!$email_valid) {
            $login_errors[1] = 'The E-mail is not valid';
        }
    }
}





function valid_pass()
{ // compares format with pattern 
    global $patterns;
    global $login_errors;


    if (isset($_POST['pass']) || isset($_POST['new_pass'])) {
        if (isset($_POST['pass'])) {
            $password = $_POST['pass'];
        } elseif (isset($_POST['new_pass'])) {
            $password = $_POST['new_pass'];
        }
        $pass_valid = preg_match($patterns["pass"], $password);
        if (!$pass_valid) {
            $login_errors[2] = 'The Password is not valid';
        }
    }
}


function update_profile_img()
{
    global $errors;
    if ($_FILES['post_file']['size'] > 1) {

        $check = getimagesize($_FILES["post_file"]["tmp_name"]);
        if (!$check) {
            $errors[6] = "File is not an image.";
        }

        if ($_FILES['post_file']['size'] > 5000000) {
            $errors[7] = "Max Image size is 5 Mega";
        }
    }

    if (!$errors) {
        runquer();
    }
}

function runquer()
{
    global $errors;
    if ($_FILES['post_file']['size'] > 1) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["post_file"]["name"]);
        $img = $_FILES["post_file"]["name"];
        if (move_uploaded_file($_FILES["post_file"]["tmp_name"], $target_file)) {

            global $link;
            $updater = "UPDATE `users` SET `user_img`= '$img' WHERE `user_email` = '$_SESSION[user_email]'";
            mysqli_query($link, $updater);
            $_SESSION['user_img'] = $_FILES["post_file"]["name"];
            header("Refresh:0; url=editprofile.php");
        } else {
            $errors[5] = "Sorry, there was an error uploading your file.";
        }
    }
}


function useportrait()
{
    global $link;
    $img = "profile_" . $_GET['portrait'] . ".png";
    $updater = "UPDATE `users` SET `user_img`= '$img' WHERE `user_email` = '$_SESSION[user_email]'";
    mysqli_query($link, $updater);
    $_SESSION['user_img'] = $img;
    header("Refresh:0; url=editprofile.php");
}

function submit_contact()
{
    global $link;

    $filter_email1 = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $escape_email1 = mysqli_real_escape_string($link, $filter_email1);

    $sanitize_title1 = trim(filter_input(INPUT_POST, 'contact_title', FILTER_SANITIZE_STRING));
    $escape_title1 = mysqli_real_escape_string($link, $sanitize_title1);

    $sanitize_content1 = trim(filter_input(INPUT_POST, 'contact_content', FILTER_SANITIZE_STRING));

    $escape_content1 = mysqli_real_escape_string($link, $sanitize_content1);



    $inserter = "INSERT INTO `contact`(`contact_email`, `contact_title`, `contact_content`) VALUES ('$escape_email1','$escape_title1','$escape_content1');";
    mysqli_query($link, $inserter);
    header("Refresh:0; url=info.php?contact_us=true&form_sent=true");
}
