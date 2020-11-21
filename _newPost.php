
<?php
if (session_status() < 2) {
    session_start();
}

$post_errors = [];

function checkpost()
{
    $sanitize_title = trim(filter_input(INPUT_POST, 'post_title', FILTER_SANITIZE_STRING));
    $sanitize_content = trim(filter_input(INPUT_POST, 'post_content', FILTER_SANITIZE_STRING));

    global $post_errors;

    if (empty($sanitize_title)) {
        $post_errors[10] = "Title Cant be Empty";
    }
    if (empty($sanitize_content)) {
        $post_errors[11] = "Your Post has no content";
    }
    if ($_FILES['post_file']['size'] > 1) {
        global $post_errors;
        $check = getimagesize($_FILES["post_file"]["tmp_name"]);
        if (!$check) {
            $post_errors[6] = "File is not an image.";
        }

        if ($_FILES['post_file']['size'] > 5000000) {
            $post_errors[7] = "Max Image size is 5 Mega";
        }
    }

    if (!$post_errors) {

        if ($_FILES['post_file']['size'] > 0) {
            $target_dir = "uploads/";
            $img =  basename(date("mdhisa")) . $_FILES["post_file"]["name"];  // to make sure that we dont get the same file name twice
            $target_file = $target_dir . $img;
        }

        if (move_uploaded_file($_FILES["post_file"]["tmp_name"], $target_file)) {
            // echo "The file " . basename($_FILES["post_file"]["name"]) . " has been uploaded.";
        } else {
            global $post_errors;
            $post_errors[5] = "Sorry, there was an error uploading your file.";
        }
        global $link;

        $escape_title = mysqli_real_escape_string($link, $sanitize_title);
        $escape_content = mysqli_real_escape_string($link, $sanitize_content);

        if (!isset($_POST['post_edit'])) {


            $inserter = "INSERT INTO posts (`post_authorid`, `post_author`, `post_title`, `post_content`, `post_image`) VALUES ('$_SESSION[user_id]','$_SESSION[user_name]','$escape_title','$escape_content','$img');";
            mysqli_query($link, $inserter);
            header('Location: index.php?post_added=true'); // sends user to homepage + show message that post was added
        } elseif (!empty($_GET['post_id'])) {

            if (empty($_FILES["post_file"]["tmp_name"])) {
                $editor = "UPDATE `posts` SET `post_title`='$escape_title',`post_content`='$escape_content' WHERE `post_id`= '$_GET[post_id]';";
            } else {
                delete_image_db();
                $editor = "UPDATE `posts` SET `post_title`='$escape_title',`post_content`='$escape_content',`post_image`='$img' WHERE `post_id`= '$_GET[post_id]';";
            }
            mysqli_query($link, $editor);
            header('Location: index.php?post_edited=true'); // sends user to homepage + show message that post was edited
        }
    }
}
