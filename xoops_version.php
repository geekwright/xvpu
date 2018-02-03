<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright 2014-2018 XOOPS Project (http://xoops.org)
 * @license   GNU GPL 2 or later (http://www.gnu.org/licenses//gpl-2.0.html)
 * @author    geekwright <richard@geekwright.com>
 */

$modversion['dirname'] = basename(__DIR__);
$modversion['name'] = ucfirst(basename(__DIR__));
$modversion['version'] = '2.0';
$modversion['description'] = 'XOOPS VisualPHPUnit';
$modversion['author'] = "geekwright";
$modversion['credits'] = "github.com/NSinopoli/VisualPHPUnit";
$modversion['help'] = 'page=help';
$modversion['helpsection'][]=array(
    'name' => _MI_XVPU_HELP,
    'link' => 'page=help'
);
$modversion['helpsection'][]=array(
    'name' => _MI_XVPU_USAGE,
    'link' => 'page=usage'
);
$modversion['license'] = "GNU GPL 2 or later";
$modversion['license_url'] = 'http://www.gnu.org/licenses/gpl-2.0.html';
$modversion['official'] = 0;
$modversion['image'] = 'icons/logo.png';

$modversion['hasMain'] = 1;

//$modversion['onInstall'] = "include/install.php";
//$modversion['onUpdate'] = "include/install.php";

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['system_menu'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu']  = "admin/menu.php";

// configuration
$modversion['config'][] = array(
    'name' => 'test_dir',
    'title' => '_MI_XVPU_TEST_DIR',
    'description' => '_MI_XVPU_TEST_DIR_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => dirname(XOOPS_ROOT_PATH) . '/tests/unit',
);

$modversion['config'][] = array(
    'name' => 'test_bootstrap',
    'title' => '_MI_XVPU_TEST_BOOTSTRAP',
    'description' => '_MI_XVPU_TEST_BOOTSTRAP_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => XOOPS_PATH . '/vendor/autoload.php',
);

// About stuff
$modversion['module_status'] = "Beta";
$modversion['status'] = "Beta";
$modversion['release_date'] = '02/03/2018';

$modversion['developer_lead'] = "geekwright";
$modversion['developer_website_url'] = "http://xoops.org";
$modversion['developer_website_name'] = "Xoops";
$modversion['developer_email'] = "richard@geekwright.com";

//$modversion['people']['developers'][] = "geekwright";

$modversion['min_xoops'] = "2.6.0";
$modversion['min_php'] = "7.1";
