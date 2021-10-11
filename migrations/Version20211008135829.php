<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211008135829 extends AbstractMigration {
    public function getDescription(): string {
        return 'Removed is_admin field from user table';
    }

    public function up(Schema $schema): void {
        $this->addSql('ALTER TABLE user DROP is_admin');
    }

    public function down(Schema $schema): void {
        $this->addSql('ALTER TABLE user ADD is_admin TINYINT(1) NOT NULL');
    }
}
