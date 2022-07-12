<?php
/**
 * @category    Scandiweb
 * @package     Scandiweb\SubscribersValidator
 * @author      Krists Miculis <info@scandiweb.com>
 * @copyright   Copyright (c) 2022 Scandiweb, Inc (https://scandiweb.com)
 * @license     http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

namespace Scandiweb\SubscribersValidator\Helper;

use Magento\Framework\DataObject;
use Magento\Newsletter\Model\ResourceModel\Subscriber\CollectionFactory;

/**
 * Class NewsletterSubscribers
 * @package Scandiweb\SubscribersValidator\Helper
 */
class NewsletterSubscribers
{
    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $subscriberCollection;

    /**
     * NewsletterSubscribers constructor.
     * @param CollectionFactory $subscriberCollection
     */
    public function __construct(
        CollectionFactory $subscriberCollection
    ) {
        $this->subscriberCollection = $subscriberCollection;
    }

    /**
     * @return DataObject[]
     */
    public function getAllNewsletterSubscribersData() {
        $subscribers = $this->subscriberCollection->create();

        return $subscribers->getItems();
    }
}