document.getElementById('twitter').onclick = function () {
    var urlsharer = 'https://twitter.com/intent/tweet?' + 'text=J\'aime une recette sur le site CookAndBurn - ' + name + '&hashtags=cooknburn' + '&url=' + url;
    window.open(urlsharer,'Partager sur Twitter', 'height=300, width=700, scrollbars=0, menubar=0');
};

document.getElementById('facebook').onclick = function () {
    var urlsharer = 'https://facebook.com/sharer/sharer.php?u=' + url;
    window.open(urlsharer,'Partager sur Facebook', 'height=300, width=550, scrollbars=0, menubar=0');
};

function addnote()
{
    document.getElementById("add-note-button").style.display = 'none';
    document.getElementById("note").style.display = 'none';
    document.getElementById("note-edit").value = document.getElementById("oldannotation").value;
    document.getElementById("note-edit").style.display = 'block';
}

$("input").blur(function(){
    var note = document.getElementById("note-edit").value;
    if(note == "")
    {
        document.getElementById("add-note-button").style.display = 'block';
        document.getElementById("note-edit").style.display = 'none';
        document.getElementById("annotation").value = "";
        document.getElementById("annotate").submit();
        return;
    }

    document.getElementById("note-edit").style.display = 'none';
    document.getElementById("note").innerHTML = "Note : " + note +
        " <button type='button' class='btn btn-info px-1 py-1' onclick='addnote()'><i class='fa fa-edit lg' aria-hidden='true'></i></button>";
    document.getElementById("note").style.display = 'block';

    document.getElementById("annotation").value = note;
    document.getElementById("annotate").submit();
});