<?php
/**
 * WP-LDAP uninstaller.
 *
 * @package plugin
 */

// Don't execute any uninstall code unless WordPress core requests it.
if (!defined('WP_UNINSTALL_PLUGIN')) { exit(); }

$options = array(
    'wp_ldap_bind_dn',
    'wp_ldap_bind_password',
    'wp_ldap_connect_uri',
    'wp_ldap_search_base_dn',
);
$networks = get_networks();

foreach ( $networks as $network ) {
    foreach( $options as $option ) {
        delete_network_option( $network->id, $option );
    }
}
