<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210929130100 extends AbstractMigration {
    public function getDescription(): string {
        return 'Added created at and updated at fields to media and tricks table';
    }

    public function up(Schema $schema): void {
        $this->addSql('ALTER TABLE media ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE tricks ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void {
        $this->addSql('ALTER TABLE media DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE tricks DROP created_at, DROP updated_at');
    }
}
