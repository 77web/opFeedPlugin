<?php

class opFeedPluginFeedGenerator
{
  public static $items = array();
  
  public static function getItems($size)
  {
    krsort(self::$items);
    $items = array_slice(self::$items, 0, $size);
    
    return $items;
  }
  
  public static function addItem($object)
  {
    $row = array();
    $row['title'] = (string)$object;
    $row['description'] = $object->getBody();
    $row['link'] = self::generateLink($object);
    $row['pub_date'] = $object->getUpdatedAt();
    
    $key = strtotime($row['pub_date']).'_'.$object->getId().'_'.get_class($object);
    
    self::$items[$key] = $row;
  }
  
  protected static function generateLink($object)
  {
    $link = '';
    switch(get_class($object))
    {
      case 'Diary':
        $link = 'diary/show';
        break;
      case 'Album':
        $link = 'album/show';
        break;
      case 'CommunityTopic':
        $link = 'communityTopic/show';
        break;
      case 'CommunityEvent':
        $link = 'communityEvent/show';
        break;
    }
    $link .= '?id='.$object->getId();
    return $link;
  }
  
  public static function resetItems()
  {
    self::$items = array();
  }
}