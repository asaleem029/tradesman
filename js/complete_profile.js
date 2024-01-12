
$(document).ready(function () {
    $("#skills-form").hide();
    $("#work-history-form").hide();
    $("#certification-form").hide();

    $("#nextToSkillsForm").click(function (e) {
        e.preventDefault();

        var name = $("#name").val()
        var phone = $("#phone").val()
        var trade_id = $("#trade_id").val()
        var city = $("#city").val()
        var country = $("#country").val()
        var hourly_rate = $("#hourly_rate").val()

        if (!name || !phone || !trade_id || !city || !country || !hourly_rate) {
            alert("Please Enter Required Fields");
        } else {
            $("#profile-form").hide();
            $("#work-history-form").hide();
            $("#certification-form").hide();
            $("#skills-form").show();
        }
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

    $("#add_new_work_history").click(function (e) {
        e.preventDefault();
        addWorkHostoryDiv();
    });

    $("#add_new_certification").click(function (e) {
        e.preventDefault();
        addCertificationDiv();
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

        var work_type = $("#work_type").val()
        var employer_name = $("#employer_name").val()
        var work_details = $("#work_details").val()

        if (!work_type || !employer_name || !work_details) {
            alert("Please Enter Required Fields");
        } else {
            $("#profile-form").hide();
            $("#work-history-form").hide();
            $("#skills-form").hide();
            $("#certification-form").show();
        }

    });

    $("#backToWorkHistoryForm").click(function (e) {
        e.preventDefault();

        $("#skills-form").hide();
        $("#profile-form").hide();
        $("#certification-form").hide();
        $("#work-history-form").show();
    });

    $(".work_images").on("change", function (e) {
        $(".old_work_images").hide();
        var files = e.target.files,
            filesLength = files.length;

        if (filesLength > 0) {
            for (var i = 0; i < filesLength; i++) {
                var f = files[i]
                var fileReader = new FileReader();

                fileReader.onload = (function (e) {
                    var file = e.target;
                    $("<span class=\"pip\">" +
                        "<br/><span class=\"remove\">x</span>" +
                        "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                        "</span>").appendTo(".work-images");

                    $(".remove").click(function () {
                        $(this).parent(".pip").remove();
                        filesLength = files.length;
                    });
                });
                fileReader.readAsDataURL(f);
            }
        } else {
            $(this).next().children(".pip").remove()
        }
    });

    $(".remove").click(function () {
        $(this).parent(".pip").remove();
    });

    $("#certificate_images").on("change", function (e) {
        $(".old_certifications_images").hide();
        var files = e.target.files,
            filesLength = files.length;

        if (filesLength > 0) {
            for (var i = 0; i < filesLength; i++) {
                var f = files[i]
                var fileReader = new FileReader();

                fileReader.onload = (function (e) {
                    var file = e.target;
                    $("<span class=\"pip\">" +
                        "<br/><span class=\"remove\">x</span>" +
                        "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                        "</span>").appendTo(".certificate-images");

                    $(".remove").click(function () {
                        $(this).parent(".pip").remove();
                    });
                });
                fileReader.readAsDataURL(f);
            }
        } else {
            $(this).next().children(".pip").remove()
        }
    });

    if (!user_skills) {
        addSkillDiv();
    }

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
                        <input class="form-control time_acquired" type="date" name="skills[` + count + `][time_acquired]" size="50">
                    </div>
                </div>
            </div>
        `);
    }

    if (!user_work_history) {
        addWorkHostoryDiv()
    }

    function addWorkHostoryDiv() {
        let divCount = $(".work-history-div").find(".form-group").length
        let count = divCount + 1;

        $(".work-history-div").append(`
            <div class="form-group">
            <div class="row">
                <div class="col">
                    <label for="work_type">Employement Type</label>
                    <i class="fa fa-asterisk" style="font-size:10px;color:red"></i>
                    <select class="form-select" name="work_history[`+ count + `][work_type]" id="work_type" aria-label="Default select example">
                        <option>-- Please Select --</option>
                        <option value="part_time">Part Time</option>
                        <option value="full_time">Full Time</option>
                    </select>
                </div>

                <div class="col">
                    <label for="employer_name">Employer Name</label>
                    <i class="fa fa-asterisk" style="font-size:10px;color:red"></i>
                    <input type="text" name="work_history[`+ count + `][employer_name]" id="employer_name" placeholder="Enter Employer Name">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="work_details">Work Details</label>
            <i class="fa fa-asterisk" style="font-size:10px;color:red"></i>
            <textarea class="form-control" name="work_history[`+ count + `][work_details]" id="work_details" cols="30" rows="10" placeholder="Write Work Details"></textarea>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="field" align="left">
                    <h3>Upload Images</h3>
                    <input type="file" class="work_images" name="work_history[`+ count + `][work_images][]" multiple accept="image/png, image/jpg, image/jpeg" />
                </div>
            </div>
        </div>
        `);
    }

    if (!user_certifications) {
        addCertificationDiv()
    }

    function addCertificationDiv() {
        let divCount = $(".certification-div").find(".form-group").length
        let count = divCount + 1;

        $(".certification-div").append(`
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="certification_name">Name of Certification</label>
                        <input type="text" name="certifications[`+ count + `][certification_name]" class="form-control" placeholder="Enter Certificate Name">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="valid_from">Valid From</label>
                        <input type="date" name="certifications[`+ count + `][valid_from]" id="valid_from">
                    </div>

                    <div class="col">
                        <label for="valid_till">Valid Till</label>
                        <input type="date" class="form-control" name="certifications[`+ count + `][valid_till]" id="valid_till">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="field" align="left">
                        <h3>Upload Images</h3>
                        <input type="file" id="certificate_images" name="certifications[`+ count + `][certificates_images][]" multiple accept="image/png, image/jpg, image/jpeg" />
                    </div>
                </div>
            </div>
        `);
    }

    function checkDate(SelectedDate) {
        var CurrentDate = (new Date()).toISOString().split('T')[0];
        if (CurrentDate > SelectedDate) {
            return true;
        } else {
            return false;
        }
    }

    $(".time_acquired").on("change", function (e) {
        e.preventDefault();

        if (!checkDate($(this).val())) {
            alert("Selected Date Must Be Less Than Today's Date");
            $(this).val(null);
        }
    });

    $("#valid_from").on("change", function (e) {
        e.preventDefault();

        if (!checkDate($(this).val())) {
            alert("Selected Date Must Be Less Than Today's Date");
            $(this).val(null);
        }
    });

    $("#valid_till").on("change", function (e) {
        e.preventDefault();

        if ($(this).val() <= $("#valid_from").val()) {
            alert("Valid Till Date Must Be Greater Than Valid From Date");
            $(this).val(null);
        }
    });
});