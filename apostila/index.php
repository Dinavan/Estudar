<?php
include_once('apostila_session.php');
session_start();
if (!function_exists("sc_check_mobile"))
{
    include_once("../_lib/lib/php/nm_check_mobile.php");
}
$_SESSION['scriptcase']['device_mobile'] = sc_check_mobile();
if ($_SESSION['scriptcase']['device_mobile'])
{
    if (!isset($_SESSION['scriptcase']['display_mobile']))
    {
        $_SESSION['scriptcase']['display_mobile'] = true;
    }
    if ($_SESSION['scriptcase']['display_mobile'] && isset($_POST['_sc_force_mobile']) && 'out' == $_POST['_sc_force_mobile'])
    {
        $_SESSION['scriptcase']['display_mobile'] = false;
    }
    elseif (!$_SESSION['scriptcase']['display_mobile'] && isset($_POST['_sc_force_mobile']) && 'in' == $_POST['_sc_force_mobile'])
    {
        $_SESSION['scriptcase']['display_mobile'] = true;
    }
}
else
{
    $_SESSION['scriptcase']['display_mobile'] = false;
}
$_SESSION['scriptcase']['apostila']['glo_nm_path_prod'] = "";
$_SESSION['scriptcase']['apostila']['glo_nm_perfil']    = "concurso";
$_SESSION['scriptcase']['apostila']['glo_nm_usa_grupo'] = "";

class apostila_class
{
  var $Db;

 function sc_Include($path, $tp, $name)
 {
     if ((empty($tp) && empty($name)) || ($tp == "F" && !function_exists($name)) || ($tp == "C" && !class_exists($name)))
     {
         include_once($path);
     }
 } // sc_Include

