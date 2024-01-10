$(document).ready(function (e) {

    var multi = $('.rating_stars');

    $.each(multi, function (index, item) {

        var div = "";
        var trademan_rating = $(item).data("rating")
        var rating = parseInt(trademan_rating);
        var stars = "";

        //loop through rating...no
        for (var j = 1; j <= rating; j++) {
            stars += '<i class="fas fa-star" style="color:gold"></i>';
        }

        trademan_rating = Number(trademan_rating).toFixed(4).replace(/\.0+$/, '')

        //check if there is `.` in number..means .5 
        if (trademan_rating.toString().indexOf('.') != -1) {
            //half star 
            stars += '<i class="fas fa-star-half-alt"  style="color:gold"></i>'
        }

        div = div +
            "<div class=\"row\">" +
            "<div class=\"col\">" +
            "<div class=\"rating-product\">" + stars +
            "</div>" +
            "</div>" +
            "</div>";
        document.getElementById('rating_stars_' + $(item).data("id")).innerHTML = div;
    });
});