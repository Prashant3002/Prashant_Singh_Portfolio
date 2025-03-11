USE recruivo;

DROP TABLE IF EXISTS student_profile;

CREATE TABLE student_profile (
  student_id            INT(32)         NOT NULL,
  user_id               INT(32)         NOT NULL,
  roll_number           VARCHAR(32)     NOT NULL,
  first_name            VARCHAR(32),
  middle_name           VARCHAR(32),     
  last_name             VARCHAR(32),
  mobile_number         VARCHAR(16)     NOT NULL,
  email                 VARCHAR(128)    NOT NULL,
  gender                CHAR(1),
  dob                   VARCHAR(16)     NOT NULL,
  college               VARCHAR(128),
  course                VARCHAR(16),
  branch                VARCHAR(16),
  year_of_passing       VARCHAR(4),
  tenth_percent         DECIMAL(5,2),
  twelfth_percent       DECIMAL(5,2),
  graduation_percent    DECIMAL(5,2),
  skills                VARCHAR(32),
  active                CHAR(1)                     DEFAULT 'Y',
  created_by            INT(16)                     DEFAULT 1,
  created_on            TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP,
  updated_by            INT(16)                     DEFAULT 1,
  updated_on            TIMESTAMP       NOT NULL    DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;