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
 * @copyright 2014 XOOPS Project (http://xoops.org)
 * @license   GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author    Richard Griffith <richard@geekwright.com>
 */

use Xmf\Request;
use Xmf\Module\Helper\Session;

include dirname(dirname(__DIR__)) . '/mainfile.php';

$xoops = \Xoops::getInstance();
$xoops->header();

$dir = basename(__DIR__);
$helper = $xoops->getModuleHelper($dir);

$config_test_dir = $helper->getConfig('test_dir');
$config_test_bootstrap = $helper->getConfig('test_bootstrap');

$test_dir = $config_test_dir;
$test_bootstrap = $config_test_bootstrap;
$sessionHelper = new Session();
if ($sessionHelper) {
    $test_dir = $sessionHelper->get('test_dir', $test_dir);
    $test_bootstrap = $sessionHelper->get('test_bootstrap', $test_bootstrap);
}

// if this is a post operation get our test_dir, save it and redirect to app
if ('GET'===Request::getMethod()) {
    $dir=Request::getVar('test_dir', '', $hash = 'GET');
    $bootstrap=Request::getVar('test_bootstrap', $config_test_bootstrap, $hash = 'GET');
    if (!empty($dir)) {
        launchApp($dir, $bootstrap);
    }
}

// if this is a post operation get our test_dir, save it and redirect to app
if ('POST'===Request::getMethod()) {
    $test_dir=Request::getVar('test_dir', $config_test_dir, 'POST');
    $test_bootstrap = Request::getVar('test_bootstrap', $config_test_bootstrap, 'POST');
    if ($sessionHelper) {
        $sessionHelper->set('test_dir', $test_dir);
        $sessionHelper->set('test_bootstrap', $test_bootstrap);
    }
    launchApp($test_dir, $test_bootstrap);
}

$form = new \Xoops\Form\ThemeForm('', 'form', '', 'POST');
$form->addElement(new \Xoops\Form\Text('Unit Test Directory', 'test_dir', 5, 512, $test_dir));
$form->addElement(new \Xoops\Form\Text('Bootstrap Script', 'test_bootstrap', 5, 512, $test_bootstrap));
$form->addElement(new \Xoops\Form\Button('', 'submit', 'Launch', 'submit'));

echo $form->render();

echo '<br \><a href="?test_dir=' . $xoops->path('modules/'.basename(__DIR__) . '/app/tests') . '">Examples</a>';

$xoops->footer();

/**
 * launchApp - launch the VisualPHPUnit app
 *
 * @param string $test_dir fully qualified path to test directory
 *
 * @return void
 */
function launchApp($test_dir, $test_bootstrap)
{
    $xoops = \Xoops::getInstance();
    $dir = basename(__DIR__);
    $configValue =
        "<?php\n"
        . "define('TEST_DIRECTORY', '" . $test_dir . "');\n"
        . "define('AUTOLOADER_PATH', '" . $test_bootstrap . "');\n";
    $configFile = __DIR__ . '/app/configpaths.php';
    file_put_contents($configFile, $configValue);
    header('Location: ' . $xoops->url('modules/'.$dir.'/app/'));
    exit;
}
