<?php
/*
Plugin Name: Shifter GitHub hosting plugin sample
Plugin URI: https://github.com/getshifter/shifter-github-hosting-plugin-sample/
Description: Shifter GitHub hosting plugin sample
Author: Shifter Team
Version: 2.1
Author URI: https://getshifter.io/
*/
require __DIR__ . '/vendor/autoload.php';

add_action( 'admin_notices', function() {
    // get Shifter News
    $transient_key = 'shifter-news-posts';
    if (false === ($posts = get_transient($transient_key))) {
        $url = 'https://www.getshifter.io/feed/';
        $res = YuzuruS\Rss\Feed::load($url);
    
        $posts = [];
        foreach ($res['item'] as $r) {
            $posts[] = sprintf(
                '<a href="%s" title="%s">%s</a>',
                esc_url_raw($r['link']),
                esc_attr($r['title']),
                $r['title']
            );
        }
        set_transient($transient_key, $posts, HOUR_IN_SECONDS);
    }
    $shifter_news = $posts[ mt_rand( 0, count( $posts ) - 1 ) ];

    printf(
        '<p id="shifter"><span dir="ltr" lang="en">%s</span></p>',
        $shifter_news
    );
});

add_action( 'admin_head', function() {
    echo "
	<style type='text/css'>
	#shifter {
		float: right;
		padding: 5px 10px;
		margin: 0;
		font-size: 12px;
		line-height: 1.6666;
	}
	.rtl #shifter {
		float: left;
	}
	.block-editor-page #shifter {
		display: none;
	}
	@media screen and (max-width: 782px) {
		#shifter,
		.rtl #shifter {
			float: none;
			padding-left: 0;
			padding-right: 0;
		}
	}
	</style>
	";
});
