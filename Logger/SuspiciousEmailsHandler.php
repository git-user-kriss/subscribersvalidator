<?php
/**
 * @category    Scandiweb
 * @package     Scandiweb\SubscribersValidator
 * @author      Krists Miculis <info@scandiweb.com>
 * @copyright   Copyright (c) 2022 Scandiweb, Inc (https://scandiweb.com)
 * @license     http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

namespace Scandiweb\SubscribersValidator\Logger;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

/**
 * Class SuspiciousEmailsHandler
 * @package Scandiweb\SubscribersValidator\Logger
 */
class SuspiciousEmailsHandler extends Base
{
    const LOG_FILE_NAME_AND_PATH = '/var/log/suspicious-emails.log';
    protected $loggerType = Logger::INFO;
    protected $fileName = self::LOG_FILE_NAME_AND_PATH;
}