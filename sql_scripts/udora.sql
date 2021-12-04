INSERT INTO `option` (`id`,`parent_id`, `order`, `type`, `visible`, `is_locked`, `is_frontend`, `is_hardlocked`) VALUES
(83, 1, 5, 'UPLOAD', 0, 1, 0, 0);

INSERT INTO `option_lang` (`option_id`, `language_id`, `option`, `values`, `prefix`, `suffix`) VALUES
(83,1,'Paid ads','','','');

INSERT INTO `option_lang` (`option_id`, `language_id`, `option`, `values`, `prefix`, `suffix`) VALUES
(83,2,'Paid ads','','','');

/* Notification Settings */
ALTER TABLE `user` ADD `favorites_notifications` TINYINT NOT NULL DEFAULT '0' AFTER `research_mail_notifications`, ADD `reviews_notifications` TINYINT NOT NULL DEFAULT '0' AFTER `favorites_notifications`, ADD `promotional_emails` TINYINT NOT NULL DEFAULT '0' AFTER `reviews_notifications`, ADD `information_disclosed` TINYINT NOT NULL DEFAULT '0' AFTER `promotional_emails`;