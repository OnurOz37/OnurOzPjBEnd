<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220805104145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidates (id INT AUTO_INCREMENT NOT NULL, offers_id INT DEFAULT NULL, firstname VARCHAR(150) NOT NULL, lastname VARCHAR(150) NOT NULL, phone INT NOT NULL, email VARCHAR(100) NOT NULL, cv VARCHAR(255) NOT NULL, INDEX IDX_6A77F80CA090B42E (offers_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, fk_user_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, logo VARCHAR(255) DEFAULT NULL, logo_color VARCHAR(255) NOT NULL, city VARCHAR(150) NOT NULL, website VARCHAR(100) NOT NULL, phone INT NOT NULL, UNIQUE INDEX UNIQ_4FBF094F5741EEB9 (fk_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offers (id INT AUTO_INCREMENT NOT NULL, fk_company_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, type VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, posted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', website VARCHAR(100) NOT NULL, requirements_item VARCHAR(255) NOT NULL, requirements_content VARCHAR(255) NOT NULL, role_item VARCHAR(255) NOT NULL, role_content VARCHAR(255) NOT NULL, INDEX IDX_DA46042767F5D045 (fk_company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(150) NOT NULL, login VARCHAR(150) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidates ADD CONSTRAINT FK_6A77F80CA090B42E FOREIGN KEY (offers_id) REFERENCES offers (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F5741EEB9 FOREIGN KEY (fk_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE offers ADD CONSTRAINT FK_DA46042767F5D045 FOREIGN KEY (fk_company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offers DROP FOREIGN KEY FK_DA46042767F5D045');
        $this->addSql('ALTER TABLE candidates DROP FOREIGN KEY FK_6A77F80CA090B42E');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F5741EEB9');
        $this->addSql('DROP TABLE candidates');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE offers');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
