<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210929133119 extends AbstractMigration {
    public function getDescription(): string {
        return 'Added created at and updated at fields to comment table';
    }

    public function up(Schema $schema): void {
        $this->addSql('ALTER TABLE comment ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void {
        $this->addSql('ALTER TABLE comment DROP created_at, DROP updated_at');
    }
}
