<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191207134013 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create the products table';
    }

    public function up(Schema $schema) : void
    {
        $sql = <<<SQL
CREATE TABLE products (
    id VARCHAR(255) PRIMARY KEY NOT NULL,
    description VARCHAR(255) NOT NULL,
    category_id INT NOT NULL,
    price VARCHAR(255) NOT NULL
)
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE products');
    }
}
