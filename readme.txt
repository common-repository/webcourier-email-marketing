=== WebCourier Email Marketing Plugin ===
Contributors: D'Gledson Rabelo
Tags: WebCourier, user management, mailin list, add users
Requires at least: 3.0.1
Tested up to: 4.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin feito para envio de campanhas do webcourier.

== Description ==
Este plugin permite que você envie campanhas de email diretamente do seu site para seus grupos de usuários wordpress.

Muito simples de usar, você só precisa criar o seu template a partir de um arquivo ou criando o seu código, criar sua campanha e enviá-la para o grupo de sua escolha.

São criados automaticamente 3 grupos para você na hora da sincronização de sua chave API.

1. Grupo Completo - Este grupo é constituído por todos os usuários do seu site.
2. Grupo Inscritos - É uma fração do seu grupo completo, composto de todos os usuários do seu site, exceto administradores.
3. Grupo WooCommerce - Grupo com os usuários que realizaram qualquer tipo de compra no seu site via WooCommerce.

É sincronizado com a aplicação, importando os seus grupos de usuários na hora da criação.

Você pode atualizar os seus grupos na página de configuração.

== Installation ==

1. Registre-se em https://app.webcourier.com.br/ e crie sua chave API campanhas na seção de administradores.
2. No seu site wordpress, faça o upload do `webcourier-email-marketing.zip` para a pasta `wp-content/plugins`.
3. Ative o plugin pelo menu 'Plugins' no Wordpress.
4. Sincronize sua chave API com o plugin webcourier.
5. Crie templates e envie suas campanhas.

== Changelog ==

= 1.0 =
* Release inicial.

= 1.1 =
* Modificações para atualizar com o webcourier atual.

= 1.2 =
* Adicionado nome remetente nas campanhas
* Desacoplado completamente o relatório das campanhas da aplicação