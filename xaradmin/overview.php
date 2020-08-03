<?php
/**
 * Displays standard Overview page
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
 * Overview function that displays the standard Overview page
 * @author jojodee <jojodee@xaraya.com>
 * @return mixed
 */
function scheduler_admin_overview()
{
   /* Security Check */
    if (!xarSecurityCheck('AdminScheduler',0)) return;

    $data=array();

    /* if there is a separate overview function return data to it
     * else just call the main function that displays the overview
     */
    $data['menulinks'] = xarModAPIFunc('scheduler','admin','getmenulinks');
    return xarTplModule('scheduler', 'admin', 'main', $data,'main');
}

?>
