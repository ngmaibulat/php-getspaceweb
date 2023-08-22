-- To convert the provided SQLite code to PostgreSQL, several changes are needed:
-- 1. `CLOB` in SQLite should be changed to `TEXT` in PostgreSQL.
-- 2. `CHAR(36)` for UUIDs should be changed to the native `UUID` data type in PostgreSQL.
-- 3. `DATETIME` in SQLite becomes `TIMESTAMP` in PostgreSQL.
-- 4. Instead of `DOUBLE PRECISION`, PostgreSQL generally uses just `DOUBLE`.
-- 5. PostgreSQL has a native `JSON` type for JSON data.
-- 6. `BOOLEAN` defaults can directly use `TRUE` or `FALSE` instead of integers in PostgreSQL.
CREATE TABLE
    catalog_category (
        uuid UUID PRIMARY KEY,
        parent UUID DEFAULT '00000000-0000-0000-0000-000000000000' NOT NULL,
        title VARCHAR(255) DEFAULT '' NOT NULL,
        description TEXT DEFAULT '' NOT NULL,
        address VARCHAR(1000) DEFAULT '' NOT NULL,
        field1 TEXT DEFAULT '' NOT NULL,
        field2 TEXT DEFAULT '' NOT NULL,
        field3 TEXT DEFAULT '' NOT NULL,
        product JSON DEFAULT '{}' NOT NULL,
        pagination INTEGER DEFAULT 10 NOT NULL,
        children BOOLEAN DEFAULT FALSE NOT NULL,
        hidden BOOLEAN DEFAULT FALSE NOT NULL,
        "order" INTEGER DEFAULT 1 NOT NULL,
        status VARCHAR(100) DEFAULT 'work' NOT NULL,
        sort JSON DEFAULT '{}' NOT NULL,
        meta JSON DEFAULT '{}' NOT NULL,
        template JSON DEFAULT '{}' NOT NULL,
        external_id VARCHAR(255) DEFAULT '' NOT NULL,
        export VARCHAR(50) DEFAULT 'manual' NOT NULL
    );

CREATE INDEX catalog_category_address_idx ON catalog_category (address);

CREATE INDEX catalog_category_parent_idx ON catalog_category (parent);

CREATE INDEX catalog_category_order_idx ON catalog_category ("order");

CREATE UNIQUE INDEX catalog_category_unique ON catalog_category (parent, address, external_id);

CREATE TABLE
    catalog_attribute (
        uuid UUID PRIMARY KEY,
        title VARCHAR(255) NOT NULL DEFAULT '',
        address VARCHAR(500) NOT NULL DEFAULT '',
        type VARCHAR(100) NOT NULL DEFAULT 'string'
    );

CREATE UNIQUE INDEX UNIQ_470546D4E6F81 ON catalog_attribute (address);

CREATE TABLE
    catalog_category_attributes (
        category_uuid UUID NOT NULL,
        attribute_uuid UUID NOT NULL,
        PRIMARY KEY (category_uuid, attribute_uuid),
        CONSTRAINT FK_1D53E6C95AE42AE1 FOREIGN KEY (category_uuid) REFERENCES catalog_category (uuid) ON DELETE CASCADE,
        CONSTRAINT FK_1D53E6C98A97F42E FOREIGN KEY (attribute_uuid) REFERENCES catalog_attribute (uuid) ON DELETE CASCADE
    );

CREATE INDEX IDX_1D53E6C95AE42AE1 ON catalog_category_attributes (category_uuid);

CREATE INDEX IDX_1D53E6C98A97F42E ON catalog_category_attributes (attribute_uuid);

CREATE TABLE
    catalog_product (
        uuid UUID PRIMARY KEY,
        category UUID DEFAULT '00000000-0000-0000-0000-000000000000' NOT NULL,
        title VARCHAR(255) DEFAULT '' NOT NULL,
        type VARCHAR(100) DEFAULT 'product' NOT NULL,
        description TEXT DEFAULT '' NOT NULL,
        extra TEXT DEFAULT '' NOT NULL,
        address VARCHAR(1000) DEFAULT '' NOT NULL,
        vendorcode TEXT DEFAULT '' NOT NULL,
        barcode TEXT DEFAULT '' NOT NULL,
        tax DOUBLE DEFAULT 0 NOT NULL,
        priceFirst DOUBLE DEFAULT 0 NOT NULL,
        price DOUBLE DEFAULT 0 NOT NULL,
        priceWholesale DOUBLE DEFAULT 0 NOT NULL,
        priceWholesaleFrom DOUBLE DEFAULT 0 NOT NULL,
        discount DOUBLE DEFAULT 0 NOT NULL,
        special BOOLEAN DEFAULT FALSE NOT NULL,
        dimension JSON DEFAULT '{}' NOT NULL,
        volume DOUBLE DEFAULT 1.0 NOT NULL,
        unit VARCHAR(64) DEFAULT '' NOT NULL,
        stock DOUBLE DEFAULT 0 NOT NULL,
        field1 TEXT DEFAULT '' NOT NULL,
        field2 TEXT DEFAULT '' NOT NULL,
        field3 TEXT DEFAULT '' NOT NULL,
        field4 TEXT DEFAULT '' NOT NULL,
        field5 TEXT DEFAULT '' NOT NULL,
        country VARCHAR(255) DEFAULT '' NOT NULL,
        manufacturer VARCHAR(255) DEFAULT '' NOT NULL,
        tags JSON DEFAULT '{}' NOT NULL,
        "order" INTEGER DEFAULT 1 NOT NULL,
        status VARCHAR(100) DEFAULT 'work' NOT NULL,
        date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
        meta JSON DEFAULT '{}' NOT NULL,
        external_id VARCHAR(255) DEFAULT '' NOT NULL,
        export VARCHAR(50) DEFAULT 'manual' NOT NULL
    );