 function apostila_menu()
 {
    global $apostila_menuData;
    if (isset($_POST["nmgp_idioma"]))  
    { 
        $Temp_lang = explode(";" , $_POST["nmgp_idioma"]);  
        if (isset($Temp_lang[0]) && !empty($Temp_lang[0]))  
         { 
             $_SESSION['scriptcase']['str_lang'] = $Temp_lang[0];
        } 
        if (isset($Temp_lang[1]) && !empty($Temp_lang[1])) 
        { 
             $_SESSION['scriptcase']['str_conf_reg'] = $Temp_lang[1];
        } 
    } 
  
    if (isset($_POST["nmgp_schema"]))  
    { 
        $_SESSION['scriptcase']['str_schema_all'] = $_POST["nmgp_schema"] . "/" . $_POST["nmgp_schema"];
    } 
   
$nm_versao_sc  = "" ; 
$_SESSION['scriptcase']['apostila']['contr_erro'] = 'off';
if (isset($_POST) && !empty($_POST))
{
    foreach ($_POST as $nmgp_var => $nmgp_val)
    {
        if (substr($nmgp_var, 0, 11) == "SC_glo_par_")
        {
            $nmgp_var = substr($nmgp_var, 11);
            $nmgp_val = $_SESSION[$nmgp_val];
        }
        if ($nmgp_var == "nmgp_parms" && substr($nmgp_val, 0, 8) == "@SC_par@")
        {
            $SC_Ind_Val = explode("@SC_par@", $nmgp_val);
            $nmgp_val = $_SESSION['sc_session'][$SC_Ind_Val[1]][$SC_Ind_Val[2]]['Lig_Md5'][$SC_Ind_Val[3]];
        }
        $$nmgp_var = $nmgp_val;
    }
}
if (isset($_GET) && !empty($_GET))
{
    foreach ($_GET as $nmgp_var => $nmgp_val)
    {
        if (substr($nmgp_var, 0, 11) == "SC_glo_par_")
        {
            $nmgp_var = substr($nmgp_var, 11);
            $nmgp_val = $_SESSION[$nmgp_val];
        }
        if ($nmgp_var == "nmgp_parms" && substr($nmgp_val, 0, 8) == "@SC_par@")
        {
            $SC_Ind_Val = explode("@SC_par@", $nmgp_val);
            $nmgp_val = $_SESSION['sc_session'][$SC_Ind_Val[1]][$SC_Ind_Val[2]]['Lig_Md5'][$SC_Ind_Val[3]];
        }
        $$nmgp_var = $nmgp_val;
    }
}
if (!isset($_SERVER['HTTP_REFERER']) || (!isset($nmgp_parms) && !isset($script_case_init) && !isset($script_case_session) && !isset($nmgp_start) ))
{
    $_SESSION['sc_session']['SC_parm_violation'] = true;
}
$nm_url_saida = "";
if (isset($nmgp_url_saida))
{
    $nm_url_saida = $nmgp_url_saida;
    if (isset($script_case_init))
    {
        $nm_url_saida .= "?script_case_init=" . $script_case_init;
    }
}
if (isset($_POST["nmgp_idioma"]) || isset($_POST["nmgp_schema"]))  
{ 
    $nm_url_saida = $_SESSION['scriptcase']['sc_saida_apostila'];
}
elseif (!empty($nm_url_saida))
{
    $_SESSION['scriptcase']['sc_url_saida'][$script_case_init]  = $nm_url_saida;
    $_SESSION['scriptcase']['sc_saida_apostila'] = $nm_url_saida;
}
else
{
    $_SESSION['scriptcase']['sc_saida_apostila'] = (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : "javascript:window.close()";
}
$Campos_Mens_erro = "";
$sc_site_ssl   = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? true : false;
$NM_dir_atual = getcwd();
if (empty($NM_dir_atual))
{
    $str_path_sys          = (isset($_SERVER['SCRIPT_FILENAME'])) ? $_SERVER['SCRIPT_FILENAME'] : $_SERVER['ORIG_PATH_TRANSLATED'];
    $str_path_sys          = str_replace("\\", '/', $str_path_sys);
}
else
{
    $sc_nm_arquivo         = explode("/", $_SERVER['PHP_SELF']);
    $str_path_sys          = str_replace("\\", "/", getcwd()) . "/" . $sc_nm_arquivo[count($sc_nm_arquivo)-1];
}
      //check publication with the prod
      $str_path_apl_url = $_SERVER['PHP_SELF'];
      $str_path_apl_url = str_replace("\\", '/', $str_path_apl_url);
      $str_path_apl_url = substr($str_path_apl_url, 0, strrpos($str_path_apl_url, "/"));
      $str_path_apl_url = substr($str_path_apl_url, 0, strrpos($str_path_apl_url, "/")+1);
      $str_path_apl_dir = substr($str_path_sys, 0, strrpos($str_path_sys, "/"));
      $str_path_apl_dir = substr($str_path_apl_dir, 0, strrpos($str_path_apl_dir, "/")+1);
//check prod
if(empty($_SESSION['scriptcase']['apostila']['glo_nm_path_prod']))
{
        /*check prod*/$_SESSION['scriptcase']['apostila']['glo_nm_path_prod'] = $str_path_apl_url . "_lib/prod";
}
$this->sc_charset['UTF-8'] = 'utf-8';
$this->sc_charset['ISO-2022-JP'] = 'iso-2022-jp';
$this->sc_charset['ISO-2022-KR'] = 'iso-2022-kr';
$this->sc_charset['ISO-8859-1'] = 'iso-8859-1';
$this->sc_charset['ISO-8859-2'] = 'iso-8859-2';
$this->sc_charset['ISO-8859-3'] = 'iso-8859-3';
$this->sc_charset['ISO-8859-4'] = 'iso-8859-4';
$this->sc_charset['ISO-8859-5'] = 'iso-8859-5';
$this->sc_charset['ISO-8859-6'] = 'iso-8859-6';
$this->sc_charset['ISO-8859-7'] = 'iso-8859-7';
$this->sc_charset['ISO-8859-8'] = 'iso-8859-8';
$this->sc_charset['ISO-8859-8-I'] = 'iso-8859-8-i';
$this->sc_charset['ISO-8859-9'] = 'iso-8859-9';
$this->sc_charset['ISO-8859-10'] = 'iso-8859-10';
$this->sc_charset['ISO-8859-13'] = 'iso-8859-13';
$this->sc_charset['ISO-8859-14'] = 'iso-8859-14';
$this->sc_charset['ISO-8859-15'] = 'iso-8859-15';
$this->sc_charset['WINDOWS-1250'] = 'windows-1250';
$this->sc_charset['WINDOWS-1251'] = 'windows-1251';
$this->sc_charset['WINDOWS-1252'] = 'windows-1252';
$this->sc_charset['WINDOWS-1253'] = 'windows-1253';
$this->sc_charset['WINDOWS-1254'] = 'windows-1254';
$this->sc_charset['WINDOWS-1255'] = 'windows-1255';
$this->sc_charset['WINDOWS-1256'] = 'windows-1256';
$this->sc_charset['WINDOWS-1257'] = 'windows-1257';
$this->sc_charset['KOI8-R'] = 'koi8-r';
$this->sc_charset['BIG-5'] = 'big5';
$this->sc_charset['EUC-CN'] = 'EUC-CN';
$this->sc_charset['GB18030'] = 'GB18030';
$this->sc_charset['GB2312'] = 'gb2312';
$this->sc_charset['EUC-JP'] = 'euc-jp';
$this->sc_charset['SJIS'] = 'shift-jis';
$this->sc_charset['EUC-KR'] = 'euc-kr';
$_SESSION['scriptcase']['charset_entities']['UTF-8'] = 'UTF-8';
$_SESSION['scriptcase']['charset_entities']['ISO-8859-1'] = 'ISO-8859-1';
$_SESSION['scriptcase']['charset_entities']['ISO-8859-5'] = 'ISO-8859-5';
$_SESSION['scriptcase']['charset_entities']['ISO-8859-15'] = 'ISO-8859-15';
$_SESSION['scriptcase']['charset_entities']['WINDOWS-1251'] = 'cp1251';
$_SESSION['scriptcase']['charset_entities']['WINDOWS-1252'] = 'cp1252';
$_SESSION['scriptcase']['charset_entities']['BIG-5'] = 'BIG5';
$_SESSION['scriptcase']['charset_entities']['EUC-CN'] = 'GB2312';
$_SESSION['scriptcase']['charset_entities']['GB2312'] = 'GB2312';
$_SESSION['scriptcase']['charset_entities']['SJIS'] = 'Shift_JIS';
$_SESSION['scriptcase']['charset_entities']['EUC-JP'] = 'EUC-JP';
$_SESSION['scriptcase']['charset_entities']['KOI8-R'] = 'KOI8-R';
$str_path_web   = $_SERVER['PHP_SELF'];
$str_path_web   = str_replace("\\", '/', $str_path_web);
$str_path_web   = str_replace('//', '/', $str_path_web);
$str_root       = substr($str_path_sys, 0, -1 * strlen($str_path_web));
$path_link      = substr($str_path_web, 0, strrpos($str_path_web, '/'));
$path_link      = substr($path_link, 0, strrpos($path_link, '/')) . '/';
$path_btn       = $str_root . $path_link . "_lib/buttons/";
$path_imag_cab  = $path_link . "_lib/img";
$this->path_botoes    = '../_lib/img';
$this->path_imag_apl  = $str_root . $path_link . "_lib/img";
$path_help      = $path_link . "_lib/webhelp/";
$path_libs      = $str_root . $_SESSION['scriptcase']['apostila']['glo_nm_path_prod'] . "/lib/php";
$path_third     = $str_root . $_SESSION['scriptcase']['apostila']['glo_nm_path_prod'] . "/third";
$url_third      = $_SESSION['scriptcase']['apostila']['glo_nm_path_prod'] . "/third";
$path_adodb     = $str_root . $_SESSION['scriptcase']['apostila']['glo_nm_path_prod'] . "/third/adodb";
$path_apls      = $str_root . substr($path_link, 0, strrpos($path_link, '/'));
$path_img_old   = $str_root . $path_link . "apostila/img";
$this->path_css = $str_root . $path_link . "_lib/css/";
$path_lib_php   = $str_root . $path_link . "_lib/lib/php";
$menu_largura   = '400';
$menu_mobile_hide          = 'S';
$menu_mobile_inicial_state = 'escondido';
$menu_mobile_hide_onclick  = 'S';
$menutree_mobile_float     = 'S';
$menu_mobile_hide_icon     = 'N';
$mobile_menu_mobile_hide          = 'S';
$mobile_menu_mobile_inicial_state = 'aberto';
$mobile_menu_mobile_hide_onclick  = 'S';
$mobile_menutree_mobile_float     = 'N';
$mobile_menu_mobile_hide_icon     = 'N';
if (isset($_SESSION['scriptcase']['user_logout']))
{
    foreach ($_SESSION['scriptcase']['user_logout'] as $ind => $parms)
    {
        if (isset($_SESSION[$parms['V']]) && $_SESSION[$parms['V']] == $parms['U'])
        {
            unset($_SESSION['scriptcase']['user_logout'][$ind]);
            $nm_apl_dest = $parms['R'];
            $dir = explode("/", $nm_apl_dest);
            if (count($dir) == 1)
            {
                $nm_apl_dest = str_replace(".php", "", $nm_apl_dest);
                $nm_apl_dest = $path_link . SC_dir_app_name($nm_apl_dest) . "/";
            }
?>
            <html>
            <body>
            <form name="FRedirect" method="POST" action="<?php echo $nm_apl_dest; ?>" target="<?php echo $parms['T']; ?>">
            </form>
            <script>
             document.FRedirect.submit();
            </script>
            </body>
            </html>
<?php
            exit;
        }
    }
}
if (!defined("SC_ERROR_HANDLER"))
{
    define("SC_ERROR_HANDLER", 1);
    include_once(dirname(__FILE__) . "/apostila_erro.php");
}
include_once(dirname(__FILE__) . "/apostila_erro.class.php"); 
$this->Erro = new apostila_erro();
$str_path = substr($_SESSION['scriptcase']['apostila']['glo_nm_path_prod'], 0, strrpos($_SESSION['scriptcase']['apostila']['glo_nm_path_prod'], '/') + 1);
if (!is_file($str_root . $str_path . 'devel/class/xmlparser/nmXmlparserIniSys.class.php'))
{
    unset($_SESSION['scriptcase']['nm_sc_retorno']);
    unset($_SESSION['scriptcase']['apostila']['glo_nm_conexao']);
}
/* Definição dos Caminhos */
$apostila_menuData          = array();
$apostila_menuData['path']  = array();
$apostila_menuData['url']   = array();
$NM_dir_atual = getcwd();
if (empty($NM_dir_atual))
{
    $apostila_menuData['path']['sys'] = (isset($_SERVER['SCRIPT_FILENAME'])) ? $_SERVER['SCRIPT_FILENAME'] : $_SERVER['ORIG_PATH_TRANSLATED'];
    $apostila_menuData['path']['sys'] = str_replace("\\", '/', $str_path_sys);
    $apostila_menuData['path']['sys'] = str_replace('//', '/', $str_path_sys);
}
else
{
    $sc_nm_arquivo                                   = explode("/", $_SERVER['PHP_SELF']);
    $apostila_menuData['path']['sys'] = str_replace("\\", "/", str_replace("\\\\", "\\", getcwd())) . "/" . $sc_nm_arquivo[count($sc_nm_arquivo)-1];
}
$apostila_menuData['url']['web']   = $_SERVER['PHP_SELF'];
$apostila_menuData['url']['web']   = str_replace("\\", '/', $apostila_menuData['url']['web']);
$apostila_menuData['path']['root'] = substr($apostila_menuData['path']['sys'],  0, -1 * strlen($apostila_menuData['url']['web']));
$apostila_menuData['path']['app']  = substr($apostila_menuData['path']['sys'],  0, strrpos($apostila_menuData['path']['sys'],  '/'));
$apostila_menuData['path']['link'] = substr($apostila_menuData['path']['app'],  0, strrpos($apostila_menuData['path']['app'],  '/'));
$apostila_menuData['path']['link'] = substr($apostila_menuData['path']['link'], 0, strrpos($apostila_menuData['path']['link'], '/')) . '/';
$apostila_menuData['path']['app'] .= '/';
$apostila_menuData['url']['app']   = substr($apostila_menuData['url']['web'],  0, strrpos($apostila_menuData['url']['web'],  '/'));
$apostila_menuData['url']['link']  = substr($apostila_menuData['url']['app'],  0, strrpos($apostila_menuData['url']['app'],  '/'));
if ($_SESSION['scriptcase']['apostila']['glo_nm_usa_grupo'] == "S")
{
    $apostila_menuData['url']['link']  = substr($apostila_menuData['url']['link'], 0, strrpos($apostila_menuData['url']['link'], '/'));
}
$apostila_menuData['url']['link']  .= '/';
$apostila_menuData['url']['app']   .= '/';

/* Itens do Menu */
$nm_img_fun_menu = ""; 
if (!isset($_SESSION['scriptcase']['str_lang']) || empty($_SESSION['scriptcase']['str_lang']))
{
    $_SESSION['scriptcase']['str_lang'] = "pt_br";
}
if (!isset($_SESSION['scriptcase']['str_conf_reg']) || empty($_SESSION['scriptcase']['str_conf_reg']))
{
    $_SESSION['scriptcase']['str_conf_reg'] = "pt_br";
}
$this->str_lang        = $_SESSION['scriptcase']['str_lang'];
$this->str_conf_reg    = $_SESSION['scriptcase']['str_conf_reg'];
if (!function_exists("NM_is_utf8"))
 {
   include_once("../_lib/lib/php/nm_utf8.php");
}
if (!function_exists("SC_dir_app_ini"))
{
    include_once("../_lib/lib/php/nm_ctrl_app_name.php");
}
SC_dir_app_ini('Estudar');
$this->str_schema_all = (isset($_SESSION['scriptcase']['str_schema_all']) && !empty($_SESSION['scriptcase']['str_schema_all'])) ? $_SESSION['scriptcase']['str_schema_all'] : "Sc8_Saphir/Sc8_Saphir";
if ($_SESSION['scriptcase']['apostila']['glo_nm_usa_grupo'] == "S")
{
    $path_apls     = substr($path_apls, 0, strrpos($path_apls, '/'));
}
$path_apls     .= "/";
include("../_lib/lang/". $this->str_lang .".lang.php");
include("../_lib/css/" . $this->str_schema_all . "_menuT.php");
include("../_lib/lang/config_region.php");
include("../_lib/lang/lang_config_region.php");
$this->sc_Include($path_lib_php . "/nm_functions.php", "", "") ; 
$this->sc_Include($path_lib_php . "/nm_data.class.php", "C", "nm_data") ; 
$this->nm_data = new nm_data("pt_br");
if(isset($this->Ini->Nm_lang))
{
    $Nm_lang = $this->Ini->Nm_lang;
}
else
{
    $Nm_lang = $this->Nm_lang;
}
$Str_btn_menu = trim($str_button) . "/" . trim($str_button) . $_SESSION['scriptcase']['reg_conf']['css_dir'] . ".php";
$Str_btn_css  = trim($str_button) . "/" . trim($str_button) . ".css";
include($path_btn . $Str_btn_menu);
if (!function_exists("nmButtonOutput"))
{
   include_once("../_lib/lib/php/nm_gp_config_btn.php");
}
asort($this->Nm_lang_conf_region);
$this->tab_grupo[0] = "Estudar/";
if ($_SESSION['scriptcase']['apostila']['glo_nm_usa_grupo'] != "S")
{
    $this->tab_grupo[0] = "";
}

    $_SESSION['scriptcase']['menu_atual'] = "apostila";
    $_SESSION['scriptcase']['menu_apls']['apostila'] = array();
    if (isset($_SESSION['scriptcase']['sc_connection']) && !empty($_SESSION['scriptcase']['sc_connection']))
    {
        foreach ($_SESSION['scriptcase']['sc_connection'] as $NM_con_orig => $NM_con_dest)
        {
            if (isset($_SESSION['scriptcase']['apostila']['glo_nm_conexao']) && $_SESSION['scriptcase']['apostila']['glo_nm_conexao'] == $NM_con_orig)
            {
/*NM*/          $_SESSION['scriptcase']['apostila']['glo_nm_conexao'] = $NM_con_dest;
            }
            if (isset($_SESSION['scriptcase']['apostila']['glo_nm_perfil']) && $_SESSION['scriptcase']['apostila']['glo_nm_perfil'] == $NM_con_orig)
            {
/*NM*/          $_SESSION['scriptcase']['apostila']['glo_nm_perfil'] = $NM_con_dest;
            }
            if (isset($_SESSION['scriptcase']['apostila']['glo_con_' . $NM_con_orig]))
            {
                $_SESSION['scriptcase']['apostila']['glo_con_' . $NM_con_orig] = $NM_con_dest;
            }
        }
    }
$_SESSION['scriptcase']['charset'] = "UTF-8";
ini_set('default_charset', $_SESSION['scriptcase']['charset']);
$_SESSION['scriptcase']['charset_html']  = (isset($this->sc_charset[$_SESSION['scriptcase']['charset']])) ? $this->sc_charset[$_SESSION['scriptcase']['charset']] : $_SESSION['scriptcase']['charset'];
foreach ($this->Nm_conf_reg[$this->str_conf_reg] as $ind => $dados)
{
    if ($_SESSION['scriptcase']['charset'] != "UTF-8" && NM_is_utf8($dados))
    {
        $this->Nm_conf_reg[$this->str_conf_reg][$ind] = sc_convert_encoding($dados, $_SESSION['scriptcase']['charset'], "UTF-8");
    }
}
foreach ($this->Nm_lang as $ind => $dados)
{
    if ($_SESSION['scriptcase']['charset'] != "UTF-8" && NM_is_utf8($ind))
    {
        $ind = sc_convert_encoding($ind, $_SESSION['scriptcase']['charset'], "UTF-8");
        $this->Nm_lang[$ind] = $dados;
    }
    if ($_SESSION['scriptcase']['charset'] != "UTF-8" && NM_is_utf8($dados))
    {
        $this->Nm_lang[$ind] = sc_convert_encoding($dados, $_SESSION['scriptcase']['charset'], "UTF-8");
    }
}
if (isset($this->Nm_lang['lang_errm_dbcn_conn']))
{
    $_SESSION['scriptcase']['db_conn_error'] = $this->Nm_lang['lang_errm_dbcn_conn'];
}
$this->regionalDefault();
$this->str_schema_all = (isset($_SESSION['scriptcase']['str_schema_all']) && !empty($_SESSION['scriptcase']['str_schema_all'])) ? $_SESSION['scriptcase']['str_schema_all'] : "Sc8_Saphir/Sc8_Saphir";
$_SESSION['scriptcase']['erro']['str_schema'] = $this->str_schema_all . "_error.css";
$_SESSION['scriptcase']['erro']['str_schema_dir'] = $this->str_schema_all . "_error" . $_SESSION['scriptcase']['reg_conf']['css_dir'] . ".css";
$_SESSION['scriptcase']['erro']['str_lang']   = $this->str_lang;
if (isset($_SESSION['sc_session']['SC_parm_violation']))
{
    unset($_SESSION['sc_session']['SC_parm_violation']);
    echo "<html>";
    echo "<body>";
    echo "<table align=\"center\" width=\"50%\" border=1 height=\"50px\">";
    echo "<tr>";
    echo "   <td align=\"center\">";
    echo "       <b><font size=4>" . $this->Nm_lang['lang_errm_ajax_data'] . "</font>";
    echo "   </b></td>";
    echo " </tr>";
    echo "</table>";
    echo "</body>";
    echo "</html>";
    exit;
}
if (is_dir($path_img_old))
{
    $Res_dir_img = @opendir($path_img_old);
    if ($Res_dir_img)
    {
        while (FALSE !== ($Str_arquivo = @readdir($Res_dir_img))) 
        {
           $Str_arquivo = "/" . $Str_arquivo;
           if (@is_file($path_img_old . $Str_arquivo) && '.' != $Str_arquivo && '..' != $path_img_old . $Str_arquivo)
           {
               @unlink($path_img_old . $Str_arquivo);
           }
        }
    }
    @closedir($Res_dir_img);
    rmdir($path_img_old);
}
//
if (!empty($_GET))
{
    foreach ($_GET as $nmgp_var => $nmgp_val)
    {
        if (substr($nmgp_var, 0, 11) == "SC_glo_par_")
        {
            $nmgp_var = substr($nmgp_var, 11);
            $nmgp_val = $_SESSION[$nmgp_val];
        }
        if ($nmgp_var == "nmgp_parms" && substr($nmgp_val, 0, 8) == "@SC_par@")
        {
            $SC_Ind_Val = explode("@SC_par@", $nmgp_val);
            $nmgp_val = $_SESSION['sc_session'][$SC_Ind_Val[1]][$SC_Ind_Val[2]]['Lig_Md5'][$SC_Ind_Val[3]];
        }
         $$nmgp_var = $nmgp_val;
    }
}
if (!empty($_POST))
{
    foreach ($_POST as $nmgp_var => $nmgp_val)
    {
        if (substr($nmgp_var, 0, 11) == "SC_glo_par_")
        {
            $nmgp_var = substr($nmgp_var, 11);
            $nmgp_val = $_SESSION[$nmgp_val];
        }
        if ($nmgp_var == "nmgp_parms" && substr($nmgp_val, 0, 8) == "@SC_par@")
        {
            $SC_Ind_Val = explode("@SC_par@", $nmgp_val);
            $nmgp_val = $_SESSION['sc_session'][$SC_Ind_Val[1]][$SC_Ind_Val[2]]['Lig_Md5'][$SC_Ind_Val[3]];
        }
         $$nmgp_var = $nmgp_val;
    }
}
if (isset($script_case_init))
{
    $_SESSION['sc_session'][1]['apostila']['init'] = $script_case_init;
}
elseif (!isset($_SESSION['sc_session'][1]['apostila']['init']))
{
    $_SESSION['sc_session'][1]['apostila']['init'] = "";
}
$script_case_init = $_SESSION['sc_session'][1]['apostila']['init'];
if (isset($nmgp_parms) && !empty($nmgp_parms)) 
{ 
    $nmgp_parms = str_replace("*scout", "?@?", $nmgp_parms);
    $nmgp_parms = str_replace("*scin", "?#?", $nmgp_parms);
    $todox = str_replace("?#?@?@?", "?#?@ ?@?", $nmgp_parms);
    $todo  = explode("?@?", $todox);
    $ix = 0;
    while (!empty($todo[$ix]))
    {
       $cadapar = explode("?#?", $todo[$ix]);
       if (substr($cadapar[0], 0, 11) == "SC_glo_par_")
       {
           $cadapar[0] = substr($cadapar[0], 11);
           $cadapar[1] = $_SESSION[$cadapar[1]];
       }
       if ($cadapar[1] == "@ ") {$cadapar[1] = trim($cadapar[1]); }
       $$cadapar[0] = $cadapar[1];
       $_SESSION[$cadapar[0]] = $cadapar[1];
       $ix++;
     }
} 
$this->sc_Include($path_libs . "/nm_sec_prod.php", "F", "nm_reg_prod") ; 
include_once($path_adodb . "/adodb.inc.php"); 
$this->sc_Include($path_libs . "/nm_ini_perfil.php", "F", "perfil_lib") ; 
 if(function_exists('set_php_timezone')) set_php_timezone('apostila'); 
perfil_lib($path_libs);
if (!isset($_SESSION['sc_session'][1]['SC_Check_Perfil']))
{
    if(function_exists("nm_check_perfil_exists")) nm_check_perfil_exists($path_libs, $_SESSION['scriptcase']['apostila']['glo_nm_path_prod']);
    $_SESSION['sc_session'][1]['SC_Check_Perfil'] = true;
}
$nm_falta_var    = ""; 
$nm_falta_var_db = ""; 
if (isset($_SESSION['scriptcase']['apostila']['glo_nm_conexao']) && !empty($_SESSION['scriptcase']['apostila']['glo_nm_conexao']))
{
    db_conect_devel($_SESSION['scriptcase']['apostila']['glo_nm_conexao'], $str_root . $_SESSION['scriptcase']['apostila']['glo_nm_path_prod'], 'Estudar', 2); 
}
if (isset($_SESSION['scriptcase']['apostila']['glo_nm_perfil']) && !empty($_SESSION['scriptcase']['apostila']['glo_nm_perfil']))
{
   $_SESSION['scriptcase']['glo_perfil'] = $_SESSION['scriptcase']['apostila']['glo_nm_perfil'];
}
if (isset($_SESSION['scriptcase']['glo_perfil']) && !empty($_SESSION['scriptcase']['glo_perfil']))
{
    $_SESSION['scriptcase']['glo_senha_protect'] = "";
    carrega_perfil($_SESSION['scriptcase']['glo_perfil'], $path_libs, "S");
    if (empty($_SESSION['scriptcase']['glo_senha_protect']))
    {
        $nm_falta_var .= "Perfil=" . $_SESSION['scriptcase']['glo_perfil'] . "; ";
    }
}
if (isset($_SESSION['scriptcase']['glo_date_separator']) && !empty($_SESSION['scriptcase']['glo_date_separator']))
{
    $SC_temp = trim($_SESSION['scriptcase']['glo_date_separator']);
    if (strlen($SC_temp) == 2)
    {
       $_SESSION['scriptcase']['apostila']['SC_sep_date']  = substr($SC_temp, 0, 1); 
       $_SESSION['scriptcase']['apostila']['SC_sep_date1'] = substr($SC_temp, 1, 1); 
   }
   else
    {
       $_SESSION['scriptcase']['apostila']['SC_sep_date']  = $SC_temp; 
       $_SESSION['scriptcase']['apostila']['SC_sep_date1'] = $SC_temp; 
   }
}
if (!isset($_SESSION['scriptcase']['glo_tpbanco']))
{
    $nm_falta_var_db .= "glo_tpbanco; ";
}
else
{
    $nm_tpbanco = $_SESSION['scriptcase']['glo_tpbanco']; 
}
if (!isset($_SESSION['scriptcase']['glo_servidor']))
{
    $nm_falta_var_db .= "glo_servidor; ";
}
else
{
    $nm_servidor = $_SESSION['scriptcase']['glo_servidor']; 
}
if (!isset($_SESSION['scriptcase']['glo_banco']))
{
    $nm_falta_var_db .= "glo_banco; ";
}
else
{
    $nm_banco = $_SESSION['scriptcase']['glo_banco']; 
}
if (!isset($_SESSION['scriptcase']['glo_usuario']))
{
    $nm_falta_var_db .= "glo_usuario; ";
}
else
{
    $nm_usuario = $_SESSION['scriptcase']['glo_usuario']; 
}
if (!isset($_SESSION['scriptcase']['glo_senha']))
{
    $nm_falta_var_db .= "glo_senha; ";
}
else
{
    $nm_senha = $_SESSION['scriptcase']['glo_senha']; 
}
$nm_con_db2 = array();
$nm_database_encoding = "";
if (isset($_SESSION['scriptcase']['glo_database_encoding']))
{
    $nm_database_encoding = $_SESSION['scriptcase']['glo_database_encoding']; 
}
if (isset($_SESSION['scriptcase']['glo_db2_autocommit']))
{
    $nm_con_db2['db2_autocommit'] = $_SESSION['scriptcase']['glo_db2_autocommit']; 
}
if (isset($_SESSION['scriptcase']['glo_db2_i5_lib']))
{
    $nm_con_db2['db2_i5_lib'] = $_SESSION['scriptcase']['glo_db2_i5_lib']; 
}
if (isset($_SESSION['scriptcase']['glo_db2_i5_naming']))
{
    $nm_con_db2['db2_i5_naming'] = $_SESSION['scriptcase']['glo_db2_i5_naming']; 
}
if (isset($_SESSION['scriptcase']['glo_db2_i5_commit']))
{
    $nm_con_db2['db2_i5_commit'] = $_SESSION['scriptcase']['glo_db2_i5_commit']; 
}
if (isset($_SESSION['scriptcase']['glo_db2_i5_query_optimize']))
{
    $nm_con_db2['db2_i5_query_optimize'] = $_SESSION['scriptcase']['glo_db2_i5_query_optimize']; 
}
$nm_con_persistente = "";
$nm_con_use_schema  = "";
if (isset($_SESSION['scriptcase']['glo_use_persistent']))
{
    $nm_con_persistente = $_SESSION['scriptcase']['glo_use_persistent']; 
}
if (isset($_SESSION['scriptcase']['glo_use_schema']))
{
    $nm_con_use_schema = $_SESSION['scriptcase']['glo_use_schema']; 
}
if (!empty($nm_falta_var) || !empty($nm_falta_var_db))
{
    if (empty($nm_falta_var_db))
    {
        echo "<table width=\"80%\"  border=\"1\" height=\"117\">";
        echo "<tr>";
        echo "   <td class=\"css_menu_sel\">";
        echo "       <b><font size=\"4\">" . $this->Nm_lang['lang_errm_glob'] . "</font>";
        echo "  " . $nm_falta_var;
        echo "   </b></td>";
        echo " </tr>";
        echo "</table>";
    }
    else
    {
        echo "<table width=\"80%\"  border=\"1\" height=\"117\">";
        echo "<tr>";
        echo "   <td class=\"css_menu_sel\">";
        echo "       <b><font size=\"4\">" . $this->Nm_lang['lang_errm_dbcn_data'] . "</font>";
        echo "   </b></td>";
        echo " </tr>";
        echo "</table>";
    }
    if (isset($_SESSION['scriptcase']['nm_ret_exec']) && '' != $_SESSION['scriptcase']['nm_ret_exec'])
    { 
        if (isset($_SESSION['sc_session'][1]['apostila']['sc_outra_jan']) && $_SESSION['sc_session'][1]['apostila']['sc_outra_jan'])
        {
            echo "<a href='javascript:window.close()'><img border='0' src='" . $path_imag_cab . "/scriptcase__NM__exit.gif' title='" . $this->Nm_lang['lang_btns_menu_rtrn_hint'] . "' align=absmiddle></a> \n" ; 
        } 
        else 
        { 
            echo "<a href='" . $_SESSION['scriptcase']['nm_ret_exec'] . "><img border='0' src='" . $path_imag_cab . "/scriptcase__NM__exit.gif' title='" . $this->Nm_lang['lang_btns_menu_rtrn_hint'] . "' align=absmiddle></a> \n" ; 
        } 
    } 
    exit ;
} 
if (isset($_SESSION['scriptcase']['glo_db_master_usr']) && !empty($_SESSION['scriptcase']['glo_db_master_usr']))
{
    $nm_usuario = $_SESSION['scriptcase']['glo_db_master_usr']; 
}
if (isset($_SESSION['scriptcase']['glo_db_master_pass']) && !empty($_SESSION['scriptcase']['glo_db_master_pass']))
{
    $nm_senha = $_SESSION['scriptcase']['glo_db_master_pass']; 
}
if (isset($_SESSION['scriptcase']['glo_db_master_cript']) && !empty($_SESSION['scriptcase']['glo_db_master_cript']))
{
    $_SESSION['scriptcase']['glo_senha_protect'] = $_SESSION['scriptcase']['glo_db_master_cript']; 
}
$sc_tem_trans_banco = false;
$this->nm_bases_access    = array("access", "ado_access");
$this->nm_bases_db2       = array("db2", "db2_odbc", "odbc_db2", "odbc_db2v6");
$this->nm_bases_ibase     = array("ibase", "firebird", "borland_ibase");
$this->nm_bases_informix  = array("informix", "informix72", "pdo_informix");
$this->nm_bases_mssql     = array("mssql", "ado_mssql", "odbc_mssql", "mssqlnative", "pdo_sqlsrv");
$this->nm_bases_mysql     = array("mysql", "mysqlt", "maxsql", "pdo_mysql");
$this->nm_bases_postgres  = array("postgres", "postgres64", "postgres7", "pdo_pgsql");
$this->nm_bases_oracle    = array("oci8", "oci805", "oci8po", "odbc_oracle", "oracle");
$this->nm_bases_sqlite    = array("sqlite", "sqlite3", "pdosqlite");
$this->nm_bases_sybase    = array("sybase");
$this->nm_bases_vfp       = array("vfp");
$this->nm_bases_odbc      = array("odbc");
$_SESSION['scriptcase']['sc_num_page'] = 1;
$_SESSION['scriptcase']['nm_bases_security']  = "enc_nm_enc_v1HQNwH9BiD1veD5XGDMrwV9FeDur/VoX7D9JmH9B/Z1NOV5X7DErKZSJ3DWX7HIBqDcXGDQFUHIrwHuFaHuNOZSrCH5FqDoXGHQJmZ1BiHABYHuBOHgBYVkJqDWX7HINUDcBiH9FUDSBYHQJsDMrwV9FeH5FqHINUHQBsVIJsDSrYHuFUHgvCHArsHEB7DoXGHQNmDQBqHANOHuBqDMrwV9FeDur/HIX7HQJmVINUHANOHQBODMrYZSXeDuFYVoXGDcJeZ9rqD1BeHuX7DMvsVIB/Dur/HIX7HQBiZ1BiHAN7HuFGHgvCHArCDWXCHMJeHQNmDQB/HIrKHuJwDMrwV9FeDWF/HMBOHQBsZ1FGZ1NOHuFaHgvCHArCH5BmZuJeDcXGDuFaHANOHQJeHgNKDkBODuFqDoFGDcBqVIJwD1rwHQrqHgBYVkJqH5FGDoJeHQXsDQFUHArYHurqDMrwVcB/H5B7VErqHQBiVINUHAvCD5JeHgvCHEJqH5BmZuXGDcBiDQFaHINaVWJeDMrwVcB/HEFYVoBiHQBqZ1BOHArKHQFaDMrYZSXeDuFYVoXGDcJeZ9rqD1BeV5BqHgvsDkB/V5X7VorqDcBqZ1FaD1rKV5XGDMNKZSJ3H5X/ZuJsHQXGZSFUHAveV5BOHuNODkBODuX7VoX7DcBqZ1B/Z1vOD5raHgBOVkXeHEFqVoX7DcBwDQFGD1BOV5JwDMBYVIBODWFYVENUHQBiZ1B/HABYV5JsDMzGHAFKV5FaZuBOHQJeDQBqHAvOV5JwHuBYDkFCDuX7VEF7D9XOZSB/Z1BeD5FaDEvsHEFKV5FaDoXGDcJeZSFGHANOD5BqHuzGVcrsH5XCVoBqDcBqZ1FaD1rwV5FaHgvCDkBsH5FYVoX7D9JKDQX7D1BOV5FGHuzGDkBOH5FqVoJwD9JmZ1F7Z1BeD5JeDEvsHENiV5FaHMJsDcJeDQX7DSBYHuFaHuNOZSrCH5FqDoXGHQJmZ1F7HIveHQF7DMvCHEFiDuFYDoJsDcXOZ9F7D1vOVWJeDMBYVcFKHEF/HMBiD9BsVIraD1rwV5X7HgBeHEFKV5FaDoraD9NwDQJsZ1rwV5BqHuBYVcFKHEFYDoJeDcBqZkFUZ1NOD5BqDEBeHEBUDWF/HIJsD9XsZ9JeD1BeD5F7DMvmVcFeDWrmVoF7HQNmZkBiHABYHuX7HgveHArsDWFGDoBqHQJKDuBqHAvOV5XGDMrYVIBsH5XCHMBqDcFYVIJsHIBeHQJwDEBODkFeH5FYVoFGHQJKDQJwD1BeD5JeHgrKVcBODWBmVoF7HQNwZkBiHINKZMFaDEBeDkXKDWr/ZuFaHQXOH9BiD1BeHQXGDMvmVcFKV5BmVoBqD9BsZkFGHArKD5JeDMBYVkJqV5FaDorqD9NwH9X7Z1rwD5NUHuBOVIBODWFYHMBiD9BsVIraD1rwV5X7HgBeHErsDWrGDoBOHQBiZ9XGD1NKV5JeDMvOZSNiDWB3VEraHQJmZ1F7Z1vmD5rqDEBOHArCDWF/VoB/D9NwDQBqHIrwV5JwDMBYVcrsDur/HMF7DcNwH9FaD1rwHuFGHgNOHArsDWXCHIJsD9XsZ9JeD1BeD5F7DMvmVcFeH5XCHMBqHQBiZSBqHABYHQBqHgBeHArCV5B3DoNUHQXsDQFaD1vOV5BiDMBODkBsV5X7HMraHQXGH9BqHAzGD5raHgvsHArCDWX7HIBiHQXsDuFaDSBYHQrqDMvmV9FeDWXCDoJsDcBwH9B/Z1rYHQJwHgBYHEFKV5B3DoBO";
 $glo_senha_protect = (isset($_SESSION['scriptcase']['glo_senha_protect'])) ? $_SESSION['scriptcase']['glo_senha_protect'] : "S";
if (isset($_SESSION['scriptcase']['nm_sc_retorno']) && !empty($_SESSION['scriptcase']['nm_sc_retorno']) && isset($_SESSION['scriptcase']['apostila']['glo_nm_conexao']) && !empty($_SESSION['scriptcase']['apostila']['glo_nm_conexao']))
{ 
   $this->Db = db_conect_devel($_SESSION['scriptcase']['apostila']['glo_nm_conexao'], $str_root . $_SESSION['scriptcase']['apostila']['glo_nm_path_prod'], 'Estudar'); 
} 
else 
{ 
   $this->Db = db_conect($nm_tpbanco, $nm_servidor, $nm_usuario, $nm_senha, $nm_banco, $glo_senha_protect, "S", $nm_con_persistente, $nm_con_db2, $nm_database_encoding); 
} 
$this->nm_tpbanco = $nm_tpbanco; 
if (in_array(strtolower($nm_tpbanco), $this->nm_bases_ibase) && function_exists('ibase_timefmt'))
{
    ibase_timefmt('%Y-%m-%d %H:%M:%S');
} 
if (in_array(strtolower($nm_tpbanco), $this->nm_bases_sybase))
{
   $this->Db->fetchMode = ADODB_FETCH_BOTH;
   $this->Db->Execute("set dateformat ymd");
} 
if (in_array(strtolower($nm_tpbanco), $this->nm_bases_mssql))
{
   $this->Db->Execute("set dateformat ymd");
} 
if (in_array(strtolower($nm_tpbanco), $this->nm_bases_oracle))
{
   $this->Db->Execute("alter session set nls_date_format = 'yyyy-mm-dd hh24:mi:ss'");
   $this->Db->Execute("alter session set nls_numeric_characters = '.,'");
} 
//
      $_SESSION['scriptcase']['apostila']['contr_erro'] = 'on';
 		unset($_SESSION['scriptcase']['sc_def_menu']["apostila"]);
if (!isset($_SESSION['scriptcase']['sc_def_menu']))
{
    $_SESSION['scriptcase']['sc_def_menu'] = array();
}
if (!isset($_SESSION['scriptcase']['sc_def_menu']["apostila"]))
{
    $_SESSION['scriptcase']['sc_def_menu']["apostila"] = array();
}
if (strpos(strtolower($nm_tpbanco), "access") === false && !$sc_tem_trans_banco)
{
    $this->Db->BeginTrans();
    $sc_tem_trans_banco = true;
}


### matéria
$materia_sql = "SELECT id_materia, materia_disciplina FROM u512969981_materia WHERE id_materia in(SELECT DISTINCT(materia_id_materia) FROM u512969981_conteudo_extra) ORDER BY materia_disciplina"; 
 

				 
      $nm_select = $materia_sql; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      if ($this->materia = $this->Db->Execute($nm_select)) 
      { }
      elseif (isset($GLOBALS["NM_ERRO_IBASE"]) && $GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->materia = false;
          $this->materia_erro = $this->Db->ErrorMsg();
      } 
;


				
				if(false == $this->materia )     
				{
					
 if (!isset($Campos_Mens_erro)){$Campos_Mens_erro = "";}
 if (!empty($Campos_Mens_erro)){$Campos_Mens_erro .= "<br>";}$Campos_Mens_erro .= 'Error while accessing database.';
;
				}
				else
				{
				   while(!$this->materia->EOF)
					{

					   $disciplina = "<b>" . $this->materia->fields[1] . "</b>";
					   $iddisciplina = "M" . $this->materia->fields[0];
					   
					  if (isset($_SESSION['scriptcase']['sc_def_menu']["apostila"]))
{
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$iddisciplina]                   = array();
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$iddisciplina]['pai']            = "";
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$iddisciplina]['label']          = $disciplina;
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$iddisciplina]['link']           = "";
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$iddisciplina]['parm']           = "nm_run_menu*scin1*scout";
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$iddisciplina]['icon']           = "";
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$iddisciplina]['hint']           = "";
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$iddisciplina]['target']         = "_self";
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$iddisciplina]['name']           = "";
    $Temp_url = "";
    if ('http://' == substr($Temp_url, 0, 7) || 'https://' == substr($Temp_url, 0, 8) || '../' == substr($Temp_url, 0, 3) || '/' == substr($Temp_url, 0, 1))
    {
        $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$iddisciplina]['lnk_url'] = true;
    }
    else
    {
        $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$iddisciplina]['lnk_url'] = false;
        if (!empty($Temp_url))
        {
            $Temp_url = SC_dir_app_name($Temp_url) . "/";
            if (strtolower($_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$iddisciplina]['target']) == '_blank')
            {
                $Temp_url .= "?nmgp_outra_jan=true&nm_apl_menu=" . "apostila" . "&script_case_session=" . session_id();
            }
            if (strtolower($_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$iddisciplina]['target']) == '_self')
            {
                $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$iddisciplina]['sc_init'] = $this->Gera_sc_init('');
                $Temp_url .= "?nm_run_menu=1&nm_apl_menu=" . "apostila" . "&script_case_init=" . $this->Gera_sc_init('') . "&script_case_session=" . session_id();
            }
            if (strtolower($_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$iddisciplina]['target']) == '_parent')
            {
                $Temp_url .= "?nm_run_menu=1&script_case_init=" . $_SESSION['sc_session'][1]["apostila"]['init'] . "&script_case_session=" . session_id();
            }
        }
    }
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$iddisciplina]['url'] = $Temp_url;
}
### assunto
					   
