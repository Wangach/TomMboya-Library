/*Adds default values to the field and additionalDetails columns*/
ALTER TABLE `tommboyalibrary`.`borrowedbooks` CHANGE `address` `address` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'MKU';

ALTER TABLE `tommboyalibrary`.`borrowedbooks` CHANGE `additionalDetails` `additionalDetails` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'N/A';

/*donations structure change*/
ALTER TABLE `tommboyalibrary`.`donations` CHANGE `amount` `amount` VARCHAR(100) NOT NULL;

/*Payments table structure change*/
ALTER TABLE `tommboyalibrary`.`payments` CHANGE `amount` `amount` VARCHAR(100) NOT NULL;
