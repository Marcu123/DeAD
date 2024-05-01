drop table prison;
drop table admins;
drop table inmate;
drop table users;
drop table request;
drop table visitor;
drop table visit_info;
drop table employee;
drop table witnesses;


CREATE TABLE prison (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255),
    inmate_number INT,
    employee_number INT
);

CREATE TABLE admins (
    username VARCHAR(255) PRIMARY KEY,
    admin_key VARCHAR(255),
    id_prison INT,
    account_created TIMESTAMP,
    last_logged TIMESTAMP,
    FOREIGN KEY (id_prison) REFERENCES prison (id)
);

CREATE TABLE inmate (
    id SERIAL PRIMARY KEY,
    photo BYTEA,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    cnp VARCHAR(13) UNIQUE,
    age INT,
    gender VARCHAR(50),
    id_prison INT,
    date_of_incarceracion TIMESTAMP,
    end_of_incarceration TIMESTAMP,
    crime VARCHAR(255),
    FOREIGN KEY (id_prison) REFERENCES prison (id)
);

CREATE TABLE users (
    username VARCHAR(255) PRIMARY KEY,
    photo BYTEA,
    password VARCHAR(255),
    email VARCHAR(255),
    cnp VARCHAR(13),
    phone_number VARCHAR(20),
    account_created TIMESTAMP,
    last_logged TIMESTAMP
);

CREATE TABLE request (
    id SERIAL PRIMARY KEY,
    visitor_type VARCHAR(255),
    visit_type VARCHAR(255),
    date_of_visit TIMESTAMP,
    status VARCHAR(100),
    id_inmate INT,
    request_created TIMESTAMP,
    status_changed TIMESTAMP,
    FOREIGN KEY (id_inmate) REFERENCES inmate (id)
);

CREATE TABLE visitor (
    id SERIAL PRIMARY KEY,
    vistor_name VARCHAR(255),
    cnp VARCHAR(13),
    photo BYTEA,
    email VARCHAR(255),
    phone_number VARCHAR(20),
    id_request INT,
    FOREIGN KEY (id_request) REFERENCES request (id)
);

CREATE TABLE visit_info (
    id SERIAL PRIMARY KEY,
    id_request INT,
    id_inmate INT,
    objects_traded VARCHAR(255),
    conversation_resume TEXT,
    health_status VARCHAR(255),
    mood VARCHAR(255),
    FOREIGN KEY (id_request) REFERENCES request (id),
    FOREIGN KEY (id_inmate) REFERENCES inmate (id)
);

CREATE TABLE employee (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255)
);

CREATE TABLE witnesses (
    id SERIAL PRIMARY KEY,
    id_visit INT,
    id_visitor INT,
    id_employee INT,
    FOREIGN KEY (id_visit) REFERENCES visit_info (id),
    FOREIGN KEY (id_visitor) REFERENCES visitor (id),
    FOREIGN KEY (id_employee) REFERENCES employee (id)
);
