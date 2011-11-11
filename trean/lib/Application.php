<?php
/**
 * Trean application API
 *
 * Copyright 2002-2011 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (BSD). If you
 * did not receive this file, see http://www.horde.org/licenses/bsdl.php.
 *
 * @author Mike Cochrane <mike@graftonhall.co.nz>
 */

/* Determine the base directories. */
if (!defined('TREAN_BASE')) {
    define('TREAN_BASE', dirname(__FILE__) . '/..');
}

if (!defined('HORDE_BASE')) {
    /* If Horde does not live directly under the app directory, the HORDE_BASE
     * constant should be defined in config/horde.local.php. */
    if (file_exists(TREAN_BASE . '/config/horde.local.php')) {
        include TREAN_BASE . '/config/horde.local.php';
    } else {
        define('HORDE_BASE', TREAN_BASE . '/..');
    }
}

/* Load the Horde Framework core (needed to autoload
 * Horde_Registry_Application::). */
require_once HORDE_BASE . '/lib/core.php';

class Trean_Application extends Horde_Registry_Application
{
    /**
     */
    public $version = 'H4 (1.0-git)';

    /**
     * Global variables defined:
     * - $trean_db:      TODO
     * - $trean_gateway: TODO
     * - $linkTags:      <link> tags for common-header.inc.
     * - $bodyClass:     <body> CSS class for common-header.inc.
     */
    protected function _init()
    {
        /* For now, autoloading the Content_* classes depend on there being a
         * registry entry for the 'content' application that contains at least
         * the fileroot entry. */
        $GLOBALS['injector']->getInstance('Horde_Autoloader')->addClassPathMapper(new Horde_Autoloader_ClassPathMapper_Prefix('/^Content_/', $GLOBALS['registry']->get('fileroot', 'content') . '/lib/'));
        if (!class_exists('Content_Tagger')) {
            throw new Horde_Exception('The Content_Tagger class could not be found. Make sure the Content application is installed.');
        }

        // Set the timezone variable.
        $GLOBALS['registry']->setTimeZone();

        // Create db and gateway instances.
        $GLOBALS['trean_db'] = $GLOBALS['injector']->getInstance('Horde_Core_Factory_Db')->create('trean');
        try {
            $GLOBALS['trean_gateway'] = $GLOBALS['injector']->getInstance('Trean_Bookmarks');
        } catch (Exception $e) {
            var_dump($e);
        }

        $rss = Horde::url('rss.php', true, -1);
        if (Horde_Util::getFormData('f')) {
            $rss->add('f', Horde_Util::getFormData('f'));
        }
        $GLOBALS['linkTags'] = array('<link rel="alternate" type="application/rss+xml" title="' . htmlspecialchars(_("Bookmarks Feed")) . '" href="' . $rss . '" />');
    }

    /**
     */
    public function perms()
    {
        return array(
            'max_bookmarks' => array(
                'title' => _("Maximum Number of Bookmarks"),
                'type' => 'int'
            ),
        );
    }

    /**
     */
    public function menu($menu)
    {
        $menu->add(Horde::url('browse.php'), _("_Browse"), 'trean.png', null, null, null, basename($_SERVER['PHP_SELF']) == 'index.php' ? 'current' : null);
        $menu->add(Horde::url('search.php'), _("_Search"), 'search.png');
    }

    /* Sidebar method. */

    /**
     */
    public function sidebarCreate(Horde_Tree_Base $tree, $parent = null,
                                  array $params = array())
    {
        $tree->addNode(
            $parent . '__new',
            $parent,
            _("Add"),
            1,
            false,
            array(
                'icon' => Horde_Themes::img('add.png'),
                'url' => Horde::url('add.php')
            )
        );

        $tree->addNode(
            $parent . '__search',
            $parent,
            _("Search"),
            1,
            false,
            array(
                'icon' => Horde_Themes::img('search.png'),
                'url' => Horde::url('search.php')
            )
        );
    }
}
