<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20191207115504 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create the customers table';
    }

    public function up(Schema $schema) : void
    {
        $sql = <<<SQL
CREATE TABLE customers (
    id INTEGER AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name VARCHAR(255) NOT NULL,
    since DATETIME NOT NULL,
    revenue VARCHAR(255) NOT NULL
)
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE customers');
    }
}
