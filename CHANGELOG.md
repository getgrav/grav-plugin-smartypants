# v2.6.1
## 10/29/2026

1. [](#new)
    * New Apostrophe override, for languages whose closing single quote isn't the apostrophe [#7](https://github.com/getgrav/grav-plugin-smartypants/issues/7)
2. [](#bugfix)
    * Quotes inside shortcode attributes are no longer curled, so `[span class="x"]` keeps its class [#6](https://github.com/getgrav/grav-plugin-smartypants/issues/6)
    * Twig in page content no longer breaks when SmartyPants curls the quotes inside it
    * A quote standing on its own next to formatting, as in `"*Hallo*"`, now uses your configured quote characters instead of the English ones

# v2.6.0
## 05/01/2026

1. [](#improved)
    * Added 1.7|2.0 compatibility flags
    * Folded in pending working-tree changes (vendor refresh / minor PHP 8 modernization)

# v2.5.0
## 02/05/2016

1. [](#new)
    * Added custom overrides for SmartyPants default quotes

# v2.4.0
## 12/30/2015

1. [](#improved)
    * Renamed initial event for more reliable operation

# v2.3.0
## 08/25/2015

1. [](#improved)
    * Added blueprints for Grav Admin plugin
    * Added page-level smartypants options

# v2.2.0
## 07/21/2015

2. [](#improved)
    * Changed the initialization even to `onBuildPagesInitialized`
    * Added compatibility note in the `README.md` file
    
# v2.1.0
## 02/22/2015

2. [](#improved)
    * Uses new `mergeConfig()` method provided in base Plugins class

# v2.0.1
## 11/30/2014

1. [](#new)
    * ChangeLog started...
