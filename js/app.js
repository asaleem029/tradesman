$(document).foundation()


$("#available_to").on("change", function (e) {
    e.preventDefault();

    if ($(this).val() <= $("#available_from").val()) {
        alert("Date Available To Must Be Greater Than Date Available From");
        $(this).val(null)
    }
});