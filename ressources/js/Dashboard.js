//INGREDIENTS
$('.type-add').select2({
    placeholder: 'Choisissez sa catégorie...',
    allowClear: true,
    width: 'resolve'
});
$('.type-edit').select2({
    placeholder: 'Choisissez sa catégorie...',
    allowClear: true,
    width: 'resolve'
});
$('.ing-edit').select2({
    placeholder: 'Choisissez l\'ingrédient à modifier...',
    allowClear: true,
    width: 'resolve'
});
$('.ing-delete').select2({
    placeholder: 'Choisissez l\'ingrédient à supprimer...',
    allowClear: true,
    width: 'resolve'
});
$('.role-add').select2({
    placeholder: 'Choisissez le rôle de l\'utilsateur...',
    allowClear: true,
    width: 'resolve'
});
$('.role-edit').select2({
    placeholder: 'Choisissez le rôle de l\'utilsateur...',
    allowClear: true,
    width: 'resolve'
});
$('.user-edit').select2({
    placeholder: 'Choisissez l\'utilisateur à modifier...',
    allowClear: true,
    width: 'resolve'
});
$('.user-delete').select2({
    placeholder: 'Choisissez l\'utilisateur à supprimer...',
    allowClear: true,
    width: 'resolve'
});

//EDIT USERS
var $eventSelectuser = $(".user-edit");
$eventSelectuser.on("select2:select", function (e) {
    var data = e.params.data;

    $('#username-edit').val(data["text"]);
    $('#username-edit').parent().children().addClass('active');
    $("#email-edit").val($("#user-edit").val());
    $('#email-edit').parent().children().addClass('active');

    group = $('select').find(':selected').closest('optgroup').attr('label');
    $('#role-edit').val(group).trigger('change');
})

$eventSelectuser.on("select2:unselecting", function (e) {
    $('#username-edit').val('');
    $('#username-edit').parent().children().removeClass('active');
    $('#email-edit').val('');
    $('#email-edit').parent().children().removeClass('active')
    $('#role-edit').val(null).trigger('change');
})



//EDIT INGREDIENTS
var $eventSelecting = $(".ing-edit");
$eventSelecting.on("select2:select", function (e) {
    var data = e.params.data;

    $('#name-edit').val(data["text"]);
    $('#name-edit').parent().children().addClass('active');

    group = $('select').find(':selected').closest('optgroup').attr('label');
    $('#type-edit').val(group).trigger('change');
})

$eventSelecting.on("select2:unselecting", function (e) {
    $('#name-edit').val('');
    $('#name-edit').parent().children().removeClass('active')
    $('#type-edit').val(null).trigger('change');
})





//RECETTE
$(function () {
    $('#recipes').DataTable({
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
            emptyTable:     "Il n'y a rien à afficher",
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


