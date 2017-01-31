<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20170115195250 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql(<<<SQL
            create table sources(
                id serial not null primary key,
                key character varying(128) not null,
                url character varying(128) not null
            );
SQL
        );

        $this->addSql(<<<SQL
            create table categories(
                id serial not null primary key,
                source_id integer not null references sources(id),
                name character varying(128) not null,
                parent_id integer default 0,
                url character varying(128)
            );
SQL
        );

        $this->addSql(<<<SQL
            create table products(
                id serial not null primary key,
                name character varying(256) not null,
                category_id integer not null references categories(id),
                description text,
                characteristics jsonb default '{}'::json,
                url character varying(256)
            );
SQL
        );

        $this->addSql(<<<SQL
            create table pictures(
                id serial not null primary key,
                url character varying(256) not null,
                product_id integer not null references products(id)
            );
SQL
        );

        $this->addSql(<<<SQL
            create table prices(
                id serial not null primary key,
                product_id integer not null references products(id),
                value double precision default 0 not null,
                old_value double precision default 0 not null,
                has_discount bool default false,
                date timestamptz not null default current_timestamp
            );
SQL
        );

        $this->addSql(<<<SQL
            create table also_buy(
                product_id integer not null references products(id),
                also_buy_product_id integer not null references products(id),
                date timestamptz not null default current_timestamp
            );
SQL
        );

        $this->addSql(<<<SQL
            create table similar_products(
                product_id integer not null references products(id),
                similar_product_id integer not null references products(id),
                date timestamptz not null default current_timestamp
            );
SQL
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('sources');
        $schema->dropTable('categories');
        $schema->dropTable('products');
        $schema->dropTable('pictures');
        $schema->dropTable('prices');
        $schema->dropTable('similar_products');
        $schema->dropTable('also_buy');
    }
}
