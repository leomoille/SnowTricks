<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220401095405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trick ADD trick_category_id INT NOT NULL');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91E9C71FA8B FOREIGN KEY (trick_category_id) REFERENCES trick_category (id)');
        $this->addSql('CREATE INDEX IDX_D8F0A91E9C71FA8B ON trick (trick_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91E9C71FA8B');
        $this->addSql('DROP INDEX IDX_D8F0A91E9C71FA8B ON trick');
        $this->addSql('ALTER TABLE trick DROP trick_category_id');
    }
}
