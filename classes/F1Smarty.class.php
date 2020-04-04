<?php
    date_default_timezone_set("Europe/Berlin");
    
    set_include_path(get_include_path().PATH_SEPARATOR.'.lib');
    require_once('lib/smarty/libs/Smarty.class.php');
    if(!defined('REQUIRED_SMARTY_DIR')) define('REQUIRED_SMARTY_DIR','./');
    
    include_once('Translator.class.php');
    
    class F1Smarty extends Smarty
    {
        function __construct()
        {
            parent::__construct();
            
            $this->template_dir = REQUIRED_SMARTY_DIR.'templates';
            $this->compile_dir = REQUIRED_SMARTY_DIR.'templates_c';
            $this->config_dir = REQUIRED_SMARTY_DIR.'config';
            $this->cache_dir = REQUIRED_SMARTY_DIR.'cache';
            
            //$this->caching = true;
            global $language;
            Translator::init($language);
            $this->registerPlugin('block', 'translate', array('Translator', 'translate'), true);
        }
    }
    
    $smarty = new F1Smarty();
    //$smarty->caching = true;
