<?php
/**
 * WP Fragment Cache Framework
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-2.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@mindsize.me so we can send you a copy immediately.
 *
 * @package   Mindsize/WP_Fragment_Cache
 * @author    Mindsize
 * @copyright Copyright (c) 2017, Mindsize, LLC.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2.0
 */

if( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * If the class already exists, no need to redeclare it.
 */
if( class_exists( 'WP_Fragment_Cache' ) ) {
	return;
}

/**
 * Class WP_Fragment_Cache
 *
 * @since 1.0.0
 */
class WP_Fragment_Object_Cache extends WP_Fragment_Cache {

	/**
	 * The slug of the fragment cache prefixes all hooks and is sanitized to create the default cache directory.
	 *
	 * @var string
	 */
    protected $slug = 'wp-fragment-object-cache';
    protected $group = 'wp-fragment-object-cache';
    protected $expire = MONTH_IN_SECONDS;

	/**
	 * Abstracted method for classes to override and store their data.
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	protected function set_cache_data( $output, $conditions ) {
        $key = $this->get_key( $conditions );
        return wp_cache_set( $key, $output, $this->group, $this->expire );
    }

	/**
	 * Abstracted method for classes to override and get their data.
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	protected function get_cache_data( $conditions ) {
        $key = $this->get_key( $conditions );
        return wp_cache_get( $key, $this->group );
    }

	/**
	 * Abstracted method for classes to override and clear their cache
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	public function clear_cache() {
        wp_cache_delete_group( $this->group );
    }

    protected function get_key( $conditions ) {
        array_multisort( $conditions );

        return md5( json_encode( $conditions ) );
    }
}