<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do banco de dados
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
// ** Configurações do banco de dados - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME',"campa653_encontrodeeducadores");
/** Usuário do banco de dados MySQL */
define('DB_USER',"campa653_encontrodeeduc");
/** Senha do banco de dados MySQL */
define('DB_PASSWORD',"CMb07{RRnmE!");
/** Nome do host do MySQL */
define('DB_HOST',"localhost");
/** Charset do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET','utf8');
/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE','');
define( 'AUTOMATIC_UPDATER_DISABLED', true );
define( 'WP_AUTO_UPDATE_CORE', false );
define( 'WP_MEMORY_LIMIT', '512M' );
define('FS_METHOD','direct');
define('WPLANG','pt_BR');
define( 'WP_DEBUG', false );
ini_set('log_errors','On');
ini_set('display_errors','Off');
ini_set('error_reporting',E_ALL);
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
//define('DISALLOW_FILE_EDIT',true);
//define('DISALLOW_FILE_MODS',true);
//define( 'DISABLE_WP_CRON',true);
define('DUPLICATOR_AUTH_KEY','c7e0ea5f0756cee8a5db5fab5a3ea6e4');
/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'pP.hfpdkf|=bmm0iZYjZU]/C3,|1|*)+{naKu:0Dclp>R8sx{P4ZPDls>,7!TR!B');
define('SECURE_AUTH_KEY',  '8LhU?wtL.>mCj@pmQ2%F.FMd@:o?)+)F4)-T2KW 9-}Sz|p(?lgFUYy*Z`F0|H-1');
define('LOGGED_IN_KEY',    'b*suyIdFC+-< *(|{-b+4qZn+JEk1XJAH5g7EN^7&_(3?/uqIU=NO$fdCHZ}02 Y');
define('NONCE_KEY',        'ds[?WP!bT0cB1U]RLg |:549*zz.,v`]=(]FAQBU8/}*B_Kc=h6W|K/7z9tW=bM>');
define('AUTH_SALT',        'c|CU_~#|S%!(i;]h2{v&TdczMoA9t-Q>9^==ZKr1DemsbUysw6)#aakz?Dr2141Y');
define('SECURE_AUTH_SALT', ' ^#dt2|B_+2t)bZmogkWz@ ,fTK~upvzL,d.w~uiGge?_ K;n/TrmJ4gag|LYG!*');
define('LOGGED_IN_SALT',   '%!K=;FFgU,[=@WsT!~PRHEG(|7{S7<bML_G;CXEzZm+AVP(T:Q!DG{~U#j6H5cN-');
define('NONCE_SALT',       'asKi3<_3Bc7.BS9oY{,z-`xSm3(/hq3qU]5=0@6N/vG__m0h<a-&q6T7N1P{[/jQ');
/**#@-*/
/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'jl_';
/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
/* Adicione valores personalizados entre esta linha até "Isto é tudo". */
/* Isto é tudo, pode parar de editar! :) */
/** Caminho absoluto para o diretório WordPress. */
define( 'WP_PLUGIN_DIR', '/home2/campa653/encontrodeeducadores.clientesdream.com.br/wp-content/plugins' );
define( 'WPMU_PLUGIN_DIR', '/home2/campa653/encontrodeeducadores.clientesdream.com.br/wp-content/mu-plugins' );
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}
/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';