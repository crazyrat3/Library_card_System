📚 Library Card Management System

A web-based system built using PHP, MySQL, and TCPDF for managing student library card applications, generating printable library cards (PDF format), and providing an admin panel for monitoring and approving requests.

🚀 Features


👨‍🎓 Student Side

Student registration & login

Submit library card application

View application status in real-time

View and edit profile

Download generated library card PDF once approved


🛠 Admin Side

View all applications

Approve, reject or keep applications pending

Generate library cards as PDF using TCPDF

Download or delete generated cards

Manage students and card records

/lib_card_system

│

├── db.php                  # Database connection


├── student_login.php

├── student_register.php

├── apply_card.php

├── check_status.php        # Student application status page

├── edit_profile.php

├── my_profile.php

│
├── admin_login.php

├── manage_applications.php

├── update_status.php       # Admin updates status (Approved / Denied / Pending)

├── approved_applications.php

├── delete_application.php

├── delete_card.php

├── generatepdfcard.php     # Generates card using TCPDF

│
├── cards/                  # Folder where PDF cards are stored


│
└── TCPDF-main/             # TCPDF library

🛠 Requirements

PHP 7+

MySQL/MariaDB

Apache / XAMPP / WAMP / LAMP

TCPDF library (included in repo)

Browser (Chrome recommended)

⚙️ Database Setup


1. Create Database

CREATE DATABASE library_system;

2. Import Tables

students
library_card_applications
library_cards


🔧 Installation & Setup

1)Clone the project

htdocs/   (XAMPP)

www/      (WAMP)

var/www/  (LAMP)

2)Configure database in db.php

$host = 'localhost';

$user = 'root';

$pass = '';

$dbname = 'library_system';

3)Start Apache & MySQL

http://localhost/lib_card_system

🧾 Library Card Generation

Admin clicks “Generate Card”

TCPDF generates an A7 PDF card

Saves under /cards/library_card_<id>.pdf

File path saved in library_cards table

Example generated card includes:

Name

Student ID

Department

Issue date

🧹 Delete / Reset Card

Admin can:

Delete card PDF from server

Remove DB record

Handled via:
delete_card.php


🔐 Security Measures Implemented

✔ Prepared statements (SQL Injection safe)

✔ Session based authentication

✔ Input validation & sanitization

✔ Restricted access to admin pages

✔ File path verification before deletion


📄 License

This project is for educational use. You may modify and distribute it as needed


