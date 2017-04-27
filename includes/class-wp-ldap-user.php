<?php
/**
 * WP-LDAP User class maps a WordPress user account to an LDAP entry.
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @copyright Copyright (c) 2017 by Meitar Moscovitz
 *
 * @package WordPress\Plugin\WP-LDAP
 */
namespace WP_LDAP;

/**
 * Class to translate a WordPress user to an LDAP user, etc.
 */
class User {

    /**
     * A reference to the WordPress user.
     *
     * @var WP_User
     */
    private $wp_user;

    /**
     * Setter.
     */
    public function setWordPressUser ( $wp_user ) {
        $this->wp_user = $wp_user;
    }

    /**
     * Retrieves the unique Distinguished Name of the user.
     *
     * @param string $base_dn
     *
     * @return string|FALSE
     */
    public function getEntityDN ( $base_dn = '' ) {
        if ( ! $this->wp_user ) {
            return false;
        }
        $dn = 'uid=' . $this->wp_user->data->user_login;
        $dn .= ( ! empty( $base_dn ) ) ? ",$base_dn" : $base_dn;
        return $dn;
    }

    /**
     * Maps a WordPress User object to an LDAP entity.
     *
     * @return array
     */
    public function wp2entity () {
        $wp_user = $this->wp_user;

        $entry = array(
            // LDAP attribute => WP_User field
            'objectClass' => 'inetOrgPerson', // TODO: Variablize this?
            'cn' => $wp_user->data->user_login,
            'sn' => $wp_user->data->user_login,
            'uid' => $wp_user->data->user_login,
            'mail' => $wp_user->data->user_email,
            'displayName' => $wp_user->data->display_name,
        );

        if ( ! empty( $wp_user->data->user_url ) ) {
            $entry['labeledURI'] = $wp_user->data->user_url;
        }

        if ( ! empty( $wp_user->data->description ) ) {
            $entry['description'] = $wp_user->data->description;
        }

        if ( ! empty( $wp_user->data->first_name ) ) {
            $entry['givenName'] = $wp_user->data->first_name;
        }

        return $entry;
    }

}
