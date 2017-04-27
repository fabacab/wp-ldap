<?php
/**
 * Prints the form fields for the LDAP settings on the Network Settings admin screen.
 */
$default_search_base_dn = 'dc=' . str_replace( '.', ',dc=', parse_url( get_network_option( null, 'siteurl' ), PHP_URL_HOST ) );
?>
<h2><?php _e( 'LDAP Settings', 'wp-ldap' ); ?></h2>
<?php if ( is_ssl() ) { ?>
<table id="menu" class="form-table">
    <tr>
        <th scope="row"><?php _e( 'LDAP Connection URI' , 'wp-ldap' ); ?></th>
        <td>
            <input type="text" class="code large-text"
                name="wp_ldap_connect_uri"
                placeholder="ldaps://127.0.0.1:636/"
                value="<?php print esc_attr( get_network_option( null, self::prefix . 'connect_uri', 'ldaps://127.0.0.1:636/' ) ); ?>"
            />
            <span class="description">
                <?php esc_html_e( 'The address of your LDAP server. For security reasons, only the local host (IP address 127.0.0.1) is accepted here when TLS is not used by the server.', 'wp-ldap' ); ?>
            </span>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php _e( 'LDAP Bind DN' , 'wp-ldap' ); ?></th>
        <td>
            <input type="text" class="code large-text"
                name="wp_ldap_bind_dn"
                placeholder="cn=admin,dc=example,dc=com"
                value="<?php print esc_attr( get_network_option( null, self::prefix . 'bind_dn', 'cn=admin,dc=example,dc=com' ) ); ?>"
            />
            <span class="description">
                <?php esc_html_e( 'The user with which to make an authenticated binding.', 'wp-ldap' ); ?>
            </span>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php _e( 'LDAP Bind Password' , 'wp-ldap' ); ?></th>
        <td>
            <input type="password" class="code large-text"
                name="wp_ldap_bind_password"
                placeholder=""
                value="<?php print esc_attr( get_network_option( null, self::prefix . 'bind_password', '' ) ); ?>"
            />
            <span class="description">
                <?php esc_html_e( 'The password to use when performing authenticated binding.', 'wp-ldap' ); ?>
            </span>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php _e( 'LDAP Search Base DN' , 'wp-ldap' ); ?></th>
        <td>
            <input type="text" class="code large-text"
                name="wp_ldap_search_base_dn"
                placeholder="<?php print esc_attr( $default_search_base_dn ); ?>"
                value="<?php print esc_attr( get_network_option( null, self::prefix . 'search_base_dn', $default_search_base_dn ) ); ?>"
            />
            <span class="description">
                <?php esc_html_e( 'The search base to use when performing an LDAP search.', 'wp-ldap' ); ?>
            </span>
        </td>
    </tr>
</table>
<?php } else { ?>
<p class="notice error" style="border-left: 4px solid red; padding: 6px 12px;">
    <?php esc_html_e( 'For security reasons, the LDAP network settings are not displayed and cannot be changed when this page is loaded over an unsecured connection.', 'wp-ldap' ); ?>
</p>
<?php } ?>
