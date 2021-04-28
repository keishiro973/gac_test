<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210428220629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664102C86CE99');
        $this->addSql('DROP INDEX IDX_FE8664102C86CE99 ON facture');
        $this->addSql('ALTER TABLE facture ADD compte_id INT DEFAULT NULL, CHANGE abonne_id_id abonne_id INT NOT NULL');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410C325A696 FOREIGN KEY (abonne_id) REFERENCES abonne (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
        $this->addSql('CREATE INDEX IDX_FE866410C325A696 ON facture (abonne_id)');
        $this->addSql('CREATE INDEX IDX_FE866410F2C56620 ON facture (compte_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410C325A696');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410F2C56620');
        $this->addSql('DROP INDEX IDX_FE866410C325A696 ON facture');
        $this->addSql('DROP INDEX IDX_FE866410F2C56620 ON facture');
        $this->addSql('ALTER TABLE facture DROP compte_id, CHANGE abonne_id abonne_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664102C86CE99 FOREIGN KEY (abonne_id_id) REFERENCES abonne (id)');
        $this->addSql('CREATE INDEX IDX_FE8664102C86CE99 ON facture (abonne_id_id)');
    }
}
