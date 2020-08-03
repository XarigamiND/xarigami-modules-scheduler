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
 * Modify extra information for scheduler jobs
 * @param id itemid
 */
function scheduler_admin_modify()
{
    if (!xarVarFetch('itemid','id', $itemid)) {return;}

    if (!xarSecurityCheck('AdminScheduler')) return;

    $serialjobs = xarModGetVar('scheduler', 'jobs');
    if (empty($serialjobs)) {
        $jobs = array();
    } else {
        $jobs = unserialize($serialjobs);
    }

    if (empty($jobs[$itemid])) {
        xarResponseRedirect(xarModURL('scheduler', 'admin', 'modifyconfig'));
        return true;
    }

    if (!xarVarFetch('confirm','isset',$confirm,NULL,XARVAR_NOT_REQUIRED)) return;
    if (!empty($confirm)) {
        if (!xarSecConfirmAuthKey()) return;

        if (!xarVarFetch('interval','isset',$interval,'',XARVAR_NOT_REQUIRED)) return;
        $jobs[$itemid]['interval'] = $interval;

        if (!xarVarFetch('config','isset',$config,array(),XARVAR_NOT_REQUIRED)) return;
        if (empty($config)) {
            $config = array();
        }
        if (!empty($config['startdate'])) {
            $config['startdate'] = strtotime($config['startdate']);
        }
        if (!empty($config['enddate'])) {
            $config['enddate'] = strtotime($config['enddate']);
        }
        if ($interval == '0c' && !empty($config['crontab'])) {
            $config['crontab']['nextrun'] = xarModAPIFunc('scheduler','user','nextrun',
                                                          $config['crontab']);
        }
        $jobs[$itemid]['config'] = $config;

        $serialjobs = serialize($jobs);
        xarModSetVar('scheduler','jobs',$serialjobs);
        $msg = xarML('Scheduler information updated.');
        xarTplSetMessage($msg,'status');
        xarResponseRedirect(xarModURL('scheduler', 'admin', 'modify',
                                      array('itemid' => $itemid)));
        return true;
    }

    // Use the current job as $data
    $data = $jobs[$itemid];
    $data['menulinks'] = xarModAPIFunc('scheduler','admin','getmenulinks');
    $data['itemid'] = $itemid;
    $data['authid'] = xarSecGenAuthKey();
    $data['intervals'] = xarModAPIFunc('scheduler','user','intervals');

    // Prefill the configuration array
    if (empty($data['config'])) {
        $data['config'] = array(
                                'params' => '',
                                'startdate' => '',
                                'enddate' => '',
                                'crontab' => array('minute' => '',
                                                   'hour' => '',
                                                   'day' => '',
                                                   'month' => '',
                                                   'weekday' => '',
                                                   'nextrun' => ''),
                                // not supported yet
                                'runas' => array('user' => '',
                                                 'pass' => ''),
                               );
    }

    // Return the template variables defined in this function
    return $data;
}
?>
