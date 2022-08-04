<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220712150958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidates ADD offers_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidates ADD CONSTRAINT FK_6A77F80CA090B42E FOREIGN KEY (offers_id) REFERENCES offers (id)');
        $this->addSql('CREATE INDEX IDX_6A77F80CA090B42E ON candidates (offers_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidates DROP FOREIGN KEY FK_6A77F80CA090B42E');
        $this->addSql('DROP INDEX IDX_6A77F80CA090B42E ON candidates');
        $this->addSql('ALTER TABLE candidates DROP offers_id');
    }
}
