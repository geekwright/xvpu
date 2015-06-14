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

use Xoops\Core\Request;
use Xmf\Module\Session;

include dirname(dirname(__DIR__)) . '/mainfile.php';

$xoops = \Xoops::getInstance();
$xoops->header();

$dir = basename(__DIR__);
$helper = $xoops->getModuleHelper($dir);

$config_test_dir = $helper->getConfig('test_dir');

$test_dir = $config_test_dir;
$sessionHelper = new Session();
if ($sessionHelper) {
    $var = $sessionHelper->get('test_dir');
    if ($var) {
        $test_dir = $var;
    }
}

// if this is a post operation get our test_dir, save it and redirect to app
if ('GET'==Request::getMethod()) {
    $var=Request::getVar('test_dir', '', $hash = 'GET');
    if (!empty($var)) {
        launchApp($var);
    }
}

// if this is a post operation get our test_dir, save it and redirect to app
if ('POST'==Request::getMethod()) {
    $test_dir=Request::getVar('test_dir', '', $hash = 'POST');
    if (empty($test_dir)) {
        $test_dir = $config_test_dir;
    }
    if ($sessionHelper) {
        $sessionHelper->set('test_dir', $test_dir);
    }
    launchApp($test_dir);
}

$form = new \Xoops\Form\ThemeForm('', 'form', '', 'POST');
$form->addElement(new \Xoops\Form\Text('Unit Test Directory', 'test_dir', 5, 512, $test_dir));
$form->addElement(new \Xoops\Form\Button('', 'submit', 'Launch', 'submit'));

echo $form->render();

echo '<br \><a href="?test_dir=' . $xoops->path('modules/'.$dir.'/app/tests') . '">Examples</a>';

$xoops->footer();

/**
 * launchApp - launch the VisualPHPUnit app
 *
 * @param string $test_dir fully qualified path to test directory
 *
 * @return void
 */
function launchApp($test_dir)
{
    $xoops = \Xoops::getInstance();
    $dir = basename(__DIR__);
    $configValue =
        "<?php\n"
        . "define('TEST_DIRECTORY', '" . $test_dir . "');\n"
        . "define('AUTOLOADER_PATH', '" . XOOPS_PATH . "/vendor/autoload.php');\n";
    $configFile = __DIR__ . '/app/configpaths.php';
    file_put_contents($configFile, $configValue);
    header('Location: ' . $xoops->url('modules/'.$dir.'/app/'));
    exit;
}
