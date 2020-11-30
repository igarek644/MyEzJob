<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20201125160540
 *
 * @package DoctrineMigrations
 */
final class Version20201125160540 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription() : string
    {
        return 'Migration to create table `articles`';
    }
    
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('articles');
        $table->addColumn("id", "integer", ["unsigned" => true, 'autoincrement' => true]);
        $table->setPrimaryKey(["id"]);
        $table->addColumn('title', 'string', ['length' => 50,'notnull' => true]);
        $table->addColumn('description', 'string', ['length' => 255]);
        $table->addColumn('tags', 'text', ['notnull' => false]);
    }
    
    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) : void
    {
        $schema->dropTable('articles');
    }
}
