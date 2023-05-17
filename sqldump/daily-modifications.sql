>>>>>>>>>>>>> Mar 11 2017 >>>>>>>>>>>>

INSERT INTO `scwxm_block_instances` (`id`, `blockname`, `parentcontextid`, `showinsubcontexts`, `requiredbytheme`, `pagetypepattern`, `subpagepattern`, `defaultregion`, `defaultweight`, `configdata`) VALUES
(NULL,	'scw_interviews',	1,	1,	0,	'user-editprofile',	NULL,	'scw-left',	1,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ=='),
(NULL,	'scw_videos',	1,	1,	0,	'user-editprofile',	NULL,	'scw-left',	2,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ=='),
(NULl,	'scw_events',	1,	1,	0,	'user-editprofile',	NULL,	'scw-left',	3,	'Tzo4OiJzdGRDbGFzcyI6MDp7fQ==');


ALTER TABLE `scwxm_user_details` ADD `receive_newsletter` TINYINT(4) NULL DEFAULT '1' AFTER `user_id`;

ALTER TABLE `scwxm_user_details` ADD `receive_email` TINYINT(4) NULL DEFAULT '1' AFTER `receive_newsletter`;

ALTER TABLE `scwxm_user_details` CHANGE `is_searchable` `is_searchable` TINYINT(4) NULL DEFAULT '1';

ALTER TABLE `scwxm_user_details` CHANGE `public_search` `public_search` TINYINT(4) NULL DEFAULT '1';

UPDATE `scwxm_user_details` SET is_searchable = '1' , public_search = '1', receive_newsletter = '1', receive_email = '1'


ALTER TABLE  `scwxm_user` CHANGE  `country`  `country` VARCHAR( 2 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'GB';

ALTER TABLE  `scwxm_user_details` CHANGE  `functional_area`  `functional_area` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT  'supply-chain-management-for-marketing';

ALTER TABLE  `scwxm_user_details` CHANGE  `industry`  `industry` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT  'education';


>>>>>>> Mar 17 2017 >>>>>>>>>

ALTER TABLE scwxm_user_details ADD(awards_reg LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci,awards_regformat TINYINT(2) DEFAULT 0);

SELECT a.user_id,b.id as contextid,c.* FROM scwxm_user_details as a join scwxm_context as b  on a.user_id = b.instanceid join scwxm_files as c on b.id = c.contextid where b.contextlevel = 30



SELECT a.id,a.user_id,b.id as contextid,c.* FROM scwxm_user_details as a join scwxm_context as b  on a.user_id = b.instanceid join scwxm_files as c on b.id = c.contextid where b.contextlevel = 30 
AND a.profile_pic IS NULL AND c.filename like 'f3.%'

$sql = "SELECT * FROM {files} WHERE `contextid` = '".$personalcontext->id."' AND `component` LIKE 'user' AND `filearea` LIKE 'draft' AND filesize > 0 order by id desc limit 1";
$presult = $DB->get_record_sql($sql);

>>>>>>>> Mar 18 2017 >>>>>>>>>>>>>>>>>>

ALTER TABLE scwxm_user_details ADD(web_url VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci,linkedin_url VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci);


>>>>>>>>>>>>>> Mar 29 2017 >>>>>>>>>>>>>>>

ALTER TABLE scwxm_local_scwevents  ADD(event_descriptionformat TINYINT(2) DEFAULT 1);