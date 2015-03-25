# Grav Smartypants Plugin

`Smartypants` is a [Grav](http://github.com/getgrav/grav) v0.9.5+ plugin that SmartyPants is a typography prettifyier tool for web writers. It easily translates plain ASCII punctuation characters into "smart" typographic punctuation HTML entities. The Grav plugin for SmartyPants provides the ability to prettify **page titles**, **page content**, and also provides a `smartypants` twig filter.

# Installation

Installing the Smartypants plugin can be done in one of two ways. Our GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file. 

## GPM Installation (Preferred)

![Smartypants](assets/readme_1.png)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's Terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install smartypants

This will install the Smartypants plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/smartypants`.

## Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `smartypants`. You can find these files either on [GitHub](https://github.com/getgrav/grav-plugin-smartypants) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/smartypants


# Usage

The `smartypants` plugin comes with some sensible default configuration, that are pretty self explanatory:

# Options

    enabled: true           // Enables or Disables the entire plugin for all pages.
    twig_filter: true       // Enables or Disables the twig filter
    process_title: false    // Enables or Disables processing on page titles
    process_content: true   // Enables or Disables processing on page contents
    options: qDew           // Smartypants-specific configuration options

The options are described in detail on the [PHP SmartyPants GitHub Site](https://github.com/michelf/php-smartypants): https://github.com/michelf/php-smartypants

To customize the plugin, you first need to create an override config. To do so, create the folder `user/config/plugins` (if it doesn't exist already) and copy the [smartypants.yaml](smartypants.yaml) config file in there and then make your edits.

Also you can override the default options per-page:

    ---
    title: 'My "Page"'
    smartypants:
        process_title: true
        process_content: true
        options: qd
    ---

    # "Lorem ipsum dolor sit amet"

There are two main scenarios:

1. **Disabled** by default by setting `process_content: false` in your `user/config/plugins/smartypants.yaml` then enable per page with `smartypants: process_content: true` in your page headers.
2. **Enabled** by default by setting `process_content: true` in your `user/config/plugins/smartypants.yaml` then disable per page with `smartypants: process_content: false` in your page headers.

# Twig Filter

There is now a Twig filter that you can use to process SmartyPants dynamically on any string when working with Twig:

```
{{ page.header.custom|smartypants }}
```

You can also pass custom SmartyPants options:

```
{{ page.header.custom|smartypants('qew') }}
```

# Compatibility Notice

> If Smartypants is **enabled** for a page that has `cache_enabled: false` and `twig: process: true`, the markdown will process and run events before Twig, causing single quotes to get converted and cause a conflict with the Twig processing. This will result in Twig erroring out.

# Updating

As development for the Smartypants plugin continues, new versions may become available that add additional features and functionality, improve compatibility with newer Grav releases, and generally provide a better user experience. Updating Smartypants is easy, and can be done through Grav's GPM system, as well as manually.

## GPM Update (Preferred)

The simplest way to update this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm). You can do this with this by navigating to the root directory of your Grav install using your system's Terminal (also called command line) and typing the following:

    bin/gpm update smartypants

This command will check your Grav install to see if your Smartypants plugin is due for an update. If a newer release is found, you will be asked whether or not you wish to update. To continue, type `y` and hit enter. The plugin will automatically update and clear Grav's cache.

## Manual Update

Manually updating Smartypants is pretty simple. Here is what you will need to do to get this done:

* Delete the `your/site/user/plugins/smartypants` directory.
* Downalod the new version of the Smartypants plugin from either [GitHub](https://github.com/getgrav/grav-plugin-smartypants) or [GetGrav.org](http://getgrav.org/downloads/plugins#extras).
* Unzip the zip file in `your/site/user/plugins` and rename the resulting folder to `smartypants`.
* Clear the Grav cache. The simplest way to do this is by going to the root Grav directory in terminal and typing `bin/grav clear-cache`.

> Note: Any changes you have made to any of the files listed under this directory will also be removed and replaced by the new set. Any files located elsewhere (for example a YAML settings file placed in `user/config/plugins`) will remain intact.

