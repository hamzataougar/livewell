<?php

define('REG_VIDEO', "/$pattern/" );

if(!defined('STYLESHEET_DIR_URI'))
    define( 'STYLESHEET_DIR_URI', get_stylesheet_directory_uri());
if(!defined('STYLESHEET_DIR'))
    define( 'STYLESHEET_DIR', get_stylesheet_directory());

require(STYLESHEET_DIR . '/include/functions/hooks.php');
require(STYLESHEET_DIR . '/include/functions/shortcodes.php');
require(STYLESHEET_DIR . '/include/functions/hbh-functions.php');
