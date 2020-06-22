CREATE TABLE IF NOT EXISTS `g_classes` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `code` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `desc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Classifications users can have';

CREATE TABLE IF NOT EXISTS `g_config` (
  `site_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `site_url` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `site_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'License key for XRF install.',
  `active` int(1) NOT NULL COMMENT 'If 0, disable site',
  `auth_version` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'If module version is not found in this string, disable module',
  `server_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ID of XRF server',
  `access_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Key used to run scripts which do not require login',
  `admin_email` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The master admin''s email for alert and notification purposes',
  `admin_id` int(8) NOT NULL DEFAULT '1' COMMENT 'The master admin''s ID',
  `reg_enabled` int(1) NOT NULL DEFAULT '1' COMMENT 'If 0, disable new registrations.  If 1, allow new registrations.',
  `login_enabled` int(1) NOT NULL DEFAULT '1' COMMENT 'If 0, disable user login.  If 1, allow user login.',
  `vlog_enabled` int(1) NOT NULL DEFAULT '0' COMMENT 'If 1, enable verbose logging.',
  `style_default` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'xrflight' COMMENT 'Style to use by default',
  PRIMARY KEY (`site_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Overall system configuration';

CREATE TABLE IF NOT EXISTS `g_log` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `uid` int(8) NOT NULL COMMENT 'User ID',
  `date` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Date and time of log event',
  `event` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Details of logged event',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Verbose log of actions';

CREATE TABLE IF NOT EXISTS `g_modules` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `prefix` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `folder` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ord` int(4) NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prefix` (`prefix`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='List of modules and configurations';

CREATE TABLE IF NOT EXISTS `g_styles` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Short name/identifier of style',
  `descr` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Friendly name of style',
  `active` int(1) NOT NULL DEFAULT '1' COMMENT '0 if disabled, 1 if active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `prefix` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT IGNORE INTO g_styles (`name`,`descr`) VALUES('xrflight','XRF Light Theme');
INSERT IGNORE INTO g_styles (`name`,`descr`) VALUES('xrfdark','XRF Dark Theme');

CREATE TABLE IF NOT EXISTS `g_users` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Used for auth',
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Used for display',
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `profilepic` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'URL for Profile Picture',
  `lname` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `mname` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'yyyy-mm-dd',
  `gender` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT 'm or f',
  `address` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Or province',
  `postal` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Or zip',
  `country` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `hphone` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `cphone` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `wphone` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `datereg` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'yyyy-mm-dd hh:mm:ss',
  `lastlogin` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'yyyy-mm-dd hh:mm:ss',
  `lastip` varchar(39) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Last IP address logged in from',
  `uclass` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `ulevel` int(1) NOT NULL DEFAULT '1' COMMENT '0 = Banned, 1 = Guest/Inactive, 2 = User, 3 = Mod, 4 = Admin',
  `getmail` int(1) NOT NULL DEFAULT '1' COMMENT 'If 0, receive no mail',
  `style_pref` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Style preference',
  `extra` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Overall user database';
