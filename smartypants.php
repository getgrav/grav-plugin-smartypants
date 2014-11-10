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
            'onPageContentProcessed' => ['onPageContentProcessed', 0],
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
    public function onPageContentProcessed(Event $event)
    {
        $defaults = (array) $this->config->get('plugins.smartypants');

        /** @var Page $page */
        $page = $event['page'];
        if (isset($page->header()->smartypants)) {
            $this->config->set('plugins.smartypants', array_merge($defaults, $page->header()->smartypants));
        }

        if ($this->config->get('plugins.smartypants.process')) {
            require_once(__DIR__.'/vendor/Michelf/SmartyPants.php');
            $page->setRawContent(\Michelf\SmartyPants::defaultTransform($page->getRawContent(), $this->config->get('plugins.smartypants.options')));
        }
    }
}
