$( "#trick-media figure" ).each(function(index, element) {
    element.onclick = function() {
        $('#mediaModal').modal('show');
        refreshMediaModal(element.dataset.type, element.dataset.link, element.dataset.alt);
    };
});

function refreshMediaModal(type, link, alt) {
    if (type=="image") {
        let image = '<img class="w-100" src="../uploads/medias/'+link+'" alt="'+alt+'" />'
        $('#mediaModal .modal-body').html(image);
        return true;
    }
    if (type=="video") {
        $('#mediaModal .modal-body').html(link);
        return true;
    }
    return false;
}