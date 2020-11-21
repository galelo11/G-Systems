<?php
$patterns = ["str" => "/^[a-zA-Z]+-?[a-zA-Z]+$/", "email" => "/^[a-zA-z0-9.-]+\@[a-zA-z0-9.-]+.[a-zA-Z]+$/", "pass" => "/^.{5,20}$/"];
$login_errors = [];




function login_validation()
{
    global $login_errors;

    valid_pass();
    valid_email();

    if (!$login_errors) {
        cleartologin();
    }
}





function cleartologin()
{
    global $link;
    //verify password
    $pass_selector = "SELECT `user_password` FROM users where `user_email` = '$_POST[email]';";
    $pass_query = mysqli_query($link, $pass_selector);
    // echo mysqli_num_rows($pass_query);
    if (mysqli_num_rows($pass_query)) {  // to make sure we got an email/pw match
        $pass_result = mysqli_fetch_assoc($pass_query);
        $pass_verify = password_verify("$_POST[pass]", "$pass_result[user_password]");

        // end of verify password

        if ($pass_verify) {
            $selector = "SELECT * FROM users WHERE (`user_email`,`user_password`) = ('$_POST[email]', '$pass_result[user_password]');";
            $myquery = mysqli_query($link, $selector);

            if (mysqli_num_rows($myquery)) {
                $results = mysqli_fetch_assoc($myquery);
                $_SESSION["user_name"] = $results["user_name"];
                $_SESSION["user_id"] = $results["user_id"];
                $_SESSION["user_img"] = $results["user_img"];
                $_SESSION["user_email"] = $results["user_email"];
                $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
                $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                $_SESSION['token'] = uniqid('token_', true);
                header("Refresh:0");
            }
        } else {
            global $login_errors;
            $login_errors[3] = "Wrong Email or password";
        }
    } else {
        global $login_errors;
        $login_errors[3] = "Wrong Email or password";
    }
}
