USE CMSC_4003;

TRUNCATE TABLE users;

INSERT INTO users
(first_name, last_name, email, user_type, start_date, registration_date, password_hash)
Values
('Steven', 'Rotelli', 'strotelli@icloud.com', 'admin', '2020-01-01', null, '$2y$12$hIwgSWBuqE6SfvxF.HfoW.NY.v.8c0Ah7CrzOABUmKN2yDfGSzALi' ),
('Sean', 'Jaeger', 'seanjaeger2001@yahoo.com', 'admin', '2020-01-01', null, '$2y$12$hIwgSWBuqE6SfvxF.HfoW.NY.v.8c0Ah7CrzOABUmKN2yDfGSzALi' ),
('John', 'Doe', 'jdoe0129@gmail.com', 'user', null, '2020-01-01', '$2y$12$hIwgSWBuqE6SfvxF.HfoW.NY.v.8c0Ah7CrzOABUmKN2yDfGSzALi' ),
('Jane', 'Doe', 'janedoe23@hotmail.com', 'hybrid', '2020-01-01', '2020-01-01', '$2y$12$hIwgSWBuqE6SfvxF.HfoW.NY.v.8c0Ah7CrzOABUmKN2yDfGSzALi' );
