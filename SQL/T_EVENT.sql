CREATE TABLE `T_EVENT` (
  `EVENT_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `EVENT_DESCRIPTION` VARCHAR(127) NOT NULL,
  `START_DATE` DATE NOT NULL,
  `END_DATE` DATE NOT NULL,
  `IS_ACTIVE` BOOL NOT NULL DEFAULT TRUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `T_EVENT`(`EVENT_DESCRIPTION`, `START_DATE`, `END_DATE`) VALUES
('На всю жизнь...', date("2020-01-01"), date("2020-12-31"));
INSERT INTO `T_EVENT`(`EVENT_DESCRIPTION`, `START_DATE`, `END_DATE`) VALUES
('На Young Lions...', date("2020-01-01"), date("2020-12-31"));

commit;