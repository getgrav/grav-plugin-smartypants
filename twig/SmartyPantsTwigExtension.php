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

        return \Michelf\SmartyPants::defaultTransform($content, $options);
    }

}
