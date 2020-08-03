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
 * update a scheduler job
 *
 * @author mikespub
 * @param  $args ['module'] module +
 * @param  $args ['type'] type +
 * @param  $args ['func'] API function, or
 * @param  $args ['itemid'] job id, and
 * @param  $args ['interval'] interval (optional)
 * @param  $args ['config'] extra configuration like params, startdate, enddate, crontab, ... (optional)
 * @param  $args ['lastrun'] lastrun (optional)
 * @param  $args ['result'] result (optional)
 * @return int job id on success, void on failure
 */
function scheduler_adminapi_update($args)
{
    extract($args);

    $invalid = array();
    if (isset($itemid)) {
        if (!is_numeric($itemid)) {
            $invalid[] = 'item id';
        }
    } else {
        if (empty($module) || !is_string($module)) {
            $invalid[] = 'module';
        }
        if (empty($type) || !is_string($type)) {
            $invalid[] = 'type';
        }
        if (empty($func) || !is_string($func)) {
            $invalid[] = 'func';
        }
    }
    if (count($invalid) > 0) {
        $msg = xarML('Invalid #(1) for #(2) function #(3)() in module #(4)',
                     join(', ', $invalid), 'admin', 'update', 'scheduler');
        throw new BadParameterException(null,$msg);
    }

    if (!xarSecurityCheck('AdminScheduler')) return;

    $serialjobs = xarModGetVar('scheduler','jobs');
    if (empty($serialjobs)) {
        $jobs = array();
    } else {
        $jobs = unserialize($serialjobs);
    }
    if (isset($itemid)) {
        if (!isset($jobs[$itemid])) {
            $msg = xarML('Invalid #(1) for #(2) function #(3)() in module #(4)',
                         'job id', 'admin', 'update', 'scheduler');
            throw new EmptyParameterException('jobs itemid');
        }
        if (!empty($module)) {
            $jobs[$itemid]['module'] = $module;
        }
        if (!empty($type)) {
            $jobs[$itemid]['type'] = $type;
        }
        if (!empty($func)) {
            $jobs[$itemid]['func'] = $func;
        }
    } else {
        foreach ($jobs as $id => $job) {
            if ($job['module'] == $module && $job['type'] == $type && $job['func'] == $func) {
                $itemid = $id;
                break;
            }
        }
        if (!isset($itemid)) {
            throw new EmptyParameterException('itemid');
        }
    }
    if (!empty($interval)) {
        $jobs[$itemid]['interval'] = $interval;
    }
    if (isset($config)) {
        $jobs[$itemid]['config'] = $config;
    }
    if (isset($lastrun)) {
        $jobs[$itemid]['lastrun'] = $lastrun;
    }
    if (isset($result)) {
        $jobs[$itemid]['result'] = $result;
    }
    $serialjobs = serialize($jobs);
    xarModSetVar('scheduler','jobs',$serialjobs);

    $item = $args;
    $item['module'] = 'scheduler';
    $item['itemid'] = $itemid;
    xarModCallHooks('item', 'update', $itemid, $item);

    // Return the id of the updated item to the calling process
    return $itemid;
}

?>
