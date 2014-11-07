<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use Grav\Common\Grav;
use Grav\Common\Page\Page;
use RocketTheme\Toolbox\Event\Event;

class SmartypantsPlugin extends Plugin
{
    /**
     * @var SmartypantsPlugin
     */


    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
            'onPageInitialized' => ['onPageInitialized', 0],
        ];
    }

    /**
     * Initialize configuration
     */
    public function onPluginsInitialized()
    {
        if ($this->isAdmin()) {
            $this->active = false;
        }

    }

    /**
     * Apply smartypants
     */
    public function onPageInitialized()
    {
        $defaults = (array) $this->config->get('plugins.smartypants');

        /** @var Page $page */
        $page = $this->grav['page'];
        if (isset($page->header()->smartypants)) {
            $this->config->set('plugins.smartypants', array_merge($defaults, $page->header()->smartypants));
        }

        $options = $this->config->get('plugins.smartypants.options');

        if ($this->config->get('plugins.smartypants.enabled')) {
            require_once(__DIR__.'/vendor/Michelf/SmartyPants.php');
            $this->grav['page']->content(\Michelf\SmartyPants::defaultTransform($this->grav['page']->content(), $options));
        }
    }
}
