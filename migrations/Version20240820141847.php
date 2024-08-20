<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240820141847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin ADD password VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE session ADD heure_debut DATETIME NOT NULL, ADD heure_fin DATETIME NOT NULL, ADD date DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session DROP heure_debut, DROP heure_fin, DROP date');
        $this->addSql('ALTER TABLE admin DROP password, CHANGE email email VARCHAR(255) NOT NULL');
    }
}
