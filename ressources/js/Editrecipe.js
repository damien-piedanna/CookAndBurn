window.onload = function() {
    loadIngredients();
    loadSteps();
};

function loadIngredients()
{
    var ing = document.getElementById("oldingredients").value;
    if(ing == "")
        return;

    var ingarrays = ing.split("/");
    for (j = 0; j < ingarrays.length; j++)
    {
        var ingarray = ingarrays[j].split(",");
        addIngredient(ingarray[0], ingarray[1], ingarray[2])
    }
}

function loadSteps()
{
    var steps = document.getElementById("oldsteps").value;
    if(steps == "")
        return;

    var stepsarray = steps.split("@");
    for (j = 0; j < stepsarray.length; j++)
    {
        addStep(stepsarray[j])
    }
}

function save_edit()
{
    document.getElementById("isPublished").value = 0;
    send_edit();
}

function publish_edit()
{
    document.getElementById("isPublished").value = 1;
    send_edit();
}

function send_edit()
{
    setParams();
    document.getElementById("editrecipe").submit();
}