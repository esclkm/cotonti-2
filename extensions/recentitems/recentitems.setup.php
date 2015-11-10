<?php
/* ====================
[BEGIN_COT_EXT]
Name=Recent items
Category=publications-events
Description=Recent pages, topics in forums, users, comments
Version=1.0
Date=2012-05-28
Author=Feliz Team
Copyright=Partial copyright (c) Feliz Team 2008-2014
Notes=BSD License
SQL=
Auth_guests=R
Lock_guests=W12345A
Auth_members=R
Lock_members=W12345A
Recommends=page,forums,comments
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
recentpages=11:radio::1:Recent pages on index
maxpages=12:string::5:Recent pages displayed
recentpagestitle=13:string:::Recent pages title length limit
recentpagestext=14:string:::Recent pages text length limit
recentforums=15:radio::1:Recent forums on index
maxtopics=16:string::5:Recent topics in forums displayed
recentforumstitle=17:string:::Recent forums title length limit
newpages=18:radio::1:Recent pages in standalone extension
newpagestext=19:string:::New pages text length limit
newforums=20:radio::1:Recent forums in standalone extension
itemsperpage=22:string::10:Elements per page in standalone extension
rightscan=23:radio::1:Enable prescanning category rights
whitelist=31:text:::White list of categories
blacklist=32:text:::Black list of categories
cache_ttl=80:select:0,60,180,300,600,1800,3600:0:Cache lifetime in seconds, 0 disables cache
[END_COT_EXT_CONFIG]
==================== */

/**
 * Recent pages, topics in forums, users, comments
 *
 * @package recentitems
 * @version 0.9.10
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');
