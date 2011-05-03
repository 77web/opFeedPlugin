<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * feed actions.
 *
 * @package    opFeedPlugin
 * @subpackage feed
 * @author     Hiromi Hishida<info@77-web.com
 * @version    0.9.0
 */
class feedActions extends sfActions
{
  public function preExecute()
  {
    $this->output = sfConfig::get('app_feed_output', 'rss2');
    $this->size = sfConfig::get('app_feed_items', 30);
    
    $contentType = $this->output=='atom'?'application/atom+xml':'application/rss+xml';
    $this->getResponse()->setContentType($contentType);
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward404();
  }
  
  public function executeMember(sfWebRequest $request)
  {
    $this->forward404Unless(sfConfig::get('app_feed_member', true));
    
    $this->member = $this->getRoute()->getObject();
    
    $list = array();
    if(opPlugin::getInstance('opDiaryPlugin')->getIsActive())
    {
      foreach(Doctrine::getTable('Diary')->getMemberDiaryList($this->member->getId(), $this->size) as $diary)
      {
        opFeedPluginFeedGenerator::addItem($diary);
      }
    }
    
    if(opPlugin::getInstance('opAlbumPlugin')->getIsActive())
    {
      foreach(Doctrine::getTable('Album')->getMemberAlbumList($this->member->getId(), $this->size) as $album)
      {
        opFeedPluginFeedGenerator::addItem($album);
      }
    }

    $this->list = opFeedPluginFeedGenerator::getItems($this->size);
    $this->name = $this->member->getName();
    $this->link = 'member/profile?id='.$this->member->getId();
    $this->setTemplate($this->output);
  }
  
  public function executeCommunity(sfWebRequest $request)
  {
    $this->forward404Unless(sfConfig::get('app_feed_community', true));
    
    
    $this->community = $this->getRoute()->getObject();
    $this->forward404If('auth_commu_member' == $this->community->getConfig('public_flag'));
    
    $list = array();
    if(opPlugin::getInstance('opCommunityTopicPlugin')->getIsActive())
    {
      foreach(Doctrine::getTable('CommunityTopic')->getTopics($this->community->getId(), $this->size) as $topic)
      {
        opFeedPluginFeedGenerator::addItem($topic);
      }

      foreach(Doctrine::getTable('CommunityEvent')->getEvents($this->community->getId(), $this->size) as $event)
      {
        opFeedPluginFeedGenerator::addItem($event);
      }
    }
    
    $this->list = opFeedPluginFeedGenerator::getItems($this->size);
    $this->name = $this->community->getName();
    $this->link = 'community/home?id='.$this->community->getId();
    $this->setTemplate($this->output);
  }
}
