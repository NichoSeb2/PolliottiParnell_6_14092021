<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211014124307 extends AbstractMigration {
    public function getDescription(): string {
        return 'Added created_at and updated_at fields to the category table';
    }

    public function up(Schema $schema): void {
        $this->addSql('ALTER TABLE category ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void {
        $this->addSql('ALTER TABLE category DROP created_at, DROP updated_at');
    }
}
