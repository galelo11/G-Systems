<?php
if (session_status() < 2) {
    session_start();
}

$errors = [];
$patterns = ["str" => "/^[a-zA-Z0-9]+$/", "email" => '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', "pass" => "/^.{5,20}$/"];

function form_validation()
{
    global $patterns;
    global $errors;

    valid_name();


    if (isset($_POST['pass'])) {
        $pass_valid = preg_match($patterns["pass"], $_POST['pass']);
        if (!$pass_valid) {
            $errors[4] = 'The Password is not valid';
        }
    }
    if ($_FILES['post_profile']['size'] > 1) {
        $check = getimagesize($_FILES["post_profile"]["tmp_name"]);
        if (!$check) {
            $errors[5] = "File is not an image.";
        }

        if ($_FILES['post_profile']['size'] > 5000000) {
            $errors[5] = "Max Image size is 5 Mega";
        }
    }
    verify_email();
    checkerrors();
}

function verify_email()
{
    $filter_email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    global $link;
    global $patterns;
    global $errors;
    if (isset($_POST['email'])) {
        $email_valid = preg_match($patterns["email"], $filter_email);
        if (!$email_valid) {
            $errors[2] = 'The E-mail is not valid';
        }
        if ($email_valid) {
            $escape_email = mysqli_real_escape_string($link, $filter_email);

            $selector = "SELECT * FROM users WHERE `user_email` = '$escape_email'";
            $myquery = mysqli_query($link, $selector);
            $results = mysqli_fetch_assoc($myquery);
            if ($results) {
                $errors[3] = 'This E-mail is Already in use';
            }
            if (!$results) {
                return true;
            }
        }
    }
}

function checkerrors()
{
    global $errors;
    if (!$errors) {
        formchecked();
    }
}
function formchecked()
{
    global $link;

    if ($_FILES['post_profile']['size'] > 1) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["post_profile"]["name"]);
        $img = $_FILES["post_profile"]["name"];
        if (move_uploaded_file($_FILES["post_profile"]["tmp_name"], $target_file)) {
            //    echo "The file " . basename($_FILES["post_profile"]["name"]) . " has been uploaded.";
        } else {
            $errors[5] = "Sorry, there was an error uploading your file.";
        }
    } else {
        $img = "profile_" . rand(1, 7) . ".png";
    }

    $sanitize_fname = trim(filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING));
    $filter_email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $escape_fname = mysqli_real_escape_string($link, $sanitize_fname);
    $escape_email = mysqli_real_escape_string($link, $filter_email);

    global $link;
    $pw = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $inserter = "INSERT INTO users (`user_name`, `user_email`, `user_password`, `user_img`) VALUES ('$escape_fname','$escape_email','$pw','$img')";
    mysqli_query($link, $inserter);
    header('Location: account.php?user_login=true&register_success=true');
}
