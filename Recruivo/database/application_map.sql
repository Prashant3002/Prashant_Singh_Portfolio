USE recruivo;

DROP TABLE IF EXISTS application_map;

CREATE TABLE application_map (
  app_id                     INT(32)         NOT NULL,
  student_id               INT(32)         NOT NULL,
  job_id                   VARCHAR(32)     NOT NULL,
  student_status               VARCHAR(16),
  active                     CHAR(1)                     DEFAULT 'Y',
  created_by                 INT(16)                     DEFAULT 1,
  created_on                 TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
  updated_by                 INT(16)                     DEFAULT 1,
  updated_on                 TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;