<?php
/**
 * WP-LDAP API class to interface with an LDAP server.
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
     * @param string $bind_rdn
     * @param string $bind_password
     *
     * @throws Exception
     */
    function __construct ( $connect_uri, $bind_rdn = '', $bind_password = '' ) {
        if (!function_exists('ldap_connect')) {
            throw new Exception('PHP does not have LDAP support?');
        }

        $this->connect_uri = $connect_uri;
        $this->bind_rdn = $bind_rdn;
        $this->bind_password = $bind_password;
    }

    /**
     * Sets (or resets) the base DN.
     *
     * @param string $dn
     */
    public function setBaseDN ( $dn ) {
        $this->base_dn = $dn;
    }

    /**
     * Sets up an LDAP connection to a server.
     *
     * @return resource|FALSE
     */
    private function connect () {
        if (false === $this->ldap_link_id) {
            $c = ldap_connect($this->connect_uri);
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
        return ldap_bind($this->ldap_link_id, $this->bind_rdn, $this->bind_password);
    }

    /**
     * Escapes a string intended for an LDAP search filter.
     *
     * @param string $str
     * 
     * @return string
     */
    public function escape_filter ( $str ) {
        return ldap_escape( $str, null, LDAP_ESCAPE_FILTER );
    }

    /**
     * Escapes a string intended for an LDAP distinguished name.
     *
     * @param string $str
     *
     * @return string
     */
    public function escape_dn ( $str ) {
        return ldap_escape( $str, null, LDAP_ESCAPE_DN );
    }

    /**
     * Performs an LDAP search.
     *
     * @var string $filter
     * @var array $attrs
     *
     * @return \WP_LDAP\API
     */
    public function search ($filter = 'objectClass=*', $attrs = array('uid', 'mail', 'labeledURI', 'displayName')) {
        $r = ldap_search(
            $this->ldap_link_id,
            $this->base_dn,
            $filter,
            $attrs
        );
        // TODO: Implement a "search result" class as a PHP iterator for ease of use.
        return $r;
    }

    /**
     * @param resource $sr Search result resource.
     *
     * @return int
     */
    public function count_entries ( $sr ) {
        return ldap_count_entries( $this->ldap_link_id, $sr );
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
     * Kills the connection to the server.
     *
     * Subsequent connections need to re-connect.
     */
    public function disconnect () {
        return ldap_close($this->ldap_link_id);
    }

}
