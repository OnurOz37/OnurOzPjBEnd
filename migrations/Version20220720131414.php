<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220720131414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company ADD fk_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F5741EEB9 FOREIGN KEY (fk_user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094F5741EEB9 ON company (fk_user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64967F5D045');
        $this->addSql('DROP INDEX UNIQ_8D93D64967F5D045 ON user');
        $this->addSql('ALTER TABLE user DROP fk_company_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F5741EEB9');
        $this->addSql('DROP INDEX UNIQ_4FBF094F5741EEB9 ON company');
        $this->addSql('ALTER TABLE company DROP fk_user_id');
        $this->addSql('ALTER TABLE `user` ADD fk_company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64967F5D045 FOREIGN KEY (fk_company_id) REFERENCES company (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64967F5D045 ON `user` (fk_company_id)');
    }
}
