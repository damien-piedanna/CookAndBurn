$(function () {
    $('#favorites').DataTable({
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : false,
        'autoWidth'   : false,
        'responsive'  : true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Recherche...",
            lengthMenu:     "_MENU_",
            emptyTable:     "Vous n'avez aucun favoris.",
            zeroRecords:    "Aucun résultat",
            paginate: {
                "first":      "Premier",
                "last":       "Dernier",
                "next":       "Suivant",
                "previous":   "Précédent"
            },
        },
        "dom": '<<"row"<"row justify-content-start col-sm"<"ml-2"f>><"row justify-content-end col-sm"<"mr-3"l>>><t>ip>'
    });
    $('#myrecipes').DataTable({
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : false,
        'autoWidth'   : false,
        'responsive'  : true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Recherche...",
            lengthMenu:     "_MENU_",
            emptyTable:     "Vous n'avez pas encore proposer de recette. <a href='/recipe/add' style='color: #4389f7'>Ajouter en une.</a>",
            zeroRecords:    "Aucun résultat",
            paginate: {
                "first":      "Premier",
                "last":       "Dernier",
                "next":       "Suivant",
                "previous":   "Précédent"
            },
        },
        "dom": '<<"row"<"row justify-content-start col-sm"<"ml-2"f>><"row justify-content-end col-sm"<"mr-3"l>>><t>ip>'
    })
})