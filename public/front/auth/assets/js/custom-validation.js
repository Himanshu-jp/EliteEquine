$(document).ready(function (e) {

    $(".alphabetvalid").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && e.which != 32 && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122) && e.which != 46) {
            return false;
        }
    });

    $(".numbervalid").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    $(".alphanumvalid").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && e.which != 32 && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122) && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

});