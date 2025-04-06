class Search {

    //Inicializar a classe
    static execute(tipo = 'free', posts_per_page = 9, blocks = {}, url_ajax = '', limpar = false, zerar = false, taxonomiaPrincipal = false){
        this.queue = [];
        this.add_to_queue('inicio');
        this.type = tipo;
        this.blocks = blocks;
        this.url_ajax = url_ajax;
        this.limpar = limpar;
        this.zerar = zerar;
        this.taxonomiaPrincipal = taxonomiaPrincipal;
        this.clean_cards();
        this.view_clear_filters_modal();
        this.clean_number_of_results();
        this.hide_number_of_results();
        this.populate_filters();
        let taxonomy = this.taxonomy();
        
        let term = this.term();
        let page = this.page();
        let order = this.order_by();
        
        let taxonomies = taxonomy;
        let action = this.action();
        this.search_for_url(taxonomies);
        
        let filters = {
            'paged': page,
            'posts_per_page': posts_per_page
        }

        let data = {
            'nonce': js_global.search_nonce, // Nonce de segurança
            'tipo': this.type, // Tipo de busca
            'search': term, // Termo de busca
            'taxonomy': taxonomies, // Taxonomias de busca
            'ob': order, // Ordem de exibição
            'filtros': filters,
            'action': action // Ação a ser executada no servidor
        };

        //console.log(data);
        this.execute_ajax(data,page);

       
        
    }
    
    //Limpar o campo de número de resultados
    static clean_number_of_results(){
        this.add_to_queue('clean_number_of_results');
        $('#search-results-cards-number').html('');
        $('#search-results-free-cards-number').html('');
    }

    //Esconder o campo de número de resultados
    static hide_number_of_results(){
        this.add_to_queue('hide_number_of_results');
        $('#search-results-cards-number').addClass('d-none');
        $('#search-results-free-cards-number').addClass('d-none');
    }

    //Obter os parâmetros da URL
    static get_url_params() {
        this.add_to_queue('get_url_params');
        var parametros = {};
        var queryString = window.location.search.substring(1);
        if(queryString){
            var pares = queryString.split("&");

            for (var i = 0; i < pares.length; i++) {
                var par = pares[i].split("=");
                parametros[par[0]] = decodeURIComponent(par[1]);
            }
        }
        //('parametros', parametros);
        return parametros;
    }

    static url_ajax(url = false){
        this.add_to_queue('url_ajax');
        if(url){
            this.url_ajax = url;
        }else{
            this.url_ajax = '';
        }
    }

    //Popular os inputs do formulário de busca
    static populate_inputs(){
        this.add_to_queue('populate_inputs');
        //console.log('populateInputs');
        var parametros = this.get_url_params();
        //console.log(parametros);
        //verificar se existe o parametro tipo na url
        if(parametros['tipo'] == 'false'){
            var tipo_busca = parametros['tipo'];
        }
        //console.log(parametros);
        $.each(parametros, function(key, value){
            //console.log(key, value);
            if(key == 's'){
                $('#formsearch').find('input[type="search"]').val(value);
                //console.log('search', value);
            }else if(key == 'search'){
                $('#formsearch-posts').find('input[type="search"]').val(value);
            }else if(key == 'paged'){
                //this.page_add(this.type, value);
            }else if(key == 'taxonomy'){
                var taxonomias = JSON.parse(atob(value));
                filters = taxonomias;
            }else if(key == 'orderby'){
                if(this.type == 'free'){
                    $('#search-results-free-cards-orderby').val(value);
                }else{
                    //this.view_posts(false);
                    //this.view_results(true);
                    $('#search-results-cards-orderby').val(value);
                }
            }
        });
    
        return filters;
    }

    //Popular os filtros do formulário de busca
    static populate_filters(){
        this.add_to_queue('populate_filters');
        if(this.type != 'filters' && this.limpar && !this.zerar){
            filters = this.populate_inputs();
            //console.log(filters);
            $('#formsearch-posts').find('input[data-type="taxonomy"]').val('');
            $.each(filters, function(taxonomy, terms){
                
                $.each(terms, function(i, term){
                    
                    var input = $('#formsearch-posts').find('input[name="'+taxonomy+'"]');
                    
                    $('[data-busca="filtro"][data-typename="'+taxonomy+'"][value="'+term+'"]').prop('checked', true);
                    if(input.length > 0){
                        input.val(terms.join(','));
                    }else{
                        $('#formsearch-posts').append('<input type="hidden" name="'+taxonomy+'" value="'+terms.join(',')+'">');
                    }
                });
            });
        }
        //console.log('filters', filters);
    }

    // Função para obter o termo de busca do formulário
    static term() {
       this.add_to_queue('term');
        if(this.type == 'simples'){
            var form = $('#formsearch');
            var input = form.find('input[type="search"]');
            var value = input.val();
        }else{
            // Seleciona o formulário com o ID 'formsearch-posts'
            var form = $('#formsearch-posts');
            
            // Encontra o campo de entrada de texto do tipo 'search' dentro do formulário
            var input = form.find('input[type="search"]');
            
            // Obtém o valor atual do campo de entrada
            var value = input.val();
        }
        
        // Retorna o valor do campo de entrada
        return value;
    }

    static page() {
        this.add_to_queue('page');
        // Declara a variável 'id' que armazenará o ID do botão
        var id;
        // Se 'tipo' for verdadeiro, usa o botão 'btn-mostrar-mais-posts-livre'
        if (this.type  == 'free') {
            id = 'btn-mostrar-mais-posts-livre';
        } else if(this.type  == 'simples'){
            id = 'btn-mostrar-mais-resultados';
        } else {
            // Caso contrário, usa o botão 'btn-mostrar-mais-posts'
            id = 'btn-mostrar-mais-posts';
        }
        // Seleciona o botão com o ID armazenado em 'id'
        var btn = $('#' + id);
        // Obtém o atributo 'data-page' do botão selecionado
        var page = btn.attr('data-page');
        //console.log(page);
        // Retorna o valor da página
        return page;
    }

    static page_add(tipo = false, number) {
        this.add_to_queue('page_add');
        // Declara a variável 'btn' que armazenará o botão selecionado
        var btn;
        // Se 'tipo' for verdadeiro, usa o botão 'btn-mostrar-mais-posts-livre'
        if (this.type == 'free') {
            btn = $('#btn-mostrar-mais-posts-livre');
        } else if(this.type == 'simples'){
            btn = $('#btn-mostrar-mais-resultados');
        } else {
            // Caso contrário, usa o botão 'btn-mostrar-mais-posts'
            btn = $('#btn-mostrar-mais-posts');
        }
        // Define o atributo 'data-page' do botão selecionado com o valor de 'number'
        btn.attr('data-page', number);
    }

    static order_by(){
        this.add_to_queue('order_by');
        var order = '';
        if(this.type == 'free'){
            order = $('#search-results-free-cards-orderby').val();
        }else{
            order = $('#search-results-cards-orderby').val();
        }
        return order;
    }

    static taxonomy(){
        this.add_to_queue('taxonomy');
        //console.log('check_filters');
        filters = {};
        blocks = this.blocks;
    
        //se for a página de blog
        if($('body').hasClass('page-template-page-blog')){
            var modal = $('#modalBuscaBlog');
        }else{
            var modal = $('#modalBusca');
        }
    
        $("#search-results-filters-itens").find('button').remove();
    
        //Varrer todos os elementos com a classe .filtro-js que es e criar um array com os valores que estão marcados
        modal.find('[data-busca="filtro"]:checked').each(function(){
            var origem = $(this).data('typename');
            var term = $(this).val();
            var text = $(this).parent().find('label').text();
            var id = $(this).attr('id');
            var block = $(this).data('bloco');
    
            if (!filters[origem]) {
                filters[origem] = [];
            }
    
            //Verifica se o termo já não está no array
            if(filters[origem].indexOf(term) == -1){
                filters[origem].push(term);
                //pega o valor inteiro do blocks e incrementa 1
                blocks[block] = (blocks[block] || 0) + 1;
            }
            //console.log(filters);
            $("#search-results-filters-itens").append('<button class="btn button-text-icon-simple" data-id="'+id+'">'+text+'<i><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M3 6H5M5 6H21M5 6L5 20C5 20.5304 5.21071 21.0391 5.58579 21.4142C5.96086 21.7893 6.46957 22 7 22H17C17.5304 22 18.0391 21.7893 18.4142 21.4142C18.7893 21.0391 19 20.5304 19 20V6M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M10 11V17M14 11V17" stroke="#830071" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round"/></svg></i></button>');
        
        });
       
        this.view_update_count_filters_modal();
        return filters;
    }

    static action(){
        this.add_to_queue('action');
        var action = '';
        if(this.type != 'simples'){
            if($('body').hasClass('page-template-page-blog')){
                action = 'search_blog';
            }
        }else{
            action = 'search';
        }
        return action;
    }

    static search_for_url(taxonomies){
        this.add_to_queue('search_for_url');
        //console.log(taxonomies);
        if(this.type == 'simples'){
           var parametros = {'search': this.term()};
        }else{
            var parametros = {'search': this.term(), 'paged': 1, 'taxonomy': taxonomies, 'orderby': this.order_by()};
        }
        if((parametros['search'] != undefined && parametros['search'] != '') || (parametros['taxonomy'] && Object.keys(parametros['taxonomy']).length > 0)){
            //console.log(parametros['taxonomy'], parametros['search']);
            // Obtém a URL atual
            var urlAtual = window.location.href;
    
            // Limpa a URL removendo a string de consulta
            var urlLimpa = urlAtual.split('?')[0];
    
            // Converte os dados para uma string de consulta
            var queryString = Object.keys(parametros).map(function(key) {
                // Verifica se o valor do parâmetro é um objeto
                var value = parametros[key];
    
                //remove o parametro nonce da url
                if(key == 'nonce'){
                    return '';
                }
    
                //Se o tipo for Simples, transforma o parametro search em s
                if(key == 'search'){
                    key = 's';
                }
    
                if (typeof value === 'object') {
                    // Converte o objeto em uma string JSON
                    value = JSON.stringify(value);
                }
                
                if(key == 'taxonomy' || key == 'filtros' || key == 'ob'){
                    // Retorna a chave e o valor codificado
                    //return key + "=" + encodeURIComponent(value);
                    // Codifica para Base64
                    return key + "=" + btoa(value);
                }
                if(value && (value != 'undefined' && value != '') && key != 'action'){
                    return key + "=" + value;
                }else{
                    return '';
                }
            }).join("&");
    
            //console.log(queryString);
            //remove & do início da string
            queryString = queryString.replace(/^&+/,'');
            //remove & do final da string
            queryString = queryString.replace(/&+$/,'');
            //remove & duplicados
            queryString = queryString.replace(/&+/g,'&');
            //remove ? do final da string
            queryString = queryString.replace(/\?+$/,'');
    
            // Constrói a URL final com os parâmetros da consulta
            var urlFinal = urlLimpa + "?" + queryString;
    
            // Atualiza a barra de endereços sem recarregar a página
            window.history.pushState({path: urlFinal}, '', urlFinal);
        }else{
            var urlAtual = window.location.href;
            var urlLimpa = urlAtual.split('?')[0];
            window.history.pushState({path: urlLimpa}, '', urlLimpa);
        }
    }

    // Funções para exibir e ocultar resultados

    static view_loader(view = false){
        this.add_to_queue('view_loader');
        // Seleciona o elemento com o ID 'search-results-loader'
        var loader = $('#search-results-loader-cards');
        
        // Se 'view' for verdadeiro, remove a classe 'd-none' para exibir o carregador
        if (view) {
            loader.removeClass('d-none');
        } else {
            // Caso contrário, adiciona a classe 'd-none' para ocultar o carregador
            loader.addClass('d-none');
        }
    }


    static view_update_count_filters_modal(){
        this.add_to_queue('view_update_count_filters_modal');
        var total_de_filtros = 0; //Contador de filtros total
        $('.accordion-item').find('span.badge').html(0);
        
        $.each(this.blocks, function(tipo, quantidade){
            //console.log(tipo, quantidade);
            $('.accordion-item[data-bloco="'+tipo+'"]').find('span.badge').html(quantidade);
            total_de_filtros += quantidade;
        });
        
        $('.total-de-filtros').html(total_de_filtros);
        $('#search-results-clear-filters-number').html(total_de_filtros);
        if(total_de_filtros > 0){
            //$('.total-de-filtros').removeClass('d-none');
            //$('.btn-filter i').addClass('d-none');
            $('#search-results header').addClass('has-filter');
            $('#search-results-filters').removeClass('d-none');
            $('#search-results-clear-filters').removeClass('invisible');
            $('#destaques').addClass('d-none');
        }else{
            //$('.total-de-filtros').addClass('d-none');
            //$('.btn-filter i').removeClass('d-none');
            $('#search-results header').removeClass('has-filter');
            $('#search-results-filters').addClass('d-none');
            $('#search-results-clear-filters').addClass('invisible');
            $('#destaques').removeClass('d-none');
        }
        //toggleClearFiltersModal(total_de_filtros);
    }

    static view_clear_filters_modal(){
        this.add_to_queue('view_clear_filters_modal');
        // Limpa os campos de taxonomia do formulário de busca
        if(this.zerar){
            this.clean_url_params();
            $('[data-busca="filtro"]:checked').prop('checked', false);
            filters = {};
            blocks = {
                'category': 0
            };
            this.view_update_count_filters_modal();
        }
    }

    static clean_url_params(){
        this.add_to_queue('clean_url_params');
        // Limpa os campos de taxonomia do formulário de busca
        if(this.limpar){
            //remove todos os parametros da url
            var urlAtual = window.location.href;
            // Limpa a URL removendo a string de consulta
            var urlLimpa = urlAtual.split('?')[0];
            window.history.pushState({path: urlLimpa}, '', urlLimpa);
        }
    }

    static clean_cards() {
        this.add_to_queue('clean_cards');
        if(this.limpar){
            $('.before-placeholder-card-js').removeClass('d-none');
            var cards = $('#search-results-free-cards,#search-results-cards');
            //Remover todo o html que não contém a classe 'placeholder-card-js'

            cards.children('.card-content-js').remove();
            $('.after-placeholder-card-js').remove();

            //Volta o atributo dos botões de mostrar mais para 1
            $('#btn-mostrar-mais-posts-livre').attr('data-page', 1);
            $('#btn-mostrar-mais-posts').attr('data-page', 1);
        }
    }

    // O parâmetro 'view' determina se os cartões serão exibidos ou removidos
    static view_placeholder_cards(view = false) {
    this.add_to_queue('view_placeholder_cards');
    // Se 'view' for verdadeiro, remove a classe 'd-none' dos elementos com a classe 'placeholder-card-js'
    if (view) {
        $('.after-placeholder-card-js').removeClass('d-none');
    } else {
        $('.after-placeholder-card-js').addClass('d-none');
    }
    }

    //Define o comportamento do termo que aparece para a quantidade de resultados, caso alguma taxonomia importante for selecionada
    static view_number_of_results(tipo, numero){
        this.add_to_queue('view_number_of_results');
        var resultado = '';
        var number = '';
        
        //se tiver taxonomia principal selecionada
        if(this.blocks[this.taxonomiaPrincipal] == 1){
            //pegar o termo da categoria principal
            var term = $('[data-busca="filtro"][data-typename="'+this.taxonomiaPrincipal+'"]:checked').parent().find('label').text();
            //console.log(term);
            resultado = term;
            number = '(' + numero + ')';
        }else{
            resultado = (numero == 1) ? 'Resultados encontrados' : 'Resultados encontrados';
            number = '(' + numero + ')';
        }
        
        if(tipo == 'free'){
            $('#search-results-free-cards-number').removeClass('d-none');
            $('#search-results-free-cards-number').html(number);
        }else{
            $('#search-results-cards-results').html(resultado);
            $('#search-results-cards-number').removeClass('d-none');
            $('#search-results-cards-number').html(number);
        }
    }

    static view_button_show_more(id, view = false) {
        this.add_to_queue('view_button_show_more');
        // Seleciona o botão com o ID fornecido
        var btn = $('#' + id);
        
        // Se 'view' for verdadeiro, remove a classe 'd-none' para exibir o botão
        if (view) {
            btn.removeClass('d-none');
        } else {
            // Caso contrário, adiciona a classe 'd-none' para ocultar o botão
            btn.addClass('d-none');
        }
    }

    // Função para executar a requisição AJAX
    static execute_ajax(data,page){
        this.add_to_queue('execute_ajax');
         // Se já houver uma requisição em andamento, cancela a requisição anterior
         if (search_request) {
            search_request.abort();
        }

        // Realiza a requisição AJAX
        let self = this;
        search_request = $.ajax({
            url: url_ajax,
            type: 'POST', // Tipo de requisição
            data: data, // Dados a serem enviados
            dataType: 'json', // Tipo de dados a serem retornados
            beforeSend: function() {
                // Antes de enviar a requisição, exibe a animação de carregamento
                if(page == 1){
                    self.view_loader(true);
                }
                self.view_placeholder_cards(true);
            },
            success: function(response) {
                //console.log(response);
                // Quando a requisição for bem-sucedida
                self.view_loader(false); // Oculta o carregador

                //checar se o tipo é = livre porém se existe na url atual um parametro tipo com um valor undefined
                if(response['livre'] == 'false'){
                    self.type = 'undefined';
                }
                if(self.type == 'free'){
                    $('#search-results').addClass('d-none');
                    $('#posts').removeClass('d-none');
                }else{
                    $('#search-results').removeClass('d-none');
                    $('#posts').addClass('d-none');
                }
                
                var cards = (self.type == 'free') ? $("#search-results-free-cards") : $('#search-results-cards');

                // Se for a primeira página, substitui o conteúdo dos cartões
                if (response['paged'] == 1) {
                    cards.html(response['html']);
                } else {
                    // Caso contrário, adiciona o novo conteúdo aos cartões existentes
                    self.view_placeholder_cards(false); // Oculta os cartões de placeholder
                    if(response['html'] == ''){
                        cards.children(':not(.before-placeholder-card-js)').remove();
                        cards.append(response['html']);
                        $('.no-results-js').removeClass('d-none');
                    }else{
                        cards.append(response['html']);
                        $('.no-results-js').addClass('d-none');
                    }
                    // view_position(); // (Comentado) Rola a página até a posição dos resultados
                }

                //alert(self.type);
                /* if(self.type == 'free'){
                    $("#destaques").addClass('d-none');
                } else {
                    $("#destaques").removeClass('d-none');
                } */

                // Controla a visibilidade do botão "Mostrar mais" com base na resposta
                if (response['carregar_mais']) {
                    if (self.type == 'free') {
                        self.view_number_of_results('free', response['total']);
                        self.view_button_show_more('btn-mostrar-mais-posts-livre', true);
                        self.page_add('free', response['paged']);
                    }else if(self.type == 'simples'){
                        self.view_number_of_results(false, response['total']);
                        self.view_button_show_more('btn-mostrar-mais-resultados', true);
                        self.page_add('simples', response['paged']);
                    }else{
                        self.view_number_of_results(false, response['total']);
                        self.view_button_show_more('btn-mostrar-mais-posts', true);
                        self.page_add(false, response['paged']);
                    }
                } else {
                    if (self.type == 'free') {
                        self.view_button_show_more('btn-mostrar-mais-posts-livre', false);
                        self.view_number_of_results('free', response['total']);
                    }else if(self.type == 'simples'){
                        self.view_button_show_more('btn-mostrar-mais-resultados', false);
                        self.view_number_of_results(false, response['total']);
                    } else {
                        self.view_button_show_more('btn-mostrar-mais-posts', false);
                        self.view_number_of_results(false, response['total']);
                    }
                }


            },
            complete: function() {
                $('.before-placeholder-card-js').addClass('d-none');
                $('.after-placeholder-card-js').addClass('d-none');
            },error: function(response) {
                //console.log(response);
                // Em caso de erro, exibe uma mensagem de erro
                self.view_loader(false); // Oculta o carregador
            }
        });
    }

    static add_to_queue(nome){
        //Função que adiciona funções a fila
        this.queue.push(nome);
    }

    static get_queue(){
        //Função que retorna a fila de funções
        console.log(this.queue);
    }

    static view_update_filters_modal(){
        this.add_to_queue('view_update_filters_modal');
        var taxonomias = {};
        var taxonomias = this.taxonomy();
        this.search_for_url(taxonomias);
    }

    

    
}
