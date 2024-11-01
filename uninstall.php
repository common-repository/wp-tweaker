<?php
if ( !defined ('WP_UNINSTALL_PLUGIN'))
{
  exit;
}
if( false != get_option('wptweaker_settings'))
{
  delete_option('wptweaker_settings');
}
?>
