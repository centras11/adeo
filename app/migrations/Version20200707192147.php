<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200707192147 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_product (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, sku VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_to_weather (product_id INT NOT NULL, weather_condition_id INT NOT NULL, INDEX IDX_512FB1B04584665A (product_id), INDEX IDX_512FB1B086C2CF78 (weather_condition_id), PRIMARY KEY(product_id, weather_condition_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_weather_condition (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_to_weather ADD CONSTRAINT FK_512FB1B04584665A FOREIGN KEY (product_id) REFERENCES product_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_to_weather ADD CONSTRAINT FK_512FB1B086C2CF78 FOREIGN KEY (weather_condition_id) REFERENCES product_weather_condition (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_to_weather DROP FOREIGN KEY FK_512FB1B04584665A');
        $this->addSql('ALTER TABLE product_to_weather DROP FOREIGN KEY FK_512FB1B086C2CF78');
        $this->addSql('DROP TABLE product_product');
        $this->addSql('DROP TABLE product_to_weather');
        $this->addSql('DROP TABLE product_weather_condition');
    }
}
