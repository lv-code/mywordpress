<?php
/**
 * WordPress基础配置文件。
 *
 * 本文件包含以下配置选项：MySQL设置、数据库表名前缀、密钥、
 * WordPress语言设定以及ABSPATH。如需更多信息，请访问
 * {@link http://codex.wordpress.org/zh-cn:%E7%BC%96%E8%BE%91_wp-config.php
 * 编辑wp-config.php}Codex页面。MySQL设置具体信息请咨询您的空间提供商。
 *
 * 这个文件被安装程序用于自动生成wp-config.php配置文件，
 * 您可以手动复制这个文件，并重命名为“wp-config.php”，然后填入相关信息。
 *
 * @package WordPress
 */

// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //

/** WordPress数据库的名称 */
if(isset($_SERVER['HTTP_HOST']) ){
	if(strpos($_SERVER['HTTP_HOST'],'upersmile.com') !== false) {
		define('ENVIRONMENT', 'upersmile');
	}else if(strpos($_SERVER['HTTP_HOST'],'lv-code.com') !== false){
		define('ENVIRONMENT', 'verify');
	}else{
		define('ENVIRONMENT', 'production');
	}
}

define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/vagrant/wordpress/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'wp_'.ENVIRONMENT);
//define('DB_NAME', 'wordpress');

/** MySQL数据库用户名 */
define('DB_USER', 'root');

/** MySQL数据库密码 */
define('DB_PASSWORD', '123');

/** MySQL主机 */
define('DB_HOST', 'localhost');

/** 创建数据表时默认的文字编码 */
define('DB_CHARSET', 'utf8');

/** 数据库整理类型。如不确定请勿更改 */
define('DB_COLLATE', '');

/**#@+
 * 身份认证密钥与盐。
 *
 * 修改为任意独一无二的字串！
 * 或者直接访问{@link https://api.wordpress.org/secret-key/1.1/salt/
 * WordPress.org密钥生成服务}
 * 任何修改都会导致所有cookies失效，所有用户将必须重新登录。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Akk.^ajrYVG{j7VaB4Ns0s7ckF^{TrW(=ru>06oFn;ic0v=Z,b%c/OeDCe{pnN.T');
define('SECURE_AUTH_KEY',  'XB y@5h<wO6/XC5[R3UQkyks2j&Z~4mv@],Un;~ViFQ}se}2}na`|B*64M@R|r^$');
define('LOGGED_IN_KEY',    'S?cQ[%cR t*DWSYHsbB%$SE,tl=O*,R$@ Y+O#9jZ(?Oj.IUvP#{`kkt!PD&ym&f');
define('NONCE_KEY',        '=7%hBYU{12:*XT>G~{?SLFG?, UcK8`55k`t^sn3|.iFBgT`%_|2#v%e[z#e?jj3');
define('AUTH_SALT',        '*i(Ol8{fela9x9wxaVI/=E8o8>aPbfUNr?~c c@(uCwZsa&f.js]WLk[*u~36u>V');
define('SECURE_AUTH_SALT', '@(t{Jbpr&q7!~4qF|@5[iMKZaJ{QoRgr<JpWD76~[|chiW&@=f8v1gyOb*D-X$>T');
define('LOGGED_IN_SALT',   'xTX|v6ubM,EMb!OP&)!gr:gw$V`8THBvg(d[-VdX;^8*T~R></rG)(;8_jH;C`;R');
define('NONCE_SALT',       'Wk)_QD]a.NBc$LtACOzqoVE>9?;;Xs3&q^W6c>jH[rdZ6qz)ao6lb)([LvpV>^7A');

/**#@-*/

/**
 * WordPress数据表前缀。
 *
 * 如果您有在同一数据库内安装多个WordPress的需求，请为每个WordPress设置
 * 不同的数据表前缀。前缀名只能为数字、字母加下划线。
 */
$table_prefix  = 'wp_';

/**
 * 开发者专用：WordPress调试模式。
 *
 * 将这个值改为true，WordPress将显示所有用于开发的提示。
 * 强烈建议插件开发者在开发环境中启用WP_DEBUG。
 */
define('WP_DEBUG', false);

/**
 * zh_CN本地化设置：启用ICP备案号显示
 *
 * 可在设置→常规中修改。
 * 如需禁用，请移除或注释掉本行。
 */
define('WP_ZH_CN_ICP_NUM', true);

/* 好了！请不要再继续编辑。请保存本文件。使用愉快！ */

/** WordPress目录的绝对路径。 */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** 设置WordPress变量和包含文件。 */
//require_once(ABSPATH . 'wp-settings.php');

if(WP_ADMIN === true) {   
	define ('WPLANG', 'zh_CN');   
} else {   
	define ('WPLANG', 'zh_CN');   
}   
require_once(ABSPATH . 'wp-settings.php');  
