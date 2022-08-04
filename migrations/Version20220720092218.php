<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220720092218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offers ADD fk_company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offers ADD CONSTRAINT FK_DA46042767F5D045 FOREIGN KEY (fk_company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_DA46042767F5D045 ON offers (fk_company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offers DROP FOREIGN KEY FK_DA46042767F5D045');
        $this->addSql('DROP INDEX IDX_DA46042767F5D045 ON offers');
        $this->addSql('ALTER TABLE offers DROP fk_company_id');
    }
}
