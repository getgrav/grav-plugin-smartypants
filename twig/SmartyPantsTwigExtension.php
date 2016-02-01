<?php
namespace Grav\Plugin;

use \Grav\Common\Grav;

class SmartyPantsTwigExtension extends \Twig_Extension
{

    protected $config;

    public function __construct()
    {
        $this->config = Grav::instance()['config'];
    }

    /**
     * Returns extension name.
     *
     * @return string
     */
    public function getName()
    {
        return 'SmartyPantsTwigExtension';
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('smartypants', [$this, 'smartypantsFilter']),

        ];
    }

    public function smartypantsFilter($content, $options = null)
    {
        if (!$options) {
            $options = $this->config->get('plugins.smartypants.options');
        }
        $smartypants = new \Michelf\SmartyPantsTypographer($options);

        if ($this->config->get('plugins.smartypants.dq_open'))
            $smartypants->smart_doublequote_open = $this->config->get('plugins.smartypants.dq_open');
        if ($this->config->get('plugins.smartypants.dq_close'))
            $smartypants->smart_doublequote_close = $this->config->get('plugins.smartypants.dq_close');
        if ($this->config->get('plugins.smartypants.sq_open'))
            $smartypants->smart_singlequote_open = $this->config->get('plugins.smartypants.sq_open');
        if ($this->config->get('plugins.smartypants.sq_close'))
            $smartypants->smart_singlequote_close = $this->config->get('plugins.smartypants.sq_close');

        return $smartypants->transform($content);
    }

}
