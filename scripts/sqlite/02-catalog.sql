CREATE TABLE
    catalog_category (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        parent CHAR(36) DEFAULT '00000000-0000-0000-0000-000000000000' NOT NULL, --(DC2Type:uuid)
        title VARCHAR(255) DEFAULT '' NOT NULL,
        description CLOB DEFAULT '' NOT NULL,
        address VARCHAR(1000) DEFAULT '' NOT NULL,
        field1 CLOB DEFAULT '' NOT NULL,
        field2 CLOB DEFAULT '' NOT NULL,
        field3 CLOB DEFAULT '' NOT NULL,
        product CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        pagination INTEGER DEFAULT 10 NOT NULL,
        children BOOLEAN DEFAULT 0 NOT NULL,
        hidden BOOLEAN DEFAULT 0 NOT NULL,
        "order" INTEGER DEFAULT 1 NOT NULL,
        status VARCHAR(100) DEFAULT 'work' NOT NULL, --(DC2Type:CatalogCategoryStatusType)
        sort CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        meta CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        template CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        external_id VARCHAR(255) DEFAULT '' NOT NULL,
        export VARCHAR(50) DEFAULT 'manual' NOT NULL,
        PRIMARY KEY (uuid)
    );

CREATE INDEX catalog_category_address_idx ON catalog_category (address);

CREATE INDEX catalog_category_parent_idx ON catalog_category (parent);

CREATE INDEX catalog_category_order_idx ON catalog_category ("order");

CREATE UNIQUE INDEX catalog_category_unique ON catalog_category (parent, address, external_id);

