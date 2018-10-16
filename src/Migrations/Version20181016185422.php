<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181016185422 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE postal (id INT AUTO_INCREMENT NOT NULL, postal_code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE town (id INT AUTO_INCREMENT NOT NULL, town_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendor (id INT AUTO_INCREMENT NOT NULL, contact_mail VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, vat VARCHAR(255) NOT NULL, website VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, postal_code_id INT NOT NULL, locality_name_id INT NOT NULL, town_name_id INT NOT NULL, door_number VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, banned TINYINT(1) NOT NULL, email VARCHAR(255) NOT NULL, sub_conf TINYINT(1) NOT NULL, sub_date DATE NOT NULL, password VARCHAR(255) NOT NULL, user_type VARCHAR(255) NOT NULL, INDEX IDX_8D93D649BDBA6A61 (postal_code_id), INDEX IDX_8D93D64982A941D7 (locality_name_id), INDEX IDX_8D93D6497FFC780F (town_name_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locality (id INT AUTO_INCREMENT NOT NULL, locality_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BDBA6A61 FOREIGN KEY (postal_code_id) REFERENCES postal (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64982A941D7 FOREIGN KEY (locality_name_id) REFERENCES locality (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497FFC780F FOREIGN KEY (town_name_id) REFERENCES town (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BDBA6A61');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497FFC780F');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64982A941D7');
        $this->addSql('DROP TABLE postal');
        $this->addSql('DROP TABLE town');
        $this->addSql('DROP TABLE vendor');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE locality');
    }
}
