<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190109165038 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, highlight TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, validity TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zip_code (id INT AUTO_INCREMENT NOT NULL, district_id INT NOT NULL, number INT NOT NULL, INDEX IDX_A1ACE158B08FA272 (district_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, district_id INT NOT NULL, zipcode_id INT NOT NULL, locality_id INT NOT NULL, door_number VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, banned TINYINT(1) NOT NULL, email VARCHAR(255) NOT NULL, sub_conf TINYINT(1) NOT NULL, sub_date DATE NOT NULL, password VARCHAR(255) NOT NULL, user_type VARCHAR(255) NOT NULL, INDEX IDX_8D93D649B08FA272 (district_id), INDEX IDX_8D93D649E4C7FA21 (zipcode_id), INDEX IDX_8D93D64988823A92 (locality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendor (id INT NOT NULL, contact_mail VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, vat VARCHAR(255) NOT NULL, website VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendor_category (vendor_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_DB5F1230F603EE73 (vendor_id), INDEX IDX_DB5F123012469DE2 (category_id), PRIMARY KEY(vendor_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locality (id INT AUTO_INCREMENT NOT NULL, zipcode_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E1D6B8E6E4C7FA21 (zipcode_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE district (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE zip_code ADD CONSTRAINT FK_A1ACE158B08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E4C7FA21 FOREIGN KEY (zipcode_id) REFERENCES zip_code (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64988823A92 FOREIGN KEY (locality_id) REFERENCES locality (id)');
        $this->addSql('ALTER TABLE vendor ADD CONSTRAINT FK_F52233F6BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vendor_category ADD CONSTRAINT FK_DB5F1230F603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vendor_category ADD CONSTRAINT FK_DB5F123012469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE locality ADD CONSTRAINT FK_E1D6B8E6E4C7FA21 FOREIGN KEY (zipcode_id) REFERENCES zip_code (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vendor_category DROP FOREIGN KEY FK_DB5F123012469DE2');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E4C7FA21');
        $this->addSql('ALTER TABLE locality DROP FOREIGN KEY FK_E1D6B8E6E4C7FA21');
        $this->addSql('ALTER TABLE vendor DROP FOREIGN KEY FK_F52233F6BF396750');
        $this->addSql('ALTER TABLE vendor_category DROP FOREIGN KEY FK_DB5F1230F603EE73');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64988823A92');
        $this->addSql('ALTER TABLE zip_code DROP FOREIGN KEY FK_A1ACE158B08FA272');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B08FA272');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE zip_code');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vendor');
        $this->addSql('DROP TABLE vendor_category');
        $this->addSql('DROP TABLE locality');
        $this->addSql('DROP TABLE district');
    }
}
