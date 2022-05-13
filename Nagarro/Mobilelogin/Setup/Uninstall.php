<?php
namespace Nagarro\Mobilelogin\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Customer\Model\Customer;
use Nagarro\Mobilelogin\Setup\InstallData;

class Uninstall implements UninstallInterface
{
    private $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function uninstall(SchemaSetupInterface $setup,ModuleContextInterface $context)
    {
        $setup->startSetup();

        $eavSetup = $this->eavSetupFactory->create();
        $eavSetup->removeAttribute(Customer::ENTITY, InstallData::MOBILENUMBER);

        $setup->endSetup();
    }
}