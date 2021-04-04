<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<rss version="2.0"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
     xmlns:admin="http://webns.net/mvcb/"
     xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
     xmlns:content="http://purl.org/rss/1.0/modules/content/">
<channel>
	<title><?php echo xml_convert($feed_name); ?></title>
	<link><?php echo $feed_url; ?></link>
	<description><?php echo convert_to_xml_character(xml_convert($page_description)); ?></description>
	<dc:language><?php echo $page_language; ?></dc:language>
	<dc:creator><?php echo $creator_email; ?></dc:creator>
	<dc:rights><?php echo convert_to_xml_character(xml_convert($settings->copyright)); ?></dc:rights>
<?php foreach ($posts as $post): ?>
<item>
<title><?php echo convert_to_xml_character(xml_convert($post->title)); ?></title>
<link><?php echo generate_post_url($post); ?></link>
<guid><?php echo generate_post_url($post); ?></guid>
<description><![CDATA[ <?php echo $post->summary; ?> ]]></description>
<?php
if (!empty($post->image_url)):
$image_path = str_replace('https://', 'http://', $post->image_url); ?>
<enclosure url="<?php echo $image_path; ?>" length="49398" type="image/jpeg"/>
<?php else:
$image_path = base_url() . $post->image_mid;
if (!empty($image_path)) {
$file_size = @filesize(FCPATH . $post->image_mid);
}
$image_path = str_replace('https://', 'http://', $image_path);
if (!empty($image_path)):?>
<enclosure url="<?php echo $image_path; ?>" length="<?php echo (isset($file_size)) ? $file_size : '12'; ?>" type="image/jpeg"/>
<?php endif;
endif; ?>
<pubDate><?php echo date('r', strtotime($post->created_at)); ?></pubDate>
<dc:creator><?php echo convert_to_xml_character($post->username); ?></dc:creator>
</item>
<?php endforeach; ?>

</channel>
</rss>
