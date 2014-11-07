# Grav Smartypants Plugin

`Smartypants` is a [Grav](http://github.com/getgrav/grav) plugin that SmartyPants is a typography prettifyier tool for web writers. It easily translates plain ASCII punctuation characters into "smart" typographic punctuation HTML entities.

# Installation

## GPM Installation (Preferred)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm).  From the root of your Grav install type:

    bin/gpm install smartypants

## Manual Installation

If for some reason you can't use GPM you can manually install this plugin. Download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `smartypants`.

You should now have all the plugin files under

	/your/site/grav/user/plugins/smartypants

# Usage

The `smartypants` plugin comes with some sensible default configuration, that are pretty self explanatory:

# Options

    enabled: true
    options: qDew

The options are described in detail on the PHP SmartyPants GitHub Site: https://github.com/michelf/php-smartypants

To customize the plugin, you first need to create an override config. To do so, create the folder `user/config/plugins` (if it doesn't exist already) and copy the [smartypants.yaml](smartypants.yaml) config file in there and then make your edits.

Also you can override the default options per-page:

    ---
    title: My Page
    smartypants:
        enabled: true
        options: qd
    ---

    # "Lorem ipsum dolor sit amet"


If you need to change any value, then the best process is to copy the [smartypants.yaml](smartypants.yaml) file into your `users/config/plugins/` folder (create it if it doesn't exist), and then modify there.  This will override the default settings.

