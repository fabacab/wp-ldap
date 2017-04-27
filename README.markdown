# WP-LDAP

[![Download WP-LDAP from WordPress.org](https://img.shields.io/wordpress/plugin/dt/wp-ldap.svg)](https://wordpress.org/plugins/wp-ldap/) [![Current release at WordPress.org](https://img.shields.io/wordpress/plugin/v/wp-ldap.svg)](https://wordpress.org/plugins/wp-ldap/) [![Required WordPress version](https://img.shields.io/wordpress/v/wp-ldap.svg)](https://wordpress.org/plugins/wp-ldap/developers/) [![WP-LDAP is licensed GPL-3.0](https://img.shields.io/github/license/meitar/wp-ldap.svg)](https://www.gnu.org/licenses/quick-guide-gplv3.en.html)

WP-LDAP is a feature-rich LDAPv3 connector for WordPress that turns your WordPress Multisite Network into a front-end for managing an LDAP Directory Information Tree (DIT). It automates the process of managing user account information to support single sign-on ("SSO"), identity management, and other enterprise functions through the familiar WordPress Network Admin Dashboard screens.

All user accounts on the WordPress side are mirrored as [`inetOrgPerson` (RFC 2798)](https://www.ietf.org/rfc/rfc2798.txt) entries on the LDAP side. The following WordPress user account fields to LDAP attribute translations take place when a new WordPress user is created:

* The WordPress `user_login` field becomes the `uid` attribute in the LDAP database.
* The WordPress `user_email` field becomes the `mail` attribute in the LDAP database.
* The WordPress `display_name` field becomes the `displayName` attribute in the LDAP database.
* The WordPress `user_pass` field becomes the `userPassword` attribute in the LDAP database.

There is no mapping for the WordPress user ID number on the LDAP side. Instead, users are uniquely identified by their fully-qualified Distinguished Name (DN). A user's DN is automatically composed by combining their WordPress `user_login` with the WordPress Multisite's configured LDAP Search Base setting. For instance, by default, a WordPress Multisite with WP-LDAP installed running at `https://example.com/` with a user whose username is `exampleuser` will automatically be mirrored over LDAP to the user identified as `uid=exampleuser,dc=example,dc=com`.

In addition to the above mappings, the following optional mappings also take place if or when the user updates their user profile:

* The WordPress `user_url` field becomes the `labeledURI` attribute in the LDAP database.
* The WordPress `first_name` field becomes the `givenName` attribute in the LDAP database.
* The WordPress `description` field becomes the `description` attribute in the LDAP database.
* The WordPress user's avatar becomes the `jpegPhoto` attribute in the LDAP database. (Not yet implemented.)

This plugin is designed for medium to large deployments of WordPress Multisite (or Multi-Network) instances, originally developed as a collaboration with the [Glocal Coop's Activist Network Platform](https://glocal.coop/activist-network-platform/) project. If you run multiple WordPress Multisite Networks, you can configure each WP Network with different LDAP settings. This plugin does not currently support single-site installs; please [post an issue on GitHub](https://github.com/meitar/wp-ldap/issues) if you want to use LDAP data stores with a WP single-site install and we can discuss use cases.

# Developing

The easiest way to develop is to use [VVV's Custom Site Template](https://github.com/Varying-Vagrant-Vagrants/custom-site-template) setup. Once that's installed and you have a running WP Multisite, perform the following additional commands:

```sh
vagrant ssh                       # Enter the Vagrant VM.
sudo apt install slapd ldap-utils # Install OpenLDAP's stand-alone LDAP daemon and helper utilities.
# sudo dpkg-reconfigure slapd     # Reconfigure the daemon, if for some reason this wasn't initiated during install.
```
