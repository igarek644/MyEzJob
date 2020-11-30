<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20201125160827
 *
 * @package DoctrineMigrations
 */
final class Version20201125160827 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription() : string
    {
        return 'Migration to create table `tags`';
    }
    
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('tags');
        $table->addColumn("id", "integer", ["unsigned" => true, 'autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 20]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['name']);
    }
    
    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) : void
    {
        $schema->dropTable('tags');
    }
}
