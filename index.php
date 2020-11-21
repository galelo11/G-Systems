<!-- uses posts.css -->
<?php

require_once "_head.php";

validate_user();

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Refresh:0; url=index.php");
}


// load all posts front page + sort desc or asc according to user

if (empty($_GET['sort']) || ($_GET['sort'] == "new")) {
    $selector = "SELECT * FROM `posts` ORDER BY `post_created` DESC;";
    $myquery = mysqli_query($link, $selector);
} elseif ($_GET['sort'] == "old") {
    $selector = "SELECT * FROM `posts` ORDER BY `post_created` ASC;";
    $myquery = mysqli_query($link, $selector);
} elseif ($_GET['sort'] == "asc") {
    $selector = "SELECT * FROM `posts` ORDER BY `post_title` ASC;";
    $myquery = mysqli_query($link, $selector);
} elseif ($_GET['sort'] == "desc") {
    $selector = "SELECT * FROM `posts` ORDER BY `post_title` DESC;";
    $myquery = mysqli_query($link, $selector);
} elseif ($_GET['sort'] == "user") {
    $selector = "SELECT * FROM `posts` ORDER BY `post_author` ASC;";
    $myquery = mysqli_query($link, $selector);
}

// END OF load all posts front page + sort desc or asc according to user


?>
<?php if (isset($_GET['post_added'])) : ?>
    <h3 class="notify">Your post has been submitted successfully </h3>
<?php endif; ?>
<?php if (isset($_GET['post_edited'])) : ?>
    <h3 class="notify">Your post has been Edited successfully </h3>
<?php endif; ?>




<body>
    <article>
        <div id="main-body">






            <div style="margin-top: 20px;" class="user_panel">

                <div class="home_head">
                    <?php if (!isset($_SESSION['user_name'])) :  ?>
                        <h2> <a style="color:black;" href="account.php?user_register=true">Click here to Join us</a></h2>
                    <?php elseif (isset($_SESSION['user_name'])) :  ?>
                        <h2> <a style="color:black" href="posts.php?post_new=1"> New Post</a></h2>
                    <?php endif; ?>
                </div>
                <br>

                <!-- load posts -->
                <?php if (mysqli_num_rows($myquery)) : ?>
                    <select onchange="post_sort()" id="post_sort">
                        <option default value="0">order by</option>
                        <option value="1">Date Newest</option>
                        <option value="2">Date oldest</option>
                        <option value="3">Title ASC</option>
                        <option value="4">Title DESC</option>
                        <option value="5">User</option>
                    </select>
                <?php else : ?>
                    <h1>No posts yet! be the first to post</h1>
                <?php endif; ?>


                <br><br>
                <?php while ($results = mysqli_fetch_assoc($myquery)) : ?>
                    <div class="editprofile_section">
                        <p style=" text-align:left;margin-left:5px" class="posts_create">Post by : <?= $results['post_author'] .  " | Posted on : " . $results['post_created']   ?> </p><br><br>
                        <h2 class="posts_title"> <?= $results['post_title'] ?> </h2><br>
                        <p class="posts_content"> <?= $results['post_content'] ?> </p>
                        <br>
                        <hr><br>
                        <?php if (!empty($results['post_image'])) : ?>
                            <img class="posts_image" src="uploads/<?= $results['post_image'] ?>"><br>
                        <?php endif; ?>
                        <a class="a_simple" href="posts.php?view_post=<?= $results['post_id']  ?> "><img src=" css\img\view.png" alt="View Post"></a>
                        <?php if (isset($_SESSION['user_name'])  && $results['post_author'] == $_SESSION['user_name']) : ?>
                            <a class=" a_simple" href="posts.php?post_id=<?= $results['post_id'] ?>"><img src="css\img\edit.png" alt="Edit Post"></a>
                            <a class="a_simple" href="posts.php?delete_id=<?= $results['post_id']  ?> " id="deletepost"><img src=" css\img\delete.png" alt="Delete Post"></a>
                            <br><br>
                        <?php endif; ?>

                    </div>

                <?php endwhile; ?>
                <br>
            </div>
            <!--End of load posts -->


    </article>
</body>


<?php

require "_footer.php";
?>