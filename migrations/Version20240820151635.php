<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240820151635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session CHANGE session_admin_id session_admin_id INT DEFAULT NULL, CHANGE session_result_id session_result_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE users_session_id users_session_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session CHANGE session_admin_id session_admin_id INT NOT NULL, CHANGE session_result_id session_result_id INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE users_session_id users_session_id INT NOT NULL');
    }
}
