<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200510111157 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE shopping_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE supplies_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE supply_alerts_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE alerts_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE alerts_types_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE quick_lists_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE quick_lists_positions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE products_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE stuffs_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE products_lists_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE position_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE shops_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE measures_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, user_type INT NOT NULL, fb_id BIGINT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE TABLE shopping (id INT NOT NULL, user_id INT NOT NULL, stuff_id INT DEFAULT NULL, product_id INT DEFAULT NULL, shop_id INT NOT NULL, measure_id INT NOT NULL, date DATE NOT NULL, price DOUBLE PRECISION NOT NULL, promotion BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FB45F439A76ED395 ON shopping (user_id)');
        $this->addSql('CREATE INDEX IDX_FB45F439950A1740 ON shopping (stuff_id)');
        $this->addSql('CREATE INDEX IDX_FB45F4394584665A ON shopping (product_id)');
        $this->addSql('CREATE INDEX IDX_FB45F4394D16C4DD ON shopping (shop_id)');
        $this->addSql('CREATE INDEX IDX_FB45F4395DA37D00 ON shopping (measure_id)');
        $this->addSql('CREATE TABLE supplies (id INT NOT NULL, product_id INT NOT NULL, measure_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EC2D5CE84584665A ON supplies (product_id)');
        $this->addSql('CREATE INDEX IDX_EC2D5CE85DA37D00 ON supplies (measure_id)');
        $this->addSql('CREATE TABLE supply_alerts (id INT NOT NULL, alert_id INT NOT NULL, supply_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_26A577DA93035F72 ON supply_alerts (alert_id)');
        $this->addSql('CREATE INDEX IDX_26A577DAFF28C0D8 ON supply_alerts (supply_id)');
        $this->addSql('CREATE TABLE alerts (id INT NOT NULL, user_id INT NOT NULL, type_id INT NOT NULL, description TEXT NOT NULL, is_active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F77AC06BA76ED395 ON alerts (user_id)');
        $this->addSql('CREATE INDEX IDX_F77AC06BC54C8C93 ON alerts (type_id)');
        $this->addSql('CREATE TABLE alerts_types (id INT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE quick_lists (id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_50822821A76ED395 ON quick_lists (user_id)');
        $this->addSql('CREATE TABLE quick_lists_positions (id INT NOT NULL, list_id INT NOT NULL, content VARCHAR(255) NOT NULL, checked BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_307E67243DAE168B ON quick_lists_positions (list_id)');
        $this->addSql('CREATE TABLE products (id INT NOT NULL, measure_id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A5DA37D00 ON products (measure_id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5AA76ED395 ON products (user_id)');
        $this->addSql('CREATE TABLE stuffs (id INT NOT NULL, product_id INT NOT NULL, measure_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DA3693584584665A ON stuffs (product_id)');
        $this->addSql('CREATE INDEX IDX_DA3693585DA37D00 ON stuffs (measure_id)');
        $this->addSql('CREATE TABLE products_lists (id INT NOT NULL, user_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(40) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E87F6175A76ED395 ON products_lists (user_id)');
        $this->addSql('CREATE TABLE position (id INT NOT NULL, product_id INT DEFAULT NULL, stuff_id INT DEFAULT NULL, measure_id INT NOT NULL, list_id INT NOT NULL, measure_value DOUBLE PRECISION NOT NULL, checked BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_462CE4F54584665A ON position (product_id)');
        $this->addSql('CREATE INDEX IDX_462CE4F5950A1740 ON position (stuff_id)');
        $this->addSql('CREATE INDEX IDX_462CE4F55DA37D00 ON position (measure_id)');
        $this->addSql('CREATE INDEX IDX_462CE4F53DAE168B ON position (list_id)');
        $this->addSql('CREATE TABLE position_alert (position_id INT NOT NULL, alert_id INT NOT NULL, PRIMARY KEY(position_id, alert_id))');
        $this->addSql('CREATE INDEX IDX_9B3DA21CDD842E46 ON position_alert (position_id)');
        $this->addSql('CREATE INDEX IDX_9B3DA21C93035F72 ON position_alert (alert_id)');
        $this->addSql('CREATE TABLE shops (id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(40) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_237A6783A76ED395 ON shops (user_id)');
        $this->addSql('CREATE TABLE measures (id INT NOT NULL, main_id INT DEFAULT NULL, user_id INT NOT NULL, name VARCHAR(30) NOT NULL, shortcut VARCHAR(10) NOT NULL, converter DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_508A1C55627EA78A ON measures (main_id)');
        $this->addSql('CREATE INDEX IDX_508A1C55A76ED395 ON measures (user_id)');
        $this->addSql('ALTER TABLE shopping ADD CONSTRAINT FK_FB45F439A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shopping ADD CONSTRAINT FK_FB45F439950A1740 FOREIGN KEY (stuff_id) REFERENCES stuffs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shopping ADD CONSTRAINT FK_FB45F4394584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shopping ADD CONSTRAINT FK_FB45F4394D16C4DD FOREIGN KEY (shop_id) REFERENCES shops (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shopping ADD CONSTRAINT FK_FB45F4395DA37D00 FOREIGN KEY (measure_id) REFERENCES measures (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE supplies ADD CONSTRAINT FK_EC2D5CE84584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE supplies ADD CONSTRAINT FK_EC2D5CE85DA37D00 FOREIGN KEY (measure_id) REFERENCES measures (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE supply_alerts ADD CONSTRAINT FK_26A577DA93035F72 FOREIGN KEY (alert_id) REFERENCES alerts (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE supply_alerts ADD CONSTRAINT FK_26A577DAFF28C0D8 FOREIGN KEY (supply_id) REFERENCES supplies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE alerts ADD CONSTRAINT FK_F77AC06BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE alerts ADD CONSTRAINT FK_F77AC06BC54C8C93 FOREIGN KEY (type_id) REFERENCES alerts_types (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quick_lists ADD CONSTRAINT FK_50822821A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quick_lists_positions ADD CONSTRAINT FK_307E67243DAE168B FOREIGN KEY (list_id) REFERENCES quick_lists (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A5DA37D00 FOREIGN KEY (measure_id) REFERENCES measures (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE stuffs ADD CONSTRAINT FK_DA3693584584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE stuffs ADD CONSTRAINT FK_DA3693585DA37D00 FOREIGN KEY (measure_id) REFERENCES measures (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products_lists ADD CONSTRAINT FK_E87F6175A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F54584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F5950A1740 FOREIGN KEY (stuff_id) REFERENCES stuffs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F55DA37D00 FOREIGN KEY (measure_id) REFERENCES measures (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F53DAE168B FOREIGN KEY (list_id) REFERENCES products_lists (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE position_alert ADD CONSTRAINT FK_9B3DA21CDD842E46 FOREIGN KEY (position_id) REFERENCES position (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE position_alert ADD CONSTRAINT FK_9B3DA21C93035F72 FOREIGN KEY (alert_id) REFERENCES alerts (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shops ADD CONSTRAINT FK_237A6783A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE measures ADD CONSTRAINT FK_508A1C55627EA78A FOREIGN KEY (main_id) REFERENCES measures (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE measures ADD CONSTRAINT FK_508A1C55A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE shopping DROP CONSTRAINT FK_FB45F439A76ED395');
        $this->addSql('ALTER TABLE alerts DROP CONSTRAINT FK_F77AC06BA76ED395');
        $this->addSql('ALTER TABLE quick_lists DROP CONSTRAINT FK_50822821A76ED395');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5AA76ED395');
        $this->addSql('ALTER TABLE products_lists DROP CONSTRAINT FK_E87F6175A76ED395');
        $this->addSql('ALTER TABLE shops DROP CONSTRAINT FK_237A6783A76ED395');
        $this->addSql('ALTER TABLE measures DROP CONSTRAINT FK_508A1C55A76ED395');
        $this->addSql('ALTER TABLE supply_alerts DROP CONSTRAINT FK_26A577DAFF28C0D8');
        $this->addSql('ALTER TABLE supply_alerts DROP CONSTRAINT FK_26A577DA93035F72');
        $this->addSql('ALTER TABLE position_alert DROP CONSTRAINT FK_9B3DA21C93035F72');
        $this->addSql('ALTER TABLE alerts DROP CONSTRAINT FK_F77AC06BC54C8C93');
        $this->addSql('ALTER TABLE quick_lists_positions DROP CONSTRAINT FK_307E67243DAE168B');
        $this->addSql('ALTER TABLE shopping DROP CONSTRAINT FK_FB45F4394584665A');
        $this->addSql('ALTER TABLE supplies DROP CONSTRAINT FK_EC2D5CE84584665A');
        $this->addSql('ALTER TABLE stuffs DROP CONSTRAINT FK_DA3693584584665A');
        $this->addSql('ALTER TABLE position DROP CONSTRAINT FK_462CE4F54584665A');
        $this->addSql('ALTER TABLE shopping DROP CONSTRAINT FK_FB45F439950A1740');
        $this->addSql('ALTER TABLE position DROP CONSTRAINT FK_462CE4F5950A1740');
        $this->addSql('ALTER TABLE position DROP CONSTRAINT FK_462CE4F53DAE168B');
        $this->addSql('ALTER TABLE position_alert DROP CONSTRAINT FK_9B3DA21CDD842E46');
        $this->addSql('ALTER TABLE shopping DROP CONSTRAINT FK_FB45F4394D16C4DD');
        $this->addSql('ALTER TABLE shopping DROP CONSTRAINT FK_FB45F4395DA37D00');
        $this->addSql('ALTER TABLE supplies DROP CONSTRAINT FK_EC2D5CE85DA37D00');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A5DA37D00');
        $this->addSql('ALTER TABLE stuffs DROP CONSTRAINT FK_DA3693585DA37D00');
        $this->addSql('ALTER TABLE position DROP CONSTRAINT FK_462CE4F55DA37D00');
        $this->addSql('ALTER TABLE measures DROP CONSTRAINT FK_508A1C55627EA78A');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE shopping_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE supplies_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE supply_alerts_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE alerts_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE alerts_types_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE quick_lists_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE quick_lists_positions_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE products_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE stuffs_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE products_lists_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE position_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE shops_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE measures_id_seq CASCADE');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE shopping');
        $this->addSql('DROP TABLE supplies');
        $this->addSql('DROP TABLE supply_alerts');
        $this->addSql('DROP TABLE alerts');
        $this->addSql('DROP TABLE alerts_types');
        $this->addSql('DROP TABLE quick_lists');
        $this->addSql('DROP TABLE quick_lists_positions');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE stuffs');
        $this->addSql('DROP TABLE products_lists');
        $this->addSql('DROP TABLE position');
        $this->addSql('DROP TABLE position_alert');
        $this->addSql('DROP TABLE shops');
        $this->addSql('DROP TABLE measures');
    }
}
