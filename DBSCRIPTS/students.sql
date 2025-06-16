CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    contact_no VARCHAR(15),
    class VARCHAR(50),
    year VARCHAR(20),
    department VARCHAR(100),
    gender VARCHAR(10),
    address TEXT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

