//definir templates que passarão pelo script
/* var templates = {
    'page-template-page-blog':'search_blog'
}; */

var taxonomies = {};

var blocks = {};

var filters = {};

var posts_per_page = 9;

var taxonomiaPrincipal = 'category'; //define se o nome da taxonomia principal aparece ao lado da quantidade de resultados

$(document).ready(function(){
    
    //ao submeter o formulário
    if($('body').hasClass('page-template-page-blog')){
        
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
            // Chama a função de busca sem parâmetros adicionais
            search('filter');
        });

        // Adiciona um evento de clique ao botão com o ID 'btn-mostrar-mais-posts-livre'
        $('#btn-mostrar-mais-posts-livre').on('click',function(e) {
            // Previne o comportamento padrão do clique (navegação)
            e.preventDefault();
            // Chama a função de busca com o parâmetro 'livre'
            search('free');
        });

        // Adiciona um evento de clique ao botão Submeter do modal de filtros
        $('.-submit-filters-modal-js').on('click',function(e){
            Search.view_update_filters_modal();
            e.preventDefault();
            search('filter',true, false); // Limpa os filtros e executa a busca novamente
            $('#modalBuscaBlog').modal('hide'); //fecha o modal
        });

        // Adiciona um evento de clique ao botão Fechar do modal de filtros
        $('.-clear-filters-modal-js').on('click',function(e){
            e.preventDefault();
            search('free', true,true); // Limpa os filtros e executa a busca novamente
            $('#modalBuscaBlog').modal('hide'); //fecha o modal
        });

        $('#search-results-clear-filters').on('click',function(e){
            e.preventDefault();
            search('free',true,true);
        });

        $('#search-results-free-cards-orderby').on('change',function(e){
            e.preventDefault();
            search('free',true,false);
        });

        $('#search-results-cards-orderby').on('change',function(e){
            e.preventDefault();
            search('filter',true,false);
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



