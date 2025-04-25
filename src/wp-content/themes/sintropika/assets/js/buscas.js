//definir templates que passarão pelo script
/* var templates = {
    'page-template-page-conteudos':'search_conteudos'
}; */

var taxonomies = {};

var blocks = {};

var filters = {};

var posts_per_page = 9;

var taxonomiaPrincipal = 'category'; //define se o nome da taxonomia principal aparece ao lado da quantidade de resultados

$(document).ready(function(){
    
    //ao submeter o formulário
    if($('body').hasClass('page-template-page-conteudos')){
        
        // Inicializa a busca
        //se existir parâmetros de busca na URL executa a busca filtrada

        search('filter',true,false);

        // Ao submeter o formulário de busca
        $('#formsearch-posts').on('submit',function(e) {
            // Previne o comportamento padrão de submissão do formulário
            e.preventDefault();
            //Pega o valor do campo de busca desse formulário
            var input_search = $(this).find('.input-search').val();
            // Verifica se o termo de busca tem algum conteúdo
            if (input_search.length > 0) {
                search('filter',true,false); // Executa a busca
            }
        });


        $("#search-results-filters-itens").on('click', 'button', function(){
            $(this).remove();

            var id = $(this).data('id');
            $('#' + id).prop('checked', false);
            
            if($('#search-results-filters-itens button').length == 0){
                search('free',true,true);
            }else{
                search('filters',true,false);
            }
           
        });

        // Verifica se o campo de busca foi alterado e limpa e refaz a busca se necessário
        $('#formsearch-posts .input-search').on('input', function() {
            // Obtém o conteúdo atual do campo de busca
            var search_content = $(this).val();
            // Verifica se o campo de busca está vazio
            if (search_content.length == 0) {
                search('free',true,true); // Executa a busca novamente
            }
        });

        // Adiciona um evento de clique ao botão com o ID 'btn-mostrar-mais-posts'
        $('#btn-mostrar-mais-posts').on('click',function(e) {
            // Previne o comportamento padrão do clique (navegação)
            e.preventDefault();
            //define min-heigth do conteudo com base no height atual para corrigir funcionamento do masonry
            var height = $('#search-results-cards').height();
            if (height == 0) {
                height = $('#search-results-cards').css('min-height');
            }
            $('#search-results-cards').css('min-height', height);
            // Chama a função de busca sem parâmetros adicionais
            search('filter');
        });

        // Adiciona um evento de clique ao botão com o ID 'btn-mostrar-mais-posts-livre'
        $('#btn-mostrar-mais-posts-livre').on('click',function(e) {
            // Previne o comportamento padrão do clique (navegação)
            e.preventDefault();
            //define min-heigth do conteudo com base no height atual para corrigir funcionamento do masonry
            var height = $('#search-results-free-cards').height();
            if (height == 0) {
                height = $('#search-results-free-cards').css('min-height');
            }
            $('#search-results-free-cards').css('min-height', height);
            // Chama a função de busca com o parâmetro 'livre'
            search('free');
        });

        // Adiciona um evento de clique ao botão Submeter do modal de filtros
        $('.-submit-filters-modal-js').on('click',function(e){
            Search.view_update_filters_modal();
            e.preventDefault();
            search('filter',true, false); // Limpa os filtros e executa a busca novamente
            $('#modalBusca').modal('hide'); //fecha o modal
        });

        // Adiciona um evento de clique ao botão Fechar do modal de filtros
        $('.-clear-filters-modal-js').on('click',function(e){
            e.preventDefault();
            search('free', true,true); // Limpa os filtros e executa a busca novamente
            $('#modalBusca').modal('hide'); //fecha o modal
            //retrair os blocos de categorias
            $('.child').addClass('d-none');
        });

        $('#search-results-clear-filters').on('click',function(e){
            e.preventDefault();
            search('free',true,true);
            $('.child').addClass('d-none');
        });

        $('#search-results-free-cards-orderby').on('change',function(e){
            e.preventDefault();
            search('free',true,false);
        });

        $('#search-results-cards-orderby').on('change',function(e){
            e.preventDefault();
            search('filter',true,false);
        });

        /*Ao clicar nos botoes que contém a classe .busca-category verifica o value do botão e
        adiciona display ao bloco-category correspondente*/
        $('.busca-category').on('click',function(e){
            //e.preventDefault();
            var bloco = $(this).val();
            if($('#bloco-'+bloco).hasClass('d-none')){
                $('#bloco-'+bloco).removeClass('d-none');
            }else{
                
                //Verifica os elementos filhos do bloco e se todos estão desmarcados fecha o bloco
                var filhos = $('#bloco-'+bloco).find('.sub-category');
                var todosDesmarcados = true;
                filhos.each(function() {
                    if ($(this).is(':checked')) {
                        todosDesmarcados = false;
                        return false; // Sai do loop se encontrar um checkbox marcado
                    }
                });
                if (todosDesmarcados) {
                    $('#bloco-'+bloco).addClass('d-none');
                }


            }
        });

        $('.sub-category').on('click',function(e){
            //Verifica se o elemento atual foi checkado caso sim, ativa o elemento pai
            if($(this).is(':checked')){
                var categoria = $(this).data('category');
                if(!$('#busca-category-'+categoria).is(':checked')){
                    $('#busca-category-'+categoria).prop('checked', true);
                }
            }else{
                var categoria = $(this).data('category');
                var categoria_checked = $('#busca-category-'+categoria).is(':checked');
                //Verifica os elementos filhos do bloco e se todos estão desmarcados fecha o bloco
                var filhos = $('#bloco-'+categoria).find('.sub-category');
                var todosDesmarcados = true;
                filhos.each(function() {
                    if ($(this).is(':checked')) {
                        todosDesmarcados = false;
                        return false; // Sai do loop se encontrar um checkbox marcado
                    }
                });
                if (todosDesmarcados && !categoria_checked) {
                    $('#bloco-'+categoria).addClass('d-none');
                }
            }
        });

    }


    if($('body').hasClass('search-results') || $('body').hasClass('search-no-results')){
        search('simples',true,false);

        $('#formsearch').on('submit',function(e) {
            // Previne o comportamento padrão de submissão do formulário
            //e.preventDefault();
            // Verifica se o termo de busca tem algum conteúdo
            //search('simples',true,false); // Executa a busca
        });

        // Verifica se o campo de busca foi alterado e limpa e refaz a busca se necessário
        $('#formsearch .input-search').on('input', function() {
            // Obtém o conteúdo atual do campo de busca
            //var search_content = $(this).val();
            
            // Verifica se o campo de busca está vazio
            /* if (search_content.length == 0) {
                search('simples',true,true); // Executa a busca novamente
            } */
        });
        
        $('#search-results-cards-orderby').on('change',function(e){
            e.preventDefault();
            search('simples');
        });

        $('#btn-mostrar-mais-resultados').on('click',function(e) {
            // Previne o comportamento padrão do clique (navegação)
            e.preventDefault();
            // Chama a função de busca sem parâmetros adicionais
            search('simples');
        });
    }

});

// Variável para armazenar a requisição de busca atual
var search_request = null;

// Função para realizar a busca
// O parâmetro 'tipo' determina o tipo de busca (livre ou padrão)
function search(tipo, limpar = false, zerar = false) {
    
    url_ajax = js_global.xhr_url;
    blocks = {
        'categories': 0,
    };
    busca = Search;
    busca.execute(tipo, posts_per_page, blocks, url_ajax, limpar, zerar, taxonomiaPrincipal);
    busca.get_queue();
}



