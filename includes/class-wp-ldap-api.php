<?php
/**
 * WP-LDAP API class to interface with an LDAP server.
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @copyright Copyright (c) 2017 by Meitar Moscovitz
 *
 * @package WordPress\Plugin\WP-LDAP
 */
namespace WP_LDAP;

class API {

    /**
     * The LDAP connection's link identifier.
     *
     * @var resource|FALSE
     */
    private $ldap_link_id = false;

    /**
     * The search base as a distinguished name.
     *
     * @var string
     */
    private $base_dn = '';

    /**
     * Constructor.
     *
     * @param string $connect_uri
     * @param string $bind_dn
     * @param string $bind_password
     *
     * @throws Exception
     */
    public function __construct ( $connect_uri, $bind_dn = '', $bind_password = '' ) {
        if ( ! function_exists( 'ldap_connect' ) ) {
            throw new Exception( 'PHP does not have LDAP support?' );
        }

        $this->connect_uri = filter_var( $connect_uri, FILTER_SANITIZE_URL );
        $this->bind_dn = self::sanitize_dn( $bind_dn );
        $this->bind_password = $bind_password;
    }

    /**
     * Sets (or resets) the base DN.
     *
     * @param string $dn
     */
    public function setBaseDN ( $dn ) {
        $this->base_dn = self::sanitize_dn( $dn );
    }

    /**
     * Sets up an LDAP connection to a server.
     *
     * @return resource|FALSE
     */
    private function connect () {
        if (false === $this->ldap_link_id) {
            $c = ldap_connect( filter_var( $this->connect_uri, FILTER_SANITIZE_URL ) );
            ldap_set_option($c, LDAP_OPT_PROTOCOL_VERSION, 3);
            $this->ldap_link_id = $c;
        }
        return $this->ldap_link_id;
    }

    /**
     * Authenticates to the LDAP server with the given binding.
     *
     * @return bool
     */
    public function bind () {
        $this->connect();
        return ldap_bind(
            $this->ldap_link_id,
            self::sanitize_dn( $this->bind_dn ),
            $this->bind_password
        );
    }

    /**
     * Escapes a string intended for an LDAP search filter.
     *
     * @param string $str
     * 
     * @return string
     */
    static public function escape_filter ( $str ) {
        return ldap_escape( $str, null, LDAP_ESCAPE_FILTER );
    }

    /**
     * Escapes a string intended for an LDAP distinguished name.
     *
     * @param string $str
     *
     * @return string
     */
    static public function escape_dn ( $str ) {
        return ldap_escape( $str, null, LDAP_ESCAPE_DN );
    }

    /**
     * Sanitizes each RDN component in a complete DN string.
     *
     * @param string $dn
     *
     * @return string
     */
    static public function sanitize_dn( $dn ) {
        $parts = ldap_explode_dn( $dn, 0 );
        $count = array_shift( $parts );
        $clean = array();
        foreach ( $parts as $rdn ) {
            $clean[] = implode( '=', array_map( array( __CLASS__, 'escape_dn' ), explode( '=', $rdn ) ) );
        }
        return implode( ',', $clean );
    }

    /**
     * Performs an LDAP search.
     *
     * @var string $filter
     * @var array $attrs
     *
     * @return \WP_LDAP\LDAP_Search_Result
     */
    public function search ($filter = 'objectClass=*', $attrs = array('uid', 'mail', 'labeledURI', 'displayName')) {
        $sr = ldap_search(
            $this->ldap_link_id,
            $this->base_dn,
            $filter,
            $attrs
        );
        return new LDAP_Search_Result( $this->ldap_link_id, $sr );
    }

    /**
     * Creates an entry in the LDAP DIT.
     *
     * @param string $dn
     * @param array $entry
     *
     * @return bool
     */
    public function add ( $dn, $entry ) {
        return ldap_add(
            $this->ldap_link_id,
            $dn,
            $entry
        );
    }

    /**
     * Modifies an entry in the LDAP DIT.
     *
     * @param string $dn
     * @param array $entry
     *
     * @return bool
     */
    public function modify ( $dn, $entry ) {
        return ldap_modify(
            $this->ldap_link_id,
            $dn,
            $entry
        );
    }

    /**
     * Kills the connection to the server.
     *
     * Subsequent connections need to re-connect.
     *
     * @return bool
     */
    public function disconnect () {
        return ldap_close( $this->ldap_link_id );
    }

}
