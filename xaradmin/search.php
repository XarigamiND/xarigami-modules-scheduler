<?php
/**
 * Scheduler module
 *
 * @package modules
 * @copyright (C) 2002-2006 The Digital Development Foundation
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 *
 * @subpackage Xarigami Scheduler Module
 * @copyright (C) 2008-2011 2skies.com
 * @link http://xarigami.com/projects/
 * @author mikespub
 */
/**
 * search for scheduler API functions in modules/<module>/xarschedulerapi directories
 */
function scheduler_admin_search()
{
    if (!xarSecurityCheck('AdminScheduler')) return;

    $data = array();
    $data['found'] = array();
    $data['menulinks'] = xarModAPIFunc('scheduler','admin','getmenulinks');
    $modules = realpath('modules');
    $dh = opendir($modules);
    if (empty($dh)) return $data;
    while (($dir = readdir($dh)) !== false) {
        if (is_dir($modules . '/' . $dir) && is_dir($modules . '/' . $dir . '/xarschedulerapi')) {
            $dh2 = opendir($modules . '/' . $dir . '/xarschedulerapi');
            if (empty($dh2)) continue;
            while (($file = readdir($dh2)) !== false) {
                if (preg_match('/^(\w+)\.php$/',$file,$matches)) {
                    $data['found'][] = array('module' => $dir, // not really, but let's not be difficult
                                             'type' => 'scheduler',
                                             'func' => $matches[1]);
                }
            }
            closedir($dh2);
        }
    }
    closedir($dh);
    return $data;
}
?>