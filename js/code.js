function mobilemenu() {

    var g1 = document.getElementsByClassName("mobile-menu");

    if (g1[0].style.display == "block") {
        g1[0].style.display = "none"

    } else {
        g1[0].style.display = "block"

    }
}


function mobilemore() {

    var g1 = document.getElementsByClassName("mobile-hidden");

    if (g1[0].style.display == "block") {
        g1[0].style.display = "none"
        g1[1].style.display = "none"

    } else {
        g1[0].style.display = "block"
        g1[1].style.display = "block"

    }
}

function userprofilemore() {
    var g1 = document.getElementsByClassName("profile_hidden");
    var g2 = document.getElementsByClassName("login_img");

    if (g1[0].style.display == "block") {
        g1[0].style.display = "none"
        g2[0].style.right = "50px";

    } else {
        g1[0].style.display = "block"
        g2[0].style.right = "150px";

    }



}



function post_sort() {
    var g1 = document.getElementById("post_sort");
    if (g1.value == 1) {
        window.location.href = 'index.php?sort=new';
    }
    if (g1.value == 2) {
        window.location.href = 'index.php?sort=old';
    }
    if (g1.value == 3) {
        window.location.href = 'index.php?sort=asc';
    }
    if (g1.value == 4) {
        window.location.href = 'index.php?sort=desc';
    }
    if (g1.value == 5) {
        window.location.href = 'index.php?sort=user';
    }
}


// form valdiate 

formerrors = [];

var patterns = {
    str: /^[a-zA-Z0-9]+$/,
    email: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
    phone: /^.{5,20}$/
}

var myform = document.getElementById("register-form");
var myform1 = document.getElementById("login-form");
var myform2 = document.getElementById("contact-form");


var fname = document.getElementById("fname")
var email = document.getElementById("email")
var pass = document.getElementById("pass")
var showerror = document.getElementsByClassName("g_vald")


if (myform != null) {
    myform.addEventListener('submit', (e) => {
        checkform();
        if (formerrors.length > 0) {
            console.log(formerrors)
            e.preventDefault();
        }
    })

} else if (myform1 != null) {
    myform1.addEventListener('submit', (e) => {
        checkform1();

        if (formerrors.length > 0) {
            console.log(formerrors)
            e.preventDefault();
        }
    })
} else if (myform2 != null) {
    myform2.addEventListener('submit', (e) => {
        checkform2();
        if (formerrors.length > 0) {
            console.log(formerrors)
            e.preventDefault();
        }
    })
}






function checkform() {
    formerrors = [];

    if ((fname.value.length >= 3) && (patterns["str"].test(fname.value))) {
        showerror[0].textContent = ""
    } else {
        showerror[0].textContent = "Min 3 chars [a-z,0-9]"
        formerrors.push("error first name")
    }

    if ((email.value.length >= 5) && (patterns["email"].test(email.value))) {
        showerror[1].textContent = ""
    } else {
        showerror[1].textContent = "The E-mail you Entered is Invalid"
        formerrors.push("error Email")
    }
    if (pass.value.length >= 5) {
        showerror[2].textContent = ""
    } else {
        showerror[2].textContent = "Password too short , min 5 chars"
        formerrors.push("Short pass")
    }


}

function checkform1() {
    formerrors = [];
    if ((email.value.length >= 5) && (patterns["email"].test(email.value))) {
        showerror[0].textContent = ""
    } else {
        showerror[0].textContent = "The E-mail you Entered is Invalid"
        formerrors.push("error Email")
    }
    if (pass.value.length >= 5) {
        showerror[1].textContent = ""
    } else {
        showerror[1].textContent = "Password too short , min 5 chars"
        formerrors.push("Short pass")
    }


}

function checkform2() {
    formerrors = [];
    if ((email.value.length >= 5) && (patterns["email"].test(email.value))) {
        showerror[0].textContent = ""
    } else {
        showerror[0].textContent = "Please Enter a Valid E-mail"
        formerrors.push("error Email")
    }
}



//end of form valdiate 