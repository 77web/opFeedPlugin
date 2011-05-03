<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('pc_frontend', 'test', true);
new sfDatabaseManager($configuration);

$t = new lime_test(4, new lime_output_color());

$t->diag("let's test opFeedPluginFeedGenerator...");

$t->diag('test for member feed');

$diary = Doctrine::getTable('Diary')->createQuery()->orderBy('id')->fetchOne();
opFeedPluginFeedGenerator::addItem($diary);

$diary2 = Doctrine::getTable('Diary')->createQuery()->orderBy('id DESC')->fetchOne();
opFeedPluginFeedGenerator::addItem($diary2);

$list1 = opFeedPluginFeedGenerator::getItems(1);
$t->is(count($list1), 1, 'if size argument = 1, getItems() will return array at size 1');

$list2 = opFeedPluginFeedGenerator::getItems(2);
$t->is(count($list2), 2, 'if size argument = 2, getItems() will return array at size 2(in member feed)');


$t->diag('refresh items');
opFeedPluginFeedGenerator::resetItems();
$list3 = opFeedPluginFeedGenerator::getItems(10);
$t->ok(count($list3)==0, 'after resetItems() called, items will be empty');


$t->diag('test for community feed');

$topic = Doctrine::getTable('CommunityTopic')->createQuery()->fetchOne();
opFeedPluginFeedGenerator::addItem($topic);

$event = Doctrine::getTable('CommunityEvent')->createQuery()->fetchOne();
opFeedPluginFeedGenerator::addItem($event);

$list4 = opFeedPluginFeedGenerator::getItems(2);
$t->is(count($list4), 2, 'if size argument = 2, getItems() will return array at size 2(in community feed)');



