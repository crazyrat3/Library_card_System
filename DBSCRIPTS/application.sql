CREATE TABLE library_card_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50),
    application_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Pending', 'Approved', 'Denied') DEFAULT 'Pending'
);

