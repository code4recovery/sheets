var dd = document.getElementById("dropdown-desktop");

dd.getElementsByTagName("button")[0].addEventListener("click", function () {
    dd.getElementsByTagName("div")[0].classList.toggle("hidden");
});

document
    .getElementById("dropdown-mobile-button")
    .addEventListener("click", function () {
        document.getElementById("dropdown-mobile").classList.toggle("hidden");
    });
