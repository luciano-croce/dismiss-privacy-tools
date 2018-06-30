# Dismiss Privacy Tools
Dismiss Privacy Tools added in WordPress 4.9.6 (completely) when it is activated, or if it is in mu-plugins directory.

Features:

 * Disable Privacy Tool /wp-admin/privacy.php
 * Disable Erase Personal Data /wp-admin/tools.php?page=erase_personal_data
 * Disable Export Personal Data /wp-admin/tools.php?page=export_personal_data
 * Dismiss pointer for the new privacy tools.
 * Remove scheduled event used to delete old export files.
 * Remove scheduled hook used to delete old export files.
 * Short circuits the option for the privacy policy page to always return 0 to avoid unneeded database query.
 * Delete unneeded database options.
 * Reset all options to default.
