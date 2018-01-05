/**
 * Created by jawad on 07/29/2016.
 */
$("#togl").click(function (e) {
    e.preventDefault();
    $("#all").toggleClass("toggled");
});

$("#messages-logo").hover(function () {
    $("#messages").css("visibility","visible")
})
$("#messages-logo").mouseout(function () {
    $("#messages").css("visibility","hidden")
})
