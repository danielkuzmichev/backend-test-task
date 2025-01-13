<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250112204455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates tables for products, coupons, and tax rates, and inserts initial data.';
    }

    public function up(Schema $schema): void
    {
        // Creating sequences and tables
        $this->addSql('CREATE SEQUENCE coupon_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE coupon (id INT NOT NULL, code VARCHAR(50) NOT NULL, discount_type VARCHAR(255) NOT NULL, discount_value NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64BF3F0277153098 ON coupon (code)');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tax_rate (id VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, rate NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id))');

        // Inserting initial data into tables
        $this->addSql("INSERT INTO product (id, name, price) VALUES (nextval('product_id_seq'), 'Iphone', 100.00)");
        $this->addSql("INSERT INTO product (id, name, price) VALUES (nextval('product_id_seq'), 'Наушники', 20.00)");
        $this->addSql("INSERT INTO product (id, name, price) VALUES (nextval('product_id_seq'), 'Чехол', 10.00)");

        $this->addSql("INSERT INTO coupon (id, code, discount_type, discount_value) VALUES (nextval('coupon_id_seq'), 'P10', 'percentage', 10.00)");
        $this->addSql("INSERT INTO coupon (id, code, discount_type, discount_value) VALUES (nextval('coupon_id_seq'), 'P100', 'percentage', 6.00)");

        $this->addSql("INSERT INTO tax_rate (id, country, rate) VALUES ('DE123456789', 'Германия', 19.00)");
        $this->addSql("INSERT INTO tax_rate (id, country, rate) VALUES ('IT12345678901', 'Италия', 22.00)");
        $this->addSql("INSERT INTO tax_rate (id, country, rate) VALUES ('FRAA123456789', 'Франция', 20.00)");
        $this->addSql("INSERT INTO tax_rate (id, country, rate) VALUES ('GR123456789', 'Греция', 24.00)");
    }

    public function down(Schema $schema): void
    {
        // Dropping sequences and tables
        $this->addSql('DROP SEQUENCE coupon_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP TABLE coupon');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE tax_rate');
    }
}
