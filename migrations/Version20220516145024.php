<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516145024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, payed_by_id INT DEFAULT NULL, price INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, stripe_session_id VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6D28840D816F52CD (payed_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D816F52CD FOREIGN KEY (payed_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F12469DE2');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE payment');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F12469DE2');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE SET NULL');
    }
}
