<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateProductsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('products');
        $table->addColumn('product_name', 'string')
            ->addColumn('description', 'text')
            ->addColumn('image', 'string')
            ->addColumn('image2', 'string')
            ->addColumn('image3', 'string')
            ->addColumn('image4', 'string')
            ->addColumn('price', 'integer')
            ->addColumn('reference', 'string')
            ->addColumn('qty', 'integer')
            ->addColumn('display', 'boolean')
            ->create();
    }
}
