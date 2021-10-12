<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211011140149 extends AbstractMigration {
    public function getDescription(): string {
        return 'Added category table, added contributors relation';
    }

    public function up(Schema $schema): void {
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_user (trick_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C320E5F9B281BE2E (trick_id), INDEX IDX_C320E5F9A76ED395 (user_id), PRIMARY KEY(trick_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trick_user ADD CONSTRAINT FK_C320E5F9B281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trick_user ADD CONSTRAINT FK_C320E5F9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trick ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D8F0A91E12469DE2 ON trick (category_id)');
    }

    public function down(Schema $schema): void {
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91E12469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE trick_user');
        $this->addSql('DROP INDEX IDX_D8F0A91E12469DE2 ON trick');
        $this->addSql('ALTER TABLE trick DROP category_id');
    }
}
