<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211005082627 extends AbstractMigration {
    public function getDescription(): string {
        return 'Added is_admin field to user table';
    }

    public function up(Schema $schema): void {
        $this->addSql('ALTER TABLE user ADD is_admin TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void {
        $this->addSql('ALTER TABLE user DROP is_admin');
    }
}
