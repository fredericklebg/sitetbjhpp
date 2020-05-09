<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200508214547 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE achat ADD nb_jetons_id INT NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A984568C5ABD6B FOREIGN KEY (nb_jetons_id) REFERENCES pack_jetons (id)');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_26A984568C5ABD6B ON achat (nb_jetons_id)');
        $this->addSql('CREATE INDEX IDX_26A98456A76ED395 ON achat (user_id)');
        $this->addSql('ALTER TABLE enchere CHANGE produit_id produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE historique_encheres CHANGE user_id user_id INT DEFAULT NULL, CHANGE enchere_id enchere_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A984568C5ABD6B');
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A98456A76ED395');
        $this->addSql('DROP INDEX IDX_26A984568C5ABD6B ON achat');
        $this->addSql('DROP INDEX IDX_26A98456A76ED395 ON achat');
        $this->addSql('ALTER TABLE achat DROP nb_jetons_id, DROP user_id');
        $this->addSql('ALTER TABLE enchere CHANGE produit_id produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE historique_encheres CHANGE user_id user_id INT DEFAULT NULL, CHANGE enchere_id enchere_id INT DEFAULT NULL');
    }
}
