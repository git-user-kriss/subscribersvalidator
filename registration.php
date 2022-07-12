<?php
/**
 * @category    Scandiweb
 * @package     Scandiweb\SubscribersValidator
 * @author      Krists Miculis <info@scandiweb.com>
 * @copyright   Copyright (c) 2022 Scandiweb, Inc (https://scandiweb.com)
 * @license     http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Scandiweb_SubscribersValidator',
    __DIR__
);
