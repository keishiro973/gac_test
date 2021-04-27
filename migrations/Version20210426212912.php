<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210426212912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create database';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE abonne (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, abonne_id_id INT NOT NULL, reference VARCHAR(255) NOT NULL, event_date DATE NOT NULL, event_time TIME NOT NULL, duree_reel TIME DEFAULT NULL, volume_reel DOUBLE PRECISION DEFAULT NULL, duree_facture TIME DEFAULT NULL, volume_facture DOUBLE PRECISION DEFAULT NULL, type_facture VARCHAR(255) NOT NULL, INDEX IDX_FE8664102C86CE99 (abonne_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664102C86CE99 FOREIGN KEY (abonne_id_id) REFERENCES abonne (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664102C86CE99');
        $this->addSql('DROP TABLE abonne');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE facture');
    }
}
