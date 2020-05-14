<?php
/**
 * WP-LDAP Search Result class to ease dealing with search results.
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package WordPress\Plugin\WP-LDAP
 */
namespace WP_LDAP;

/**
 * The result of an LDAP search.
 */
class LDAP_Search_Result implements \Countable, \Iterator {

    /**
     * The LDAP connection.
     *
     * @var resource|FALSE
     */
    private $ldap_link_id = false;

    /**
     * The search result resource.
     *
     * @var resource|FALSE|NULL
     */
    private $sr = null;

    /**
     * The current position in the result set.
     *
     * @var int
     */
    private $cursor = -1;

    /**
     * The resulting entry.
     *
     * @var resource
     */
    private $entry;

    /**
     * Constructor.
     *
     * @param resource $ldap_link_id
     * @param resource $sr Search result resource.
     */
    public function __construct ( $ldap_link_id, $sr ) {
        $this->ldap_link_id = $ldap_link_id;
        $this->sr = $sr;
    }

    /**
     * Gets the number of search result entries.
     *
     * @return int
     */
    public function count () {
        return ldap_count_entries( $this->ldap_link_id, $this->sr );
    }

    /**
     * Rewinds to the beginning of the result set.
     */
    public function rewind () {
        $this->cursor = 0;
        $this->entry = ldap_first_entry( $this->ldap_link_id, $this->sr );
    }

    /**
     * Advances the iterator to the next entry.
     */
    public function next () {
        $this->cursor++;
        $this->entry = ldap_next_entry( $this->ldap_link_id, $this->entry );
    }

    /**
     * Fetches the cursor position.
     *
     * @return int
     */
    public function key () {
        return $this->cursor;
    }

    /**
     * Fetches the data in the current entry.
     *
     * @TODO Would be nice if this was also an object, not a messy array.
     *
     * @return array
     */
    public function current () {
        return array(
            'dn' => ldap_get_dn( $this->ldap_link_id, $this->entry ),
            'data' => ldap_get_attributes( $this->ldap_link_id, $this->entry ),
        );
    }

    /**
     * Whether or not there are more results.
     *
     * @return bool
     */
    public function valid () {
        return $this->cursor < count( $this );
    }

}
