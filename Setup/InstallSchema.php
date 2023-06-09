<?php
namespace Wisepet\Slider\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var \Wisepet\ScopedEav\Setup\SchemaSetupFactory
     */
    private $schemaSetupFactory;

    /**
     * Constructor.
     *
     * @param \Wisepet\ScopedEav\Setup\SchemaSetupFactory $schemaSetupFactory Scoped EAV schema setup factory.
     */
    public function __construct(\Wisepet\ScopedEav\Setup\SchemaSetupFactory $schemaSetupFactory)
    {
        $this->schemaSetupFactory = $schemaSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    // @codingStandardsIgnoreLine Context param not used (Generic.CodeAnalysis.UnusedFunctionParameter.Found)
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        // Start setup.
        $setup->startSetup();

        $schemaSetup = $this->schemaSetupFactory->create(['setup' => $setup]);
        $connection  = $setup->getConnection();
        $entityTable = 'wisepet_slider';

        // Create additional attribute config table.
        $table = $this->addAttributeConfigFields($schemaSetup->getAttributeAdditionalTable($entityTable))
            ->setComment('Slider Attribute');
        $connection->createTable($table);

        // Create the slider main table.
        $table = $schemaSetup->getEntityTable($entityTable)->setComment('Slider Table');
        $connection->createTable($table);

        // Create the slider attribute backend tables (int, varchar, decimal, text and datetime).
        $table = $schemaSetup->getEntityAttributeValueTable($entityTable, \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, 'int')
            ->setComment('Slider Backend Table (int).');
        $connection->createTable($table);

        $table = $schemaSetup->getEntityAttributeValueTable($entityTable, \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL, '12,4')
            ->setComment('Slider Backend Table (decimal).');
        $connection->createTable($table);

        $table = $schemaSetup->getEntityAttributeValueTable($entityTable, \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, 'varchar')
            ->setComment('Slider Backend Table (varchar).');
        $connection->createTable($table);

        $table = $schemaSetup->getEntityAttributeValueTable($entityTable, \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '64k')
            ->setComment('Slider Backend Table (text).');
        $connection->createTable($table);

        $table = $schemaSetup->getEntityAttributeValueTable($entityTable, \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME)
            ->setComment('Slider Backend Table (datetime).');
        $connection->createTable($table);

        // Create the slider website link table.
        $table = $schemaSetup->getEntityWebsiteTable($entityTable)
            ->setComment('Slider To Website Linkage Table');
        $connection->createTable($table);

        // Fix catalog_eav_attribute table.
        $this->addProductAttributeConfigFields($setup);

        // End setup.
         $setup->endSetup();
    }

    /**
     * Add slider attributes special config fields.
     *
     * @param \Magento\Framework\DB\Ddl\Table $table Base table.
     *
     * @return \Magento\Framework\DB\Ddl\Table
     */
    private function addAttributeConfigFields(\Magento\Framework\DB\Ddl\Table $table)
    {
        $table->addColumn(
            'is_global',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '1'],
            'Is Global'
        )
        ->addColumn(
            'is_wysiwyg_enabled',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '0'],
            'Is WYSIWYG Enabled'
        )
        ->addColumn(
            'is_html_allowed_on_front',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '0'],
            'Is HTML Allowed On Front'
        );

        return $table;
    }

    /**
     * Append new configuration field slider_attribute_set_id in catalog_eav_attribute table.
     *
     * @param SchemaSetupInterface $setup Setup
     *
     * @return void
     */
    private function addProductAttributeConfigFields(SchemaSetupInterface $setup)
    {
        $connection = $setup->getConnection();

        $connection->addColumn(
            $setup->getTable('catalog_eav_attribute'),
            'slider_attribute_set_id',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'default' => null,
                'unsigned' => true,
                'nullable' => true,
                'comment' => 'Additional swatch attributes data',
            ]
        );

        $connection->addForeignKey(
            $connection->getForeignKeyName(
                'catalog_eav_attribute',
                'slider_attribute_set_id',
                'eav_attribute_set',
                'attribute_set_id'
            ),
            $setup->getTable('catalog_eav_attribute'),
            'slider_attribute_set_id',
            $setup->getTable('eav_attribute_set'),
            'attribute_set_id'
        );
    }
}
