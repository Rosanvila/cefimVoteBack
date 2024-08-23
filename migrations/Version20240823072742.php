<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240823072742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote ADD votes_result_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085642DF170B6 FOREIGN KEY (votes_result_id) REFERENCES result (id)');
        $this->addSql('CREATE INDEX IDX_5A1085642DF170B6 ON vote (votes_result_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085642DF170B6');
        $this->addSql('DROP INDEX IDX_5A1085642DF170B6 ON vote');
        $this->addSql('ALTER TABLE vote DROP votes_result_id');
    }
}
