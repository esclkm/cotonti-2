/**
 * Version: 0.9.15
 */

DROP TABLE IF EXISTS `cot_auth`;
CREATE TABLE `cot_auth` (
  `auth_id` int NOT NULL auto_increment,
  `auth_groupid` int NOT NULL default '0',
  `auth_code` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `auth_option` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `auth_rights` tinyint unsigned NOT NULL default '0',
  `auth_rights_lock` tinyint unsigned NOT NULL default '0',
  `auth_setbyuserid` int unsigned NOT NULL default '0',
  PRIMARY KEY  (`auth_id`),
  KEY `auth_groupid` (`auth_groupid`),
  KEY `auth_code` (`auth_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `cot_auth` (`auth_groupid`, `auth_code`, `auth_option`, `auth_rights`, `auth_rights_lock`, `auth_setbyuserid`) VALUES
(1, 'admin', 'a', 0, 255, 1),
(2, 'admin', 'a', 0, 255, 1),
(3, 'admin', 'a', 0, 255, 1),
(4, 'admin', 'a', 0, 255, 1),
(5, 'admin', 'a', 255, 255, 1),
(6, 'admin', 'a', 1, 0, 1),
(1, 'message', 'a', 1, 255, 1),
(2, 'message', 'a', 1, 255, 1),
(3, 'message', 'a', 1, 255, 1),
(4, 'message', 'a', 1, 255, 1),
(5, 'message', 'a', 255, 255, 1),
(6, 'message', 'a', 131, 0, 1),
(1, 'structure', 'a', 0, 255, 1),
(2, 'structure', 'a', 0, 255, 1),
(3, 'structure', 'a', 0, 255, 1),
(4, 'structure', 'a', 0, 255, 1),
(5, 'structure', 'a', 255, 255, 1),
(6, 'structure', 'a', 1, 0, 1);

DROP TABLE IF EXISTS `cot_cache`;
CREATE TABLE `cot_cache` (
  `c_name` varchar(120) collate utf8_unicode_ci NOT NULL,
  `c_realm` varchar(64) collate utf8_unicode_ci NOT NULL default 'cot',
  `c_expire` int NOT NULL default '0',
  `c_auto` tinyint NOT NULL default '1',
  `c_value` MEDIUMTEXT collate utf8_unicode_ci,
  PRIMARY KEY  (`c_name`, `c_realm`),
  KEY (`c_realm`),
  KEY (`c_name`),
  KEY (`c_expire`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `cot_cache_bindings`;
CREATE TABLE `cot_cache_bindings` (
  `c_event` VARCHAR(64) collate utf8_unicode_ci NOT NULL,
  `c_id` VARCHAR(120) collate utf8_unicode_ci NOT NULL,
  `c_realm` VARCHAR(64) collate utf8_unicode_ci NOT NULL DEFAULT 'cot',
  `c_type` TINYINT NOT NULL DEFAULT '0',
  PRIMARY KEY (`c_event`, `c_id`, `c_realm`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `cot_config`;
CREATE TABLE `cot_config` (
  `config_owner` varchar(24) collate utf8_unicode_ci NOT NULL default 'core',
  `config_cat` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `config_order` char(3) collate utf8_unicode_ci NOT NULL default '00',
  `config_name` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `config_type` tinyint NOT NULL default '0',
  `config_value` text collate utf8_unicode_ci NOT NULL,
  `config_default` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `config_variants` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `config_text` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `config_donor` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  KEY (`config_owner`, `config_cat`),
  KEY (`config_owner`, `config_cat`, `config_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `cot_config` (`config_owner`, `config_cat`, `config_order`, `config_name`, `config_type`, `config_value`, `config_default`, `config_variants`, `config_text`) VALUES

('system','main','01','adminemail',1,'admin@mysite.com','admin@mysite.com','',''),
('system','main','02','clustermode',3,'0','0','',''),
('system','main','03','hostip',1,'999.999.999.999','999.999.999.999','',''),
('system','main','04','parser',4,'none','none','cot_get_parsers()',''),
('system','main','05','maxrowsperpage',1,'15','15','',''),
('system','main','06','easypagenav',3,'1','1','',''),
('system','main','07','confirmlinks',3,'1','1','',''),
('system','main','11','forcedefaultlang',3,'0','0','',''),
('system','main','12','defaulttimezone',4,'0','0','cot_config_timezones()',''),
('system','main','21','gzip',3,'0','0','',''),
('system','main','22','headrc_consolidate',3,'0','0','',''),
('system','main','23','headrc_minify',3,'1','1','',''),
('system','main','24','jquery_cdn',1,'','','',''),
('system','main','25','jquery',3,'1','1','',''),
('system','main','26','turnajax',3,'1','1','',''),
('system','main','91','default_show_installed',3,'0','0','',''),
('system','security','21','shieldenabled',3,'0','0','',''),
('system','security','22','shieldtadjust',2,'100','100','10,25,50,75,100,125,150,200,300,400,600,800',''),
('system','security','23','shieldzhammer',2,'25','25','5,10,15,20,25,30,40,50,100',''),
('system','security','31','captchamain',4,'mcaptcha','mcaptcha','cot_captcha_list()',''),
('system','security','32','captcharandom',3,'0','0','',''),
('system','security','41','referercheck',3,'1','1','',''),
('system','security','42','hashfunc',4,'sha256','sha256','cot_hash_funcs()',''),
('system','security','97','devmode',3,'0','0','',''),
('system','security','98','maintenance',3,'0','0','',''),
('system','security','99','maintenancereason',1,'','','',''),
('system','sessions','01','cookiedomain',1,'','','',''),
('system','sessions','02','cookiepath',1,'','','',''),
('system','sessions','03','cookielifetime',2,'5184000','5184000','1800,3600,7200,14400,28800,43200,86400,172800,259200,604800,1296000,2592000,5184000',''),
('system','sessions','04','forcerememberme',3,'0','0','',''),
('system','sessions','05','timedout',2,'1200','1200','30,60,120,300,600,900,1200,1800,2400,3600',''),
('system','sessions','06','redirbkonlogin',3,'1','1','',''),
('system','sessions','07','redirbkonlogout',3,'0','0','',''),
('system','theme','01','forcedefaulttheme',3,'0','0','',''),
('system','theme','02','homebreadcrumb',3,'0','0','',''),
('system','theme','04','separator',1,'/','/','',''),
('system','theme','05','disablesysinfos',3,'0','0','',''),
('system','theme','06','keepcrbottom',3,'1','1','',''),
('system','theme','07','showsqlstats',3,'0','0','',''),
('system','theme','08','msg_separate',3,'0','0','','Show messages separately for each source'),
('system','title','01','maintitle',1,'Title of your site','Title of your site','',''),
('system','title','02','subtitle',1,'Subtitle','Subtitle','',''),
('system','title','03','metakeywords',1,'','','',''),
('system','title','14','title_users_details',1,'{USER}: {NAME}','{USER} - {NAME}','',''),
('system','title','18','title_header',1,'{SUBTITLE} - {MAINTITLE}','{SUBTITLE} - {MAINTITLE}','',''),
('system','title','19','title_header_index',1,'{MAINTITLE} - {DESCRIPTION}','{MAINTITLE} - {DESCRIPTION}','',''),
('system','title','98','subject_mail',1,'{SITE_TITLE} - {MAIL_SUBJECT}','{SITE_TITLE} - {MAIL_SUBJECT}','',''),
('system','title','99','body_mail',0,'{MAIL_BODY}\n\n{SITE_TITLE} - {SITE_URL}\n{SITE_DESCRIPTION}','{MAIL_BODY}\n\n{SITE_TITLE} - {SITE_URL}\n{SITE_DESCRIPTION}','','');

DROP TABLE IF EXISTS `cot_core`;
CREATE TABLE `cot_core` (
  `ct_id` mediumint NOT NULL auto_increment,
  `ct_code` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `ct_title` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `ct_version` varchar(32) collate utf8_unicode_ci NOT NULL default '',
  `ct_state` tinyint unsigned NOT NULL default '1',
  `ct_lock` tinyint unsigned NOT NULL default '0',
  `ct_extension` tinyint unsigned NOT NULL default '0',
  PRIMARY KEY  (`ct_id`),
  KEY `ct_code` (`ct_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `cot_core` (`ct_code`, `ct_title`, `ct_version`, `ct_state`, `ct_lock`) VALUES
('admin', 'Administration panel', '0.7.0', 1, 1),
('message', 'Messages', '0.7.0', 1, 1);

DROP TABLE IF EXISTS `cot_extrafields`;
CREATE TABLE `cot_extrafields` (
  `field_location` varchar(255) collate utf8_unicode_ci NOT NULL,
  `field_name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `field_type` varchar(255) collate utf8_unicode_ci NOT NULL,
  `field_html` text collate utf8_unicode_ci NOT NULL,
  `field_variants` text collate utf8_unicode_ci NOT NULL,
  `field_params` text collate utf8_unicode_ci NOT NULL,
  `field_default` text collate utf8_unicode_ci NOT NULL,
  `field_required` tinyint(1) unsigned NOT NULL default '0',
  `field_enabled` tinyint(1) unsigned NOT NULL default '1',
  `field_parse` varchar(32) collate utf8_unicode_ci NOT NULL default 'HTML',
  `field_description` text collate utf8_unicode_ci NOT NULL,
  KEY `field_location` (`field_location`),
  KEY `field_name` (`field_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `cot_groups`;
CREATE TABLE `cot_groups` (
  `grp_id` int NOT NULL auto_increment,
  `grp_alias` varchar(32) collate utf8_unicode_ci NOT NULL default '',
  `grp_level` tinyint NOT NULL default '1',
  `grp_disabled` tinyint NOT NULL default '0',
  `grp_name` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `grp_title` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `grp_desc` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `grp_icon` varchar(128) collate utf8_unicode_ci NOT NULL default '',
  `grp_ownerid` int NOT NULL default '0',
  `grp_maintenance` tinyint NOT NULL default '0',
  `grp_skiprights` tinyint NOT NULL default '0',
  PRIMARY KEY  (`grp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7;


INSERT INTO `cot_groups` (`grp_id`, `grp_alias`, `grp_level`, `grp_disabled`, `grp_name`, `grp_title`, `grp_desc`, `grp_icon`, `grp_ownerid`, `grp_maintenance`) VALUES
(1, 'guests', 0, 0, 'Guests', 'Guest', '', '', 1, 0),
(2, 'inactive', 1, 0, 'Inactive', 'Inactive', '', '', 1, 0),
(3, 'banned', 1, 0, 'Banned', 'Banned', '', '', 1, 0),
(4, 'members', 1, 0, 'Members', 'Member', '', '', 1, 0),
(5, 'administrators', 99, 0, 'Administrators', 'Administrator', '', '', 1, 1),
(6, 'moderators', 50, 0, 'Moderators', 'Moderator', '', '', 1, 1);

DROP TABLE IF EXISTS `cot_groups_users`;
CREATE TABLE `cot_groups_users` (
  `gru_userid` int NOT NULL default '0',
  `gru_groupid` int NOT NULL default '0',
  `gru_state` tinyint NOT NULL default '0',
  UNIQUE KEY `gru_groupid` (`gru_groupid`,`gru_userid`),
  KEY `gru_userid` (`gru_userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `cot_logger`;
CREATE TABLE `cot_logger` (
  `log_id` mediumint NOT NULL auto_increment,
  `log_date` int NOT NULL default '0',
  `log_ip` varchar(15) collate utf8_unicode_ci NOT NULL default '',
  `log_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `log_group` varchar(4) collate utf8_unicode_ci NOT NULL default 'def',
  `log_text` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `cot_extension_hooks`;
CREATE TABLE `cot_extension_hooks` (
  `ext_id` mediumint NOT NULL auto_increment,
  `ext_hook` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `ext_code` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `ext_part` varchar(32) collate utf8_unicode_ci NOT NULL default '',
  `ext_title` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `ext_file` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `ext_order` tinyint unsigned NOT NULL default '10',
  `ext_active` tinyint unsigned NOT NULL default '1',
  PRIMARY KEY  (`ext_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `cot_structure`;
CREATE TABLE `cot_structure` (
  `structure_id` mediumint NOT NULL auto_increment,
  `structure_area` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `structure_code` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `structure_path` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `structure_tpl` varchar(128) collate utf8_unicode_ci NOT NULL default '',
  `structure_title` varchar(128) collate utf8_unicode_ci NOT NULL,
  `structure_desc` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `structure_icon` varchar(128) collate utf8_unicode_ci NOT NULL default '',
  `structure_locked` tinyint NOT NULL default '0',
  `structure_count` mediumint NOT NULL default '0',
  PRIMARY KEY  (`structure_id`),
  KEY `structure_code` (`structure_code`),
  KEY `structure_path` (`structure_path`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `cot_updates`;
CREATE TABLE `cot_updates` (
  `upd_param` VARCHAR(255) NOT NULL,
  `upd_value` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`upd_param`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
INSERT INTO `cot_updates` (`upd_param`, `upd_value`) VALUES
('revision', '0.9.15-01'),
('branch', 'siena');

DROP TABLE IF EXISTS `cot_users`;
CREATE TABLE `cot_users` (
  `user_id` int unsigned NOT NULL auto_increment,
  `user_banexpire` int default '0',
  `user_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `user_password` varchar(224) collate utf8_unicode_ci NOT NULL default '',
  `user_passfunc` VARCHAR(32) NOT NULL default 'sha256',
  `user_passsalt` VARCHAR(16) NOT NULL default '',
  `user_maingrp` int NOT NULL default '4',
  `user_country` char(2) collate utf8_unicode_ci NOT NULL default '',
  `user_timezone` varchar(32) collate utf8_unicode_ci NOT NULL default 'GMT',
  `user_text` text collate utf8_unicode_ci,
  `user_birthdate` DATE NOT NULL DEFAULT '0000-00-00',
  `user_gender` char(1) collate utf8_unicode_ci NOT NULL default 'U',
  `user_email` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `user_hideemail` tinyint unsigned NOT NULL default '1',
  `user_theme` varchar(32) collate utf8_unicode_ci NOT NULL default '',
  `user_scheme` varchar(32) collate utf8_unicode_ci NOT NULL default '',
  `user_lang` varchar(16) collate utf8_unicode_ci NOT NULL default '',
  `user_regdate` int NOT NULL default '0',
  `user_lastlog` int NOT NULL default '0',
  `user_lastvisit` int NOT NULL default '0',
  `user_lastip` varchar(16) collate utf8_unicode_ci NOT NULL default '',
  `user_logcount` int unsigned NOT NULL default '0',
  `user_sid` char(64) collate utf8_unicode_ci NOT NULL default '',
  `user_sidtime` int NOT NULL default 0,
  `user_lostpass` char(32) collate utf8_unicode_ci NOT NULL default '',
  `user_auth` MEDIUMTEXT collate utf8_unicode_ci,
  `user_token` char(16) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`user_id`),
  KEY `user_password` (`user_password`),
  KEY `user_regdate` (`user_regdate`),
  KEY `user_name` (`user_name`),
  KEY `user_maingrp` (`user_maingrp`),
  KEY `user_email` (`user_email`),
  KEY `user_sid` (`user_sid`),
  KEY `user_lostpass` (`user_lostpass`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
