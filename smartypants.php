<?php
namespace Grav\Plugin;

use Grav\Common\Data;
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
            'onBuildPagesInitialized' => ['onBuildPagesInitialized', 0],
            'onBlueprintCreated' => ['onBlueprintCreated', 0]
        ];
    }

    /**
     * Initialize configuration
     */
    public function onBuildPagesInitialized()
    {
        if ($this->isAdmin() && !$this->config->get('plugins.smartypants.enabled_in_admin', false)) {
            $this->active = false;
            return;
        }

        require_once(__DIR__.'/vendor/Michelf/SmartyPants.php');
        $this->enable([
            'onTwigExtensions' => ['onTwigExtensions', 0],
            'onPageProcessed' => ['onPageProcessed', 0],
            'onPageContentProcessed' => ['onPageContentProcessed', 0]
        ]);
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

    /**
     * Apply smartypants to title
     */
    public function onPageProcessed(Event $event)
    {
        $page = $event['page'];
        $config = $this->mergeConfig($page);

        if ($config->get('process_title')) {
            $page->title(\Michelf\SmartyPants::defaultTransform(
                $page->title(),
                $config->get('options')
            ));
        }
    }

    /**
     * Apply smartypants to content
     */
    public function onPageContentProcessed(Event $event)
    {
        $page = $event['page'];
        $config = $this->mergeConfig($page);

        if ($config->get('process_content')) {
            $page->setRawContent(\Michelf\SmartyPants::defaultTransform(
                $page->getRawContent(),
                $config->get('options')
            ));
        }
    }

    /**
     * Extend page blueprints with feed configuration options.
     *
     * @param Event $event
     */
    public function onBlueprintCreated(Event $event)
    {
        static $inEvent = false;

        /** @var Data\Blueprint $blueprint */
        $blueprint = $event['blueprint'];
        if (!$inEvent && $blueprint->get('form.fields.tabs')) {
            $inEvent = true;
            $blueprints = new Data\Blueprints(__DIR__ . '/blueprints/');
            $extends = $blueprints->get('smartypants');
            $blueprint->extend($extends, true);
            $inEvent = false;
        }
    }
}