$assunto_sql = "SELECT id_assunto, assunto FROM u512969981_assunto WHERE id_assunto in(SELECT assunto_id_assunto FROM u512969981_conteudo_extra WHERE materia_id_materia = '" . $this->materia->fields[0] . "') ORDER BY assunto"; 

				 
      $nm_select = $assunto_sql; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      if ($this->assunto = $this->Db->Execute($nm_select)) 
      { }
      elseif (isset($GLOBALS["NM_ERRO_IBASE"]) && $GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->assunto = false;
          $this->assunto_erro = $this->Db->ErrorMsg();
      } 
;

				
				if(false == $this->assunto )     
				{
					
 if (!isset($Campos_Mens_erro)){$Campos_Mens_erro = "";}
 if (!empty($Campos_Mens_erro)){$Campos_Mens_erro .= "<br>";}$Campos_Mens_erro .= 'Error while accessing database.';
;
				}
				else
				{
				   while(!$this->assunto->EOF)
					{

					   $assuntos = "<font color=#0000FF>" . $this->assunto->fields[1] . "</font>";
					   $idassunto = "A" . $this->assunto->fields[0];
					   
					  if (isset($_SESSION['scriptcase']['sc_def_menu']["apostila"]))
{
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idassunto]                   = array();
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idassunto]['pai']            = "item_".$iddisciplina;
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idassunto]['label']          = $assuntos;
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idassunto]['link']           = "";
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idassunto]['parm']           = "nm_run_menu*scin1*scout";
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idassunto]['icon']           = "";
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idassunto]['hint']           = "";
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idassunto]['target']         = "_self";
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idassunto]['name']           = "";
    $Temp_url = "";
    if ('http://' == substr($Temp_url, 0, 7) || 'https://' == substr($Temp_url, 0, 8) || '../' == substr($Temp_url, 0, 3) || '/' == substr($Temp_url, 0, 1))
    {
        $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idassunto]['lnk_url'] = true;
    }
    else
    {
        $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idassunto]['lnk_url'] = false;
        if (!empty($Temp_url))
        {
            $Temp_url = SC_dir_app_name($Temp_url) . "/";
            if (strtolower($_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idassunto]['target']) == '_blank')
            {
                $Temp_url .= "?nmgp_outra_jan=true&nm_apl_menu=" . "apostila" . "&script_case_session=" . session_id();
            }
            if (strtolower($_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idassunto]['target']) == '_self')
            {
                $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idassunto]['sc_init'] = $this->Gera_sc_init('');
                $Temp_url .= "?nm_run_menu=1&nm_apl_menu=" . "apostila" . "&script_case_init=" . $this->Gera_sc_init('') . "&script_case_session=" . session_id();
            }
            if (strtolower($_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idassunto]['target']) == '_parent')
            {
                $Temp_url .= "?nm_run_menu=1&script_case_init=" . $_SESSION['sc_session'][1]["apostila"]['init'] . "&script_case_session=" . session_id();
            }
        }
    }
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idassunto]['url'] = $Temp_url;
}
#### EXTRA		
				  
