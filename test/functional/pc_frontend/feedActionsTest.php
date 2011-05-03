<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$browser = new opTestFunctional(new sfBrowser(), new lime_test(null, new lime_output_color()));


$browser
  ->info('member feed routing test')
  ->get('/member/1/feed')
  ->with('request')->begin()
    ->isParameter('module', 'feed')
    ->isParameter('action', 'member')
  ->end();

$browser
  ->info('community feed routing test')
  ->get('/community/1/feed')
  ->with('request')->begin()
    ->isParameter('module', 'feed')
    ->isParameter('action', 'community')
  ->end();

