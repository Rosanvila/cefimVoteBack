<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240822095923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE result (id INT AUTO_INCREMENT NOT NULL, principal VARCHAR(255) NOT NULL, secondary VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD password VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE session ADD session_admin_id INT DEFAULT NULL, ADD session_result_id INT DEFAULT NULL, ADD heure_debut DATETIME NOT NULL, ADD heure_fin DATETIME NOT NULL, ADD date DATE NOT NULL, ADD responsible VARCHAR(255) NOT NULL, ADD signature VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4EF87E278 FOREIGN KEY (session_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D44445F349 FOREIGN KEY (session_result_id) REFERENCES result (id)');
        $this->addSql('CREATE INDEX IDX_D044D5D4EF87E278 ON session (session_admin_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D044D5D44445F349 ON session (session_result_id)');
        $this->addSql('ALTER TABLE user ADD users_session_id INT DEFAULT NULL, DROP session_id');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B654434B FOREIGN KEY (users_session_id) REFERENCES session (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649B654434B ON user (users_session_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D44445F349');
        $this->addSql('DROP TABLE result');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4EF87E278');
        $this->addSql('DROP INDEX IDX_D044D5D4EF87E278 ON session');
        $this->addSql('DROP INDEX UNIQ_D044D5D44445F349 ON session');
        $this->addSql('ALTER TABLE session DROP session_admin_id, DROP session_result_id, DROP heure_debut, DROP heure_fin, DROP date, DROP responsible, DROP signature');
        $this->addSql('ALTER TABLE admin DROP password, CHANGE email email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B654434B');
        $this->addSql('DROP INDEX IDX_8D93D649B654434B ON user');
        $this->addSql('ALTER TABLE user ADD session_id INT NOT NULL, DROP users_session_id');
    }
}
