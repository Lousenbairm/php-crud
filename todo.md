## Features

1. Create new info and store it in DB [fullName, NRIC, DOB, Address, mobile no]
2. Data can be edited [mobile no, address]
3. Soft deleting data
4. List data (Maybe a search feature)

## Table design

1. nric
2. name
3. dob
4. address
5. mobile no
6. status?

## Correction

CREATE TABLE IF NOT EXISTS crud_proj.customer (
    nric VARCHAR(12) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    dob DATE NOT NULL,
    address VARCHAR(255) NOT NULL,
    mobile_no VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,
    
	INDEX idx_dob (dob),
    INDEX idx_delete_at (deleted_at),
    INDEX idx_mobile_no (mobile_no),
  
    CONSTRAINT chk_nric_format CHECK(nric REGEXP '^[0-9]{12}$')
    
);