$extra_sql = "SELECT Id, titulo, assunto_id_assunto, materia_id_materia from u512969981_conteudo_extra WHERE materia_id_materia = '" . $this->materia->fields[0] . "' and assunto_id_assunto = '" . $this->assunto->fields[0] . "' ORDER BY Id"; 

				 
      $nm_select = $extra_sql; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      if ($this->extra = $this->Db->Execute($nm_select)) 
      { }
      elseif (isset($GLOBALS["NM_ERRO_IBASE"]) && $GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->extra = false;
          $this->extra_erro = $this->Db->ErrorMsg();
      } 
;

				
				if(false == $this->extra )     
				{
					
 if (!isset($Campos_Mens_erro)){$Campos_Mens_erro = "";}
 if (!empty($Campos_Mens_erro)){$Campos_Mens_erro .= "<br>";}$Campos_Mens_erro .= 'Error while accessing database.';
;
				}
				else
				{
				   while(!$this->extra->EOF)
					{

					   $extras = "<font color=#008000>" . $this->extra->fields[1] . "</font>";
					   $idextra = $this->extra->fields[0];
					  
					   
					  if (isset($_SESSION['scriptcase']['sc_def_menu']["apostila"]))
{
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idextra]                   = array();
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idextra]['pai']            = "item_".$idassunto;
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idextra]['label']          = $extras;
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idextra]['link']           = "conteudo_extra";
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idextra]['parm']           = "id*scin" . $idextra . "*scout" . "nm_run_menu*scin1*scout";
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idextra]['icon']           = "";
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idextra]['hint']           = "";
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idextra]['target']         = "_self";
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idextra]['name']           = "conteudo_extra";
    $Temp_url = "conteudo_extra";
    if ('http://' == substr($Temp_url, 0, 7) || 'https://' == substr($Temp_url, 0, 8) || '../' == substr($Temp_url, 0, 3) || '/' == substr($Temp_url, 0, 1))
    {
        $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idextra]['lnk_url'] = true;
    }
    else
    {
        $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idextra]['lnk_url'] = false;
        if (!empty($Temp_url))
        {
            $Temp_url = SC_dir_app_name($Temp_url) . "/";
            if (strtolower($_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idextra]['target']) == '_blank')
            {
                $Temp_url .= "?nmgp_outra_jan=true&nm_apl_menu=" . "apostila" . "&script_case_session=" . session_id();
            }
            if (strtolower($_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idextra]['target']) == '_self')
            {
                $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idextra]['sc_init'] = $this->Gera_sc_init('conteudo_extra');
                $Temp_url .= "?nm_run_menu=1&nm_apl_menu=" . "apostila" . "&script_case_init=" . $this->Gera_sc_init('conteudo_extra') . "&script_case_session=" . session_id();
            }
            if (strtolower($_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idextra]['target']) == '_parent')
            {
                $Temp_url .= "?nm_run_menu=1&script_case_init=" . $_SESSION['sc_session'][1]["apostila"]['init'] . "&script_case_session=" . session_id();
            }
        }
    }
    $_SESSION['scriptcase']['sc_def_menu']["apostila"]["item_".$idextra]['url'] = $Temp_url;
}
$this->extra->MoveNext();
					}
					$this->extra->Close();
				}	

