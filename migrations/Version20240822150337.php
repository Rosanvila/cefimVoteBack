<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240822150337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delegues ADD delegue_session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE delegues ADD CONSTRAINT FK_E3A4FF1374209293 FOREIGN KEY (delegue_session_id) REFERENCES session (id)');
        $this->addSql('CREATE INDEX IDX_E3A4FF1374209293 ON delegues (delegue_session_id)');
        $this->addSql('ALTER TABLE result ADD principal VARCHAR(255) NOT NULL, ADD secondary VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE session ADD result_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D47A7B643 FOREIGN KEY (result_id) REFERENCES result (id)');
        $this->addSql('CREATE INDEX IDX_D044D5D47A7B643 ON session (result_id)');
        $this->addSql('ALTER TABLE user DROP has_voted');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D47A7B643');
        $this->addSql('DROP INDEX IDX_D044D5D47A7B643 ON session');
        $this->addSql('ALTER TABLE session DROP result_id');
        $this->addSql('ALTER TABLE result DROP principal, DROP secondary');
        $this->addSql('ALTER TABLE delegues DROP FOREIGN KEY FK_E3A4FF1374209293');
        $this->addSql('DROP INDEX IDX_E3A4FF1374209293 ON delegues');
        $this->addSql('ALTER TABLE delegues DROP delegue_session_id');
        $this->addSql('ALTER TABLE user ADD has_voted TINYINT(1) DEFAULT NULL');
    }
}
