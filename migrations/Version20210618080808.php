<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210618080808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_employee (project_id INT NOT NULL, employee_id INT NOT NULL, INDEX IDX_60D1FE7A166D1F9C (project_id), INDEX IDX_60D1FE7A8C03F15C (employee_id), PRIMARY KEY(project_id, employee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project_employee ADD CONSTRAINT FK_60D1FE7A166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_employee ADD CONSTRAINT FK_60D1FE7A8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D9F75A1E7927C74 ON employee (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_employee DROP FOREIGN KEY FK_60D1FE7A166D1F9C');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_employee');
        $this->addSql('DROP INDEX UNIQ_5D9F75A1E7927C74 ON employee');
    }
}