#### EXTRA FIM					   

						$this->assunto->MoveNext();
					}

					$this->assunto->Close();
				}					   

### fim assunto
		
						$this->materia->MoveNext();
					}
					$this->materia->Close();;
				}
### fim matéria

if ($sc_tem_trans_banco)
{
    $this->Db->CommitTrans();
    $sc_tem_trans_banco = false;
}
$_SESSION['scriptcase']['apostila']['contr_erro'] = 'off';
if ((isset($nmgp_outra_jan) && $nmgp_outra_jan == "true") || (isset($_SESSION['scriptcase']['sc_outra_jan']) && $_SESSION['scriptcase']['sc_outra_jan'] == 'apostila'))
{
    $_SESSION['sc_session'][1]['apostila']['sc_outra_jan'] = true;
     unset($_SESSION['scriptcase']['sc_outra_jan']);
    $_SESSION['scriptcase']['sc_saida_apostila'] = "javascript:window.close()";
}

/* Variáveis de Configuração do Menu */
$apostila_menuData['iframe'] = TRUE;

$apostila_menuData['height'] = '100%';
if (!isset($_SESSION['scriptcase']['sc_apl_seg']))
{
    $_SESSION['scriptcase']['sc_apl_seg'] = array();
}
/* Arquivos JS */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">

