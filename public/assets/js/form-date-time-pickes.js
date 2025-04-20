$(function () {
    "use strict";

    $("#tglmasuk").pickadate({
        selectMonths: true,
        selectYears: true,
    });

    $("#tanggal_masuk").pickadate({
        selectMonths: true,
        selectYears: true,
    }),
        $(".timepicker").pickatime();

    $("#date-time").bootstrapMaterialDatePicker({
        format: "YYYY-MM-DD HH:mm",
    });
    $("#date").bootstrapMaterialDatePicker({
        time: false,
    });
    $("#time").bootstrapMaterialDatePicker({
        date: false,
        format: "HH:mm",
    });
});
