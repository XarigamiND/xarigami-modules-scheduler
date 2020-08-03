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
$modversion['name']           = 'scheduler';
$modversion['directory']      = 'scheduler';
$modversion['id']             = '189';
$modversion['version']        = '1.2.1';
$modversion['displayname']    = 'Scheduler';
$modversion['description']    = 'Schedule jobs at certain times of the day/week/month (cron)';
$modversion['credits']        = '';
$modversion['help']           = '';
$modversion['changelog']      = '';
$modversion['license']        = '';
$modversion['official']       = 1;
$modversion['author']         = 'mikespub';
$modversion['contact']        = 'http://xarigami.com/';
$modversion['homepage']       = 'http://xarigami.com/projects/xarigami_scheduler';
$modversion['admin']          = 1;
$modversion['user']           = 0;
$modversion['class']          = 'Utility';
$modversion['category']       = 'Tools';
$modversion['dependencyinfo']   = array(
                                    0 => array(
                                            'name' => 'core',
                                            'version_ge' => '1.4.0'
                                         )
                                      );
if (false) {
    xarML('Scheduler');
    xarML('Schedule jobs at certain times of the day/week/month');
}
?>
