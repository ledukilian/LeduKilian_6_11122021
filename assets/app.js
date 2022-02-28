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

// start the Stimulus application
import './bootstrap';

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

$( document ).ready(function() {
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
                        renderTrick(data.name, data.slug, 'default_trick.jpg', infos.format);
                    }
                    if (infos.method=="load-comments") {
                        renderComment(data.content, data.user.username, data.createdAt);
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

    function renderTrick(name, slug, picture, format) {
        let html = '<a href="/trick/'+slug+'" class="mb-3 col-sm-12 col-md-'+format+' px-2 trick">';
        html += '<article class="card bg-light d-flex flex-row flex-wrap card-body p-2 shadow-sm">';
        html += '<img class="col-12 rounded px-0" src="/img/'+picture+'" alt="Trick"/><h5 class="card-title text-dark px-0 mt-1 m-0 fw-bold">';
        html += '<em class="fas fa-chevron-right text-primary me-1"></em>'+name+'</h5>';
        html += '<div class="ms-auto pt-1"><em class="fas fa-edit text-warning"></em><em class="fas fa-trash-alt text-danger"></em></div>';
        html += '</article></a>';
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
        let newDate = new Date(date);
        let val = addZero(newDate.getDay())+'/'+addZero(newDate.getMonth())+'/'+newDate.getFullYear()+' à ';
        val += addZero(newDate.getHours())+':'+addZero(newDate.getMinutes());
        return val;
    }
});