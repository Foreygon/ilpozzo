<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230206093149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE upload (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, paths VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lacarte ADD upload_image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lacarte ADD CONSTRAINT FK_6E242DF07AD2DD08 FOREIGN KEY (upload_image_id) REFERENCES upload (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6E242DF07AD2DD08 ON lacarte (upload_image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lacarte DROP FOREIGN KEY FK_6E242DF07AD2DD08');
        $this->addSql('DROP TABLE upload');
        $this->addSql('DROP INDEX UNIQ_6E242DF07AD2DD08 ON lacarte');
        $this->addSql('ALTER TABLE lacarte DROP upload_image_id');
    }
}
