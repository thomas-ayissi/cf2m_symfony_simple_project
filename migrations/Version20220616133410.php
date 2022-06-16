<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220616133410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE the_articles ADD useriduser_id INT NOT NULL');
        $this->addSql('ALTER TABLE the_articles ADD CONSTRAINT FK_F654A40BB627209B FOREIGN KEY (useriduser_id) REFERENCES the_users (id)');
        $this->addSql('CREATE INDEX IDX_F654A40BB627209B ON the_articles (useriduser_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE the_articles DROP FOREIGN KEY FK_F654A40BB627209B');
        $this->addSql('DROP INDEX IDX_F654A40BB627209B ON the_articles');
        $this->addSql('ALTER TABLE the_articles DROP useriduser_id');
    }
}