<html<?php echo $_SESSION['scriptcase']['reg_conf']['html_dir'] ?> style="height: 100%">
<head>
 <title>apostila</title>
 <META http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['scriptcase']['charset_html'] ?>" />
 <?php
 if ($_SESSION['scriptcase']['device_mobile'] && $_SESSION['scriptcase']['display_mobile'])
 {
  ?>
   <meta name='viewport' content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' />
  <?php
 }
 ?>
 <link rel="stylesheet" type="text/css" href="<?php echo $url_third; ?>/jquery_plugin/vakata-jstree-e22db21/themes/default/style.min.css" /> 
 <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $this->str_schema_all ?>_menuT.css" /> 
 <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $this->str_schema_all ?>_menuT<?php echo $_SESSION['scriptcase']['reg_conf']['css_dir'] ?>.css" /> 
 <link rel="stylesheet" type="text/css" href="../_lib/buttons/<?php echo $Str_btn_css ?>" /> 
<script  type="text/javascript" src="<?php echo $url_third; ?>/jquery/js/jquery.js"></script>
<script  type="text/javascript" src="<?php echo $url_third; ?>/jquery/js/jquery-ui.js"></script>
<script  type="text/javascript" src="<?php echo $url_third; ?>/jquery_plugin/vakata-jstree-e22db21/jstree.min.js"></script>
<script  type="text/javascript" src="<?php echo $url_third; ?>/jquery_plugin/layout/jquery.layout.js"></script>
<style>
  li.jstree-open   > a .jstree-icon { background:url(../_lib/img/tree_folder_open.png)  ; background-position: center center; background-size: auto auto; background-repeat: no-repeat;}
  li.jstree-closed > a .jstree-icon { background:url(../_lib/img/tree_folder_closed.png); background-position: center center; background-size: auto auto; background-repeat: no-repeat;}
  li.jstree-leaf   > a .jstree-icon { background:url(../_lib/img/tree_leaf.png); background-position: center center; background-size: auto auto; background-repeat: no-repeat;}
   .scTabText {
            display: inline-block !important;
            overflow: hidden !important;
            white-space: nowrap !important;
   }</style>
<script>
var is_menu_vertical = false;
</script>
</head>
<body style="height: 100%" scroll="no" class='scMenuTPage'>
<?php
$str_bmenu = nmButtonOutput($this->arr_buttons, "bmenu", "showMenu();", "showMenu();", "bmenu", "", "" . $this->Nm_lang['lang_btns_menu'] . "", "position:absolute; top:4px; left:2px;z-index:9999;", "absmiddle", "", "0px", $this->path_botoes, "", "" . $this->Nm_lang['lang_btns_menu_hint'] . "", "", "", "", "only_text", "text_right", "", "", "", "", "", "");
if($_SESSION['scriptcase']['device_mobile'] && $_SESSION['scriptcase']['display_mobile'])
{
    $menu_mobile_hide          = $mobile_menu_mobile_hide;
    $menu_mobile_inicial_state = $mobile_menu_mobile_inicial_state;
    $menu_mobile_hide_onclick  = $mobile_menu_mobile_hide_onclick;
    $menutree_mobile_float     = $mobile_menutree_mobile_float;
    $menu_mobile_hide_icon     = $mobile_menu_mobile_hide_icon;
    $menu_largura              = '250';
}
$str_menu_display = 'false';
$str_menu_display_float = false;
if($menu_mobile_hide == 'S')
{
    if($menu_mobile_inicial_state =='escondido')
    {
            $str_menu_display='true';
            $str_btn_display="show";
    }
    else
    {
            $str_menu_display='false';
            $str_btn_display="hide";
    }
    if($menu_mobile_hide_icon != 'S')
    {
        $str_btn_display="show";
    }
?>
<script>
    $( document ).ready(function() {
        <?php if($_SESSION['scriptcase']['display_mobile'] === true) { ?>
        $('#menu-container').width('250px');
        $('#div_contrl_abas').css('-webkit-overflow-scrolling','touch');
        $('.ui-layout-center').css('-webkit-overflow-scrolling','touch');
        $('#div_contrl_abas').css('overflow','auto');
        $('.ui-layout-center').css('overflow','auto');
        <?php } ?>
        $('#bmenu').<?php echo $str_btn_display; ?>();
        <?php
        if($menu_mobile_hide_icon != 'S')
        {
            ?>
            $('#css3menut').css('margin-top', $('#bmenu').outerHeight());

            <?php
        }
        ?>
        $('#bmenu').css('left', '0px');
        $('#bmenu').css('top', $('.scMenuTHeader').height());
    });
    function showMenu()
    {
      <?php
      if($menu_mobile_hide_icon == 'S')
      {
      ?>
                $('#bmenu').hide();
      <?php
      }
      ?>
            myLayout.toggle('west');
    }
    function HideMenu()
    {
      <?php
      if($menu_mobile_hide_icon == 'S')
      {
      ?>
                $('#bmenu').show();
      <?php
      }
      ?>
            myLayout.toggle('west');
    }
</script>
<?php
echo $str_bmenu;
}
?>
<?php 
        $NM_scr_iframe = (isset($_POST['hid_scr_iframe'])) ? $_POST['hid_scr_iframe'] : "";   
?> 

        <script  type="text/javascript">
                        var myLayout; // a var is required because this page utilizes: myLayout.allowOverflow() method
                        $(document).ready(function () {
                                myLayout = $('body').layout({
                                west__size: 400
                                        ,west__showOverflowOnHover : false
                                        ,west__showOverflowOnHover: false
                                        ,west__initClosed          : <?php echo $str_menu_display; ?>
                                        ,east__showOverflowOnHover: false
                                        ,east__initClosed          : <?php echo $str_menu_display; ?>
                                        ,north__slidable          : false
                                        ,north__resizable         : false
                                        ,north__closable          : false
                                        ,north__spacing_open      : 0
                                        ,north__spacing_closed    : 0
                                        ,south__slidable          : false
                                        ,south__resizable         : false
                                        ,south__closable          : false
                                        ,south__spacing_open      : 0
                                        ,south__spacing_closed    : 0
                                
                                });
                                $('#css3menut').jstree({
                                        
                                        'plugins' : [ ]
                                  }).on("select_node.jstree",function(e, data) {
                                      str_link   = '';
                                      str_target = '';
                                      if(data.instance.is_leaf(data.node))
                                      {
                                        str_link   = data.node.a_attr.href;
                                        str_target = data.node.a_attr.target;
                                      }
                                      else
                                      {
                                        data.instance.toggle_node(data.node);
                                        str_link   = $('#' + data.node.id + ' > a > span > a').attr('href');
                                        str_target = $('#' + data.node.id + ' > a > span > a').attr('target');
                                      }

                                      //test link type
                                      if(str_link != '' && str_target != '')
                                      {
                                          if(str_link.substring(0, 11) == 'javascript:')
                                          {
                                            eval(str_link.substring(11));
                                          }
                                          else if(str_link != '#')
                                          {
                                            if(str_target == '_parent')
                                            {
                                                            str_target = '_self';
                                            }
                                            window.open(str_link, str_target);
                                          }
                                          <?php
                                          if($menu_mobile_hide == 'S' && $menu_mobile_hide_onclick=='S')
                                          {
                                          ?>
                                            if(typeof data.node.a_attr.onclick == 'undefined') {
                                                HideMenu();
                                            }
                                          <?php
                                          }
                                          ?>
                                      }
                                });
                                $('#css3menut').jstree().close_all();
                         });
                </script>
<script type="text/javascript">
var numl = 0;
var toBeHidden = 0;
function NM_show_menu()
{
   return true;
}
function NM_hide_menu()
{
   return true;
}
</script>

<style type="text/css">

        .ui-layout-pane { /* all 'panes' */
                        border: 0px solid #BBB;
                        padding: 0px;
                        overflow: auto;
        }
        .ui-layout-resizer { /* all 'resizer-bars' */
                        background: #DDD;
        }

        .ui-layout-toggler { /* all 'toggler-buttons' */
                        background: #AAA;
        }
        </style>
<?php


$saida_apl = $_SESSION['scriptcase']['sc_saida_apostila'];
$apostila_menuData['data'] = array();
$nextLevelToBeWrite = false;

if (isset($_SESSION['scriptcase']['sc_def_menu']['apostila']))
{
    $arr_menu_usu = $this->nm_arr_menu_recursiv($_SESSION['scriptcase']['sc_def_menu']['apostila']);
    $this->nm_gera_menus($str_menu_usu, $arr_menu_usu, 1, 'apostila');
    $apostila_menuData['data'] = $str_menu_usu;
}
if (is_file("apostila_help.txt"))
{
    $Arq_WebHelp = file("apostila_help.txt"); 
    if (isset($Arq_WebHelp[0]) && !empty($Arq_WebHelp[0]))
    {
        $Arq_WebHelp[0] = str_replace("\r\n" , "", trim($Arq_WebHelp[0]));
        $Tmp = explode(";", $Arq_WebHelp[0]); 
        foreach ($Tmp as $Cada_help)
        {
            $Tmp1 = explode(":", $Cada_help); 
            if (!empty($Tmp1[0]) && isset($Tmp1[1]) && !empty($Tmp1[1]) && $Tmp1[0] == "menu" && is_file($str_root . $path_help . $Tmp1[1]))
            {
                $str_disabled = "N";
                $str_link = "" . $path_help . $Tmp1[1] . "";
                $str_icon = "";
                $icon_aba = "";
                $icon_aba_inactive = "";
                $apostila_menuData['data'][] = array(
                    'label'    => "" . $this->Nm_lang['lang_btns_help_hint'] . "",
                    'level'    => "0",
                    'link'     => $str_link,
                    'hint'     => "" . $this->Nm_lang['lang_btns_help_hint'] . "",
                    'id'       => "item_Help",
                    'icon'     => $str_icon,
                    'icon_aba' => $icon_aba,
                    'icon_aba_inactive' => $icon_aba_inactive,
                    'target'   => "" . $this->apostila_target('_blank') . "",
                    'sc_id'    => "item_Help",
                    'disabled' => $str_disabled,
                );
            }
        }
    }
}