CREATE TABLE
    catalog_category_attributes (
        category_uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        attribute_uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        PRIMARY KEY (category_uuid, attribute_uuid),
        CONSTRAINT FK_1D53E6C95AE42AE1 FOREIGN KEY (category_uuid) REFERENCES catalog_category (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
        CONSTRAINT FK_1D53E6C98A97F42E FOREIGN KEY (attribute_uuid) REFERENCES catalog_attribute (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
    );

CREATE INDEX IDX_1D53E6C95AE42AE1 ON catalog_category_attributes (category_uuid);

CREATE INDEX IDX_1D53E6C98A97F42E ON catalog_category_attributes (attribute_uuid);

CREATE TABLE
    catalog_product (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        category CHAR(36) DEFAULT '00000000-0000-0000-0000-000000000000' NOT NULL, --(DC2Type:uuid)
        title VARCHAR(255) DEFAULT '' NOT NULL,
        type VARCHAR(100) DEFAULT 'product' NOT NULL, --(DC2Type:CatalogProductTypeType)
        description CLOB DEFAULT '' NOT NULL,
        extra CLOB DEFAULT '' NOT NULL,
        address VARCHAR(1000) DEFAULT '' NOT NULL,
        vendorcode CLOB DEFAULT '' NOT NULL,
        barcode CLOB DEFAULT '' NOT NULL,
        tax DOUBLE PRECISION DEFAULT '0' NOT NULL,
        priceFirst DOUBLE PRECISION DEFAULT '0' NOT NULL,
        price DOUBLE PRECISION DEFAULT '0' NOT NULL,
        priceWholesale DOUBLE PRECISION DEFAULT '0' NOT NULL,
        priceWholesaleFrom DOUBLE PRECISION DEFAULT '0' NOT NULL,
        discount DOUBLE PRECISION DEFAULT '0' NOT NULL,
        special BOOLEAN DEFAULT 0 NOT NULL,
        dimension CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        volume DOUBLE PRECISION DEFAULT '1.0' NOT NULL,
        unit VARCHAR(64) DEFAULT '' NOT NULL,
        stock DOUBLE PRECISION DEFAULT '0' NOT NULL,
        field1 CLOB DEFAULT '' NOT NULL,
        field2 CLOB DEFAULT '' NOT NULL,
        field3 CLOB DEFAULT '' NOT NULL,
        field4 CLOB DEFAULT '' NOT NULL,
        field5 CLOB DEFAULT '' NOT NULL,
        country VARCHAR(255) DEFAULT '' NOT NULL,
        manufacturer VARCHAR(255) DEFAULT '' NOT NULL,
        tags CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        "order" INTEGER DEFAULT 1 NOT NULL,
        status VARCHAR(100) DEFAULT 'work' NOT NULL, --(DC2Type:CatalogProductStatusType)
        date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        meta CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        external_id VARCHAR(255) DEFAULT '' NOT NULL,
        export VARCHAR(50) DEFAULT 'manual' NOT NULL,
        PRIMARY KEY (uuid)
    );

CREATE INDEX catalog_product_address_idx ON catalog_product (address);

CREATE INDEX catalog_product_category_idx ON catalog_product (category);

CREATE INDEX catalog_product_price_idx ON catalog_product (price, priceFirst, priceWholesale);

CREATE INDEX catalog_product_volume_idx ON catalog_product (volume, unit);

CREATE INDEX catalog_product_manufacturer_idx ON catalog_product (manufacturer);

CREATE INDEX catalog_product_country_idx ON catalog_product (country);

CREATE INDEX catalog_product_order_idx ON catalog_product ("order");

CREATE UNIQUE INDEX catalog_product_unique ON catalog_product (category, address, volume, unit, external_id);

CREATE TABLE
    catalog_order (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        user_uuid CHAR(36) DEFAULT NULL, --(DC2Type:uuid)
        status_uuid CHAR(36) DEFAULT NULL, --(DC2Type:uuid)
        serial VARCHAR(12) DEFAULT '' NOT NULL,
        delivery CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        shipping DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        comment VARCHAR(500) DEFAULT '' NOT NULL,
        phone VARCHAR(25) DEFAULT '' NOT NULL,
        email VARCHAR(120) DEFAULT '' NOT NULL,
        date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        external_id VARCHAR(255) DEFAULT '' NOT NULL,
        export VARCHAR(50) DEFAULT 'manual' NOT NULL,
        system VARCHAR(500) DEFAULT '' NOT NULL,
        PRIMARY KEY (uuid),
        CONSTRAINT FK_4C3AF221ABFE1C6F FOREIGN KEY (user_uuid) REFERENCES user (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE,
        CONSTRAINT FK_4C3AF221E979FD32 FOREIGN KEY (status_uuid) REFERENCES catalog_order_status (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE
    );

CREATE INDEX IDX_4C3AF221ABFE1C6F ON catalog_order (user_uuid);

CREATE INDEX catalog_order_serial_idx ON catalog_order (serial);

CREATE INDEX catalog_order_status_idx ON catalog_order (status_uuid);

CREATE TABLE
    catalog_order_status (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        title VARCHAR(255) DEFAULT '' NOT NULL,
        "order" INTEGER DEFAULT 1 NOT NULL,
        PRIMARY KEY (uuid)
    );

CREATE UNIQUE INDEX catalog_order_status_unique ON catalog_order_status (title);

CREATE TABLE
    catalog_attribute (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        title VARCHAR(255) DEFAULT '' NOT NULL,
        address VARCHAR(500) DEFAULT '' NOT NULL,
        type VARCHAR(100) DEFAULT 'string' NOT NULL, --(DC2Type:CatalogAttributeTypeType)
        PRIMARY KEY (uuid)
    );

CREATE UNIQUE INDEX UNIQ_470546D4E6F81 ON catalog_attribute (address);

CREATE TABLE
    catalog_order_product (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        order_uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        product_uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        price DOUBLE PRECISION DEFAULT '0' NOT NULL,
        count DOUBLE PRECISION DEFAULT '1' NOT NULL,
        PRIMARY KEY (uuid),
        CONSTRAINT FK_59DD3D6B9C8E6AB1 FOREIGN KEY (order_uuid) REFERENCES catalog_order (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE,
        CONSTRAINT FK_59DD3D6B5C977207 FOREIGN KEY (product_uuid) REFERENCES catalog_product (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE
    );

CREATE INDEX IDX_59DD3D6B9C8E6AB1 ON catalog_order_product (order_uuid);

CREATE INDEX IDX_59DD3D6B5C977207 ON catalog_order_product (product_uuid);

CREATE TABLE
    catalog_measure (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        title VARCHAR(255) DEFAULT '' NOT NULL,
        contraction VARCHAR(255) DEFAULT '' NOT NULL,
        value DOUBLE PRECISION DEFAULT '1.00' NOT NULL,
        PRIMARY KEY (uuid)
    );

CREATE UNIQUE INDEX catalog_measure_contraction_unique ON catalog_measure (contraction);

CREATE TABLE
    catalog_product_attributes (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        product_uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        attribute_uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        value VARCHAR(1000) DEFAULT '' NOT NULL,
        PRIMARY KEY (uuid),
        CONSTRAINT FK_747A21D55C977207 FOREIGN KEY (product_uuid) REFERENCES catalog_product (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE,
        CONSTRAINT FK_747A21D58A97F42E FOREIGN KEY (attribute_uuid) REFERENCES catalog_attribute (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE
    );

CREATE INDEX IDX_747A21D55C977207 ON catalog_product_attributes (product_uuid);

CREATE INDEX IDX_747A21D58A97F42E ON catalog_product_attributes (attribute_uuid);

CREATE TABLE
    catalog_product_related (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        product_uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        related_uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        count DOUBLE PRECISION DEFAULT '1' NOT NULL,
        PRIMARY KEY (uuid),
        CONSTRAINT FK_CFAC628F5C977207 FOREIGN KEY (product_uuid) REFERENCES catalog_product (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE,
        CONSTRAINT FK_CFAC628F3A6DF4A3 FOREIGN KEY (related_uuid) REFERENCES catalog_product (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE
    );

CREATE INDEX IDX_CFAC628F5C977207 ON catalog_product_related (product_uuid);

CREATE INDEX IDX_CFAC628F3A6DF4A3 ON catalog_product_related (related_uuid);