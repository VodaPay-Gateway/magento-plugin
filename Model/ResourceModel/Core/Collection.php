<?php

namespace VodaPay\VodaPay\Model\ResourceModel\Core;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use VodaPay\VodaPay\Model\Core as VodaPayModelCore;
use VodaPay\VodaPay\Model\ResourceModel\Core as VodaPayModelResourceCore;

/**
 * Model resource collection for Custom VodaPay order table
 *
 * Class Collection
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize
     *
     * @phpcs:disable PSR2.Methods.MethodDeclaration.Underscore
     */
    protected function _construct()
    {
        $this->_init(
            VodaPayModelCore::class,
            VodaPayModelResourceCore::class
        );
    }
}
