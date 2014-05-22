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
 * @copyright The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license   GNU GPL 2 or later (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author    Richard Griffith <richard@geekwright.com>
 * @version   $Id: about.php 8065 2011-11-06 02:02:32Z beckmi $
 */

require __DIR__ . '/admin_header.php';

$modAdmin = new \Xoops\Module\Admin();
$modAdmin->displayNavigation('index.php');
$modAdmin->displayIndex();

require __DIR__ . '/admin_footer.php';