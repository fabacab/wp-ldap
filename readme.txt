=== WP-LDAP ===
Contributors: meitar
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=TJLPJYXHSRBEE&lc=US&item_name=WP-LDAP&item_number=WP-LDAP&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted
Tags: multisite, ldap, users, administration
Requires at least: 4.6
Tested up to: 4.7.4
Stable tag: 0.1
License: GPL-3.0
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Translates the WordPress user database to an LDAP store of the same; manage your LDAP DIT using your WordPress Dashboard.

== Description ==

This plugin turns your WordPress Dashboard into a familiar management interface for an enterprise-scale LDAP Directory Information Tree. Configure a connection to your LDAPv3 directory server, and from then on any modifications you make to your WordPress user database through the WordPress admin screens will be reflected in your LDAP database. This offers a simpler and more convenient front-end for managing user account information.

All user accounts on the WordPress side are mirrored as `inetOrgPerson` entries on the LDAP side. The following WordPress user account fields to LDAP attribute translations take place:

* The WordPress `user_login` field becomes the `uid` attribute in the LDAP database.
* The WordPress `user_email` field becomes the `mail` attribute in the LDAP database.
* The WordPress `user_url` field becomes the `labeledURI` attribute in the LDAP database.
* The WordPress `display_name` field becomes the `displayName` attribute in the LDAP database.

This plugin was designed for medium to large deployments of WordPress Multisite (or Multi-Network) instances. It does not currently support single-site installs.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php do_action('plugin_name_hook'); ?>` in your templates

= Requirements =

The PHP LDAP extension must be installed. On a Debian system, this is usually as simple as running `sudo apt install php-ldap`.

== Changelog ==

= 0.1 =
* First prototype.
