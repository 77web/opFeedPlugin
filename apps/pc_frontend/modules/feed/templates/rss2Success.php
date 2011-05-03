<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<rss version="2.0">
  <channel>
    <title><?php echo $name; ?></title>
    <description><![CDATA[<?php echo __('Recent updates of %name% in %sns%', array('%name%'=>$name, '%sns%'=>$op_config['sns_name'])); ?>]]></description>
    <link><?php echo url_for($link, true); ?></link>
    <?php if(count($list) > 0): ?>
      <?php use_helper('Date'); ?>
      <?php foreach($list as $row): ?>
        <?php $raw_row = $row->getRawValue(); ?>
        <item>
          <title><?php echo $row['title']; ?></title>
          <description><![CDATA[<?php echo $row['description']; ?>]]></description>
          <link><?php echo url_for($raw_row['link'], true); ?></link>
          <pubDate><?php echo format_date($row['pub_date'], 'r', 'en_US'); ?></pubDate>
        </item>
      <?php endforeach; ?>
    <?php endif; ?>
  </channel>
</rss>