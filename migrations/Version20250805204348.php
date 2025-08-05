<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250805204348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_item ADD stock_movement_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_item ADD CONSTRAINT FK_6017DDAFD50D693 FOREIGN KEY (stock_movement_id) REFERENCES stock_movement (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6017DDAFD50D693 ON stock_item (stock_movement_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_item DROP FOREIGN KEY FK_6017DDAFD50D693
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_6017DDAFD50D693 ON stock_item
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_item DROP stock_movement_id
        SQL);
    }
}
