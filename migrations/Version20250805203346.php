<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250805203346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE stock_item (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, total_price DOUBLE PRECISION NOT NULL, INDEX IDX_6017DDA4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE stock_movement (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, comment VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_item ADD CONSTRAINT FK_6017DDA4584665A FOREIGN KEY (product_id) REFERENCES product (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_item DROP FOREIGN KEY FK_6017DDA4584665A
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stock_item
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stock_movement
        SQL);
    }
}
