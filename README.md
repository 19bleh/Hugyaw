# Hugyaw

The Hugyaw project is a website designed to celebrate and preserve the rich cultural heritage of the respective municipalities of the creators. This platform enables users to engage with the festival by selecting a municipality, submitting their feedback, and viewing feedback from others. Additionally, users can have fun by answering a quiz about the festivals. The application also features an admin dashboard that allows administrators to efficiently manage quiz questions, feedback, users, and scores, ensuring a seamless and interactive festival experience for all participants.

## Features

- Submit feedback for a selected municipality.
- View feedback for a selected municipality.
- Delete feedback entries.
- Admin dashboard for managing:
  - Quiz questions
  - Feedback
  - Users
  - Scores

## Technologies Used

- HTML
- CSS
- PHP
- MySQL
- XAMPP

## Setup Instructions

### Prerequisites

- XAMPP (or any other local server environment with PHP and MySQL)
- Web browser

### Step 1: Clone the Project from GitHub

1. **Clone the Repository**:
   - Copy the repository URL.
   - Open a terminal or Git Bash on your computer.
   - Navigate to the directory where you want to clone the repository.
   - Run the following command:
     ```bash
     git clone https://github.com/markalvincadangin/Hugyaw
     ```

2. **Navigate to the Project Directory**:
   - After cloning, navigate to the project directory:
     ```sh
     cd Hugyaw
     ```

### Step 2: Set Up the Database Using XAMPP

1. **Start XAMPP**:
   - Open the XAMPP Control Panel.
   - Start the Apache and MySQL services.

2. **Open phpMyAdmin**:
   - In your browser, go to `http://localhost/phpmyadmin`.

3. **Create a Database**:
   - Click on the "New" button in the left sidebar.
   - Enter a name for your database (`hugyaw`) and click "Create".

4. **Create the Tables**:
   - Click on the newly created database.
   - Click on the "SQL" tab to open the SQL query editor.
   - Paste the following SQL statements to create the necessary tables:
     ```sql
     CREATE TABLE municipalities (
         id INT AUTO_INCREMENT PRIMARY KEY,
         name VARCHAR(255) NOT NULL
     );

     CREATE TABLE feedback (
         id INT AUTO_INCREMENT PRIMARY KEY,
         municipality_id INT NOT NULL,
         comment TEXT NOT NULL,
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
         FOREIGN KEY (municipality_id) REFERENCES municipalities(id)
     );

     CREATE TABLE quiz_questions (
         id INT AUTO_INCREMENT PRIMARY KEY,
         question TEXT NOT NULL,
         option1 VARCHAR(255) NOT NULL,
         option2 VARCHAR(255) NOT NULL,
         option3 VARCHAR(255) NOT NULL,
         option4 VARCHAR(255) NOT NULL,
         correct_option INT NOT NULL
     );

     CREATE TABLE quiz_scores (
         id INT AUTO_INCREMENT PRIMARY KEY,
         user_id INT NOT NULL,
         score INT NOT NULL,
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
         FOREIGN KEY (user_id) REFERENCES users(id)
     );

     CREATE TABLE users (
         id INT AUTO_INCREMENT PRIMARY KEY,
         username VARCHAR(255) NOT NULL,
         password VARCHAR(255) NOT NULL,
         role VARCHAR(50) NOT NULL
     );
     ```
   - Click "Go" to execute the queries.

5. **Insert Sample Data**:
   - Insert these data into the `municipalities` and `users` tables.
   - Click on the "SQL" tab and enter the following SQL queries:
     ```sql
     INSERT INTO municipalities (name) VALUES ('Barotac Nuevo'), ('Barotac Viejo'), ('Cabatuan'), ('Leon');

     INSERT INTO users (username, password, role) VALUES ('admin', 'admin123', 'admin');
     ```
   - Click "Go" to execute the queries.

### Step 3: Configure the Project

1. **Update Database Connection**:
   - Open the [`db_connection.php`](db_connection.php ) file in your project.
   - Ensure the database connection details are correct:
     ```php
     <?php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "hugyaw";

     // Create connection
     $conn = new mysqli($servername, $username, $password, $dbname);

     // Check connection
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }
     ?>
     ```

### Run the Project

1. **Place the project folder in the `htdocs` directory of your XAMPP installation (usually located at `C:\xampp\htdocs` on Windows).**

2. **Open your browser and go to `http://localhost/Hugyaw` to view the project.**

## Usage

1. **Submit Feedback:**
   - Select a municipality from the dropdown.
   - Enter your feedback in the textarea.
   - Click "Submit Feedback" to submit your feedback.

2. **View Feedback:**
   - Select a municipality from the dropdown in the "View Feedback" section.
   - Click "View Feedback" to see the feedback submitted for the selected municipality.

3. **Admin Dashboard:**
   - Log in as an admin to access the admin dashboard.
   - Manage quiz questions, feedback, users, and scores.

### Admin Credentials

- **Username:** admin
- **Password:** admin123

### Directory Structure

Hugyaw/
├── css/
│   ├── admin_style.css
│   ├── Barotac_Nuevo.css
│   ├── Barotac_Viejo.css
│   ├── Cabatuan.css
│   ├── Leon.css
│   ├── log_style.css
│   ├── quiz_style.css
│   └── style.css
├── images/
│   ├── Barotac_Nuevo/
│   │      ├── Barotac Nuevo.jpg
│   │      └── Tamasak.png
│   ├── Barotac_Viejo/
│   │      └── Barotac Viejo.jpg
│   ├── Cabatuan/
│   │      └── Cabatuan.jpg
│   └── Leon/
│           └── Leon.jpg
├── html/
│   ├── Barotac Nuevo.html
│   ├── Barotac Viejo.html
│   ├── Cabatuan.html
│   └── Leon.html
├── videos/
│   ├── Barotac Nuevo/
│   │      ├── Hiliusa.mp4
│   │      └── Tamasak.mp4
│   ├── Barotac Viejo/
│   ├── Cabatuan/
│   └── Leon/
├── db_connection.php
├── admin_dashboard.php
├── feedback.php
├── Festival.php
├── quiz.php
├── quiz_result.php
├── login.php
├── register.php
├── logout.php
└── README.md
