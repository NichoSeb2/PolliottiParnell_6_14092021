<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220105122058 extends AbstractMigration {
    public function getDescription(): string {
        return 'Removed nullable from description field';
    }

    public function up(Schema $schema): void {
        $this->addSql('ALTER TABLE trick CHANGE description description LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void {
        $this->addSql('ALTER TABLE trick CHANGE description description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
