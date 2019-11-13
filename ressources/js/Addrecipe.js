$('.ingredient').select2({
    placeholder: 'Choisissez un ingredient',
    allowClear: true,
    width: 'resolve'
});

var list_ingredients = [];

function getIngredientInfo()
{
    var select_ings = document.getElementById("ingredient").selectedIndex;
    var ing = document.getElementsByTagName("option")[select_ings].label;
    var iding = document.getElementsByTagName("option")[select_ings].value;
    var quantity = document.getElementById("quantity").value;
    document.getElementById("quantity").value = "";
    $('.ingredient').val('').trigger('change');
    if(ing == "" || quantity == "")
        return;
    addIngredient(iding, quantity, ing)
}

function addIngredient(iding, quantity, ing)
{
    list_ingredients.push([iding,quantity,ing]);
    showIngredient();
}

function DeleteIngredient(number)
{
    list_ingredients.splice(number, 1);
    showIngredient();
}

function showIngredient()
{
    $("div.list_ing").empty();
    for (i = 0; i < list_ingredients.length; i++) {
        quantity = list_ingredients[i][1];
        ing = list_ingredients[i][2];
        var div =
            '<div class="alert alert-warning alert-dismissible fade show" style="margin-bottom: 5px" role="alert">' +
            '<strong>Ingredient ' + (i+1) + ':</strong> '  + ing + ' (' + quantity + ')' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="DeleteIngredient(' + i + ')"  >' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>' +
            '</div>';

        $("div.list_ing").append(div);
    }
}

var list_steps = [];

function getStepInfo()
{
    var step = document.getElementById("step").value;
    document.getElementById("step").value = "";
    if(step == "")
        return;

    for (var c of step)
        if(c === '@')
            return;
    addStep(step);
}
function addStep(step)
{
    list_steps.push(step);
    showSteps();
}

function DeleteStep(number)
{
    list_steps.splice(number, 1);
    showSteps();
}

function showSteps()
{
    $("div.list_steps").empty();
    for (i = 0; i < list_steps.length; i++) {
        step = list_steps[i];
        var div =
            '<div class="alert alert-info alert-dismissible fade show" style="margin-bottom: 5px" role="alert">' +
            '<strong>Étape ' + (i+1) + ':</strong> '  + step +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="DeleteStep(' + i + ')"  >' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>' +
            '</div>';

        $("div.list_steps").append(div);
    }
}

function setParams()
{
    var ingredients = "";
    for (i = 0; i < list_ingredients.length; i++) {
        ingredients = ingredients + list_ingredients[i][0] + ',' + list_ingredients[i][1] + '/';
    }

    var steps = "";
    for (i = 0; i < list_steps.length; i++) {
        steps = steps + list_steps[i] + '@';
    }

    document.getElementById("steps").value = steps;
    document.getElementById("ingredients").value = ingredients;
}

function save_add()
{
    document.getElementById("isPublished").value = 0;
    send_add();
}

function publish_add()
{
    document.getElementById("isPublished").value = 1;
    send_add();
}

function send_add()
{
    setParams();
    document.getElementById("addrecipe").submit();
}