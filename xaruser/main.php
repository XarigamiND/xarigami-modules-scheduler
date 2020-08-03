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
 * the main user function - only used for external triggers
 */
function scheduler_user_main()
{
    // check if we have the right trigger
    $trigger = xarModGetVar('scheduler','trigger');
    if (empty($trigger) || $trigger != 'external') {
        return xarML('Wrong trigger');
    }

    // get the IP
    $ip = xarServerGetVar('REMOTE_ADDR');
    $forwarded = xarServerGetVar('HTTP_X_FORWARDED_FOR');
    if (!empty($forwarded)) {
        $proxy = $ip;
        $ip = preg_replace('/,.*/', '', $forwarded);
    }

    $checktype = xarModGetVar('scheduler','checktype');
    $checkvalue = xarModGetVar('scheduler','checkvalue');

// TODO: allow IP range or domain here if that's what people want (insecure)
    $isvalid = 0;
    switch ($checktype) {
        case 'local':
            if (empty($proxy) && !empty($ip) && $ip == '127.0.0.1') {
                $isvalid = 1;
            }
            break;
        case 'ip':
            if (empty($proxy) && !empty($ip) && $ip == $checkvalue) {
                $isvalid = 1;
            }
            break;
        case 'proxy':
            if (!empty($proxy) && !empty($ip) && $ip == $checkvalue) {
                $isvalid = 1;
            }
            break;
        case 'host':
            if (!empty($ip)) {
                $hostname = @gethostbyaddr($ip);
                // same player, shoot again...
                if (empty($hostname)) {
                    $hostname = @gethostbyaddr($ip);
                }
                if (!empty($hostname) && $hostname == $checkvalue) {
                    $isvalid = 1;
                }
            }
            break;
    }
    if (!$isvalid) {
        if (!empty($ip)) {
            $hostname = @gethostbyaddr($ip);
            // same player, shoot again...
            if (empty($hostname)) {
                $hostname = @gethostbyaddr($ip);
            }

            if (empty($hostname)) {
                $hostname = 'unknown';
            }
        }
        xarLogMessage("scheduler: Failed trigger attempt from host $ip ($hostname).");
        return xarML('Wrong trigger')." $ip ($hostname) at " . date('j', time());
    }

    // check when we last ran the scheduler
    $lastrun = xarModGetVar('scheduler', 'lastrun');
    $now = time();
/*
    if (!empty($lastrun) && $lastrun > $now - ((60*5)-1) )  // Make sure it's been at least five minutes
    {
        $diff = time() - $lastrun;
        return xarML('Last run was #(1) minutes #(2) seconds ago', intval($diff / 60), $diff % 60);
    }
*/
    // let's run without interruptions for a while :)
    @ignore_user_abort(true);
    @set_time_limit(15*60);

    // update the last run time
    xarModSetVar('scheduler','lastrun',$now - 60); // remove the margin here
    xarModSetVar('scheduler','running',1);

    $output = xarModAPIFunc('scheduler','user','runjobs');

// TODO: dump exceptions ?
    return $output;
}

?>
