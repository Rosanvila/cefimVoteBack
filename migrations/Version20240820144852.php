<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240820144852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4EF87E278 FOREIGN KEY (session_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D44445F349 FOREIGN KEY (session_result_id) REFERENCES result (id)');
        $this->addSql('CREATE INDEX IDX_D044D5D4EF87E278 ON session (session_admin_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D044D5D44445F349 ON session (session_result_id)');
        $this->addSql('ALTER TABLE user ADD users_session_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B654434B FOREIGN KEY (users_session_id) REFERENCES session (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649B654434B ON user (users_session_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4EF87E278');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D44445F349');
        $this->addSql('DROP INDEX IDX_D044D5D4EF87E278 ON session');
        $this->addSql('DROP INDEX UNIQ_D044D5D44445F349 ON session');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B654434B');
        $this->addSql('DROP INDEX IDX_8D93D649B654434B ON user');
        $this->addSql('ALTER TABLE user DROP users_session_id');
    }
}
