
let fieldNbr = $('#media-fields-list').data('widgetCounter');

for (let i = 0; i < fieldNbr; i++) {
    //console.log('#trick_trickMedia_'+i);

    $('#trick_trickMedia_'+i+'_type_0').click(function() {
        toggleMediaForm(i, 'image');
    });
    $('#trick_trickMedia_'+i+'_type_1').click(function() {
        toggleMediaForm(i, 'video');
    });

    if ($('#trick_trickMedia_'+i+'_type_0').is(':checked')) {
        toggleMediaForm(i, 'image');
    } else if ($('#trick_trickMedia_'+i+'_type_1').is(':checked')) {
        toggleMediaForm(i, 'video');
    }
}

jQuery('#add-another-collection-widget').click(function (e) {
    var list = jQuery(jQuery(this).attr('data-list-selector'));
    // Try to find the counter of the list or use the length of the list
    var counter = list.data('widget-counter') || list.children().length;
    // grab the prototype template
    var newWidget = list.attr('data-prototype');
    // replace the "__name__" used in the id and name of the prototype with a number that's unique to your emails
    // end name attribute looks like name="contact[emails][2]"
    newWidget = newWidget.replace(/__name__/g, counter);
    // Increase the counter
    counter++;
    // And store it, the length cannot be used if deleting widgets is allowed
    list.data('widget-counter', counter);

    deleteBtn = '<button onclick="deleteMediaWidget(this)" class="btn btn-danger btn-sm float-end mt-3"><i class="fas fa-trash-alt"></i></button>';
    // create a new list element and add it to the list
    var newElem = jQuery(list.attr('data-widget-tags')).html(deleteBtn+newWidget);

    newElem.appendTo(list);

    $('#trick_trickMedia_'+(counter-1)+'_type_0').click(function() {
        toggleMediaForm(counter-1, 'image');
    });
    $('#trick_trickMedia_'+(counter-1)+'_type_1').click(function() {
        toggleMediaForm(counter-1, 'video');
    });
});

function deleteMediaWidget(widget) {
    console.log('On est là');
    $(widget).parent().addClass('d-none');
    console.log('On avait '+$('#media-fields-list').data('widgetCounter')+' maintenant on a '+($('#media-fields-list').data('widgetCounter')-1));
    $(widget).parent().parent().data('widget-counter', $(widget).parent().parent().data('widget-counter')-1);
    return false;
}

function toggleMediaForm(id, type) {
    if (type === 'image') {
        $('#trick_trickMedia_'+id+' .field-image').show();
        $('#trick_trickMedia_'+id+' .field-video').hide();
    }
    if (type === 'video') {
        $('#trick_trickMedia_'+id+' .field-video').show();
        $('#trick_trickMedia_'+id+' .field-image').hide();
    }
}
