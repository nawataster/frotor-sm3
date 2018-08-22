<?php declare(strict_types=1);

namespace AppBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180822055251 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE faucets CHANGE duration duration INT DEFAULT 1800 NOT NULL, CHANGE until until DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated updated DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE priority priority INT DEFAULT 1 NOT NULL, CHANGE ban_until ban_until DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE faucets CHANGE duration duration INT NOT NULL, CHANGE until until DATETIME NOT NULL, CHANGE updated updated DATETIME DEFAULT NULL, CHANGE priority priority INT NOT NULL, CHANGE ban_until ban_until DATETIME NOT NULL');
    }
}
