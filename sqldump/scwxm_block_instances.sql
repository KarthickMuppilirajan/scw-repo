-- Adminer 4.2.6-dev MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `scwxm_block_instances`;
CREATE TABLE `scwxm_block_instances` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `blockname` varchar(40) NOT NULL DEFAULT '',
  `parentcontextid` bigint(10) NOT NULL,
  `showinsubcontexts` smallint(4) NOT NULL,
  `requiredbytheme` smallint(4) NOT NULL DEFAULT '0',
  `pagetypepattern` varchar(64) NOT NULL DEFAULT '',
  `subpagepattern` varchar(16) DEFAULT NULL,
  `defaultregion` varchar(16) NOT NULL DEFAULT '',
  `defaultweight` bigint(10) NOT NULL,
  `configdata` longtext,
  PRIMARY KEY (`id`),
  KEY `scwxm_blocinst_parshopagsub_ix` (`parentcontextid`,`showinsubcontexts`,`pagetypepattern`,`subpagepattern`),
  KEY `scwxm_blocinst_par_ix` (`parentcontextid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table stores block instances. The type of block this is';

INSERT INTO `scwxm_block_instances` (`id`, `blockname`, `parentcontextid`, `showinsubcontexts`, `requiredbytheme`, `pagetypepattern`, `subpagepattern`, `defaultregion`, `defaultweight`, `configdata`) VALUES
(1,	'admin_bookmarks',	1,	0,	0,	'admin-*',	NULL,	'side-pre',	2,	''),
(2,	'private_files',	1,	0,	0,	'my-index',	'2',	'side-post',	0,	''),
(3,	'online_users',	1,	0,	0,	'my-index',	'2',	'side-post',	1,	''),
(4,	'badges',	1,	0,	0,	'my-index',	'2',	'side-post',	2,	''),
(5,	'calendar_month',	1,	0,	0,	'my-index',	'2',	'side-post',	3,	''),
(6,	'calendar_upcoming',	1,	0,	0,	'my-index',	'2',	'side-post',	4,	''),
(7,	'lp',	1,	0,	0,	'my-index',	'2',	'content',	0,	''),
(8,	'course_overview',	1,	0,	0,	'my-index',	'2',	'content',	1,	''),
(9,	'private_files',	5,	0,	0,	'my-index',	'3',	'side-post',	0,	''),
(10,	'online_users',	5,	0,	0,	'my-index',	'3',	'side-post',	1,	''),
(11,	'badges',	5,	0,	0,	'my-index',	'3',	'side-post',	2,	''),
(12,	'calendar_month',	5,	0,	0,	'my-index',	'3',	'side-post',	3,	''),
(13,	'calendar_upcoming',	5,	0,	0,	'my-index',	'3',	'side-post',	4,	''),
(14,	'lp',	5,	0,	0,	'my-index',	'3',	'content',	0,	''),
(15,	'course_overview',	5,	0,	0,	'my-index',	'3',	'content',	1,	''),
(16,	'navigation',	1,	1,	1,	'*',	NULL,	'side-pre',	0,	''),
(17,	'settings',	1,	1,	1,	'*',	NULL,	'side-pre',	0,	''),
(18,	'html',	23,	1,	0,	'*',	NULL,	'side-post',	1,	'Tzo4OiJzdGRDbGFzcyI6Mzp7czo0OiJ0ZXh0IjtzOjIyODoiPHA+PGltZyBzcmM9Imh0dHA6Ly9zdHVkeS5jb20vY2ltYWdlcy92aWRlb3ByZXZpZXcvaGlzdG9yeS1vZi1vcGVyYXRpb25zLWFuZC1zdXBwbHktY2hhaW4tbWFuYWdlbWVudDFfMTQxOTI4LmpwZyIgYWx0PSIiIHdpZHRoPSIxMDI0IiBoZWlnaHQ9IjU3NiIgcm9sZT0icHJlc2VudGF0aW9uIiBjbGFzcz0iaW1nLXJlc3BvbnNpdmUgYXR0b19pbWFnZV9idXR0b25fdGV4dC1ib3R0b20iPjxicj48L3A+IjtzOjU6InRpdGxlIjtzOjIwOiJDcm9zcyBEb2NraW5nIHN5c3RlbSI7czo2OiJmb3JtYXQiO3M6MToiMSI7fQ=='),
(19,	'html',	23,	1,	0,	'*',	NULL,	'side-post',	2,	'Tzo4OiJzdGRDbGFzcyI6Mzp7czo0OiJ0ZXh0IjtzOjEwNDU6IjxvbD48bGk+QnV0IEkgbXVzdCBleHBsYWluIHRvIHlvdSBob3cgYWxsIHRoaXMgbWlzdGFrZW4gaWRlYSBvZiBkZW5vdW5jaW5nIHBsZWFzdXJlIGFuZCBwcmFpc2luZyBwYWluIHdhcyBib3JuIGFuZCBJIHdpbGwgZ2l2ZSB5b3UgYSBjb21wbGV0ZSBhY2NvdW50IG9mIHRoZSBzeXN0ZW0sIGFuZCBleHBvdW5kIHRoZSBhY3R1YWwgdGVhY2hpbmdzIG9mIHRoZSBncmVhdCBleHBsb3JlciBvZiB0aGUgdHJ1dGgsIHRoZSBtYXN0ZXItYnVpbGRlciBvZiBodW1hbiBoYXBwaW5lc3MuPGJyPjwvbGk+PGxpPiZuYnNwO05vIG9uZSByZWplY3RzLCBkaXNsaWtlcywgb3IgYXZvaWRzIHBsZWFzdXJlIGl0c2VsZiwgYmVjYXVzZSBpdCBpcyBwbGVhc3VyZSwgYnV0IGJlY2F1c2UgdGhvc2Ugd2hvIGRvIG5vdCBrbm93IGhvdyB0byBwdXJzdWUgcGxlYXN1cmUgcmF0aW9uYWxseSBlbmNvdW50ZXIgY29uc2VxdWVuY2VzIHRoYXQgYXJlIGV4dHJlbWVseSBwYWluZnVsLiZuYnNwOzxicj48L2xpPjxsaT5Ob3IgYWdhaW4gaXMgdGhlcmUgYW55b25lIHdobyBsb3ZlcyBvciBwdXJzdWVzIG9yIGRlc2lyZXMgdG8gb2J0YWluIHBhaW4gb2YgaXRzZWxmLCBiZWNhdXNlIGl0IGlzIHBhaW4sIGJ1dCBiZWNhdXNlIG9jY2FzaW9uYWxseSBjaXJjdW1zdGFuY2VzIG9jY3VyIGluIHdoaWNoIHRvaWwgYW5kIHBhaW4gY2FuIHByb2N1cmUgaGltIHNvbWUgZ3JlYXQgcGxlYXN1cmUuJm5ic3A7PGJyPjwvbGk+PGxpPlRvIHRha2UgYSB0cml2aWFsIGV4YW1wbGUsIHdoaWNoIG9mIHVzIGV2ZXIgdW5kZXJ0YWtlcyBsYWJvcmlvdXMgcGh5c2ljYWwgZXhlcmNpc2UsIGV4Y2VwdCB0byBvYnRhaW4gc29tZSBhZHZhbnRhZ2UgZnJvbSBpdD8gQnV0IHdobyBoYXMgYW55IHJpZ2h0IHRvIGZpbmQgZmF1bHQgd2l0aCBhIG1hbiB3aG8gY2hvb3NlcyB0byBlbmpveSBhIHBsZWFzdXJlIHRoYXQgaGFzIG5vIGFubm95aW5nIGNvbnNlcXVlbmNlcywgb3Igb25lIHdobyBhdm9pZHMgYSBwYWluIHRoYXQgcHJvZHVjZXMgbm8gcmVzdWx0YW50IHBsZWFzdXJlPGJyPjwvbGk+PC9vbD4iO3M6NToidGl0bGUiO3M6MTU6IlNwZWNpYWwgUmVwb3J0cyI7czo2OiJmb3JtYXQiO3M6MToiMSI7fQ=='),
(22,	'scw_interviews',	2,	0,	0,	'site-index',	NULL,	'scw-left',	1,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ=='),
(23,	'scw_videos',	2,	0,	0,	'site-index',	NULL,	'scw-left',	2,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ=='),
(24,	'scw_events',	2,	0,	0,	'site-index',	NULL,	'scw-left',	3,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ=='),
(25,	'scw_interviews',	1,	1,	0,	'login-*',	NULL,	'scw-left',	1,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ=='),
(26,	'scw_videos',	1,	1,	0,	'login-*',	NULL,	'scw-left',	2,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ=='),
(27,	'scw_events',	1,	1,	0,	'login-*',	NULL,	'scw-left',	3,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ=='),
(28,	'scw_interviews',	5,	0,	0,	'my-index',	NULL,	'scw-left',	1,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ=='),
(29,	'scw_events',	5,	0,	0,	'my-index',	NULL,	'scw-left',	3,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ=='),
(30,	'scw_videos',	5,	0,	0,	'my-index',	NULL,	'scw-left',	2,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ=='),
(31,	'private_files',	40,	0,	0,	'my-index',	'5',	'side-post',	0,	''),
(32,	'online_users',	40,	0,	0,	'my-index',	'5',	'side-post',	1,	''),
(33,	'badges',	40,	0,	0,	'my-index',	'5',	'side-post',	2,	''),
(34,	'calendar_month',	40,	0,	0,	'my-index',	'5',	'side-post',	3,	''),
(35,	'calendar_upcoming',	40,	0,	0,	'my-index',	'5',	'side-post',	4,	''),
(36,	'lp',	40,	0,	0,	'my-index',	'5',	'content',	0,	''),
(37,	'course_overview',	40,	0,	0,	'my-index',	'5',	'content',	1,	''),
(38,	'private_files',	50,	0,	0,	'my-index',	'7',	'side-post',	0,	''),
(39,	'online_users',	50,	0,	0,	'my-index',	'7',	'side-post',	1,	''),
(40,	'badges',	50,	0,	0,	'my-index',	'7',	'side-post',	2,	''),
(41,	'calendar_month',	50,	0,	0,	'my-index',	'7',	'side-post',	3,	''),
(42,	'calendar_upcoming',	50,	0,	0,	'my-index',	'7',	'side-post',	4,	''),
(43,	'lp',	50,	0,	0,	'my-index',	'7',	'content',	0,	''),
(44,	'course_overview',	50,	0,	0,	'my-index',	'7',	'content',	1,	''),
(45,	'scw_interviews',	1,	0,	0,	'admin-setting-frontpagesettings',	NULL,	'side-pre',	3,	''),
(46,	'scw_interviews',	1,	1,	0,	'local-*',	NULL,	'scw-left',	1,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ=='),
(47,	'scw_videos',	1,	1,	0,	'local-*',	NULL,	'scw-left',	2,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ=='),
(48,	'scw_events',	1,	1,	0,	'local-*',	NULL,	'scw-left',	3,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ=='),
(49,	'private_files',	74,	0,	0,	'my-index',	'9',	'side-post',	0,	''),
(50,	'online_users',	74,	0,	0,	'my-index',	'9',	'side-post',	1,	''),
(51,	'badges',	74,	0,	0,	'my-index',	'9',	'side-post',	2,	''),
(52,	'calendar_month',	74,	0,	0,	'my-index',	'9',	'side-post',	3,	''),
(53,	'calendar_upcoming',	74,	0,	0,	'my-index',	'9',	'side-post',	4,	''),
(54,	'lp',	74,	0,	0,	'my-index',	'9',	'content',	0,	''),
(55,	'course_overview',	74,	0,	0,	'my-index',	'9',	'content',	1,	''),
(56,	'private_files',	86,	0,	0,	'my-index',	'11',	'side-post',	0,	''),
(57,	'online_users',	86,	0,	0,	'my-index',	'11',	'side-post',	1,	''),
(58,	'badges',	86,	0,	0,	'my-index',	'11',	'side-post',	2,	''),
(59,	'calendar_month',	86,	0,	0,	'my-index',	'11',	'side-post',	3,	''),
(60,	'calendar_upcoming',	86,	0,	0,	'my-index',	'11',	'side-post',	4,	''),
(61,	'lp',	86,	0,	0,	'my-index',	'11',	'content',	0,	''),
(62,	'course_overview',	86,	0,	0,	'my-index',	'11',	'content',	1,	'');

-- 2017-03-09 13:50:09

INSERT INTO `scwxm_block_instances` (`id`, `blockname`, `parentcontextid`, `showinsubcontexts`, `requiredbytheme`, `pagetypepattern`, `subpagepattern`, `defaultregion`, `defaultweight`, `configdata`) VALUES
(NULL,	'scw_interviews',	1,	1,	0,	'my-index',	NULL,	'scw-left',	1,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ=='),
(NULL,	'scw_videos',	1,	1,	0,	'my-index',	NULL,	'scw-left',	2,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ=='),
(NULl,	'scw_events',	1,	1,	0,	'my-index',	NULL,	'scw-left',	3,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ==');

INSERT INTO `scwxm_block_instances` (`id`, `blockname`, `parentcontextid`, `showinsubcontexts`, `requiredbytheme`, `pagetypepattern`, `subpagepattern`, `defaultregion`, `defaultweight`, `configdata`) VALUES
(NULL,	'scw_interviews',	1,	1,	0,	'user-editprofile',	NULL,	'scw-left',	1,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ=='),
(NULL,	'scw_videos',	1,	1,	0,	'user-editprofile',	NULL,	'scw-left',	2,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ=='),
(NULl,	'scw_events',	1,	1,	0,	'user-editprofile',	NULL,	'scw-left',	3,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ==');


ALTER TABLE `scwxm_user_details` ADD `receive_newsletter` TINYINT(4) NULL DEFAULT '1' AFTER `user_id`;

ALTER TABLE `scwxm_user_details` ADD `receive_email` TINYINT(4) NULL DEFAULT '1' AFTER `receive_newsletter`;

ALTER TABLE `scwxm_user_details` CHANGE `is_searchable` `is_searchable` TINYINT(4) NULL DEFAULT '1';

ALTER TABLE `scwxm_user_details` CHANGE `public_search` `public_search` TINYINT(4) NULL DEFAULT '1';

UPDATE `scwxm_user_details` SET is_searchable = '1' , public_search = '1', receive_newsletter = '1', receive_email = '1'





