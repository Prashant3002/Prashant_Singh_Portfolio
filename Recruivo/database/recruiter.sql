USE recruivo;

DROP TABLE IF EXISTS recruiter_profile;

CREATE TABLE recruiter_profile (
  recruiter_id              INT(16)         NOT NULL,
  user_id                   INT(16)         NOT NULL,
  recruiter_name            VARCHAR(32),
  email                     VARCHAR(128),
  company_name              VARCHAR(128)    NOT NULL,
  company_description       VARCHAR(1024),
  company_logo              VARCHAR(128),
  company_address           VARCHAR(256),
  company_website           VARCHAR(64),
  company_phone             VARCHAR(16),
  active                    CHAR(1)                     DEFAULT 'Y',
  created_by                INT(16)                     DEFAULT 1,
  created_on                TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
  updated_by                INT(16)                     DEFAULT 1,
  updated_on                TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP 
) ENGINE=InnoDB;