ALTER TABLE `probid_auctions`
ADD INDEX (`creation_in_progress`, `creation_date`);

ALTER TABLE `probid_auctions`
ADD INDEX (`closed`, `deleted`);

ALTER TABLE `probid_auctions`
ADD INDEX (`end_time`, `deleted`, `creation_in_progress`);

ALTER TABLE `probid_currencies`
ADD INDEX (`symbol`);

ALTER TABLE `probid_auctions`
ADD INDEX (`is_relisted_item`, `notif_item_relisted`);