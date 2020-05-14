# WP-LDAP

[![Download WP-LDAP from WordPress.org](https://img.shields.io/wordpress/plugin/dt/wp-ldap.svg)](https://wordpress.org/plugins/wp-ldap/)
[![Current release at WordPress.org](https://img.shields.io/wordpress/plugin/v/wp-ldap.svg)](https://wordpress.org/plugins/wp-ldap/)
[![Required WordPress version](https://img.shields.io/wordpress/v/wp-ldap.svg)](https://wordpress.org/plugins/wp-ldap/developers/)
[![WP-LDAP is licensed GPL-3.0](https://img.shields.io/github/license/fabacab/wp-ldap.svg)](https://www.gnu.org/licenses/quick-guide-gplv3.en.html)
[![Build status](https://travis-ci.org/fabacab/wp-ldap.svg?branch=develop)](https://travis-ci.org/fabacab/wp-ldap)

WP-LDAP is a feature-rich LDAPv3 connector for WordPress that turns your WordPress Multisite Network into a front-end for managing an LDAP Directory Information Tree (DIT). It automates the process of managing user account information to support single sign-on ("SSO"), identity management, and other enterprise functions through the familiar WordPress Network Admin Dashboard screens.

See the [`readme.txt`](readme.txt) file for a longer description.

This plugin is designed for medium to large deployments of WordPress Multisite (or Multi-Network) instances, originally developed as a collaboration with the [Glocal Coop's Activist Network Platform](https://glocal.coop/activist-network-platform/) project. If you run multiple WordPress Multisite Networks, you can configure each WP Network with different LDAP settings. This plugin does not currently support single-site installs; please [post an issue on GitHub](https://github.com/fabacab/wp-ldap/issues) if you want to use LDAP data stores with a WP single-site install and we can discuss use cases.

# Developing

The easiest way to develop is to use [VVV's Custom Site Template](https://github.com/Varying-Vagrant-Vagrants/custom-site-template) setup. Once that's installed and you have a running WP Multisite, perform the following additional commands:

```sh
vagrant ssh                          # Enter the Vagrant VM.
sudo apt install -y php-ldap         # Install the PHP LDAP extension for your default PHP version.
sudo apt install -y slapd ldap-utils # Install OpenLDAP's stand-alone LDAP daemon and helper utilities.
# sudo dpkg-reconfigure slapd        # Reconfigure to add a basic DIT, if not automatically triggered.
```

Please see the project [wiki](https://github.com/fabacab/wp-ldap/wiki) for additional information.
