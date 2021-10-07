<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211006124203 extends AbstractMigration {
    public function getDescription(): string {
        return 'Added status field to comment table';
    }

    public function up(Schema $schema): void {
        $this->addSql('ALTER TABLE comment ADD status TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void {
        $this->addSql('ALTER TABLE comment DROP status');
    }
}
