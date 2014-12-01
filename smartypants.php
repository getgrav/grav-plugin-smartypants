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
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
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
        require_once(__DIR__.'/vendor/Michelf/SmartyPants.php');
        $this->enable([
            'onPageProcessed' => ['onPageProcessed', 0],
            'onPageContentProcessed' => ['onPageContentProcessed', 0],
            'onTwigExtensions' => ['onTwigExtensions', 0]
        ]);
    }

    /**
     * Apply smartypants to title
     */
    public function onPageProcessed(Event $event)
    {
        $page = $event['page'];
        $this->mergeConfig($page);

        if ($this->config->get('plugins.smartypants.process_title')) {
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
            $page->setRawContent(\Michelf\SmartyPants::defaultTransform(
                $page->getRawContent(),
                $this->config->get('plugins.smartypants.options')
            ));
        }
    }

    /**
     * Add Twig Extensions
     */
    public function onTwigExtensions()
    {
        if (!$this->config->get('plugins.smartypants.twig_filter')) {
            return;
        }

        require_once(__DIR__.'/twig/SmartyPantsTwigExtension.php');
        $this->grav['twig']->twig->addExtension(new SmartyPantsTwigExtension());
    }

    protected function mergeConfig(Page $page)
    {
        $defaults = (array) $this->config->get('plugins.smartypants');
        if (isset($page->header()->smartypants)) {
            $this->config->set('plugins.smartypants', array_merge($defaults, $page->header()->smartypants));
        }
    }
}
