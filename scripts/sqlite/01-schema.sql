CREATE TABLE
    publication_category (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        address VARCHAR(1000) DEFAULT '' NOT NULL,
        title VARCHAR(255) DEFAULT '' NOT NULL,
        description CLOB DEFAULT '' NOT NULL,
        parent CHAR(36) DEFAULT '00000000-0000-0000-0000-000000000000' NOT NULL, --(DC2Type:uuid)
        pagination INTEGER DEFAULT 10 NOT NULL,
        children BOOLEAN DEFAULT 0 NOT NULL,
        public BOOLEAN DEFAULT 1 NOT NULL,
        sort CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        meta CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        template CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        PRIMARY KEY (uuid)
    );

CREATE UNIQUE INDEX UNIQ_Address ON publication_category (address);

CREATE TABLE
    file_related (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        file_uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        entity_uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        "order" INTEGER DEFAULT 1 NOT NULL,
        comment CLOB DEFAULT '' NOT NULL,
        object_type VARCHAR(255) NOT NULL,
        PRIMARY KEY (uuid),
        CONSTRAINT FK_3B31C9AB588338C8 FOREIGN KEY (file_uuid) REFERENCES file (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE
    );

CREATE INDEX IDX_3B31C9AB588338C8 ON file_related (file_uuid);

CREATE INDEX IDX_3B31C9AB99B3E98D ON file_related (entity_uuid);

CREATE TABLE
    params (
        name VARCHAR(50) DEFAULT '' NOT NULL,
        value CLOB DEFAULT '' NOT NULL,
        PRIMARY KEY (name)
    );

CREATE TABLE
    form_data (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        form_uuid CHAR(36) DEFAULT '00000000-0000-0000-0000-000000000000' NOT NULL, --(DC2Type:uuid)
        data CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        message CLOB DEFAULT '' NOT NULL,
        date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (uuid)
    );

CREATE TABLE
    file (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        name VARCHAR(255) DEFAULT '' NOT NULL,
        ext VARCHAR(255) DEFAULT '' NOT NULL,
        type VARCHAR(255) DEFAULT '' NOT NULL,
        size INTEGER DEFAULT 0 NOT NULL,
        salt VARCHAR(255) DEFAULT '' NOT NULL,
        hash VARCHAR(255) DEFAULT '' NOT NULL,
        private BOOLEAN DEFAULT 0 NOT NULL,
        date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (uuid)
    );

CREATE TABLE
    user (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        group_uuid CHAR(36) DEFAULT NULL, --(DC2Type:uuid)
        username VARCHAR(50) DEFAULT '' NOT NULL,
        email VARCHAR(120) DEFAULT '' NOT NULL,
        phone VARCHAR(25) DEFAULT '' NOT NULL,
        password VARCHAR(140) DEFAULT '' NOT NULL,
        firstname VARCHAR(50) DEFAULT '' NOT NULL,
        lastname VARCHAR(50) DEFAULT '' NOT NULL,
        patronymic VARCHAR(50) DEFAULT '' NOT NULL,
        birthdate DATE DEFAULT NULL,
        gender VARCHAR(25) DEFAULT '' NOT NULL,
        country VARCHAR(100) DEFAULT '' NOT NULL,
        city VARCHAR(100) DEFAULT '' NOT NULL,
        address VARCHAR(500) DEFAULT '' NOT NULL,
        postcode VARCHAR(50) DEFAULT '' NOT NULL,
        additional VARCHAR(1000) DEFAULT '' NOT NULL,
        allow_mail BOOLEAN DEFAULT 1 NOT NULL,
        company CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        legal CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        messenger CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        status VARCHAR(100) DEFAULT 'work' NOT NULL, --(DC2Type:UserStatusType)
        register DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        "change" DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        website VARCHAR(100) DEFAULT '' NOT NULL,
        source VARCHAR(500) DEFAULT '' NOT NULL,
        auth_code VARCHAR(12) DEFAULT '' NOT NULL,
        language VARCHAR(5) DEFAULT '' NOT NULL,
        external_id VARCHAR(255) DEFAULT '' NOT NULL,
        token CLOB DEFAULT '[]' NOT NULL, --(DC2Type:json)
        PRIMARY KEY (uuid),
        CONSTRAINT FK_8D93D649F8250BD6 FOREIGN KEY (group_uuid) REFERENCES user_group (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE
    );

CREATE INDEX IDX_8D93D649F8250BD6 ON user (group_uuid);

CREATE TABLE
    guestbook (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        name VARCHAR(255) DEFAULT '' NOT NULL,
        email VARCHAR(120) DEFAULT '' NOT NULL,
        message CLOB DEFAULT '' NOT NULL,
        response CLOB DEFAULT '' NOT NULL,
        status VARCHAR(100) DEFAULT 'work' NOT NULL, --(DC2Type:GuestBookStatusType)
        date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (uuid)
    );

CREATE TABLE
    publication (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        user_uuid CHAR(36) DEFAULT NULL, --(DC2Type:uuid)
        category_uuid CHAR(36) DEFAULT '00000000-0000-0000-0000-000000000000', --(DC2Type:uuid)
        address VARCHAR(1000) DEFAULT '' NOT NULL,
        title VARCHAR(255) DEFAULT '' NOT NULL,
        date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        content CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        poll CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        meta CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        external_id VARCHAR(255) DEFAULT '' NOT NULL,
        PRIMARY KEY (uuid),
        CONSTRAINT FK_AF3C6779ABFE1C6F FOREIGN KEY (user_uuid) REFERENCES user (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE,
        CONSTRAINT FK_AF3C67795AE42AE1 FOREIGN KEY (category_uuid) REFERENCES publication_category (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE
    );

CREATE UNIQUE INDEX UNIQ_AF3C6779D4E6F81 ON publication (address);

CREATE INDEX IDX_AF3C6779ABFE1C6F ON publication (user_uuid);

CREATE INDEX IDX_AF3C67795AE42AE1 ON publication (category_uuid);

CREATE TABLE
    user_group (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        title VARCHAR(255) DEFAULT '' NOT NULL,
        description CLOB DEFAULT '' NOT NULL,
        access CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        PRIMARY KEY (uuid)
    );

CREATE TABLE
    user_token (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        user_uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        "unique" CLOB DEFAULT '' NOT NULL,
        comment CLOB DEFAULT '' NOT NULL,
        ip VARCHAR(16) DEFAULT '' NOT NULL,
        agent VARCHAR(256) DEFAULT '' NOT NULL,
        date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (uuid),
        CONSTRAINT FK_BDF55A63ABFE1C6F FOREIGN KEY (user_uuid) REFERENCES user (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE
    );

CREATE INDEX IDX_BDF55A63ABFE1C6F ON user_token (user_uuid);

CREATE TABLE
    user_integration (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        user_uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        provider CLOB DEFAULT '' NOT NULL,
        "unique" VARCHAR(20) DEFAULT '' NOT NULL,
        date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (uuid),
        CONSTRAINT FK_54F2A40EABFE1C6F FOREIGN KEY (user_uuid) REFERENCES user (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE
    );

CREATE INDEX IDX_54F2A40EABFE1C6F ON user_integration (user_uuid);

CREATE UNIQUE INDEX user_provider_unique ON user_integration (user_uuid, provider, "unique");

CREATE TABLE
    user_subscriber (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        email VARCHAR(120) DEFAULT '' NOT NULL,
        date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (uuid)
    );

CREATE UNIQUE INDEX UNIQ_A679D85E7927C74 ON user_subscriber (email);

CREATE TABLE
    task (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        title VARCHAR(255) DEFAULT '' NOT NULL,
        "action" VARCHAR(255) DEFAULT '' NOT NULL,
        progress DOUBLE PRECISION DEFAULT '0' NOT NULL,
        status VARCHAR(100) DEFAULT 'queue' NOT NULL, --(DC2Type:TaskStatusType)
        params CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        output VARCHAR(1000) DEFAULT '' NOT NULL,
        date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (uuid)
    );

CREATE TABLE
    page (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        title VARCHAR(255) DEFAULT '' NOT NULL,
        address VARCHAR(1000) DEFAULT '' NOT NULL,
        date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        content CLOB DEFAULT '' NOT NULL,
        type VARCHAR(100) NOT NULL, --(DC2Type:PageTypeType)
        meta CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        template VARCHAR(50) DEFAULT '' NOT NULL,
        PRIMARY KEY (uuid)
    );

CREATE UNIQUE INDEX UNIQ_140AB620D4E6F81 ON page (address);

CREATE TABLE
    form (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        title VARCHAR(255) DEFAULT '' NOT NULL,
        address VARCHAR(1000) DEFAULT '' NOT NULL,
        template CLOB DEFAULT '' NOT NULL,
        templateFile VARCHAR(50) DEFAULT '' NOT NULL,
        recaptcha BOOLEAN DEFAULT 1 NOT NULL,
        authorSend BOOLEAN DEFAULT 0 NOT NULL,
        origin CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        mailto CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        duplicate VARCHAR(250) DEFAULT '' NOT NULL,
        PRIMARY KEY (uuid)
    );

CREATE UNIQUE INDEX UNIQ_5288FD4FD4E6F81 ON form (address);

CREATE TABLE
    notification (
        uuid CHAR(36) NOT NULL, --(DC2Type:uuid)
        user_uuid CHAR(36) DEFAULT '00000000-0000-0000-0000-000000000000' NOT NULL, --(DC2Type:uuid)
        title VARCHAR(255) DEFAULT '' NOT NULL,
        message CLOB DEFAULT '' NOT NULL,
        params CLOB DEFAULT '{}' NOT NULL, --(DC2Type:json)
        date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (uuid)
    );