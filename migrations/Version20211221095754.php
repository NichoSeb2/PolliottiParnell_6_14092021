<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211221095754 extends AbstractMigration {
    public function getDescription(): string {
        return 'Added the possibility to be null to the cover_image field';
    }

    public function up(Schema $schema): void {
        $this->addSql('ALTER TABLE trick CHANGE cover_image_id cover_image_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void {
        $this->addSql('ALTER TABLE trick CHANGE cover_image_id cover_image_id INT NOT NULL');
    }
}
