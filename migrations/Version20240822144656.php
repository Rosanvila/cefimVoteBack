<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240822144656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delegues ADD delegues_votes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE delegues ADD CONSTRAINT FK_E3A4FF13EDFA7CAB FOREIGN KEY (delegues_votes_id) REFERENCES vote (id)');
        $this->addSql('CREATE INDEX IDX_E3A4FF13EDFA7CAB ON delegues (delegues_votes_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delegues DROP FOREIGN KEY FK_E3A4FF13EDFA7CAB');
        $this->addSql('DROP INDEX IDX_E3A4FF13EDFA7CAB ON delegues');
        $this->addSql('ALTER TABLE delegues DROP delegues_votes_id');
    }
}
