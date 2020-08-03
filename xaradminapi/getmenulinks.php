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
 * utility function pass individual menu items to the main menu
 *
 * @return array containing the menulinks for the main menu items.
 */
function scheduler_adminapi_getmenulinks()
{
    $menulinks = array();
    if (xarSecurityCheck('AdminScheduler', 0)) {
        $menulinks[] = Array('url' => xarModURL('scheduler', 'admin', 'search'),
                             'title' => xarML('Search for scheduler API functions'),
                             'label' => xarML('Find Functions'),
                             'active' => array('search'));
        $menulinks[] = Array('url' => xarModURL('scheduler', 'admin', 'modifyconfig'),
                             'title' => xarML('Modify the configuration for the module'),
                             'label' => xarML('Modify Config'),
                             'active' => array('modifyconfig'));
    }
    return $menulinks;
}

?>
