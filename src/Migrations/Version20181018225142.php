<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181018225142 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP user_type');
        $this->addSql('ALTER TABLE vendor DROP door_number, DROP street, DROP banned, DROP email, DROP sub_conf, DROP sub_date, DROP password, DROP user_type');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD user_type VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE vendor ADD door_number VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD street VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD banned TINYINT(1) NOT NULL, ADD email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD sub_conf TINYINT(1) NOT NULL, ADD sub_date DATE NOT NULL, ADD password VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD user_type VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
