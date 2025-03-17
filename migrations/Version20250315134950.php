<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250315134950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answers (id INT AUTO_INCREMENT NOT NULL, answer VARCHAR(50) NOT NULL, comment LONGTEXT DEFAULT NULL, evaluation_id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_50D0C606456C5646 (evaluation_id), INDEX IDX_50D0C6061E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE audits (id INT AUTO_INCREMENT NOT NULL, audit_date DATETIME NOT NULL, results LONGTEXT NOT NULL, corrective_actions LONGTEXT NOT NULL, company_id INT NOT NULL, INDEX IDX_32451E6C979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE companies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, sector VARCHAR(100) DEFAULT NULL, creation_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE documents (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, type VARCHAR(100) NOT NULL, content LONGTEXT NOT NULL, creation_date DATETIME NOT NULL, company_id INT NOT NULL, INDEX IDX_A2B07288979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE evaluations (id INT AUTO_INCREMENT NOT NULL, evaluation_date DATETIME NOT NULL, overall_score DOUBLE PRECISION NOT NULL, status VARCHAR(50) NOT NULL, company_id INT NOT NULL, INDEX IDX_3B72691D979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT NOT NULL, category VARCHAR(100) NOT NULL, weight INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE recommendations (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT NOT NULL, priority VARCHAR(50) NOT NULL, due_date DATETIME NOT NULL, evaluation_id INT NOT NULL, INDEX IDX_73904ED7456C5646 (evaluation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE trainings (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date DATETIME NOT NULL, participants JSON NOT NULL, company_id INT NOT NULL, INDEX IDX_66DC4330979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(50) NOT NULL, company_id INT NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), INDEX IDX_1483A5E9979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE answers ADD CONSTRAINT FK_50D0C606456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluations (id)');
        $this->addSql('ALTER TABLE answers ADD CONSTRAINT FK_50D0C6061E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE audits ADD CONSTRAINT FK_32451E6C979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B07288979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)');
        $this->addSql('ALTER TABLE evaluations ADD CONSTRAINT FK_3B72691D979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)');
        $this->addSql('ALTER TABLE recommendations ADD CONSTRAINT FK_73904ED7456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluations (id)');
        $this->addSql('ALTER TABLE trainings ADD CONSTRAINT FK_66DC4330979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answers DROP FOREIGN KEY FK_50D0C606456C5646');
        $this->addSql('ALTER TABLE answers DROP FOREIGN KEY FK_50D0C6061E27F6BF');
        $this->addSql('ALTER TABLE audits DROP FOREIGN KEY FK_32451E6C979B1AD6');
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B07288979B1AD6');
        $this->addSql('ALTER TABLE evaluations DROP FOREIGN KEY FK_3B72691D979B1AD6');
        $this->addSql('ALTER TABLE recommendations DROP FOREIGN KEY FK_73904ED7456C5646');
        $this->addSql('ALTER TABLE trainings DROP FOREIGN KEY FK_66DC4330979B1AD6');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9979B1AD6');
        $this->addSql('DROP TABLE answers');
        $this->addSql('DROP TABLE audits');
        $this->addSql('DROP TABLE companies');
        $this->addSql('DROP TABLE documents');
        $this->addSql('DROP TABLE evaluations');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE recommendations');
        $this->addSql('DROP TABLE trainings');
        $this->addSql('DROP TABLE users');
    }
}
