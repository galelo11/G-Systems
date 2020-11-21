<!-- uses posts.css -->
<?php
require_once "_head.php";
require "_newPost.php";
validate_user();

if (isset($_POST['post_edit']) || (isset($_POST['post_submit']))) {
    isloggedin();
    check_token();
    checkpost();
}
?>

<body>
    <!-- View post -->
    <?php if (isset($_GET['view_post'])) : ?>
        <?php fetch_post_by_id(); ?>


        <div style=" margin-top: 20px;" class="user_panel">
            <div class="user_panel_head">
                <h2 style="color:RGB(70,130,180)">View Post</h2>
            </div><br>
            <img src="uploads/<?= $getimg['user_img'];  ?>" alt="">
            <p style="text-align:left;" class="posts_create"><?= $results['post_author']  . " Date : " . $results['post_created']  ?> </p>
            <?php if (isset($_SESSION['user_name'])  && $results['post_author'] == $_SESSION['user_name']) : ?>
            <?php endif; ?>
            <br><br>
            <h2 class="posts_title"> <?= $results['post_title'] ?> </h2>
            <br>
            <p class="posts_content"> <?= $results['post_content'] ?> </p><br>
            <hr><br>
            <?php if (!empty($results['post_image'])) : ?>
                <img class="posts_image" src="uploads/<?= $results['post_image'] ?>"><br>

            <?php endif; ?>
        </div>

    <?php endif; ?>



    <!-- End of View post -->


    <!-- edit post -->
    <?php if (isset($_GET['post_id'])) : ?>
        <?php fetch_post_by_id();   ?>
        <?php if ($_SESSION['user_name'] !== $results['post_author']) {
            header('Location:index.php');
        } ?>
        <div style="margin-top: 20px;" class="user_panel">

            <form name="edit_post" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="token" value="<?= get_token(); ?>">
                <div class="user_panel_head">
                    <h2 style="color:RGB(70,130,180)">Edit Post</h2>
                </div><br>
                <label class="new_post_user" for=""> <?= "Editing post # " . $_GET['post_id'] ?></label><br>
                <label class="account_input_label" for="">Post Title</label> <input class="account_input" type=" text" name="post_title" id="" placeholder="Post Tittle" value="<?= $results['post_title']  ?>">
                <?php echo isset($post_errors[10]) ? "<p class='register_error' >$post_errors[10]</p>" : ""; ?>
                <br>
                <label class="account_input_label" for="">Post Content</label> <textarea class="account_input" name="post_content" id="" cols="70" rows="3" placeholder="Post Content" value=""><?= $results['post_content'] ?></textarea>
                <?php echo isset($post_errors[11]) ? "<p class='register_error' >$post_errors[11]</p>" : ""; ?><br>
                <?php if (!empty($results['post_image'])) : ?>
                    <img class="posts_image" src="uploads/<?= $results['post_image'] ?? "" ?>"><br>
                <?php endif; ?>

                Change Image: (max 5 mb) <input type="file" class="new_post_file" name="post_file" id=""><br>
                <?php echo isset($post_errors[5]) ? "<p class='register_error' >$post_errors[5]</p>" : ""; ?>
                <?php echo isset($post_errors[6]) ? "<p class='register_error' >$post_errors[6]</p>" : ""; ?>
                <?php echo isset($post_errors[7]) ? "<p class='register_error' >$post_errors[7]</p>" : ""; ?>
                <button class="small_btn" name="post_edit" value="post" type="submit">Edit Post</button><br>


            </form>
        </div>
    <?php endif; ?>
    <!--end of edit post -->


    <!-- add new post -->
    <?php if (isset($_GET['post_new'])) : ?>
        <div style=" margin-top: 20px;" class="user_panel">
            <form name="new_post" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="token" value="<?= get_token(); ?>">

                <div class="user_panel_head">
                    <h2 style="color:black;background-color: rgb(164, 233, 61);">New Post</h2>
                </div><br>

                <label class="new_post_user" for=""> <?= "New Post By : " . $_SESSION['user_name'] ?></label>
                <br>
                <label class="account_input_label" for="">Post Title</label> <input class="account_input" type=" text" name="post_title" id="" placeholder="Post Tittle" value="<?= $_POST['post_title'] ?? ""  ?>"> <br>
                <?php echo isset($post_errors[10]) ? "<p class='register_error' >$post_errors[10]</p>" : ""; ?><br>

                <label class="account_input_label" for="">Post Content</label> <textarea class="account_input" name="post_content" id="" cols="70" rows="3" placeholder="Post Content" value=""><?= $_POST['post_content'] ?? ""  ?></textarea>
                <?php echo isset($post_errors[11]) ? "<p class='register_error' >$post_errors[11]</p>" : ""; ?>
                <br>
                Select image to upload: (max 5 mb) <input type="file" class="new_post_file" name="post_file" id=""><br>
                <?php echo isset($post_errors[5]) ? "<p class='register_error' >$post_errors[5]</p>" : ""; ?>
                <?php echo isset($post_errors[6]) ? "<p class='register_error' >$post_errors[6]</p>" : ""; ?>
                <?php echo isset($post_errors[7]) ? "<p class='register_error' >$post_errors[7]</p>" : ""; ?>
                <button class="small_btn" class="new_post_submit" name="post_submit" value="post" type="submit">Create Post</button><br>


            </form>
        </div>
    <?php endif; ?>
    <!--end of add new post -->


    <!--delete post -->
    <?php

    if (isset($_POST['delete'])) {

        isloggedin();
        check_token();
        delete_post_by_id();
    }
    ?>
    <?php if (isset($_GET['delete_id'])) : ?>

        <?php fetch_post_by_id();  ?>
        <?php if ($_SESSION['user_name'] !== $results['post_author']) {
            header('Location:index.php');
        } ?>
        <form action="" method="post">
            <input type="hidden" name="token" value="<?= get_token(); ?>">
            <h3 class="notify_red">Are you sure you want to delete this post? <button type="submit" value="yes" name="delete">Yes</button> </h3>
        </form>
        <?php if (isset($_SESSION['user_name'])) :  ?>
            <div style=" margin-top: 20px;" class="user_panel">
                <div class="user_panel_head">
                    <h2 style="color:RGB(70,130,180)">Delete Post</h2>
                </div><br>
                <p style="text-align:left;" class="posts_create"><?= $results['post_author'] . " Date : " . $results['post_created']  ?> </p>
                <?php if (isset($_SESSION['user_name'])  && $results['post_author'] == $_SESSION['user_name']) : ?>
                <?php endif; ?>
                <h2 class="posts_title"> <?= $results['post_title'] ?> </h2><br>
                <p class="posts_content"> <?= $results['post_content'] ?> </p><br>
                <hr><br>
                <?php if (!empty($results['post_image'])) : ?>
                    <img class="posts_image" src="uploads/<?= $results['post_image'] ?>"><br>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <!--end of  delete post -->
</body>





<?php require "_footer.php";




?>