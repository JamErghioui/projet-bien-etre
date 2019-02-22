<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190222155219 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, highlight TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, validity TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zip_code (id INT AUTO_INCREMENT NOT NULL, number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, banned TINYINT(1) NOT NULL, email VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', sub_date DATE NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, confirm_token VARCHAR(255) DEFAULT NULL, user_type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendor (id INT NOT NULL, district_id INT DEFAULT NULL, zipcode_id INT DEFAULT NULL, locality_id INT DEFAULT NULL, contact_mail VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, vat VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, door_number VARCHAR(255) DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, is_visible TINYINT(1) NOT NULL, INDEX IDX_F52233F6B08FA272 (district_id), INDEX IDX_F52233F6E4C7FA21 (zipcode_id), INDEX IDX_F52233F688823A92 (locality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendor_category (vendor_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_DB5F1230F603EE73 (vendor_id), INDEX IDX_DB5F123012469DE2 (category_id), PRIMARY KEY(vendor_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locality (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, vendor_id INT NOT NULL, internaut_id INT NOT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_9474526CF603EE73 (vendor_id), INDEX IDX_9474526C9FE1F53D (internaut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, vendor_id INT NOT NULL, show_date_begin DATETIME NOT NULL, show_date_end DATETIME NOT NULL, date_begin DATETIME NOT NULL, date_end DATETIME NOT NULL, description VARCHAR(255) NOT NULL, info VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, INDEX IDX_C27C9369F603EE73 (vendor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE internaut (id INT NOT NULL, news_letter TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE district (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vendor ADD CONSTRAINT FK_F52233F6B08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
        $this->addSql('ALTER TABLE vendor ADD CONSTRAINT FK_F52233F6E4C7FA21 FOREIGN KEY (zipcode_id) REFERENCES zip_code (id)');
        $this->addSql('ALTER TABLE vendor ADD CONSTRAINT FK_F52233F688823A92 FOREIGN KEY (locality_id) REFERENCES locality (id)');
        $this->addSql('ALTER TABLE vendor ADD CONSTRAINT FK_F52233F6BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vendor_category ADD CONSTRAINT FK_DB5F1230F603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vendor_category ADD CONSTRAINT FK_DB5F123012469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9FE1F53D FOREIGN KEY (internaut_id) REFERENCES internaut (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369F603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)');
        $this->addSql('ALTER TABLE internaut ADD CONSTRAINT FK_87685117BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vendor_category DROP FOREIGN KEY FK_DB5F123012469DE2');
        $this->addSql('ALTER TABLE vendor DROP FOREIGN KEY FK_F52233F6E4C7FA21');
        $this->addSql('ALTER TABLE vendor DROP FOREIGN KEY FK_F52233F6BF396750');
        $this->addSql('ALTER TABLE internaut DROP FOREIGN KEY FK_87685117BF396750');
        $this->addSql('ALTER TABLE vendor_category DROP FOREIGN KEY FK_DB5F1230F603EE73');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF603EE73');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369F603EE73');
        $this->addSql('ALTER TABLE vendor DROP FOREIGN KEY FK_F52233F688823A92');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9FE1F53D');
        $this->addSql('ALTER TABLE vendor DROP FOREIGN KEY FK_F52233F6B08FA272');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE zip_code');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vendor');
        $this->addSql('DROP TABLE vendor_category');
        $this->addSql('DROP TABLE locality');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE internaut');
        $this->addSql('DROP TABLE district');
    }
}
