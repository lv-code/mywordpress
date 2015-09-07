=== Disable User Gravatar ===
Contributors: netweblogic
Tags: activity stream, wordpress, wordpress mu, wpmu, BuddyPress, wire, activity
Requires at least: 2.7
Tested up to: 2.8.6
Stable tag: 1.0

Stops wordpress from grabbing a user avatar using their registration email.

== Description ==

This is a simple plugin that changes the email used to access a user's gravatar so that their registered email avatar is not used. This would be useful for sites where users require an extra layer of privacy.

The email used to access the gravatar is changed to the format of "member.%USER%@mydomain.com" which is customizable directly in the plugin file.

If you have any problems with the plugins, please visit our [support forums](http://netweblogic.com/forums/) for further information and provide some feedback first, we may be able to help. It's considered rude to just give low ratings and no reason for doing so.

If you find this plugin useful and would like to say thanks, a link, digg, or some other form of recognition to the plugin page on our blog would be appreciated.

== Installation ==

=== As a normal WP Plugin ===

1. Upload this plugin to the `/wp-content/plugins/` directory and unzip it, or simply upload the zip file within your wordpress installation.

2. Activate the plugin through the 'Plugins' menu in WordPress

=== As a wpmu plugin ===

1. Unzip the plugin file and move the contents of the extracted folder to `/wp-content/mu-plugins/`. That's it!