# Dismiss Privacy Tools
Dismiss Privacy Tools added in WordPress 4.9.6 (completely) when it is activated, or if it is in mu-plugins directory.

Features:

 * Disable Privacy Tool /wp-admin/privacy.php
 * Disable Erase Personal Data /wp-admin/tools.php?page=erase_personal_data
 * Disable Export Personal Data /wp-admin/tools.php?page=export_personal_data
 * Dismiss pointer for the new privacy tools.
 * Remove scheduled action used to delete old export files.
 * Remove scheduled event used to delete old export files.
 * Remove scheduled hook used to delete old export files.
 * Short circuits the option for the privacy policy page to always return 0 to avoid unneeded database query.
 * Delete unneeded database options.
 * Reset all options to default.

Why this Plugin?

Simply because it is different from the others that perform the same function: it can be considered advanced because clean the database from all orphan options and reset everything to default values.
