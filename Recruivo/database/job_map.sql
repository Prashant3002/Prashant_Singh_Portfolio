USE recruivo;

DROP TABLE IF EXISTS job_map;

CREATE TABLE job_map (
  job_id                     INT(32)         NOT NULL,
  recruiter_id               INT(32)         NOT NULL,
  active                     CHAR(1)                     DEFAULT 'Y',
  created_by                 INT(16)                     DEFAULT 1,
  created_on                 TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
  updated_by                 INT(16)                     DEFAULT 1,
  updated_on                 TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;