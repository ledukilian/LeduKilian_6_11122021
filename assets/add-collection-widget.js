jQuery(document).ready(function () {
    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $container = $('#media-fields-list');

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find('fieldset').length;

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $('#add-another-collection-widget').click(function(e) {
        addPricing($container);

        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
    });

    // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
    if (index !== 0) {
        // S'il existe déjà des catégories, on ajoute un lien de suppression pour chacune d'entre elles
        $container.children('li').each(function(loop_index) {
            $(this).children('legend').text('Element n°' + (loop_index+1))
            addDeleteLink($(this));

        });
    }

    // La fonction qui ajoute un formulaire CategoryType
    function addPricing(container) {
        // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
        var number_field = $container.find('fieldset').length;

        // Dans le contenu de l'attribut « data-prototype », on remplace :
        // - le texte "__name__label__" qu'il contient par le label du champ
        // - le texte "__name__" qu'il contient par le numéro du champ
        var template = container.attr('data-prototype')
            .replace(/__name__label__/g, 'Element n°' + (number_field+1))
            .replace(/__name__/g,        number_field)
        ;

        // On crée un objet jquery qui contient ce template
        var $prototype = $(template);

        // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
        addDeleteLink($prototype);

        // On ajoute le prototype modifié à la fin de la balise <div>
        $container.append($prototype);
        $('#trick_medias_'+number_field+'_type_0').change(function() {
            toggleMediaForm(number_field, 'image');
        });
        $('#trick_medias_'+number_field+'_type_1').click(function() {
            toggleMediaForm(number_field, 'video');
        });

    }

    // La fonction qui ajoute un lien de suppression d'une catégorie
    function addDeleteLink($prototype) {
        // Création du lien
        var $deleteLink = $('<a href="#" class="btn btn-danger my-2"><i class="fas fa-trash-alt me-2"></i>Supprimer ce média</a>');

        // Ajout du lien
        $prototype.append($deleteLink);

        // Ajout du listener sur le clic du lien pour effectivement supprimer la catégorie
        $deleteLink.click(function(e) {
            $prototype.remove();
            $container.children('fieldset').each(function(delete_loop_index) {
                $(this).children('legend').text('Element n°' + (delete_loop_index+1))
            });
            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });
    }
});


//let fieldNbr = $('#media-fields-list').data('widgetCounter');
let number_field = $('#media-fields-list').find('fieldset').length;

for (let i = 0; i < number_field; i++) {
    $('#trick_medias_'+i+'_type_0').click(function() {
        toggleMediaForm(i, 'image');
    });
    $('#trick_medias_'+i+'_type_1').click(function() {
        toggleMediaForm(i, 'video');
    });

    if ($('#trick_medias_'+i+'_type_0').is(':checked')) {
        toggleMediaForm(i, 'image');
    } else if ($('#trick_medias_'+i+'_type_1').is(':checked')) {
        toggleMediaForm(i, 'video');
    }
}

function toggleMediaForm(id, type) {
    $('#trick_medias_'+id+' .field-image-video').show();
    if (type === 'image') {
        $('#trick_medias_'+id+' .field-image').show();
        $('#trick_medias_'+id+' .field-video').hide();
    }
    if (type === 'video') {
        $('#trick_medias_'+id+' .field-video').show();
        $('#trick_medias_'+id+' .field-image').hide();
    }
}
