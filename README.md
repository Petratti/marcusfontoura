# Documentação técnica

## Descrição Geral do Projeto  
- **Nome do site:** Marcus Fontoura
- **Endereço do site:** https://inesplorato.com.br/

**Tecnologias e ferramentas principais:**  
- WordPress
- ACF Pro
- WPML

## Ambiente de desenvolvimento

### Docker  
O projeto utiliza Docker para rodar no ambiente de desenvolvimento/local.

- **Comando para rodar o ambiente:** docker-compose up --build
- **Endereço local:** http://localhost:8080/
- **Banco de dados local:** db:3306

## Tema
**Tema Base:** Sintrópika

**Compilação de Assets (JS e CSS) com Gulp:**
O projeto utiliza **Gulp** para gerenciar e automatizar tarefas relacionadas à compilação de arquivos JavaScript e CSS (ou SCSS).
- **Versão do Nodejs:** 22
- **Acesse o diretório do projeto pelo terminal:** cd src/wp-content/themes/sintropika
- **Instale as dependências do projeto:** npm install --save-dev
- **Inicie o gulp:** gulp

## Estrutura geral

### Páginas
- Home
- O que fazemos
- A inesplorato
- Contato
- Blog / Perspectivas (Agregadora)


### Tipos de post
- Post (Blog)
    - Com imagem
    - Sem imagem

### Taxonomias
- Categoria
- Autor (Nome, descrição e foto)
- Cliente

### Campos customizados estruturais
- Blocos de Destaques
    - Apenas Super destaque, no blog

### Blocos customizados importantes
- Barra de clientes citados (Não é custom block)
- Barra de ação FIXA (Não é custom block)
- Bloco – Botão de ação
- Bloco - Destaque cliente

### Filtros
- Página Blog
    - Comportamento padrão

### Integrações
- RD Station
    - Assinatura de Newsletter

### Idiomas
- WPML
    - Português (Principal)
    - Inglês

### Atualizações  
- **WordPress Core:** Baixar e instalar a última versão do WordPress no ambiente local. Após testar no ambiente local, enviar para produção os diretórios wp-admin, wp-includes e wp-content/languages, além dos arquivos do diretório raíz, exceto os arquivos wp-config.php, wp-config-dev.php, wp-config-prd.php e wp-config-sample.php.
- **Plugins:** Baixar e instalar a última versão dos plugins no ambiente local. Após testar no ambiente local, enviar para produção.

## Hospedagem e manutenção

### Hospedagem  
- **Ambiente de produção:** ...

### Manutenção  
- **Preventiva:** ...
- **Suporte:** ...