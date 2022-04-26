/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/styles.scss';

// start the Stimulus application
import './bootstrap';

document.addEventListener("DOMContentLoaded", function() {
    if (document.getElementById("mainButton")){
        const mainButton = document.getElementById("mainButton");
    mainButton.addEventListener("click", function() {
        const mainVideo = document.getElementById("mainVideo");
        mainVideo.classList.add("main-hide");
        document.body.classList.remove("no-scroll");
        scrollTo(0,0);
    });
    }

    console.log(window.location.href.indexOf("no-intro"))
    
    if (window.location.href.indexOf("no-intro") !== -1){
        const mainVideo = document.getElementById("mainVideo");
        mainVideo.classList.add("no-transition");
        mainVideo.classList.add("main-hide");
        document.body.classList.remove("no-scroll");
        scrollTo(0,0);
    }

    if (window.location.href.indexOf("contact") !== -1)
    {
        document.body.classList.add('contact-bg');
    }
    else {
        document.body.classList.remove('contact-bg');
    }
});