CREATE INDEX catalog_product_address_idx ON catalog_product (address);

CREATE INDEX catalog_product_category_idx ON catalog_product (category);

CREATE INDEX catalog_product_price_idx ON catalog_product (price, priceFirst, priceWholesale);

CREATE INDEX catalog_product_volume_idx ON catalog_product (volume, unit);

CREATE INDEX catalog_product_manufacturer_idx ON catalog_product (manufacturer);

CREATE INDEX catalog_product_country_idx ON catalog_product (country);

CREATE INDEX catalog_product_order_idx ON catalog_product ("order");

CREATE UNIQUE INDEX catalog_product_unique ON catalog_product (category, address, volume, unit, external_id);

-------------------------------------------------------------------------
-------------------------------------------------------------------------
-------------------------------------------------------------------------
-------------------------------------------------------------------------
-------------------------------------------------------------------------
CREATE TABLE
    catalog_order (
        uuid UUID PRIMARY KEY,
        user_uuid UUID,
        status_uuid UUID,
        serial VARCHAR(12) NOT NULL DEFAULT '',
        delivery JSONB NOT NULL DEFAULT '{}',
        shipping TIMESTAMP
        WITH
            TIME ZONE DEFAULT CURRENT_TIMESTAMP,
            comment VARCHAR(500) NOT NULL DEFAULT '',
            phone VARCHAR(25) NOT NULL DEFAULT '',
            email VARCHAR(120) NOT NULL DEFAULT '',
            date TIMESTAMP
        WITH
            TIME ZONE DEFAULT CURRENT_TIMESTAMP,
            external_id VARCHAR(255) NOT NULL DEFAULT '',
            export VARCHAR(50) NOT NULL DEFAULT 'manual',
            system VARCHAR(500) NOT NULL DEFAULT ''
    );

CREATE INDEX IDX_4C3AF221ABFE1C6F ON catalog_order (user_uuid);

CREATE INDEX catalog_order_serial_idx ON catalog_order (serial);

CREATE INDEX catalog_order_status_idx ON catalog_order (status_uuid);

CREATE TABLE
    catalog_order_status (
        uuid UUID PRIMARY KEY,
        title VARCHAR(255) NOT NULL DEFAULT '',
        "order" INTEGER NOT NULL DEFAULT 1
    );

CREATE UNIQUE INDEX catalog_order_status_unique ON catalog_order_status (title);

CREATE TABLE
    catalog_order_product (
        uuid UUID PRIMARY KEY,
        order_uuid UUID NOT NULL,
        product_uuid UUID NOT NULL,
        price DOUBLE NOT NULL DEFAULT 0,
        count DOUBLE NOT NULL DEFAULT 1
    );

CREATE INDEX IDX_59DD3D6B9C8E6AB1 ON catalog_order_product (order_uuid);

CREATE INDEX IDX_59DD3D6B5C977207 ON catalog_order_product (product_uuid);

CREATE TABLE
    catalog_measure (
        uuid UUID PRIMARY KEY,
        title VARCHAR(255) NOT NULL DEFAULT '',
        contraction VARCHAR(255) NOT NULL DEFAULT '',
        value DOUBLE NOT NULL DEFAULT 1.00
    );

CREATE UNIQUE INDEX catalog_measure_contraction_unique ON catalog_measure (contraction);

CREATE TABLE
    catalog_product_attributes (
        uuid UUID PRIMARY KEY,
        product_uuid UUID NOT NULL,
        attribute_uuid UUID NOT NULL,
        value VARCHAR(1000) NOT NULL DEFAULT ''
    );

CREATE INDEX IDX_747A21D55C977207 ON catalog_product_attributes (product_uuid);

CREATE INDEX IDX_747A21D58A97F42E ON catalog_product_attributes (attribute_uuid);

CREATE TABLE
    catalog_product_related (
        uuid UUID PRIMARY KEY,
        product_uuid UUID NOT NULL,
        related_uuid UUID NOT NULL,
        count DOUBLE NOT NULL DEFAULT 1
    );

CREATE INDEX IDX_CFAC628F5C977207 ON catalog_product_related (product_uuid);

CREATE INDEX IDX_CFAC628F3A6DF4A3 ON catalog_product_related (related_uuid);