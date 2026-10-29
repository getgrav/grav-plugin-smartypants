<?php
namespace Grav\Plugin\Smartypants;

use Michelf\SmartyPantsTypographer;

/**
 * SmartyPants Typographer with the fixes Grav content needs.
 */
class Typographer extends SmartyPantsTypographer
{
    /**
     * Apostrophe character. Empty keeps the library behavior, where the
     * closing single quote doubles as the apostrophe.
     */
    public $smart_apostrophe = '';

    /**
     * Leave Twig tags alone. Grav renders content Twig after
     * onPageContentProcessed, so a curled quote inside {{ }} or {% %}
     * is a Twig syntax error by the time Twig sees it.
     */
    protected function tokenizeHTML($str)
    {
        // The library's own tokenizer with Twig tags added as tag tokens.
        // A Twig tag that starts in text wins over any HTML inside it
        // ({{ '<br>'|raw }}); one inside an HTML tag's attribute is already
        // part of that tag.
        $match = '(?s:\{\{.*?\}\})|(?s:\{%.*?%\})|(?s:\{#.*?#\})|'.
                 '(?s:<!--.*?-->)|'.
                 '(?s:<\?.*?\?>)|'.
                 '(?:<[/!$]?[-a-zA-Z0-9:]+\b(?>[^"\'>]+|"[^"]*"|\'[^\']*\')*>)';

        $tokens = [];
        foreach (preg_split("{($match)}", $str, -1, PREG_SPLIT_DELIM_CAPTURE) as $i => $part) {
            if ($i % 2) {
                $tokens[] = ['tag', $part];
            } elseif ($part !== '') {
                $tokens[] = ['text', $part];
            }
        }

        return $tokens;
    }

    /**
     * A quote that is a whole text token on its own (`"<em>x</em>"`) gets
     * the configured characters. The bundled library hard-codes the English
     * ones for that case.
     */
    public function educate($t, $prev_token_last_char)
    {
        if ($this->do_quotes && ($t === '"' || $t === "'")) {
            $closing = (bool) preg_match('/\S/', $prev_token_last_char);
            if ($t === '"') {
                $t = $closing ? $this->smart_doublequote_close : $this->smart_doublequote_open;
            } else {
                $t = $closing ? $this->smart_singlequote_close : $this->smart_singlequote_open;
            }
        }

        return parent::educate($t, $prev_token_last_char);
    }

    /**
     * A quote between two letters (it's, geht's, l'été) or in front of a
     * decade ('80s) is an apostrophe, never a closing quote.
     */
    protected function educateQuotes($_)
    {
        if ($this->smart_apostrophe !== '') {
            $patterns = ["/(?<=\\w)'(?=\\w)/u", "/'(?=\\d{2}s\\b)/u"];
            // /u gives \w the accented letters; on invalid UTF-8 it fails, so fall back to plain \w.
            $_ = preg_replace($patterns, $this->smart_apostrophe, $_)
                ?? preg_replace(["/(?<=\\w)'(?=\\w)/", "/'(?=\\d{2}s\\b)/"], $this->smart_apostrophe, $_);
        }

        return parent::educateQuotes($_);
    }
}
