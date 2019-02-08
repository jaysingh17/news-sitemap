<?php
/* Auto Sitemap for google */
add_action("init","googlesitemap");
function googlesitemap() {
 $posts = get_posts( array(
     'numberposts' => 2,
     'post_type'   => array('post'),
     'order'       => 'DESC'
 		) );
 header('Content-Type: text/xml; charset=' . get_bloginfo('charset'), true);
 header('X-Robots-Tag: index, follow', true);
 $sitemap .= '<?xml version="1.0" encoding="UTF-8"?>
 <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
';
foreach( $posts as $post ) {
	$posttitle=$post->post_title;
	$postmetatitle=get_post_meta($post->ID, "meta_title", true);
	$keyword=get_post_meta($post->ID, 'meta_keywords', true);
	$date=$post->post_date;
   setup_postdata( $post);
   $postdate = explode( " ", $post->post_modified );
   $sitemap .= '<url>
   <loc>' . get_permalink( $post->ID ) . '</loc>
   <news:news>
   <news:publication>
    <news:name>' .$posttitle.'</news:name>
    <news:language>en</news:language>
   </news:publication>
   <news:genres>Blog</news:genres>
   <news:publication_date>'. get_the_time('Y-m-d', $post->ID) .'</news:publication_date>
   <news:title>'.$postmetatitle.'</news:title>
   <news:keywords>'.$keyword.'</news:keywords>
  </news:news>
   </url>';
 }
 $sitemap .= '</urlset>';

 $fop = fopen(ABSPATH."news-sitemap.xml",'w');
 fwrite($fop,$sitemap );
 fclose( $fop );
}
?>    
