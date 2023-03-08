CREATE TABLE `product_categories`
(
    `id`        int(11) unsigned NOT NULL AUTO_INCREMENT,
    `cat_title` varchar(255) DEFAULT NULL,
    `cat_desc`  varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `product_units`
(
    `id`       int(11) unsigned NOT NULL AUTO_INCREMENT,
    `un_title` varchar(45)  DEFAULT NULL,
    `un_desc`  varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;


#CREATE TABLE PRODUCTS - MARCOS ORLANDO 01/02/2023 : 20:07
CREATE TABLE `product`
(
    `pdt_id`            int(11) unsigned NOT NULL,
    `pdt_title`         varchar(255)              DEFAULT NULL,
    `pdt_subtitle`      varchar(255)              DEFAULT NULL,
    `pdt_tags`          varchar(255)              DEFAULT NULL,
    `pdt_url`           varchar(255)              DEFAULT NULL,
    `pdt_profit_margin` varchar(50)               DEFAULT NULL,
    `pdt_code`          char(8)                   DEFAULT NULL,
    `pdt_un`            int(11)                   DEFAULT NULL,
    `pdt_brand`         int(11)                   DEFAULT NULL,
    `pdt_category`      int(11)                   DEFAULT NULL,
    `pdt_description`   text                      DEFAULT NULL,
    `pdt_height`        int(11)                   DEFAULT NULL,
    `pdt_width`         int(11)                   DEFAULT NULL,
    `pdt_depth`         int(11)                   DEFAULT NULL,
    `pdt_weight`        decimal(11, 2)            DEFAULT NULL,
    `pdt_cost_price`    decimal(11, 2)            DEFAULT NULL,
    `pdt_offer_price`   decimal(11, 2)            DEFAULT NULL,
    `pdt_offer_percent` decimal(11, 2)            DEFAULT NULL,
    `pdt_price`         decimal(11, 2)            DEFAULT NULL,
    `pdt_offer_start`   timestamp        NULL     DEFAULT NULL,
    `pdt_offer_end`     timestamp        NULL     DEFAULT NULL,
    `pdt_stock`         int(11)                   DEFAULT NULL,
    `pdt_status`        smallint(1)               DEFAULT 0,
    `created_at`        timestamp        NULL     DEFAULT current_timestamp(),
    `pdt_update`        timestamp        NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
    `pdt_cover`         varchar(255)              DEFAULT NULL,
    PRIMARY KEY (`pdt_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
