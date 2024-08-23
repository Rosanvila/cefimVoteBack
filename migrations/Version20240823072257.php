<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240823072257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D44445F349');
        $this->addSql('DROP INDEX UNIQ_D044D5D44445F349 ON session');
        $this->addSql('ALTER TABLE session DROP session_result_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session ADD session_result_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D44445F349 FOREIGN KEY (session_result_id) REFERENCES result (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D044D5D44445F349 ON session (session_result_id)');
    }
}
