<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210311185512 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE beer ADD tier_id INT DEFAULT NULL, ADD description VARCHAR(2048) NOT NULL, DROP color');
        $this->addSql('ALTER TABLE beer ADD CONSTRAINT FK_58F666ADA354F9DC FOREIGN KEY (tier_id) REFERENCES `rank` (id)');
        $this->addSql('CREATE INDEX IDX_58F666ADA354F9DC ON beer (tier_id)');
        $this->addSql('ALTER TABLE `rank` DROP FOREIGN KEY FK_8879E8E5D0989053');
        $this->addSql('DROP INDEX IDX_8879E8E5D0989053 ON `rank`');
        $this->addSql('ALTER TABLE `rank` DROP beer_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE beer DROP FOREIGN KEY FK_58F666ADA354F9DC');
        $this->addSql('DROP INDEX IDX_58F666ADA354F9DC ON beer');
        $this->addSql('ALTER TABLE beer ADD color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP tier_id, DROP description');
        $this->addSql('ALTER TABLE `rank` ADD beer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `rank` ADD CONSTRAINT FK_8879E8E5D0989053 FOREIGN KEY (beer_id) REFERENCES beer (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8879E8E5D0989053 ON `rank` (beer_id)');
    }
}
