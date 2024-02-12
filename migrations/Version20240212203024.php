<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240212203024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(45) NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE pedido_producto (id INT AUTO_INCREMENT NOT NULL, unidades INT NOT NULL, pedido_id INT NOT NULL, producto_id INT NOT NULL, INDEX IDX_DD333C24854653A (pedido_id), INDEX IDX_DD333C27645698E (producto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE pedido_restaurante (id INT AUTO_INCREMENT NOT NULL, fecha DATE NOT NULL, enviado TINYINT(1) NOT NULL, restaurante_id INT NOT NULL, INDEX IDX_30C9CAB638B81E49 (restaurante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE producto (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(45) NOT NULL, descripcion VARCHAR(255) NOT NULL, peso DOUBLE PRECISION NOT NULL, precio DOUBLE PRECISION NOT NULL, stock INT NOT NULL, imagen VARCHAR(255) NOT NULL, categoria_id INT NOT NULL, INDEX IDX_A7BB06153397707A (categoria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE restaurante (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, cp INT NOT NULL, pais VARCHAR(255) NOT NULL, direccion VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_5957C275E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE pedido_producto ADD CONSTRAINT FK_DD333C24854653A FOREIGN KEY (pedido_id) REFERENCES pedido_restaurante (id)');
        $this->addSql('ALTER TABLE pedido_producto ADD CONSTRAINT FK_DD333C27645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE pedido_restaurante ADD CONSTRAINT FK_30C9CAB638B81E49 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id)');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB06153397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedido_producto DROP FOREIGN KEY FK_DD333C24854653A');
        $this->addSql('ALTER TABLE pedido_producto DROP FOREIGN KEY FK_DD333C27645698E');
        $this->addSql('ALTER TABLE pedido_restaurante DROP FOREIGN KEY FK_30C9CAB638B81E49');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB06153397707A');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE pedido_producto');
        $this->addSql('DROP TABLE pedido_restaurante');
        $this->addSql('DROP TABLE producto');
        $this->addSql('DROP TABLE restaurante');
    }
}
