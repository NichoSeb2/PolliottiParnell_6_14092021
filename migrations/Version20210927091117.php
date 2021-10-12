<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210927091117 extends AbstractMigration {
    public function getDescription(): string {
        return 'Added email field to user table';
    }

    public function up(Schema $schema): void {
        $this->addSql('ALTER TABLE user ADD email VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void {
        $this->addSql('ALTER TABLE user DROP email');
    }
}
