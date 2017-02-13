<?php
namespace Asset\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\View\StringTemplateTrait;

/**
 * Cdnjs helper
 */
class CdnjsHelper extends Helper
{
	use StringTemplateTrait;

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
    	'templates' => [
            'javascriptlink' => '<script src="{{url}}"{{attrs}}></script>',
        ]
    ];

    /**
     * HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries
     * @return array link
     */
    public function library($url = [])
    {
        if (empty($url) || $url == '') {
        	$out = null;
        } else {
			// Script JS for IE and HTML5
	        $out = '<!--[if lt IE 9]>' . "\n";

	        if (count($url) > 0) {
	            foreach ($url as $i) {
	            	$out .= "\t";
	                $out .= $this->formatTemplate('javascriptlink', [
			            'url' => $i,
			            'attrs' => '',
			        ]);
			        $out .= "\n";
	            }
	        } else {
	        	$out .= "\t";
	            $out .= $this->formatTemplate('javascriptlink', [
			            'url' => $url,
			            'attrs' => '',
			        ]);
	            $out .= "\n";
	        }

	        $out .= "\t" .'<![endif]-->';
        }

        return $out;
    }

}
