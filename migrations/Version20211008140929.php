<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211008140929 extends AbstractMigration {
    public function getDescription(): string {
        return 'Renamed tricks table to trick';
    }

    public function up(Schema $schema): void {
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C3B153154');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C3B153154');
        $this->addSql('CREATE TABLE trick (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D8F0A91EF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91EF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE tricks');
        $this->addSql('DROP INDEX IDX_9474526C3B153154 ON comment');
        $this->addSql('ALTER TABLE comment CHANGE tricks_id trick_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('CREATE INDEX IDX_9474526CB281BE2E ON comment (trick_id)');
        $this->addSql('DROP INDEX IDX_6A2CA10C3B153154 ON media');
        $this->addSql('ALTER TABLE media CHANGE tricks_id trick_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10CB281BE2E ON media (trick_id)');
    }

    public function down(Schema $schema): void {
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CB281BE2E');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CB281BE2E');
        $this->addSql('CREATE TABLE tricks (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E1D902C1F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tricks ADD CONSTRAINT FK_E1D902C1F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE trick');
        $this->addSql('DROP INDEX IDX_9474526CB281BE2E ON comment');
        $this->addSql('ALTER TABLE comment CHANGE trick_id tricks_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C3B153154 FOREIGN KEY (tricks_id) REFERENCES tricks (id)');
        $this->addSql('CREATE INDEX IDX_9474526C3B153154 ON comment (tricks_id)');
        $this->addSql('DROP INDEX IDX_6A2CA10CB281BE2E ON media');
        $this->addSql('ALTER TABLE media CHANGE trick_id tricks_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C3B153154 FOREIGN KEY (tricks_id) REFERENCES tricks (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C3B153154 ON media (tricks_id)');
    }
}