if (isset($_SESSION['scriptcase']['sc_menu_del']['apostila']) && !empty($_SESSION['scriptcase']['sc_menu_del']['apostila']))
{
    $nivel = 0;
    $exclui_menu = false;
    foreach ($apostila_menuData['data'] as $i_menu => $cada_menu)
    {
       if (in_array($cada_menu['id'], $_SESSION['scriptcase']['sc_menu_del']['apostila']))
       {
          $nivel = $cada_menu['level'];
          $exclui_menu = true;
          unset($apostila_menuData['data'][$i_menu]);
       }
       elseif ( empty($cada_menu) || ($exclui_menu && $nivel < $cada_menu['level']))
       {
          unset($apostila_menuData['data'][$i_menu]);
       }
       else
       {
          $exclui_menu = false;
       }
    }
    $Temp_menu = array();
    foreach ($apostila_menuData['data'] as $i_menu => $cada_menu)
    {
        $Temp_menu[] = $cada_menu;
    }
    $apostila_menuData['data'] = $Temp_menu;
}

if (isset($_SESSION['scriptcase']['sc_menu_disable']['apostila']) && !empty($_SESSION['scriptcase']['sc_menu_disable']['apostila']))
{
    $disable_menu = false;
    foreach ($apostila_menuData['data'] as $i_menu => $cada_menu)
    {
       if (in_array($cada_menu['id'], $_SESSION['scriptcase']['sc_menu_disable']['apostila']))
       {
          $nivel = $cada_menu['level'];
          $disable_menu = true;
          $apostila_menuData['data'][$i_menu]['disabled'] = 'Y';
       }
       elseif (!empty($cada_menu) && $disable_menu && $nivel < $cada_menu['level'])
       { 
          $apostila_menuData['data'][$i_menu]['disabled'] = 'Y';
       }
       elseif (!empty($cada_menu))
       {
          $disable_menu = false;
       }
    }
}

$Str_date = strtolower($_SESSION['scriptcase']['reg_conf']['date_format']);
$Lim   = strlen($Str_date);
$Ult   = "";
$Arr_D = array();
for ($I = 0; $I < $Lim; $I++)
{
    $Char = substr($Str_date, $I, 1);
    if ($Char != $Ult)
    {
        $Arr_D[] = $Char;
    }
    $Ult = $Char;
}
$Prim = true;
$Str  = "";
foreach ($Arr_D as $Cada_d)
{
    $Str .= (!$Prim) ? $_SESSION['scriptcase']['reg_conf']['date_sep'] : "";
    $Str .= $Cada_d;
    $Prim = false;
}
$Str = str_replace("a", "Y", $Str);
$Str = str_replace("y", "Y", $Str);
$nm_data_fixa = date($Str); 
?>
<?php
    $_SESSION['scriptcase']['apostila']['apl_inicial'] = ($NM_scr_iframe != "") ? $NM_scr_iframe : "apostila_pag_ini.php";
    $_SESSION['scriptcase']['apostila']['path_link'] = $path_link;
?>
<div class="ui-layout-west">
<table id="main_menutree_table" cellspacing=0 cellpadding=0 class="scMenuTTable" style="height: 100%; width: 100%">
    <tr class="scMenuTTable">
        <td class="scMenuTTableM" valign="top">
                <table cellpadding=0 cellspacing=0>
                    <tr>
                            <td>
                      <?php
                      echo $this->apostila_escreveMenu($apostila_menuData['data']);
                      ?>
                            </td>
                    </tr>
                </table>
        </td>
      </tr>
    </table>
</div>
<div class="ui-layout-center">
  <table cellspacing=0 cellpadding=0 style="height: 100%; width: 100%" cellpadding=0 cellspacing=0>
    <tr>
      
        <td id="Iframe_control" style="border: 0px; height: 100%; width:100%; vertical-align:top;text-align:center;padding: 0px">
        <iframe name="apostila_iframe" id="iframe_apostila" frameborder="0" class="scMenuIframe" style="width: 100%; height: 100%;" src="<?php echo $_SESSION['scriptcase']['apostila']['apl_inicial']?>"></iframe>
      </tr>
    </table>
</div>
<script type="text/javascript">
 function nm_out_menu(link)
 {
    if (link == 'javascript:window.close()')
    {
        window.close();
    }
    else
    {
        window.location = (link);
    }
 }
