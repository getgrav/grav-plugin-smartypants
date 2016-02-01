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
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
            'onBlueprintCreated' => ['onBlueprintCreated', 0]
        ];
    }

    /**
     * Initialize configuration
     */
    public function onPluginsInitialized()
    {
        if ($this->isAdmin() && !$this->config->get('plugins.smartypants.enabled_in_admin', false)) {
            $this->active = false;
            return;
        }

        require_once(__DIR__.'/vendor/Michelf/SmartyPants.php');
        require_once(__DIR__.'/vendor/Michelf/SmartyPantsTypographer.php');
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
            $page->title($this->transform(
                $page->title(),
                $config
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
            $page->setRawContent($this->transform(
                $page->getRawContent(),
                $config
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

    /**
     * Apply SmartyPants transformation on raw text.
     *
     * @param string $text raw text
     * @return string transformed text
     */
    protected function transform($text, $config)
    {
        $smartypants = new \Michelf\SmartyPantsTypographer($config->get('options'));
        if ($config->get('dq_open')) $smartypants->smart_doublequote_open = $config->get('dq_open');
        if ($config->get('dq_close')) $smartypants->smart_doublequote_close = $config->get('dq_close');
        if ($config->get('sq_open')) $smartypants->smart_singlequote_open = $config->get('sq_open');
        if ($config->get('sq_close')) $smartypants->smart_singlequote_close = $config->get('sq_close');
        return $smartypants->transform($text);
    }
}
