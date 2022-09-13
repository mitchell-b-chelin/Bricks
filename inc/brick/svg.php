<?php
namespace MBC\inc\brick;
if(!defined('ABSPATH') || !defined('WP_CONTENT_DIR') || !defined('WP_CONTENT_URL')) exit;
class SVGJson extends brick {
	function __construct(){}
	public static function convert($file) {
		if(!$file) return;
		if(!file_exists($file)) return;
		$content = file_get_contents($file);
		if(!$content) return false;
		$svg = new \SimpleXMLElement( $content );
		$namespaces = $svg->getDocNamespaces();
		$svg->registerXPathNamespace('__nons', $namespaces['']);
		$svg = json_encode($svg);
		$svg = str_replace('@', '', $svg);
		return json_decode($svg);
	}
};