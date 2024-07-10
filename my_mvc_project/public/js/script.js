document.addEventListener("DOMContentLoaded", function() {
    var hamburger = document.querySelector(".hamburger");
    var sidebar = document.querySelector(".sidebar");

    hamburger.addEventListener("click", function() {
        sidebar.style.display = (sidebar.style.display === "block") ? "none" : "block";
    });

    document.addEventListener("click", function(event) {
        if (!sidebar.contains(event.target) && !hamburger.contains(event.target)) {
            sidebar.style.display = "none";
        }
    });
});
