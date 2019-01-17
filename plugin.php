<?php
/**
Plugin Name: Share to Shaarli
Plugin URI: https://github.com/miwasp/yourls-shaarli
Description: Add <a href="https://github.com/sebsauvage/Shaarli/">Shaarli</a> to the list of Quick Share destinations
Version: 1.0
Author: Michael Winkler
Author URI: https://github.com/miwasp
**/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

yourls_add_action( 'share_links', 'jr_yourls_shaarli' );

function jr_yourls_shaarli( $args ) {
	list( $longurl, $shorturl, $title, $text ) = $args;
	$longurl = rawurlencode( $longurl );
	if ( defined('SHAARLI_URL') ) {
		$shaarli_url = SHAARLI_URL;
    		// Plugin URL (no URL is hardcoded)
    		$pluginurl = YOURLS_PLUGINURL . '/'.yourls_plugin_basename( dirname(__FILE__) );
    		$icon = $pluginurl.'/shaarli.png';
		echo <<<SHAARLI
		<style type="text/css">
		#share_shaarli{background: transparent url("$icon") left center no-repeat;}
		</style>
		
		<a id="share_shaarli"
			href="$shaarli_url/index.php?post=$longurl&amp;title=$title&amp;source=bookmarklet"
			title="Share to Shaarli"
			onclick="yourls_share_on_shaarli();return false;">Shaarli
		</a>
		
		<script type="text/javascript">
		// Send to Shaarli open window
		function yourls_share_on_shaarli() {
			var url = $('#share_shaarli').attr('href');
			window.open(url, 'shaarli', 'toolbar=no,width=800,height=600');
			return false;
		}
		// Dynamically update shaarli link
		// when user clicks on the "Share" Action icon, event $('#tweet_body').keypress() is fired, so we'll add to this
		$('#tweet_body').keypress(function(){
			var title = encodeURIComponent( $('#titlelink').val() );
			var url = encodeURIComponent( $('#copylink').val() );
			var shaarli = '$shaarli_url/index.php?post='+url+'&title='+title+'&source=bookmarklet';
			$('#share_shaarli').attr('href', shaarli);		
		});
		</script>

SHAARLI;
	}
}
