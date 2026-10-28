<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261028163305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lieu (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) NOT NULL, quartier VARCHAR(255) DEFAULT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE oeuvre (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, description LONGTEXT NOT NULL, est_detruite TINYINT NOT NULL, id_lieu_id INT DEFAULT NULL, id_oeuvre_recouverte_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_35FE2EFEE60C9234 (id_oeuvre_recouverte_id), INDEX IDX_35FE2EFEB42FBABC (id_lieu_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE oeuvre_artiste (oeuvre_id INT NOT NULL, artiste_id INT NOT NULL, INDEX IDX_DB75DF1488194DE8 (oeuvre_id), INDEX IDX_DB75DF1421D25844 (artiste_id), PRIMARY KEY (oeuvre_id, artiste_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE oeuvre_technique (oeuvre_id INT NOT NULL, technique_id INT NOT NULL, INDEX IDX_CEAB50CA88194DE8 (oeuvre_id), INDEX IDX_CEAB50CA1F8ACB26 (technique_id), PRIMARY KEY (oeuvre_id, technique_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, date_prise_vue DATE NOT NULL, nom_fichier VARCHAR(255) NOT NULL, etat_oeuvre LONGTEXT NOT NULL, id_oeuvre_id INT NOT NULL, id_benevole_id INT NOT NULL, INDEX IDX_14B7841882CF1CF (id_oeuvre_id), INDEX IDX_14B78418FF69B1FE (id_benevole_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFEB42FBABC FOREIGN KEY (id_lieu_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFEE60C9234 FOREIGN KEY (id_oeuvre_recouverte_id) REFERENCES oeuvre (id)');
        $this->addSql('ALTER TABLE oeuvre_artiste ADD CONSTRAINT FK_DB75DF1488194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvre_artiste ADD CONSTRAINT FK_DB75DF1421D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvre_technique ADD CONSTRAINT FK_CEAB50CA88194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvre_technique ADD CONSTRAINT FK_CEAB50CA1F8ACB26 FOREIGN KEY (technique_id) REFERENCES technique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B7841882CF1CF FOREIGN KEY (id_oeuvre_id) REFERENCES oeuvre (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418FF69B1FE FOREIGN KEY (id_benevole_id) REFERENCES benevole (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFEB42FBABC');
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFEE60C9234');
        $this->addSql('ALTER TABLE oeuvre_artiste DROP FOREIGN KEY FK_DB75DF1488194DE8');
        $this->addSql('ALTER TABLE oeuvre_artiste DROP FOREIGN KEY FK_DB75DF1421D25844');
        $this->addSql('ALTER TABLE oeuvre_technique DROP FOREIGN KEY FK_CEAB50CA88194DE8');
        $this->addSql('ALTER TABLE oeuvre_technique DROP FOREIGN KEY FK_CEAB50CA1F8ACB26');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B7841882CF1CF');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418FF69B1FE');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE oeuvre');
        $this->addSql('DROP TABLE oeuvre_artiste');
        $this->addSql('DROP TABLE oeuvre_technique');
        $this->addSql('DROP TABLE photo');
    }
}