Iframe_atual = "apostila_iframe";
</script>
</body>
</html>
<?php
}
/* Controle de Target */
function apostila_escreveMenu($arr_menu)
{
    $aMenuItemList = array();
    foreach ($arr_menu as $ind => $resto)
    {
        $aMenuItemList[] = $resto;
    }
?>
<div id="css3menut">
    <ul>
        <?php
            for ($i = 0; $i < sizeof($aMenuItemList); $i++) {
            ?>
            
            <?php
                if ('' != $aMenuItemList[$i]['icon'] && file_exists($this->path_imag_apl . "/" . $aMenuItemList[$i]['icon'])) {
                    $iconHtml = 'data-jstree=\'{ "icon" : "../_lib/img/'. $aMenuItemList[$i]['icon'] .'" }\'';
                }
                else {
                    $iconHtml = '';
                }
                $sDisabledClass = '';
                if ('Y' == $aMenuItemList[$i]['disabled']) {
                    $aMenuItemList[$i]['link']   = '#';
                    $aMenuItemList[$i]['target'] = '';
                    $sDisabledClass               = 0 == $aMenuItemList[$i]['level'] ? ' scMenuTItemDisabled' : ' scMenuTSubItemDisabled';
                }
                if ($aMenuItemList[$i + 1] && $aMenuItemList[$i]['level'] < $aMenuItemList[$i + 1]['level']) {
                  if ($aMenuItemList[$i]['link'] == '#')
                  {
                  ?>
                     <li <?php echo $iconHtml; ?>><span class="scMenuTItems<?php echo $sDisabledClass; ?>"><?php echo $aMenuItemList[$i]['label']; ?></span><ul>
                  <?php
                  }
                  else
                  {
                  ?>
                     <li <?php echo $iconHtml; ?>><span class="scMenuTItems scMenuTItem"><a href="<?php echo $aMenuItemList[$i]['link']; ?>" id="<?php echo $aMenuItemList[$i]['id']; ?>" title="<?php echo $aMenuItemList[$i]['hint']; ?>"<?php echo $aMenuItemList[$i]['target']; ?> class="scMenuTItem"><?php echo $aMenuItemList[$i]['label']; ?></a></span><ul>
                  <?php
                  }
                }
                else
                {
                  if ($aMenuItemList[$i]['link'] == '#')
                  {
                    ?>
                    <li <?php echo $iconHtml; ?> class="scMenuTItems<?php echo $sDisabledClass; ?>"><a href='#' target=''><?php echo $aMenuItemList[$i]['label']; ?></a>
                    <?php
                  }
                  else
                  {
                    ?>
                    <li <?php echo $iconHtml; ?> class="scMenuTItems scMenuTItem"><a href="<?php echo $aMenuItemList[$i]['link']; ?>" id="<?php echo $aMenuItemList[$i]['id']; ?>" title="<?php echo $aMenuItemList[$i]['hint']; ?>"<?php echo $aMenuItemList[$i]['target']; ?> class="scMenuTItem"><?php echo $aMenuItemList[$i]['label']; ?></a>
                    <?php
                  }
                }
                if ($aMenuItemList[$i + 1] && $aMenuItemList[$i]['level'] == $aMenuItemList[$i + 1]['level']) {
                ?>
                    </li>
                <?php
                }
                elseif ($aMenuItemList[$i + 1] && $aMenuItemList[$i]['level'] > $aMenuItemList[$i + 1]['level']) {
                ?>
                    </li><?php echo str_repeat('</ul></li>', $aMenuItemList[$i]['level'] - $aMenuItemList[$i + 1]['level']); ?>
                <?php
                }
                elseif (!$aMenuItemList[$i + 1] && $aMenuItemList[$i]['level'] > 0) {
                ?>
                    </li><?php echo str_repeat('</ul></li>', $aMenuItemList[$i]['level']); ?>
                <?php
                }
                elseif (!$aMenuItemList[$i + 1] && $aMenuItemList[$i]['level'] == 0) {
                ?>
                    </li>
                <?php
                }
            }
        ?>
    </ul>
</div>
<?php
}
/* Controle de Target */
   function apostila_target($str_target)
   {
       global $apostila_menuData;
       if ('_blank' == $str_target)
       {
           return '_blank';
       }
       elseif ('_parent' == $str_target)
       {
           return '_parent';
       }
       elseif ($apostila_menuData['iframe'])
       {
           return 'apostila_iframe';
       }
       else
       {
           return $str_target;
       }
   }

   function nm_prot_aspas($str_item)
   {
       return str_replace('"', '\"', $str_item);
   }

   function nm_gera_menus(&$str_line_ret, $arr_menu_usu, $int_level, $nome_aplicacao)
   {
       global $apostila_menuData; 
       $str_marg = str_repeat('&nbsp;', 2);
       $str_marg = '';
       foreach ($arr_menu_usu as $arr_item)
       {
           $str_line   = array();
           $str_line['label']    = $this->nm_prot_aspas($arr_item['label']);
           $str_line['level']    = $int_level - 1;
           $str_line['link']     = "";
           $nome_apl = $arr_item['link'];
           $pos = strrpos($nome_apl, "/");
           if ($pos !== false)
           {
               $nome_apl = substr($nome_apl, $pos + 1);
           }
           if ('' != $arr_item['link'])
           {
               if ($arr_item['target'] == '_parent')
               {
                    $str_line['link'] = "javascript:parent.nm_out_menu('apostila_form_php.php?sc_item_menu=" . $arr_item['id'] . "&sc_apl_menu=" . $nome_apl . "&sc_apl_link=" . urlencode($apostila_menuData['url']['link']) . "&sc_usa_grupo=" . $_SESSION['scriptcase']['apostila']['glo_nm_usa_grupo'] . "')";  
               }
               else
               {
                    $str_line['link'] = "apostila_form_php.php?sc_item_menu=" . $arr_item['id'] . "&sc_apl_menu=" . $nome_apl . "&sc_apl_link=" . urlencode($apostila_menuData['url']['link']) . "&sc_usa_grupo=" . $_SESSION['scriptcase']['apostila']['glo_nm_usa_grupo'] . ""; 
               }
           }
           elseif ($arr_item['target'] == '_parent')
           {
               $str_line['link'] = "javascript:parent.nm_out_menu('" . $_SESSION['scriptcase']['sc_saida_apostila'] . "')"; 
           }
           $str_line['hint']     = ('' != $arr_item['hint']) ? $this->nm_prot_aspas($arr_item['hint']) : '';
           $str_line['id']       = $arr_item['id'];
           $str_line['icon']     = ('' != $arr_item['icon_on']) ? $arr_item['icon_on'] : '';
           $str_line['icon_aba'] = (isset($arr_item['icon_aba']) && !empty($arr_item['icon_aba'])) ? $arr_item['icon_aba'] : '';
           $str_line['icon_aba_inactive'] = (isset($arr_item['icon_aba_inactive']) && !empty($arr_item['icon_aba_inactive'])) ? $arr_item['icon_aba_inactive'] : '';
           if ('' == $arr_item['link'] && $arr_item['target'] == '_parent')
           {
               $str_line['target'] = '_parent';
           }
           else
           {
                $str_line['target'] = ('' != $arr_item['target'] && '' != $arr_item['link']) ?  $this->apostila_target( $arr_item['target']) : "_self"; 
           }
           $str_line['target']   = ' target="' . $str_line['target']  . '" ';
           $str_line['sc_id']    = $arr_item['id'];
           $str_line['disabled'] = "N";
           $str_line_ret[] = $str_line;
           if (!empty($arr_item['menu_itens']))
           {
               $this->nm_gera_menus($str_line_ret, $arr_item['menu_itens'], $int_level + 1, $nome_aplicacao);
           }
       }
   }

   function nm_arr_menu_recursiv($arr, $id_pai = '')
   {
         $arr_return = array();
         foreach ($arr as $id_menu => $arr_menu)
         {
             if ($id_pai == $arr_menu['pai']) 
             {
                 $arr_return[] = array('label'      => $arr_menu['label'],
                                        'link'       => $arr_menu['link'],
                                        'target'     => $arr_menu['target'],
                                        'icon_on'    => $arr_menu['icon'],
                                        'icon_aba'   => $arr_menu['icon_aba'],
                                        'icon_aba_inactive'   => $arr_menu['icon_aba_inactive'],
                                        'hint'       => $arr_menu['hint'],
                                        'id'         => $id_menu,
                                        'menu_itens' => $this->nm_arr_menu_recursiv($arr, $id_menu));
             }
         }
         return $arr_return;
   }
   function Gera_sc_init($apl_menu)
   {
        $_SESSION['scriptcase']['apostila']['sc_init'][$apl_menu] = 1;
        return  1;
   }
   function regionalDefault()
   {
       $_SESSION['scriptcase']['reg_conf']['date_format']   = (isset($this->Nm_conf_reg[$this->str_conf_reg]['data_format']))              ?  $this->Nm_conf_reg[$this->str_conf_reg]['data_format'] : "ddmmyyyy";
       $_SESSION['scriptcase']['reg_conf']['date_sep']      = (isset($this->Nm_conf_reg[$this->str_conf_reg]['data_sep']))                 ?  $this->Nm_conf_reg[$this->str_conf_reg]['data_sep'] : "/";
       $_SESSION['scriptcase']['reg_conf']['date_week_ini'] = (isset($this->Nm_conf_reg[$this->str_conf_reg]['prim_dia_sema']))            ?  $this->Nm_conf_reg[$this->str_conf_reg]['prim_dia_sema'] : "SU";
       $_SESSION['scriptcase']['reg_conf']['time_format']   = (isset($this->Nm_conf_reg[$this->str_conf_reg]['hora_format']))              ?  $this->Nm_conf_reg[$this->str_conf_reg]['hora_format'] : "hhiiss";
       $_SESSION['scriptcase']['reg_conf']['time_sep']      = (isset($this->Nm_conf_reg[$this->str_conf_reg]['hora_sep']))                 ?  $this->Nm_conf_reg[$this->str_conf_reg]['hora_sep'] : ":";
       $_SESSION['scriptcase']['reg_conf']['time_pos_ampm'] = (isset($this->Nm_conf_reg[$this->str_conf_reg]['hora_pos_ampm']))            ?  $this->Nm_conf_reg[$this->str_conf_reg]['hora_pos_ampm'] : "right_without_space";
       $_SESSION['scriptcase']['reg_conf']['time_simb_am']  = (isset($this->Nm_conf_reg[$this->str_conf_reg]['hora_simbolo_am']))          ?  $this->Nm_conf_reg[$this->str_conf_reg]['hora_simbolo_am'] : "am";
       $_SESSION['scriptcase']['reg_conf']['time_simb_pm']  = (isset($this->Nm_conf_reg[$this->str_conf_reg]['hora_simbolo_pm']))          ?  $this->Nm_conf_reg[$this->str_conf_reg]['hora_simbolo_pm'] : "pm";
       $_SESSION['scriptcase']['reg_conf']['simb_neg']      = (isset($this->Nm_conf_reg[$this->str_conf_reg]['num_sinal_neg']))            ?  $this->Nm_conf_reg[$this->str_conf_reg]['num_sinal_neg'] : "-";
       $_SESSION['scriptcase']['reg_conf']['grup_num']      = (isset($this->Nm_conf_reg[$this->str_conf_reg]['num_sep_agr']))              ?  $this->Nm_conf_reg[$this->str_conf_reg]['num_sep_agr'] : ".";
       $_SESSION['scriptcase']['reg_conf']['dec_num']       = (isset($this->Nm_conf_reg[$this->str_conf_reg]['num_sep_dec']))              ?  $this->Nm_conf_reg[$this->str_conf_reg]['num_sep_dec'] : ",";
       $_SESSION['scriptcase']['reg_conf']['neg_num']       = (isset($this->Nm_conf_reg[$this->str_conf_reg]['num_format_num_neg']))       ?  $this->Nm_conf_reg[$this->str_conf_reg]['num_format_num_neg'] : 2;
       $_SESSION['scriptcase']['reg_conf']['monet_simb']    = (isset($this->Nm_conf_reg[$this->str_conf_reg]['unid_mont_simbolo']))        ?  $this->Nm_conf_reg[$this->str_conf_reg]['unid_mont_simbolo'] : "R$";
       $_SESSION['scriptcase']['reg_conf']['monet_f_pos']   = (isset($this->Nm_conf_reg[$this->str_conf_reg]['unid_mont_format_num_pos'])) ?  $this->Nm_conf_reg[$this->str_conf_reg]['unid_mont_format_num_pos'] : 3;
       $_SESSION['scriptcase']['reg_conf']['monet_f_neg']   = (isset($this->Nm_conf_reg[$this->str_conf_reg]['unid_mont_format_num_neg'])) ?  $this->Nm_conf_reg[$this->str_conf_reg]['unid_mont_format_num_neg'] : 13;
       $_SESSION['scriptcase']['reg_conf']['grup_val']      = (isset($this->Nm_conf_reg[$this->str_conf_reg]['unid_mont_sep_agr']))        ?  $this->Nm_conf_reg[$this->str_conf_reg]['unid_mont_sep_agr'] : ".";
       $_SESSION['scriptcase']['reg_conf']['dec_val']       = (isset($this->Nm_conf_reg[$this->str_conf_reg]['unid_mont_sep_dec']))        ?  $this->Nm_conf_reg[$this->str_conf_reg]['unid_mont_sep_dec'] : ",";
       $_SESSION['scriptcase']['reg_conf']['html_dir']      = (isset($this->Nm_conf_reg[$this->str_conf_reg]['ger_ltr_rtl']))              ?  " DIR='" . $this->Nm_conf_reg[$this->str_conf_reg]['ger_ltr_rtl'] . "'" : "";
       $_SESSION['scriptcase']['reg_conf']['css_dir']       = (isset($this->Nm_conf_reg[$this->str_conf_reg]['ger_ltr_rtl']))              ?  $this->Nm_conf_reg[$this->str_conf_reg]['ger_ltr_rtl'] : "LTR";
       $_SESSION['scriptcase']['reg_conf']['html_dir_only'] = (isset($this->Nm_conf_reg[$this->str_conf_reg]['ger_ltr_rtl']))              ?  $this->Nm_conf_reg[$this->str_conf_reg]['ger_ltr_rtl'] : "";
       $_SESSION['scriptcase']['reg_conf']['num_group_digit']       = (isset($this->Nm_conf_reg[$this->str_conf_reg]['num_group_digit']))       ?  $this->Nm_conf_reg[$this->str_conf_reg]['num_group_digit'] : "1";
       $_SESSION['scriptcase']['reg_conf']['unid_mont_group_digit'] = (isset($this->Nm_conf_reg[$this->str_conf_reg]['unid_mont_group_digit'])) ?  $this->Nm_conf_reg[$this->str_conf_reg]['unid_mont_group_digit'] : "1";
   }

}
if ((isset($_POST['nmgp_opcao']) && $_POST['nmgp_opcao'] == "force_lang") || (isset($_GET['nmgp_opcao']) && $_GET['nmgp_opcao'] == "force_lang"))
{
    if (isset($_POST['nmgp_opcao']) && $_POST['nmgp_opcao'] == "force_lang")
    {
        $nmgp_opcao  = $_POST['nmgp_opcao'];
        $nmgp_idioma = $_POST['nmgp_idioma'];
    }
    else
    {
        $nmgp_opcao  = $_GET['nmgp_opcao'];
        $nmgp_idioma = $_GET['nmgp_idioma'];
    }
    $Temp_lang = explode(";" , $nmgp_idioma);
    if (isset($Temp_lang[0]) && !empty($Temp_lang[0]))
    {
        $_SESSION['scriptcase']['str_lang'] = $Temp_lang[0];
    }
    if (isset($Temp_lang[1]) && !empty($Temp_lang[1]))
    {
        $_SESSION['scriptcase']['str_conf_reg'] = $Temp_lang[1];
    }
}
$contr_apostila = new apostila_class;
$contr_apostila->apostila_menu();

?>
