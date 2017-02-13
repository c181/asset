<?php
namespace Asset\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\Core\Configure;
use Cake\View\StringTemplateTrait;

/**
 * Asset helper
 */
class AssetHelper extends Helper
{
	use StringTemplateTrait;

    public $helpers = ['Url', 'Html'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'templates' => [
            'css' => '<link rel="{{rel}}" href="{{url}}"{{attrs}}/>',
            'style' => '<style{{attrs}}>{{content}}</style>',
            'javascriptblock' => '<script{{attrs}}>{{content}}</script>',
            'javascriptlink' => '<script src="{{url}}"{{attrs}}></script>',
        ]
    ];

    /**
     * Creates a link element for CSS stylesheets.
     *
     * ### Usage
     *
     * Include one CSS file:
     *
     * ```
     * echo $this->Html->css('styles.css');
     * ```
     *
     * Include multiple CSS files:
     *
     * ```
     * echo $this->Html->css(['one.css', 'two.css']);
     * ```
     *
     * Add the stylesheet to view block "css":
     *
     * ```
     * $this->Html->css('styles.css', ['block' => true]);
     * ```
     *
     * Add the stylesheet to a custom block:
     *
     * ```
     * $this->Html->css('styles.css', ['block' => 'layoutCss']);
     * ```
     *
     * ### Options
     *
     * - `block` Set to true to append output to view block "css" or provide
     *   custom block name.
     * - `once` Whether or not the css file should be checked for uniqueness. If true css
     *   files  will only be included once, use false to allow the same
     *   css to be included more than once per request.
     * - `plugin` False value will prevent parsing path as a plugin
     * - `rel` Defaults to 'stylesheet'. If equal to 'import' the stylesheet will be imported.
     * - `fullBase` If true the URL will get a full address for the css file.
     *
     * @param string|array $path The name of a CSS style sheet or an array containing names of
     *   CSS stylesheets. If `$path` is prefixed with '/', the path will be relative to the webroot
     *   of your application. Otherwise, the path will be relative to your CSS path, usually webroot/css.
     * @param array $options Array of options and HTML arguments.
     * @return string|null CSS <link /> or <style /> tag, depending on the type of link.
     * @link http://book.cakephp.org/3.0/en/views/helpers/html.html#linking-to-css-files
     */
    public function css($path, $file, $type = true, array $options = [])
    {
        $options += ['once' => true, 'block' => null, 'rel' => 'stylesheet'];

        if (is_array($path)) {
            $out = '';
            foreach ($path as $i) {
                $out .= "\n\t" . $this->css($i, $options);
            }
            if (empty($options['block'])) {
                return $out . "\n";
            }
            return null;
        }

        $typeFile = ($type === true) ? 'css/' : '';

        if (strpos($path, '//') !== false) {
            $url = $path . '/' . $typeFile . $file;
        } else {
            $url = $this->Url->css($path . '/' . $typeFile . $file, $options + ['pathPrefix' => Configure::read('App.assetBaseUrl'), 'ext' => '.css']);
            $options = array_diff_key($options, ['fullBase' => null, 'pathPrefix' => null]);
        }

        if ($options['once'] && isset($this->_includedAssets[__METHOD__][$path])) {
            return null;
        }
        unset($options['once']);
        $templater = $this->templater();

        if ($options['rel'] === 'import') {
            $out = $templater->format('style', [
                'attrs' => $templater->formatAttributes($options, ['rel', 'block']),
                'content' => '@import url(' . $url . ');',
            ]);
        } else {
            $out = $templater->format('css', [
                'rel' => $options['rel'],
                'url' => $url,
                'attrs' => $templater->formatAttributes($options, ['rel', 'block']),
            ]);
        }

        if (empty($options['block'])) {
            return $out;
        }
        if ($options['block'] === true) {
            $options['block'] = __FUNCTION__;
        }
        $this->_View->append($options['block'], $out);
    }

    /**
     * Returns one or many `<script>` tags depending on the number of scripts given.
     *
     * If the filename is prefixed with "/", the path will be relative to the base path of your
     * application. Otherwise, the path will be relative to your JavaScript path, usually webroot/js.
     *
     * ### Usage
     *
     * Include one script file:
     *
     * ```
     * echo $this->Html->script('styles.js');
     * ```
     *
     * Include multiple script files:
     *
     * ```
     * echo $this->Html->script(['one.js', 'two.js']);
     * ```
     *
     * Add the script file to a custom block:
     *
     * ```
     * $this->Html->script('styles.js', ['block' => 'bodyScript']);
     * ```
     *
     * ### Options
     *
     * - `block` Set to true to append output to view block "script" or provide
     *   custom block name.
     * - `once` Whether or not the script should be checked for uniqueness. If true scripts will only be
     *   included once, use false to allow the same script to be included more than once per request.
     * - `plugin` False value will prevent parsing path as a plugin
     * - `fullBase` If true the url will get a full address for the script file.
     *
     * @param string|array $url String or array of javascript files to include
     * @param array $options Array of options, and html attributes see above.
     * @return string|null String of `<script />` tags or null if block is specified in options
     *   or if $once is true and the file has been included before.
     * @link http://book.cakephp.org/3.0/en/views/helpers/html.html#linking-to-javascript-files
     */
    public function script($path, $file, $type = true, array $options = [])
    {
        $defaults = ['block' => null, 'once' => true];
        $options += $defaults;

        if (is_array($file)) {
            $out = '';
            foreach ($file as $i) {
                $out .= "\n\t" . $this->script($path, $i, $options);
            }
            if (empty($options['block'])) {
                return $out . "\n";
            }
            return null;
        }

        $typeFile = ($type === true) ? 'js/' : '';

        if (strpos($path, '//') === false) {
            $url = $this->Url->script($path . '/' . $typeFile . $file, $options + ['pathPrefix' => Configure::read('App.assetBaseUrl'), 'ext' => '.js']);
            $options = array_diff_key($options, ['fullBase' => null, 'pathPrefix' => null]);
        }
        if ($options['once'] && isset($this->_includedAssets[__METHOD__][$url])) {
            return null;
        }
        
        $out = $this->formatTemplate('javascriptlink', [
            'url' => $url,
            'attrs' => $this->templater()->formatAttributes($options, ['block', 'once']),
        ]);

        if (empty($options['block'])) {
            return $out;
        }
        if ($options['block'] === true) {
            $options['block'] = __FUNCTION__;
        }
        $this->_View->append($options['block'], $out);
    }

}
