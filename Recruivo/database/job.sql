USE recruivo;

DROP TABLE IF EXISTS job;

CREATE TABLE job (
  job_id                     INT(32)         NOT NULL,
  recruiter_id               INT(32)         NOT NULL,
  job_name                   VARCHAR(32)     NOT NULL,
  job_desc                   VARCHAR(2048),
  min_salary                 DECIMAL(10, 2), 
  max_salary                 DECIMAL(10, 2),
  job_type                   VARCHAR(32),
  job_role                   VARCHAR(16),
  job_location               VARCHAR(16),
  post_start                 DATE,
  post_end                   DATE,
  active                     CHAR(1)                     DEFAULT 'Y',
  created_by                 INT(16)                     DEFAULT 1,
  created_on                 TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
  updated_by                 INT(16)                     DEFAULT 1,
  updated_on                 TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;