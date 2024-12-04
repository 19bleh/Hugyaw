# Hugyaw Festival Feedback

This project is a web application for collecting and displaying feedback for various municipalities during the Hugyaw Festival. It allows users to select a municipality, submit their feedback, and view feedback submitted by others.

## Features

- Submit feedback for a selected municipality.
- View feedback for a selected municipality.
- Responsive design with a consistent theme.

## Technologies Used

- HTML
- CSS
- PHP
- MySQL
- XAMPP

## Setup Instructions

### Prerequisites

- XAMPP (or any other local server environment)
- Git

### Step 1: Clone the Project from GitHub

1. **Open GitHub**:
   - Go to the GitHub repository URL provided by your group.

2. **Clone the Repository**:
   - Copy the repository URL.
   - Open a terminal or Git Bash on your computer.
   - Navigate to the directory where you want to clone the repository.
   - Run the following command:
     ```sh
     git clone https://github.com/markalvincadangin/Hugyaw
     ```

3. **Navigate to the Project Directory**:
   - After cloning, navigate to the project directory:
     ```sh
     cd https://github.com/markalvincadangin/Hugyaw
     ```

### Step 2: Set Up the Database Using XAMPP

1. **Start XAMPP**:
   - Open the XAMPP Control Panel.
   - Start the Apache and MySQL services.

2. **Open phpMyAdmin**:
    In- your browser, go to `http://localhost/phpmyadmin`.

3. **Create a Database**:
   - Click on the "New" button in the left sidebar.
   - Enter a name for your database (`hugyaw`) and click "Create".

4. **Create the Tables**:
   - Click on the newly created database.
   - Click on the "SQL" tab to open the SQL query editor.
   - Paste the following SQL statements to create the `municipalities` and `feedback` tables:
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
     ```
   - Click "Go" to execute the queries.

5. **Insert Sample Data**:
   - You can insert some sample data into the `municipalities` table for testing.
   - Click on the "SQL" tab and enter the following SQL query:
     ```sql
     INSERT INTO municipalities (name) VALUES ('Barotac Nuevo'), ('Barotac Viejo'), ('Cabatuan'), ('Leon');
     ```
   - Click "Go" to execute the query.

### Step 3: Configure the Project

1. **Update Database Connection**:
   - Open the [db_connection.php](http://_vscodecontentref_/0) file in your project.
   - Ensure the database connection details are correct:
     ```php
     <?php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "feedback_db";

     // Create connection
     $conn = new mysqli($servername, $username, $password, $dbname);

     // Check connection
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }
     ?>
     ```

2. **Run the Project**:
   - Place the project folder in the `htdocs` directory of your XAMPP installation (usually located at `C:\xampp\htdocs` on Windows).
   - Open your browser and go to `http://localhost/Hugyaw` to view the project.

## Usage

1. **Submit Feedback**:
   - Select a municipality from the dropdown.
   - Enter your feedback in the textarea.
   - Click "Submit Feedback" to submit your feedback.

2. **View Feedback**:
   - Select a municipality from the dropdown in the "View Feedback" section.
   - Click "View Feedback" to see the feedback submitted for the selected municipality.