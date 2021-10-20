<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211015095517 extends AbstractMigration {
    public function getDescription(): string {
        return 'Added cover_image field to trick table';
    }

    public function up(Schema $schema): void {
        $this->addSql('ALTER TABLE trick ADD cover_image_id INT NOT NULL');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91EE5A0E336 FOREIGN KEY (cover_image_id) REFERENCES media (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8F0A91EE5A0E336 ON trick (cover_image_id)');
    }

    public function down(Schema $schema): void {
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91EE5A0E336');
        $this->addSql('DROP INDEX UNIQ_D8F0A91EE5A0E336 ON trick');
        $this->addSql('ALTER TABLE trick DROP cover_image_id');
    }
}
