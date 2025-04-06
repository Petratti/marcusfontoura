$(document).ready(function(){

    //se existir o elemento .form-search .input-search e for mobile trocar placeholder
    if($('.form-search .input-search').length) {
        if ($(window).width() < 992) {
            $('.form-search .input-search').attr('placeholder', 'Pesquisar...');
        }
    }

    if($('#top').length){
        $(window).scroll(function(){
            var scroll = $(window).scrollTop();
            if(scroll > 700){
                $('#top').addClass('show');
            }
        });
    }


    //ao clicar no submenu e for ancora, rolar para o ponto da página correspondente com offset
    $('#submenu li a[href^="#"], a[href^="#"]').on('click', function(e){
        if ($(this).attr('href') !== '#') {
            e.preventDefault();
            var id = $(this).attr('href');
            var headerHeight = $('#header').outerHeight();
            //var headerHeight = 150;
            //checar se existe #submenu
            if($('#submenu').length){
                var submenuHeight = $('#submenu').outerHeight();
            }else{
                var submenuHeight = 0;
            }
            var menuaccessibilityHeight = $('.menu-accessibility').outerHeight();
            //var offset = headerHeight + submenuHeight + menuaccessibilityHeight + 0;
            var offset = submenuHeight - 1;
            var top = $(id).offset().top - offset;
            window.scrollTo({
                top: top,
                behavior: "smooth"
            });
        }
    });

    //ao carregar a página, verificar se existe um hash na url e rolar para o ponto da página correspondente com offset
    if(window.location.hash){
        var id = window.location.hash;
        var headerHeight = $('#header').outerHeight();
        //var headerHeight = 150;
        var submenuHeight = $('#submenu').outerHeight();
        var menuaccessibilityHeight = $('.menu-accessibility').outerHeight();
        var offset = headerHeight + submenuHeight + menuaccessibilityHeight + 0;
        var top = $(id).offset().top - offset;
        window.scrollTo({
            top: top,
            behavior: "smooth"
        });
    }

    //se existir o elemento #submenu, verificar a posicao do scroll e adicionar a classe active ao elemento do submenu correspondente
    if($('#submenu').length){
        //excluir item do submenu se nao tiver conteudo correspondente
        $('#submenu li a[href^="#"]').each(function(){
            var id = $(this).attr('href');
            var element = $(id);
            if(!element.length){
                $(this).parent().remove();
            }
        });
        $(window).scroll(function(){
            var headerHeight = $('#header').outerHeight();
            //var headerHeight = 150;
            var submenuHeight = $('#submenu').outerHeight();
            //var menuaccessibilityHeight = $('.menu-accessibility').outerHeight();
            //var offset = headerHeight + submenuHeight + menuaccessibilityHeight + 0;
            var offset = submenuHeight;
            //var offset = 180;
            //var offset = 0;
            var scroll = $(window).scrollTop() + offset;
            //verificar todos os elementos com o id correspondente ao href do submenu e adicionar a classe active ao que estiver visivel
            $('#submenu li a[href^="#"]').each(function(){
                var id = $(this).attr('href');
                var element = $(id);
                if(element.length){
                    var elementTop = element.offset().top;
                    var elementHeight = element.outerHeight();
                    if(scroll >= elementTop && scroll < elementTop + elementHeight){
                        $('#submenu li a').removeClass('active');
                        $(this).addClass('active');
                    }
                }
            });
        });
    }

    $('#searchButton').click(function() {
        $('#searchBar').toggleClass('active');
        $(this).toggleClass('active');
        $('#searchBar input').focus();
        //incluir visually-hidden na search bar se nao estiver visivel
        /* if($('#searchBar').hasClass('active')){
            $('#searchBar').removeClass('visually-hidden');
        }else{
            $('#searchBar').addClass('visually-hidden');
        } */
        //nao deixar disponivel via tab se nao tiver classe active
        if($('#searchBar').hasClass('active')){
            $('#searchBar input, #searchBar button').attr('tabindex','0');
        }else{
            $('#searchBar input, #searchBar button').attr('tabindex','-1');
        }
    });

    


});