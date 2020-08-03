<?php
/**
 * Scheduler module
 *
 * @package modules
 * @copyright (C) 2002-2006 The Digital Development Foundation
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * *
 * @subpackage Xarigami Scheduler Module
 * @copyright (C) 2008-2011 2skies.com
 * @link http://xarigami.com/projects/
 * @author mikespub
 */
/**
 * the main administration function
 */
function scheduler_admin_main()
{
    if (!xarSecurityCheck('AdminScheduler')) return;

        xarResponseRedirect(xarModURL('scheduler', 'admin', 'modifyconfig'));

    return true;
}

?>
