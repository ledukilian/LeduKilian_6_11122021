$('#mediaModal a').hide();

$( "#trick-media figure" ).each(function(index, element) {
    element.onclick = function() {
        $('#mediaModal').modal('show');
        refreshMediaModal(element.dataset);
    };
});

function refreshMediaModal(data) {
    $modal = $('#mediaModal .modal-body');
    $modal.html('');
    if (data.type==="image") {
        if (data.link!==document.getElementById('trick-cover').dataset.link) {
            $('#mediaModal a').show();
            $('#mediaModal a').attr('href', '/trick/couverture/'+data.trick+'/'+data.cover+'/');
        }
        let image = '<img class="w-100" src="../uploads/medias/'+data.link+'" alt="'+data.alt+'" />'
        $modal.html(image + $modal.html());
        return true;
    }
    if (data.type==="video") {
        $('#mediaModal a').hide();
        $modal.html(data.link + $modal.html());
        return true;
    }
    return false;
}