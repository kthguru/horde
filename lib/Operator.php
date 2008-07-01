<?php
/**
 * Operator Base Class.
 *
 * $Horde: incubator/operator/lib/Operator.php,v 1.3 2008/07/01 22:25:00 bklang Exp $
 *
 * Copyright 2008 Alkaloid Networks LLC <http://projects.alkaloid.net>
 *
 * See the enclosed file COPYING for license information (GPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * @author  Ben Klang <ben@alkaloid.net>
 * @package Operator
 */
class Operator {

    /**
     * Build Operator's list of menu items.
     */
    function getMenu($returnType = 'object')
    {
        global $conf, $registry, $browser, $print_link;

        require_once 'Horde/Menu.php';

        $menu = new Menu(HORDE_MENU_MASK_ALL);
        $menu->add(Horde::applicationUrl('search.php'), _("Search"), 'user.png', $registry->getImageDir('horde'));
        $menu->add(Horde::applicationUrl('viewgraph.php'), _("View Graphs"), 'user.png', $registry->getImageDir('horde'));

        if ($returnType == 'object') {
            return $menu;
        } else {
            return $menu->render();
        }
    }

    function getColumns()
    {
        #static $columns = array(
        $columns = array(
            'accountcode' => _("Account Code"),
            'src' => _("Source"),
            'dst' => _("Destination"),
            'dcontext' => _("Destination Context"),
            'clid' => _("Caller ID"),
            'channel' => _("Channel"),
            'dstchannel' => _("Destination Channel"),
            'lastapp' => _("Last Application"),
            'lastdata' => _("Last Application Data"),
            'start' => _("Call Start Time"),
            'answer' => _("Call Answer Time"),
            'end' => _("Call End Time"),
            'duration' => _("Call Duration"),
            'billsec' => _("Billing Time (seconds)"),
            'disposition' => _("Call Disposition"),
            'amaflags' => _("AMA Flag"),
            'userfield' => _("User Defined Field"),
            'uniqueid' => _("Call Unique ID"));

        return $columns;
    }


    function getColumnName($column)
    {
        $columns = Operator::getColumns();
        return $columns[$column];
    }

    function getAMAFlagName($flagid)
    {
        // See <asterisk/cdr.h> for definitions
        switch($flagid) {
        case 1:
            return _("OMIT");
            break;
        case 2:
            return _("BILLING");
            break;
        case 3:
            return _("DOCUMENTATION");
            break;
        }
    }

    /**
     * Get a list of valid account codes from the database
     *
     * @return array  List of valid account codes.
     */
    function getAccountCodes()
    {
        global $cache, $operator_driver;

        // Use 0 lifetime to allow cache lifetime to be set when storing the
        // object.
        $accountcodes = $cache->get('operator-accountcodes', 0);
        if ($accountcodes === false) {
            $accountcodes = $operator_driver->getAccountCodes();

            // Add an option to select all accounts
            $keys = $accountcodes;
            array_unshift($keys, '%');
            $values = $accountcodes;
            array_unshift($values, _("-- All Accounts --"));

            if ($index = array_search('', $values)) {
               $values[$index] = _("-- Empty Accountcode --");
            }

            // Make the index of each array entry the same as its value
            $accountcodes = array_combine($keys, $values);

            $res = $cache->set('operator-accountcodes',
                               serialize($accountcodes), 600);
            if ($res === false) {
                Horde::logMessage('The cache system has experienced an error.  Unable to continue.', __FILE__, __LINE__, PEAR_LOG_ERR);
                $notification->push(_("Internal error.  Details have been logged for the administrator."));
                $accountcodes = array();
            }
        } else {
            $accountcodes = unserialize($accountcodes);
        }

        return $accountcodes;
    }
}
