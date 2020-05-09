<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200508150444 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE achat (id INT AUTO_INCREMENT NOT NULL, date_achat DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique_encheres (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, enchere_id INT DEFAULT NULL, date_enchere DATETIME NOT NULL, prix INT NOT NULL, INDEX IDX_4B517BEFA76ED395 (user_id), INDEX IDX_4B517BEFE80B6EFB (enchere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pack_jetons (id INT AUTO_INCREMENT NOT NULL, nb_jetons INT NOT NULL, description VARCHAR(50) NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, niveau INT NOT NULL, description VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historique_encheres ADD CONSTRAINT FK_4B517BEFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE historique_encheres ADD CONSTRAINT FK_4B517BEFE80B6EFB FOREIGN KEY (enchere_id) REFERENCES enchere (id)');
        $this->addSql('ALTER TABLE enchere CHANGE produit_id produit_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE achat');
        $this->addSql('DROP TABLE historique_encheres');
        $this->addSql('DROP TABLE pack_jetons');
        $this->addSql('DROP TABLE role');
        $this->addSql('ALTER TABLE enchere CHANGE produit_id produit_id INT DEFAULT NULL');
    }
}
