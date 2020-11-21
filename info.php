<?php

require_once "_head.php";
?>

<?php if (isset($_GET['about_us'])) : ?>
    <div style="margin-top: 20px;" class="user_panel">

        <div class="user_panel_head">
            <h2> About us</h2>
            <br>
            <hr>
            <br>
        </div>

        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet dicta accusantium ducimus perspiciatis non voluptas cupiditate explicabo mollitia dolorem eos, repudiandae accusamus? Ut a ex alias accusantium recusandae! Nulla corrupti enim optio officia, ullam deleniti voluptates nobis culpa fuga eaque, necessitatibus, error soluta! Perspiciatis dignissimos autem nostrum provident ab neque dolor voluptas aliquam sequi commodi id unde illo pariatur quis qui, G-Blog was created in 1900 by a wise man named jalal, consectetur sed, accusamus ipsam aperiam voluptatem veniam dolorum eveniet quidem ad! Nam similique alias reprehenderit provident facilis, consectetur ex voluptates voluptatem sunt facere quis consequuntur ratione nisi eveniet error animi temporibus tenetur eos ducimus dicta saepe doloremque. Perferendis, vitae.</p>

        <br>
    </div>
<?php endif; ?>

<?php if (isset($_POST['submit'])) {
    //checkpost();
    submit_contact();
} ?>

<?php if (isset($_GET['form_sent'])) : ?>
    <h3 class="notify">Your Contact Form has been submitted successfully</h3>
<?php endif; ?>


<?php if (isset($_GET['contact_us'])) : ?>
    <div style="margin-top: 20px;" class="user_panel">
        <div class="user_panel_head">
            <h2>Contact us</h2>

        </div>
        <form id="contact-form" name="login" action="" method="post">
            <label class="account_input_label" for="">Email Adress</label><input class="account_input" onkeyup="checkform2()" name="email" id="email" type="email" placeholder="Enter Email" value="<?= $_POST['email'] ?? "";  ?>">
            <p class="g_vald register_error"></p>

            <label class="account_input_label" for=""> Title</label> <input class="account_input" type=" text" name="contact_title" id="" placeholder="Tittle" value=""> <br>

            <label class="account_input_label" for=""> Content</label> <textarea class="account_input" name="contact_content" id="" cols="70" rows="3" placeholder="Message" value=""></textarea>
            <br>
            <button class="wide_btn" name="submit" value="send" type="submit">Submit</button><br>
        </form>
    </div>
<?php endif; ?>







<?php

require "_footer.php";
?>