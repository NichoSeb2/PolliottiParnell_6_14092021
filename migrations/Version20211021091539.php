<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211021091539 extends AbstractMigration {
    public function getDescription(): string {
        return 'Added slug field to trick table';
    }

    public function up(Schema $schema): void {
        $this->addSql('ALTER TABLE trick ADD slug VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void {
        $this->addSql('ALTER TABLE trick DROP slug');
    }
}
