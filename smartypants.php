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
            'onPageProcessed' => ['onPageProcessed', 0],
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
     * Apply smartypants to title
     */
    public function onPageProcessed(Event $event)
    {
        $page = $event['page'];
        $this->mergeConfig($page);

        if ($this->config->get('plugins.smartypants.process_title')) {
            require_once(__DIR__.'/vendor/Michelf/SmartyPants.php');
            $page->title(\Michelf\SmartyPants::defaultTransform(
                $page->title(),
                $this->config->get('plugins.smartypants.options')
            ));
        }
    }

    /**
     * Apply smartypants to content
     */
    public function onPageContentProcessed(Event $event)
    {
        $page = $event['page'];
        $this->mergeConfig($page);

        if ($this->config->get('plugins.smartypants.process_content')) {
            require_once(__DIR__.'/vendor/Michelf/SmartyPants.php');
            $page->setRawContent(\Michelf\SmartyPants::defaultTransform(
                $page->getRawContent(),
                $this->config->get('plugins.smartypants.options')
            ));
        }
    }

    protected function mergeConfig(Page $page)
    {
        $defaults = (array) $this->config->get('plugins.smartypants');
        if (isset($page->header()->smartypants)) {
            $this->config->set('plugins.smartypants', array_merge($defaults, $page->header()->smartypants));
        }
    }
}
