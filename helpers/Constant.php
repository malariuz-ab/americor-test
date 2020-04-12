<?php

namespace app\helpers;

/**
 * All constants of the site
 * @author Alexander Bulatov <alexander.leon.bulatov@gmail.com>
 */
class Constant
{
    const MY_IP = '00.000.000.00';

    const IS_TECH_RESOURCE_YES = 1;
    const IS_TECH_RESOURCE_NO = 0;
    const AJAX_UPLOAD_LIMIT = 12;

    // Common values of status
    const STATUS_ON = 200;
    const STATUS_OFF = 0;
    const BOOLEAN_STATUS_YES = true;
    const BOOLEAN_STATUS_NO = false;
    // For any publications
    const STATUS_PUBLISHED = 200;
    const STATUS_DRAFT = 0;

    // Company Rates and Payments
    const COMPANY_RATE_NOT_PAID = 0;
    const COMPANY_RATE_BUSINESS = 1;
    const COMPANY_RATE_MAXIMUM = 2;
    const COMPANY_PAYMENT_SWITCH_ON_YES = 1;
    const COMPANY_PAYMENT_SWITCH_ON_NO = 0;


    // For the taxonomy of site
    const BLOCK_NUMBER_FIRST = 1;
    const BLOCK_NUMBER_SECOND = 2;
    const COMPANY_TAXONOMY_TYPE_DIRECTION = 1;
    const COMPANY_TAXONOMY_TYPE_THEME_SERVICE = 2;
    const COMPANY_TAXONOMY_TYPE_THEME_EQUIPMENT = 3;
    const COMPANY_TAXONOMY_TYPE_SUBTHEME = 4;
    const COMPANY_TAXONOMY_TYPE_SERVICE_TECHNOLOGY = 5;
    const COMPANY_TAXONOMY_TYPE_EQUIPMENT_TECHNOLOGY = 6;
    const COMPANY_TAXONOMY_TYPE_OPERATION = 7;
    const COMPANY_TAXONOMY_TYPE_GROUP_OF_TOPIC_TAG = 8;
    const COMPANY_TAXONOMY_TYPE_TOPIC_TAG = 9;
    const COMPANY_TAXONOMY_TYPE_EQUIPMENT_TYPE = 10;
    const COMPANY_TAXONOMY_TYPE_MANUFACTURER = 11;
    const PUBLICATION_TAXONOMY_TYPE_DIRECTION = 1;
    const PUBLICATION_TAXONOMY_TYPE_THEME = 2;
    const PUBLICATION_TAXONOMY_TYPE_TECHNOLOGY = 3;
    const PUBLICATION_TAXONOMY_TYPE_OPERATION = 4;
    const PUBLICATION_TAXONOMY_TYPE_EQUIPMENT_TYPE = 5;
    const PUBLICATION_TAXONOMY_TYPE_MANUFACTURER = 6;
    // For checkboxes
    const IS_MARKABLE = 1;
    const IS_NOT_MARKABLE = 0;

    // For Admin Menu
    const IS_HEADER_YES = 1;
    const IS_HEADER_NO = 0;

    // For Event
    const EVENT_TYPE_RUSSIAN_NEWS = 1;
    const EVENT_TYPE_FOREIGN_NEWS = 2;
    const EVENT_TYPE_RUSSIAN_FAIR = 3;
    const EVENT_TYPE_FOREIGN_FAIR = 4;
    const EVENT_TYPE_SEMINAR = 5;
}