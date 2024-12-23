<?php

namespace VodaPay\VodaPay\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Ngenius\NgeniusCommon\NgeniusOrderStatuses;

class DataPatch implements DataPatchInterface
{
    /**
     * VodaPay State
     */
    public const STATE = 'vodapay_state';
    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * Apply Data Patch for VodaPay custom order statuses
     *
     * @return void
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $table = $this->moduleDataSetup->getTable('sales_order_status');

        $checkExistingStatus1 = $this->moduleDataSetup->getConnection()->fetchOne(
            $this->moduleDataSetup->getConnection()->select()
                                  ->from($table)
                                  ->where('status = ?', 'vodapay_pending')
        );

        if (!$checkExistingStatus1) {
            $this->insertAllVodaPayStatuses();
        }

        $checkExistingStatus2 = $this->moduleDataSetup->getConnection()->fetchOne(
            $this->moduleDataSetup->getConnection()->select()
                                  ->from($table)
                                  ->where('status = ?', 'vodapay_declined')
        );

        if (!$checkExistingStatus2) {
            $table1 = $this->moduleDataSetup->getTable('sales_order_status');
            if ($this->moduleDataSetup->getConnection()->isTableExists($table1)) {
                $this->moduleDataSetup->getConnection()->insert(
                    $table1,
                    [
                        'status' => 'vodapay_declined',
                        'label'  => 'VodaPay Declined',
                    ]
                );
            }

            $table2 = $this->moduleDataSetup->getTable('sales_order_status_state');
            if ($this->moduleDataSetup->getConnection()->isTableExists($table2)) {
                $this->moduleDataSetup->getConnection()->insert(
                    $table2,
                    [
                        'status'           => 'vodapay_declined',
                        'state'            => 'vodapay_state',
                        'is_default'       => 0,
                        'visible_on_front' => 1,
                    ]
                );
            }
        }

        $this->moduleDataSetup->endSetup();
    }

    /**
     * Installs all custom VodaPay Statuses
     *
     * @return void
     */
    private function insertAllVodaPayStatuses(): void
    {
        // Add code from the DataPatch class
        $this->moduleDataSetup->getConnection()
                              ->insertArray(
                                  $this->moduleDataSetup->getTable('sales_order_status'),
                                  ['status', 'label'],
                                  $this->getStatuses()
                              );

        $state[] = ['vodapay_pending', self::STATE, '1', '1'];
        $state[] = ['vodapay_processing', self::STATE, '0', '1'];
        $state[] = ['vodapay_failed', self::STATE, '0', '1'];
        $state[] = ['vodapay_complete', self::STATE, '0', '1'];
        $state[] = ['vodapay_authorised', self::STATE, '0', '1'];
        $state[] = ['vodapay_fully_captured', self::STATE, '0', '1'];
        $state[] = ['vodapay_partially_captured', self::STATE, '0', '1'];
        $state[] = ['vodapay_fully_refunded', self::STATE, '0', '1'];
        $state[] = ['vodapay_partially_refunded', self::STATE, '0', '1'];
        $state[] = ['vodapay_auth_reversed', self::STATE, '0', '1'];
        $state[] = ['vodapay_declined', self::STATE, '0', '1'];

        $this->moduleDataSetup->getConnection()
                              ->insertArray(
                                  $this->moduleDataSetup->getTable('sales_order_status_state'),
                                  ['status', 'state', 'is_default', 'visible_on_front'],
                                  $state
                              );
    }

    /**
     * Mark any dependencies here
     *
     * @return array|string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * For any references to old installation data
     *
     * @return array|string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Function retrieving all custom VodaPay statuses
     *
     * @return string[][]
     */
    public static function getStatuses(): array
    {
        return NgeniusOrderStatuses::magentoOrderStatuses('VodaPay', 'vodapay');
    }
}
