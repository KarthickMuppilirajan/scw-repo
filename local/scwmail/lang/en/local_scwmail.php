<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    local-scwmail
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['addbcc'] = 'Add Bcc';
$string['addcc'] = 'Add Cc';
$string['addrecipients'] = 'Add recipients';
$string['addto'] = 'Add To';
$string['advsearch'] = 'Advanced search';
$string['all'] = 'All';
$string['applychanges'] = 'Apply';
$string['assigntonewlabel'] = 'Assign to a new label...';
$string['attachments'] = 'Attachments';
$string['attachnumber'] = '{$a} attachments';
$string['bcc'] = 'Bcc';
$string['bulkmessage'] = 'With selected users send a local mail...';
$string['cancel'] = 'Cancel';
$string['cannotcompose'] = 'You cannot compose messages because you are not enrolled in any courses.';
$string['cc'] = 'Cc';
$string['compose'] = 'Compose';
$string['continue'] = 'Continue';
$string['courses'] = 'Courses';
$string['delete'] = 'Delete';
$string['discard'] = 'Discard';
$string['downloadall'] = 'Download all';
$string['draft'] = 'Draft';
$string['drafts'] = 'Drafts';
$string['editlabel'] = 'Edit label';
$string['emptyrecipients'] = 'No recipients.';
$string['erroremptycourse'] = 'Please specifiy a course.';
$string['erroremptylabelname'] = 'Please specify a label name.';
$string['erroremptyrecipients'] = 'Please specifiy at least one recipient.';
$string['erroremptysubject'] = 'Please specify a subject.';
$string['errorrepeatedlabelname'] = 'Label name already exists';
$string['errorinvalidcolor'] = 'Invalid color';
$string['filterbydate'] = 'Date (up to the day):';
$string['from'] = 'From';
$string['hasattachments'] = '(Message with attachments)';
$string['inbox'] = 'Inbox';
$string['invalidlabel'] = 'Invalid label';
$string['invalidmessage'] = 'Invalid message';
$string['labeldeleteconfirm'] = 'You are about to completely delete the label \'{$a}\'';
$string['labelname'] = 'Name';
$string['labelcolor'] = 'Color';
$string['labels'] = 'Labels';
$string['mail:addinstance'] = 'Add a new mail';
$string['mail:mailsamerole'] = 'Send mails to users with same role';
$string['mail:usemail'] = 'Use mail';
$string['mailupdater'] = 'Mail updater';
$string['markasread'] = 'Mark as read';
$string['markasread_help'] = 'If enabled, all new messages will be marked as read';
$string['markasstarred'] = 'Mark as starred';
$string['markasunread'] = 'Mark as unread';
$string['markasunstarred'] = 'Mark as unstarred';
$string['maxattachments'] = 'Maximum number of attachments';
$string['maxattachmentsize'] = 'Maximum attachment size';
$string['message'] = 'Message';
$string['messageprovider:mail'] = 'Mail received notification';
$string['moreactions'] = 'More';
$string['mymail'] = 'My mail';
$string['newlabel'] = 'New label';
$string['nocolor'] = 'No color';
$string['nolabels'] = 'No labels available.';
$string['nomessages'] = 'No messages.';
$string['nomessageserror'] = 'Action required needs at least one message selected';
$string['nomessagestoview'] = 'No messages to view.';
$string['none'] = 'None';
$string['norecipient'] = '(no recipient)';
$string['noselectedmessages'] = 'No messages selected';
$string['nosubject'] = '(no subject)';
$string['notificationbody'] = '- From: {$a->user}

- Subject: {$a->subject}

{$a->content}';
$string['notificationbodyhtml'] = '<p>From: {$a->user}</p><p>Subject: <a href="{$a->url}">{$a->subject}</a></p><p>{$a->content}</p>';
$string['notificationpref'] = 'Send notifications';
$string['notificationsubject'] = 'New mail message in {$a}';
$string['notingroup'] = 'You are not part of any group';
$string['pagingsingle'] = '{$a->index} of {$a->total}';
$string['pagingmultiple'] = '{$a->first}-{$a->last} of {$a->total}';
$string['perpage'] = 'Display {$a} messages';
$string['pluginname'] = 'SCW Mail';
$string['read'] = 'Read';
$string['references'] = 'References';
$string['removelabel'] = 'Remove label';
$string['reply'] = 'Reply';
$string['replyall'] = 'Reply all';
$string['restore'] = 'Restore';
$string['search'] = 'Search';
$string['searchbyunread'] = 'Unread only';
$string['searchbyattach'] = 'Has attachment';
$string['shortaddbcc'] = 'Bcc';
$string['shortaddcc'] = 'Cc';
$string['shortaddto'] = 'To';
$string['showlabelmessages'] = 'Show "{$a}" label messages';
$string['showrecentmessages'] = 'Show recent messages';
$string['smallmessage'] = '{$a->user} has sent you an email';
$string['toomanyrecipients'] = 'Search has too many results';
$string['forward'] = 'Forward';
$string['save'] = 'Save';
$string['send'] = 'Send';
$string['sendmessage'] = 'Send a message';
$string['sentmail'] = 'Sent';
$string['setlabels'] = 'Labels';
$string['starred'] = 'Starred';
$string['starredmail'] = 'Starred';
$string['subject'] = 'Subject';
$string['to'] = 'To';
$string['trash'] = 'Trash';
$string['undo'] = 'Undo';
$string['undodelete'] = '{$a} messages have been moved to trash';
$string['undorestore'] = '{$a} messages have been restored';
$string['unread'] = 'Unread';
$string['unstarred'] = 'Unstarred';
$string['configenablebackup'] = 'Backup / restore';
$string['configenablebackupdesc'] = 'Enable backup and restore of mail messages and labels.';
$string['validate_to'] = 'Please select at least one recipient';
$string['validate_subject'] = 'Please enter subject';
$string['validate_message'] = 'Please enter message';
$string['maximumchars'] = 'Maximum of 2500 characters';
