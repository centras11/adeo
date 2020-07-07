<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200707153601 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE weather_city (id INT AUTO_INCREMENT NOT NULL, city VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weather_forecast (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, forecast_time_utc DATETIME DEFAULT NULL, condition_code VARCHAR(20) DEFAULT NULL, INDEX IDX_CB36DFBF8BAC62AF (city_id), INDEX forecast_time_city_index (forecast_time_utc, city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE weather_forecast ADD CONSTRAINT FK_CB36DFBF8BAC62AF FOREIGN KEY (city_id) REFERENCES weather_city (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE weather_forecast DROP FOREIGN KEY FK_CB36DFBF8BAC62AF');
        $this->addSql('DROP TABLE weather_city');
        $this->addSql('DROP TABLE weather_forecast');
    }
}
