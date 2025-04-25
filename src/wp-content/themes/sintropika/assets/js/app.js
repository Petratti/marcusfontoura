$(window).on('load', function(){
    //$('.loader').hide();
    $('.loader').fadeOut();
});



$(document).ready(function(){

    $('#modalDefault').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var titulo = button.data('titulo');
        var imagem = button.data('imagem');
        var modal = $(this);
        //alert(YouTubeGetID(video));
        modal.find('.modal-title').text(titulo);
        modal.find('.modal-body').html('<img src="'+imagem+'" class="img-fluid" alt="Imagem">');
    });


    // ao abrir modal modalVideo, pegar data-video do botao e colocar no src do iframe
    $('#modalVideo').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var video = button.data('video');
        var modal = $(this);
        //alert(YouTubeGetID(video));
        modal.find('.modal-body iframe').attr('src', 'https://youtube.com/embed/'+YouTubeGetID(video)+'?rel=0&showinfo=0&autoplay=1');
    });

    //ao fechar modal modalVideo, remover src do iframe
    $('#modalVideo').on('hidden.bs.modal', function () {
        $(this).find('.modal-body iframe').removeAttr('src');
    });

    //se a classe .-cards existir, inicializar o masonry
    if($('.-cards').length){
        var cards = $('.-cards');
        //checar se mansory já existe
        if(cards.data('masonry')){
            //se existir, destruir
            cards.masonry('destroy');
            //cards.removeData('masonry'); // This line to remove masonry's data
        }
        // Initialize masonry again
        cards.masonry({
            itemSelector: '.card-content-js',
            //columnWidth: 340,
        });

        //contar a quantidade de cards paraincluir a linha entre as colunas
        var total = cards.children('.card-content-js').length;
        cards.removeClass('duas-colunas');
        if(total >= 2){
            cards.addClass('duas-colunas');
        }
    }
    
});



//pegar id do video do youtube
function YouTubeGetID(url){
    url = url.split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
    return (url[2] !== undefined) ? url[2].split(/[^0-9a-z_\-]/i)[0] : url[0];
 }


//validacao do formulario do bootstrap
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();


//pegar cookie
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}


//fechar menu principal ao clicar fora
/* document.addEventListener("click", function(event) {
    let navbar = document.querySelector(".navbar-collapse");
    let toggleButton = document.querySelector(".navbar-toggler");

    if (!navbar.contains(event.target) && !toggleButton.contains(event.target)) {
        let bsCollapse = new bootstrap.Collapse(navbar, {
            toggle: false
        });
        bsCollapse.hide();
    }
}); */

//fechar menu principal ao scrollar 50vh
/* window.addEventListener('scroll', function() {
    let navbar = document.querySelector(".navbar-collapse");
    let toggleButton = document.querySelector(".navbar-toggler");
    let scrollTop = window.scrollY || document.documentElement.scrollTop;

    if (scrollTop > window.innerHeight / 2) {
        if (navbar.classList.contains('show')) {
            let bsCollapse = new bootstrap.Collapse(navbar, {
                toggle: false
            });
            bsCollapse.hide();
        }
    }
}); */