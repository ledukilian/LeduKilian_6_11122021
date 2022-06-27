/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import './styles/zephyr.css';
import './styles/style.css';

$(document).on('click', 'a[href^="#"]', function(e) {
    let id = $(this).attr('href');
    let $id = $(id);
    if ($id.length === 0) {
        return;
    }
    e.preventDefault();
    let mainNavbarSize = document.getElementById('main-navbar').offsetHeight;
    let pos = $id.offset().top - mainNavbarSize;
    $('body, html').animate({scrollTop: pos});
});

$( "#load-more" ).click(function() {
    $('#loader').show();
    $('#load-more').hide();
    let infos = this.dataset;
    $.ajax({
        type: "POST",
        url: "/"+infos.method+"/"+infos.id+"/"+infos.limit+"/"+infos.offset,
        dataType: "json",
        success: function(data) {
            document.getElementById('load-more').dataset.offset = parseInt(document.getElementById('load-more').dataset.offset) + parseInt(document.getElementById('load-more').dataset.limit);
            $('#loader').hide();
            $(data.data).each(function(index, data) {
                if (infos.method=="load-tricks") {
                    console.log(data);
                    renderTrick(data.name, data.slug, data.coverImg.link, data.coverImg.alt, infos.format);
                }
                if (infos.method=="load-comments") {
                    console.log(data);
                    renderComment(data.content, data.user.username, data.createdAt.timestamp);
                }
            });
            if (data.remain!==false) {
                $('#load-more').show();
            }
        }
    });
});

function renderComment(content, username, date) {
    let html = '<div class="mb-3 col-12 col-md-10 offset-md-1">';
    html += '<div class="card bg-light d-flex flex-row flex-wrap card-body p-2 shadow-sm">';
    html += '<em class="fas fa-comment text-primary reverse-h me-1"></em><span class="fw-bold text-primary">'+username+'</span>';
    html += '<span class="ms-auto text-muted">'+convertToReadableDateTime(date)+'<em class="far fa-clock ms-1"></em></span>';
    html += '<blockquote class="blockquote text-start col-12 m-0 px-0">';
    html += '<small class="card card-text border-0 text-dark col-12 p-4 mt-2">'+content+'</small>';
    html += '</blockquote></div></div>';
    $('#comment-list').html($('#comment-list').html() + html);

}

function renderTrick(name, slug, cover, alt, format) {
    let html = '<article class="mb-3 col-sm-12 col-md-3 px-2 trick"><div class="h-100 card bg-light d-flex flex-row flex-wrap card-body p-2 shadow-sm"><figure class="d-flex flex-column m-0 w-100">';
    html += '<a href="/trick/'+slug+'" class="h-100 trick-img-container">';
    html += '<img class="h-100 of-cover col-12 rounded px-0" src="uploads/medias/'+cover+'" alt="'+alt+'" /></a><figcaption class="d-flex figcaption-size">';
    html += '<h5 class="card-title text-dark px-0 mt-1 m-0 fw-bold"><em class="fas fa-chevron-right text-primary me-1"></em>'+name+'</h5>';
    //html += '<div className="ms-auto pt-1"><a href="/trick/editer/'+slug+'/"><em class="zoom-in fas fa-edit text-warning"></em></a>';
    //html += '<span class="delete-action" data-bs-toggle="modal" data-bs-target="#confirmModal" data-name="'+name+'" data-slug="'+slug+'"><em class="zoom-in fas fa-trash-alt text-danger"></em></span></div>'
    html += '</figcaption></figure></div></article>';


    $('#tricks-list').html($('#tricks-list').html() + html);
}

function addZero(val) {
    if (val < 10) {
        return '0'+val;
    } else {
        return val;
    }
}

function convertToReadableDateTime(date) {
    let newDate = new Date(date*1000);
    let val = addZero(newDate.getDay())+'/'+addZero(newDate.getMonth())+'/'+newDate.getFullYear()+' à ';
    val += addZero(newDate.getHours())+':'+addZero(newDate.getMinutes());
    return val;
}

function refreshConfirmModal(name, slug) {
    console.log(name);
    console.log(slug);
    $('#confirmModal .modal-body').html('Voulez-vous vraiment supprimer le trick ' + name + ' ?')
    $('#confirmModal .modal-footer a').attr('href', '/trick/supprimer/' + slug + '/');
}

$( ".delete-action" ).each(function( index, element ) {
    element.onclick = function() {
        refreshConfirmModal(element.dataset.name, element.dataset.slug);
    };
});