$(document).ready(function() {
    $(".btnmenu").click(function() { $(".mm").toggleClass("shwx"), $(".btnmenu").toggleClass("active") });
    $(document).on("click", ".search-resp", function() { $("#form-search-resp").toggleClass("formblock"), $(".search-resp").toggleClass("active") });
    $(".filterss").click(function() { $(".filtersearch").toggleClass("advs") });
});
$(window).scroll(function() { if ($(this).scrollTop() > 100) { $(".scrollToTop").fadeIn() } else { $(".scrollToTop").fadeOut() } });
$(".inner-switch").on("click", function() {
    if ($("body").hasClass("darkmode")) {
        $("body").removeClass("darkmode");
        $(".inner-switch").html('<i class="fas fa-moon" aria-hidden="true"></i>');
        localStorage.setItem("theme-mode", "lightmode")
    } else {
        $("body").addClass("darkmode");
        $(".inner-switch").html('<i class="fas fa-sun" aria-hidden="true"></i>');
        localStorage.setItem("theme-mode", "darkmode")
    }
});
$(document).on("click", ".widgetfilter .dropdown-toggle", function() {
    if (!$(this).parent().hasClass("open")) { $(document).find(".widgetfilter .filter.dropdown").removeClass("open") }
    $(this).parent().toggleClass("open")
});