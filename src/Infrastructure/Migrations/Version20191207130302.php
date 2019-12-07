<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191207130302 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create the categories table';
    }

    public function up(Schema $schema) : void
    {
        $sql = <<<SQL
CREATE TABLE categories (
    id INTEGER AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name VARCHAR(255) NOT NULL
)
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE categories');
    }
}
