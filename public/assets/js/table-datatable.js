$(function () {
    "use strict";

    $(document).ready(function () {
        var table = $("#example2").DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            columnDefs: [
                {
                    orderable: false,
                    targets: 0, // kolom pertama (No) tidak bisa disortir
                },
            ],
            order: [[1, "asc"]], // kolom ke-2 sebagai default sort
            drawCallback: function (settings) {
                var api = this.api();
                api.column(0, { page: "current" })
                    .nodes()
                    .each(function (cell, i) {
                        cell.innerHTML = i + 1;
                    });
            },
            buttons: ["copy", "excel", "pdf", "print"],
        });
        // ✅ Ini WAJIB agar tombolnya muncul
        table.buttons().container().appendTo("#export-buttons");

        // Filter berdasarkan status
        $("#filter-status").on("change", function () {
            var status = $(this).val();
            table
                .column(4) // Kolom status (misalnya kolom ke-5)
                .search(status) // Filter berdasarkan nilai status
                .draw(); // Update tabel
        });

        // Filter berdasarkan jenis transaksi
        $("#filter-jenis-transaksi").on("change", function () {
            var jenisTransaksi = $(this).val();
            // console.log(table.search(jenisTransaksi));
            table
                .column(1) // Kolom jenis transaksi (misalnya kolom ke-2)
                .search(jenisTransaksi) // Filter berdasarkan jenis transaksi
                .draw(); // Update tabel
        });
    });

    // $(document).ready(function () {
    //     var table = $("#example2").DataTable({
    //         lengthChange: false,
    //         buttons: ["copy", "excel", "pdf", "print"],
    //     });

    //     table
    //         .buttons()
    //         .container()
    //         .appendTo("#example2_wrapper .col-md-6:eq(0)");
    // });
});
