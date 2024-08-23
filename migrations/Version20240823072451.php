<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240823072451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE result ADD result_session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC1139964E600 FOREIGN KEY (result_session_id) REFERENCES session (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_136AC1139964E600 ON result (result_session_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC1139964E600');
        $this->addSql('DROP INDEX UNIQ_136AC1139964E600 ON result');
        $this->addSql('ALTER TABLE result DROP result_session_id');
    }
}
