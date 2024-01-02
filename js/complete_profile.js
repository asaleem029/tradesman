
$(document).ready(function () {
    $("#skills-form").hide();
    $("#work-history-form").hide();
    $("#certification-form").hide();

    $("#nextToSkillsForm").click(function (e) {
        e.preventDefault();
        $("#profile-form").hide();
        $("#work-history-form").hide();
        $("#certification-form").hide();
        $("#skills-form").show();
    });

    $("#backToProfileSection").click(function (e) {
        e.preventDefault();
        $("#skills-form").hide();
        $("#work-history-form").hide();
        $("#certification-form").hide();
        $("#profile-form").show();
    });

    $("#add_new_skill").click(function (e) {
        e.preventDefault();
        addSkillDiv();
    });

    $("#nextToWorkHistoryForm").click(function (e) {
        e.preventDefault();

        $("#skills-form").hide();
        $("#profile-form").hide();
        $("#certification-form").hide();
        $("#work-history-form").show();
    });

    $("#backToSkillsForm").click(function (e) {
        e.preventDefault();

        $("#profile-form").hide();
        $("#work-history-form").hide();
        $("#certification-form").hide();
        $("#skills-form").show();
    });

    $("#nextToCertificationForm").click(function (e) {
        e.preventDefault();

        $("#profile-form").hide();
        $("#work-history-form").hide();
        $("#skills-form").hide();
        $("#certification-form").show();
    });

    $("#backToWorkHistoryForm").click(function (e) {
        e.preventDefault();

        $("#skills-form").hide();
        $("#profile-form").hide();
        $("#certification-form").hide();
        $("#work-history-form").show();
    });

    $("#work_images").on("change", function (e) {
        console.log("wi");
        var files = e.target.files,
            filesLength = files.length;

        for (var i = 0; i < filesLength; i++) {
            var f = files[i]
            var fileReader = new FileReader();

            fileReader.onload = (function (e) {
                var file = e.target;
                $("<span class=\"pip\">" +
                    "<br/><span class=\"remove\">x</span>" +
                    "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                    "</span>").insertAfter("#work_images");

                $(".remove").click(function () {
                    $(this).parent(".pip").remove();
                });
            });
            fileReader.readAsDataURL(f);
        }
    });

    $("#certificate_images").on("change", function (e) {
        console.log("cert");
        var files = e.target.files,
            filesLength = files.length;

        for (var i = 0; i < filesLength; i++) {
            var f = files[i]
            var fileReader = new FileReader();

            fileReader.onload = (function (e) {
                var file = e.target;
                $("<span class=\"pip\">" +
                    "<br/><span class=\"remove\">x</span>" +
                    "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                    "</span>").insertAfter("#certificate_images");

                $(".remove").click(function () {
                    $(this).parent(".pip").remove();
                });
            });
            fileReader.readAsDataURL(f);
        }
    });

    addSkillDiv();

    function addSkillDiv() {
        let divCount = $(".skills-div").find(".form-group").length
        let count = divCount + 1;

        $(".skills-div").append(`
    <div class="form-group">
        <div class="row">
            <div class="col">
                <label for="skill_name">Skill Name</label>
                <input class="form-control" type="text" name="skills[` + count + `][name]" size="20">
            </div>

            <div class="col">
                <label for="skill_time">Time Since Skill Acquired</label>
                <input class="form-control" type="date" name="skills[` + count + `][skill_time]" size="50">
            </div>
        </div>
    </div>
    `);
    }
});