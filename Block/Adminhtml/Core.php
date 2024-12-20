<?php

namespace VodaPay\VodaPay\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

/**
 * Class Core
 * The core driver for the VodaPay Report
 */
class Core extends Container
{
    // phpcs:disable PSR2.Methods.MethodDeclaration.Underscore
    // phpcs:disable PSR2.Classes.PropertyDeclaration.Underscore

    /**
     * Core constructor
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_core_report';
        $this->_blockGroup = 'VodaPay_VodaPay';
        $this->_headerText = __('VodaPay Orders');
        parent::_construct();
        $this->buttonList->remove('add');
    }
}
