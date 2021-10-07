<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211007084507 extends AbstractMigration {
    public function getDescription(): string {
        return 'Added verification token and forgot password token to user table';
    }

    public function up(Schema $schema): void {
        $this->addSql('ALTER TABLE user ADD verification_token CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', ADD forgot_password_token CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\'');
    }

    public function down(Schema $schema): void {
        $this->addSql('ALTER TABLE user DROP verification_token, DROP forgot_password_token');
    }
}
