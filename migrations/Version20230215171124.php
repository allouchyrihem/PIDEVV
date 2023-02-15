<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215171124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE discount_product (id INT AUTO_INCREMENT NOT NULL, discountprod_id INT DEFAULT NULL, value DOUBLE PRECISION DEFAULT NULL, startdate DATE DEFAULT NULL, enddate DATE DEFAULT NULL, UNIQUE INDEX UNIQ_654269BC96BBF4C9 (discountprod_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discount_totale (id INT AUTO_INCREMENT NOT NULL, code_promo VARCHAR(255) DEFAULT NULL, valeur_promo DOUBLE PRECISION DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discount_totale_product (discount_totale_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_DF48725430E21505 (discount_totale_id), INDEX IDX_DF4872544584665A (product_id), PRIMARY KEY(discount_totale_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE discount_product ADD CONSTRAINT FK_654269BC96BBF4C9 FOREIGN KEY (discountprod_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE discount_totale_product ADD CONSTRAINT FK_DF48725430E21505 FOREIGN KEY (discount_totale_id) REFERENCES discount_totale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discount_totale_product ADD CONSTRAINT FK_DF4872544584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD discount_totale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D30E21505 FOREIGN KEY (discount_totale_id) REFERENCES discount_totale (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D30E21505 ON commande (discount_totale_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D30E21505');
        $this->addSql('ALTER TABLE discount_product DROP FOREIGN KEY FK_654269BC96BBF4C9');
        $this->addSql('ALTER TABLE discount_totale_product DROP FOREIGN KEY FK_DF48725430E21505');
        $this->addSql('ALTER TABLE discount_totale_product DROP FOREIGN KEY FK_DF4872544584665A');
        $this->addSql('DROP TABLE discount_product');
        $this->addSql('DROP TABLE discount_totale');
        $this->addSql('DROP TABLE discount_totale_product');
        $this->addSql('DROP INDEX IDX_6EEAA67D30E21505 ON commande');
        $this->addSql('ALTER TABLE commande DROP discount_totale_id');
    }
}
