<?php
/**
 * Craft GeoLite plugin for Craft CMS 3.x
 *
 * Fetches location based on IP from the GeoIP2 Lite database
 *
 * @link      https://github.com/HaiekTech
 * @copyright Copyright (c) 2019 HAIEK
 */

namespace haiek\craftgeolite\twigextensions;

use haiek\craftgeolite\CraftGeolite;
use GeoIp2\Database\Reader;

use Craft;

/**
 * Twig can be extended in many ways; you can add extra tags, filters, tests, operators,
 * global variables, and functions. You can even extend the parser itself with
 * node visitors.
 *
 * http://twig.sensiolabs.org/doc/advanced.html
 *
 * @author    HAIEK
 * @package   CraftGeolite
 * @since     0.0.1
 */
class CraftGeoliteTwigExtension extends \Twig_Extension
{
    // Public Methods
    // =========================================================================

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'CraftGeolite';
    }

    /**
     * Returns an array of Twig filters, used in Twig templates via:
     *
     *      {{ 'something' | someFilter }}
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('getLocationFromIp', [$this, 'getLocationFromIpInternal']),
        ];
    }

    /**
     * Returns an array of Twig functions, used in Twig templates via:
     *
     *      {% set this = someFunction('something') %}
     *
    * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('getLocationFromIp', [$this, 'getLocationFromIpInternal']),
        ];
    }

    /**
     * getLocationFromIpInternal
     *
     * @param string $ip
     *
     * @return object GeoIP2 Object
     */
    public function getLocationFromIpInternal($ip = null)
    {
        $the_ip = ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
        $reader = new Reader(dirname(__DIR__).'/geolite2-country.mmdb');

        try {
            $record = $reader->country($the_ip);
            return $record;
        }
        catch(\Exception $e){
            return null;
        }
        
        return null;
    }
}
