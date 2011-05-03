<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<feed xmlns="http://www.w3.org/2005/Atom">

  <title><?php echo $name; ?></title>
  <link href="<?php echo url_for($link, true); ?>"/>
  <updated></updated>
  <author>
    <name><?php echo $name; ?></name>
  </author>
 
  <?php if(count($list) > 0): ?>
    <?php use_helper('Date'); ?>
    <?php foreach($list as $row): ?>
      <?php $raw_row = $row->getRawValue(); ?>
      <entry>
        <title><?php echo $row['title']; ?></title>
        <link href="<?php echo url_for($raw_row['link'], true); ?>"/>
        <updated><?php echo format_date($row['pub_date'], 'r', 'en_US'); ?></updated>
        <summary><![CDATA[<?php echo $row['description']; ?>]]></summary>
      </entry>
    <?php endforeach; ?>
  <?php endif; ?>

</feed>