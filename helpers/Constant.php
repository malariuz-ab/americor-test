<?php

namespace app\helpers;

/**
 * All constants of the site
 * @author Alexander Bulatov <alexander.leon.bulatov@gmail.com>
 */
class Constant
{
    const AJAX_UPLOAD_LIMIT = 12;

    // Common values of status
    const STATUS_ON = 100;
    const STATUS_OFF = 10;
    // For any publications
    const STATUS_PUBLISHED = 100;
    const STATUS_DRAFT = 10;

    // For Event
    const EVENT_TYPE_RUSSIAN_NEWS = 10;
    const EVENT_TYPE_FOREIGN_NEWS = 20;
    const EVENT_TYPE_RUSSIAN_FAIR = 30;
    const EVENT_TYPE_FOREIGN_FAIR = 40;
    const EVENT_TYPE_SEMINAR = 50;
}