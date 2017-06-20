<?php
/**
 * Test cases for the WP_LDAP::API class.
 */

use WP_LDAP\API;

/**
 * @covers API
 */
final class APITest extends Plugin_UnitTestCase {

    /**
     * Tests the API::hashPassword implementation against the
     * output of using OpenLDAP's `slappasswd(8)` to create a
     * password for the same purpose.
     *
     * Refer to RFC 2307 § 5.3 for implementation details.
     *
     * This raises a test failure if our password hashing
     * implementation differs in any way from OpenLDAP's.
     *
     * @link http://www.faqs.org/rfcs/rfc2307.html
     */
    public function testCreateRfc2307UserPassword () {
        $plain = 'password';
        $cmd = "slappasswd -h {SSHA} -s $plain";
        $userPassword = trim( shell_exec( escapeshellcmd( $cmd ) ) );
        $saltedhash = base64_decode( substr( $userPassword, 6 ) );
        $salt = substr( $saltedhash, -4 );

        $this->assertSame(
            $userPassword,
            API::hashPassword( $plain, $salt )
        );
    }

    /**
     * Tests to ensure that various special characters in an
     * LDAP DN are sanitized correctly.
     */
    public function testCanSanitizeDN () {
        $arr = array(
            // Input DN => Sanitized DN
            'employeeNumber=2+uid=someuser,dc=example,dc=com' => 'employeeNumber=2+uid=someuser,dc=example,dc=com',
            'somekey=with spaces' => 'somekey=with spaces',
            'somekey=withequals=init' => 'somekey=withequals\5c3Dinit',
        );
        foreach ( $arr as $dn => $cleaned ) {
            $this->assertSame(
                $cleaned,
                API::sanitize_dn( $dn )
            );
        }
    }

}
