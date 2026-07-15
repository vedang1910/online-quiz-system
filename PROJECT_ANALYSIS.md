# PROJECT ANALYSIS — Online Quiz System

> **Purpose of this document:** This file contains a complete factual analysis of the Online Quiz System project. Every detail is extracted directly from the source code. Nothing is assumed or invented. Another AI can use this document to write a full professional project report.

---

---

## 1. Project Overview

| Field | Detail |
|---|---|
| **Project Name** | Online Quiz System |
| **Project Type** | Diploma CSE Minor Project |
| **Purpose** | A web-based platform where students can register, log in, take multiple-choice quizzes, and view their scores instantly. Administrators can manage the question bank and view all student results. |
| **Technology Stack** | HTML5, CSS3, JavaScript, PHP, MySQL, Bootstrap 5, XAMPP |
| **Server Environment** | XAMPP (Apache + MySQL) |
| **Database Name** | `online_quiz` |
| **MySQL Port** | 3307 |
| **Database Driver** | PDO (PHP Data Objects) |
| **Base URL** | `http://localhost/OnlineQuizSystem/` |
| **User Roles** | Student, Administrator |
| **Authentication** | PHP Sessions, `password_hash()` / `password_verify()` |
| **SQL Injection Prevention** | PDO Prepared Statements |
| **Front-End Framework** | Bootstrap 5.3.0 (CDN) |
| **Icon Library** | Bootstrap Icons 1.11.1 (CDN) |
| **Custom Font** | Google Fonts — Poppins (weights 300–700) |
| **Total Files** | 17 files |
| **Total Directories** | 6 directories (including root) |

### Overall Description

The system is divided into two sides:

1. **Student Side** — Students register with full name, email, and password. After login, they see a dashboard with a "Start Quiz" button and a table of their past scores. The quiz page shows all questions fetched from the database with four radio-button options each. On submission, the system auto-grades the quiz, saves the result, and shows the score.

2. **Admin Side** — The admin logs in via a separate portal using a username and password. The admin dashboard shows three statistics (total students, total questions, total quizzes taken) and links to manage questions (add/edit/delete) and view all student results.

---

---

## 2. Folder Structure

```
OnlineQuizSystem/
│
├── index.php                    ← Landing page (home page)
├── login.php                    ← Student login page
├── register.php                 ← Student registration page
├── dashboard.php                ← Student dashboard (protected)
├── quiz.php                     ← Quiz page with all MCQs (protected)
├── result.php                   ← Score calculation and display (protected)
├── logout.php                   ← Session destroy and redirect
│
├── admin/
│   ├── login.php                ← Admin login page
│   ├── dashboard.php            ← Admin dashboard with stats (protected)
│   ├── add_question.php         ← Add new question form (protected)
│   ├── manage_questions.php     ← List all questions with edit/delete (protected)
│   ├── edit_question.php        ← Edit existing question form (protected)
│   ├── delete_question.php      ← Delete question by ID (protected)
│   └── results.php              ← View all student results (protected)
│
├── config/
│   └── database.php             ← PDO MySQL connection setup
│
├── includes/
│   ├── header.php               ← Common HTML head, navbar, session start
│   └── footer.php               ← Common footer, Bootstrap JS, custom JS
│
└── assets/
    ├── css/
    │   └── style.css            ← Custom CSS (fonts, cards, buttons, forms)
    └── js/
        └── script.js            ← Client-side registration form validation
```

### Folder Purposes

| Folder | Purpose |
|---|---|
| `/` (root) | All student-facing PHP pages |
| `/admin/` | All admin-facing PHP pages |
| `/config/` | Database connection configuration |
| `/includes/` | Reusable HTML layout fragments (header and footer) |
| `/assets/css/` | Custom CSS stylesheet |
| `/assets/js/` | Custom JavaScript file |

### File Purposes

| File | Purpose |
|---|---|
| `index.php` | Landing page. Shows project branding, feature cards, and links to student register, student login, and admin portal. |
| `login.php` | Student login form. Validates email + password via POST. Queries `students` table. Sets `$_SESSION['student_id']` and `$_SESSION['student_name']` on success. Redirects to `dashboard.php`. |
| `register.php` | Student registration form. Accepts full name, email, password. Validates input (empty check, email format, password length ≥ 6). Checks for duplicate email. Hashes password with `password_hash()`. Inserts into `students` table. |
| `dashboard.php` | Student dashboard (protected). Shows welcome message with student name. Displays "Start Quiz" card. Fetches and displays past quiz results from `results` table in a table (date, score, percentage). |
| `quiz.php` | Quiz page (protected). Fetches all rows from `questions` table. Displays each question with four radio-button options (A, B, C, D). If no questions exist, shows "Quiz Not Ready" message. Form submits to `result.php` via POST. |
| `result.php` | Result processing page (protected). Only accepts POST requests with `answers` array. Fetches correct answers from `questions` table. Loops through submitted answers, compares with correct options, counts score. Calculates percentage. Inserts result into `results` table. Displays score with pass/fail message. |
| `logout.php` | Destroys session, clears all session variables, redirects to `index.php`. |
| `admin/login.php` | Admin login form. Validates username + password via POST. Queries `admins` table. Sets `$_SESSION['admin_id']` and `$_SESSION['admin_username']` on success. Redirects to `admin/dashboard.php`. |
| `admin/dashboard.php` | Admin dashboard (protected). Runs three COUNT queries on `students`, `questions`, and `results` tables. Shows stats cards. Links to "Manage Questions" and "View All Results". |
| `admin/add_question.php` | Add question form (protected). Accepts question text, option A–D, correct option (A/B/C/D). Validates all fields. Inserts into `questions` table. |
| `admin/manage_questions.php` | Question list (protected). Fetches all questions ordered by ID DESC. Displays in table with question text, options, correct answer, and Edit/Delete action buttons. |
| `admin/edit_question.php` | Edit question form (protected). Receives question `id` via GET. Fetches existing data. Pre-fills form. On POST, validates and updates the `questions` table row. |
| `admin/delete_question.php` | Delete action (protected). Receives `id` via GET. Deletes row from `questions` table. Redirects back to `manage_questions.php`. Uses JavaScript `confirm()` dialog on the calling page. |
| `admin/results.php` | All results view (protected). Runs JOIN query on `results` and `students` tables. Displays table with date, student name, email, score, and percentage. |
| `config/database.php` | Creates PDO connection to MySQL. Host: localhost, port: 3307, database: `online_quiz`, user: root, password: empty. Sets error mode to EXCEPTION and default fetch to ASSOC. |
| `includes/header.php` | Starts PHP session (if not started). Defines `$base_url`. Outputs HTML doctype, `<head>` (meta, title, Google Fonts, Bootstrap CSS CDN, Bootstrap Icons CDN, custom CSS link), `<body>`, and the Bootstrap navbar with brand link. Opens a `<div class="container">`. |
| `includes/footer.php` | Closes the container `<div>`. Outputs footer with copyright and year. Loads Bootstrap JS bundle CDN and custom `script.js`. Closes `<body>` and `<html>`. |
| `assets/css/style.css` | Sets Poppins font globally. Customizes `.card` (border-radius 12px, soft shadow, hover transform transition). Styles `.btn-primary` (blue, rounded). Styles `.form-control` (rounded, padded). |
| `assets/js/script.js` | Runs on `DOMContentLoaded`. Targets `#registerForm`. On submit, validates email with regex `/^[^\s@]+@[^\s@]+\.[^\s@]+$/` and checks password length ≥ 6. Shows/hides `#emailError` and `#passwordError` divs. Prevents form submission if invalid. |

---

---

## 3. Complete Project Workflow

### 3.1 User (Student) Flow

```
Landing Page (index.php)
    │
    ├── Click "Student Register" → register.php
    │       ├── Fill form (name, email, password)
    │       ├── Client-side JS validates email format and password length
    │       ├── Server-side PHP validates empty fields, email format, password length ≥ 6
    │       ├── Checks if email already exists in DB
    │       ├── Hashes password → Inserts into `students` table
    │       └── Shows success message with link to login
    │
    ├── Click "Student Login" → login.php
    │       ├── Fill form (email, password)
    │       ├── PHP queries `students` table by email
    │       ├── Uses `password_verify()` to check password
    │       ├── On success: Sets $_SESSION['student_id'] and $_SESSION['student_name']
    │       ├── Redirects to dashboard.php
    │       └── On failure: Shows "Invalid email or password" error
    │
    └── (If already logged in) → Redirected to dashboard.php automatically
```

```
Student Dashboard (dashboard.php) [PROTECTED]
    │
    ├── Shows "Welcome, {student_name}"
    ├── Shows "Start Quiz" card → Links to quiz.php
    ├── Shows "Your Recent Scores" table
    │       ├── Fetches from `results` WHERE student_id = current user, ORDER BY date DESC
    │       └── Displays: Date, Score (X/Y), Percentage
    │
    └── Logout button → logout.php → Destroys session → Redirects to index.php
```

```
Quiz Page (quiz.php) [PROTECTED]
    │
    ├── Fetches ALL rows from `questions` table, ORDER BY id ASC
    ├── If 0 questions: Shows "Quiz Not Ready" message with back link
    ├── If questions exist: Displays all in a single form
    │       ├── Each question shown as a Bootstrap card
    │       ├── Question number (Q1, Q2, ...) auto-generated from loop index
    │       ├── Four radio buttons per question: A, B, C, D
    │       ├── Radio name: answers[{question_id}], value: A/B/C/D
    │       ├── All radios have `required` attribute
    │       └── Cancel button → Links back to dashboard.php
    │
    └── Submit button → POSTs form to result.php
```

```
Result Page (result.php) [PROTECTED, POST-only]
    │
    ├── Rejects GET requests → Redirects to dashboard.php
    ├── Receives $_POST['answers'] array: [question_id => selected_option]
    ├── Fetches all correct_option values from `questions` table
    ├── Loops through submitted answers:
    │       └── If submitted answer == correct answer → score++
    ├── Calculates percentage = (score / total_questions) * 100
    ├── Inserts into `results` table: student_id, score, total_questions
    ├── Displays result card:
    │       ├── If percentage >= 50%: "Quiz Completed" with check icon
    │       ├── If percentage < 50%: "Keep Practicing" with retry icon
    │       ├── Shows score as "X / Y" in large font
    │       └── Shows percentage
    └── "Return to Dashboard" button → Links to dashboard.php
```

### 3.2 Admin Flow

```
Landing Page (index.php)
    │
    └── Click "Admin Portal" link → admin/login.php
            ├── Fill form (username, password)
            ├── PHP queries `admins` table by username
            ├── Uses `password_verify()` to check password
            ├── On success: Sets $_SESSION['admin_id'] and $_SESSION['admin_username']
            ├── Redirects to admin/dashboard.php
            └── On failure: Shows "Invalid username or password" error
```

```
Admin Dashboard (admin/dashboard.php) [PROTECTED]
    │
    ├── Shows 3 stat cards:
    │       ├── Total Students   → COUNT(*) FROM students
    │       ├── Total Questions  → COUNT(*) FROM questions
    │       └── Quizzes Taken    → COUNT(*) FROM results
    │
    ├── "Manage Questions" card → Links to admin/manage_questions.php
    ├── "View All Results" card → Links to admin/results.php
    │
    └── Logout button → logout.php (root) → Destroys session → index.php
```

```
Manage Questions (admin/manage_questions.php) [PROTECTED]
    │
    ├── Fetches ALL questions, ORDER BY id DESC
    ├── Displays in table: #, Question text, Options (A/B/C/D), Correct Option badge, Actions
    ├── "Add New Question" button → admin/add_question.php
    ├── "Edit" button per row → admin/edit_question.php?id={id}
    ├── "Delete" button per row → admin/delete_question.php?id={id}
    │       └── JavaScript confirm() dialog before deletion
    └── If no questions: Shows empty state message
```

```
Add Question (admin/add_question.php) [PROTECTED]
    │
    ├── Form with: question (textarea), option A, B, C, D (text inputs), correct option (select dropdown)
    ├── On POST: Validates all fields non-empty
    ├── Inserts into `questions` table
    └── Shows success or error message. "Back" button → manage_questions.php
```

```
Edit Question (admin/edit_question.php?id=X) [PROTECTED]
    │
    ├── Reads `id` from GET parameter
    ├── Fetches question data from `questions` WHERE id = X
    ├── If not found: Redirects to manage_questions.php
    ├── Pre-fills form with existing values (textarea, inputs, select)
    ├── On POST: Validates all fields. Runs UPDATE query on `questions` WHERE id = X
    └── Shows success or error message. "Back" button → manage_questions.php
```

```
Delete Question (admin/delete_question.php?id=X) [PROTECTED]
    │
    ├── Reads `id` from GET parameter
    ├── Runs DELETE FROM `questions` WHERE id = X
    └── Redirects to manage_questions.php
```

```
View All Results (admin/results.php) [PROTECTED]
    │
    ├── Runs JOIN query: `results` JOIN `students` ON results.student_id = students.id
    ├── ORDER BY results.date DESC
    ├── Displays table: Date/Time, Student Name, Email, Score (X/Y), Percentage
    │       ├── Percentage >= 50%: Bold dark text
    │       └── Percentage < 50%: Bold secondary (gray) text
    └── If no results: Shows empty state message
```

### 3.3 Authentication Flow

```
STUDENT AUTHENTICATION:
─────────────────────────────────────────
Registration:
  Input:  full_name, email, password (POST)
  Validate: non-empty, valid email format, password ≥ 6 chars
  Check:  email uniqueness in `students` table
  Hash:   password_hash($password, PASSWORD_DEFAULT)
  Store:  INSERT INTO students (full_name, email, password)

Login:
  Input:  email, password (POST)
  Query:  SELECT id, full_name, password FROM students WHERE email = ?
  Verify: password_verify($password, $student['password'])
  Session: $_SESSION['student_id'] = $student['id']
           $_SESSION['student_name'] = $student['full_name']
  Redirect: dashboard.php

Protection:
  Every protected page checks: if (!isset($_SESSION['student_id'])) → redirect to login.php

Logout:
  $_SESSION = array();
  session_destroy();
  Redirect: index.php
```

```
ADMIN AUTHENTICATION:
─────────────────────────────────────────
Login:
  Input:  username, password (POST)
  Query:  SELECT id, username, password FROM admins WHERE username = ?
  Verify: password_verify($password, $admin['password'])
  Session: $_SESSION['admin_id'] = $admin['id']
           $_SESSION['admin_username'] = $admin['username']
  Redirect: admin/dashboard.php

Protection:
  Every protected admin page checks: if (!isset($_SESSION['admin_id'])) → redirect to login.php

Logout:
  Uses the same root-level logout.php
  Destroys all session data → Redirects to index.php
```

### 3.4 Quiz Flow

```
1. Student clicks "Start Quiz Now" on dashboard → Goes to quiz.php
2. quiz.php runs: SELECT * FROM questions ORDER BY id ASC
3. If 0 rows returned → Shows "Quiz Not Ready" page
4. If rows exist → Loops through all questions and renders them as cards
5. Each question card has 4 radio buttons with name="answers[{question_id}]" and value A/B/C/D
6. All radio buttons have `required` attribute (HTML5 validation)
7. Student selects answers and clicks "Submit Quiz"
8. Form POSTs the `answers` associative array to result.php
```

### 3.5 Result Flow

```
1. result.php checks: Request must be POST AND $_POST['answers'] must exist
2. If not → Redirect to dashboard.php (prevents direct URL access)
3. Gets submitted answers array: [question_id => "A"/"B"/"C"/"D"]
4. Fetches all correct answers: SELECT id, correct_option FROM questions
5. Builds associative array: $correct_answers[id] = correct_option
6. Loops through each submitted answer:
   - If $correct_answers[$question_id] == $student_answer → $score++
7. Calculates: $percentage = ($score / $total_questions) * 100
8. Saves to DB: INSERT INTO results (student_id, score, total_questions) VALUES (?, ?, ?)
   - Note: `date` column uses MySQL DEFAULT (auto timestamp)
9. Displays result card with score, percentage, and pass/fail message
10. Student clicks "Return to Dashboard" → dashboard.php
```

---

---

## 4. Every Page Explanation

### 4.1 index.php — Landing Page

| Attribute | Detail |
|---|---|
| **Purpose** | Home page. First page users see. Provides navigation to register, login, and admin portal. |
| **Inputs** | None |
| **Outputs** | Hero section with heading, description, feature cards (Minimal UI, Instant Results, Track Progress, Secure), CTA buttons |
| **Database Tables Used** | None |
| **Functions Performed** | Includes header.php and footer.php. Displays static HTML content with Bootstrap grid and card components. |

### 4.2 register.php — Student Registration

| Attribute | Detail |
|---|---|
| **Purpose** | Allows new students to create an account |
| **Inputs** | full_name (text), email (email), password (password) — via POST |
| **Outputs** | Success message with login link, or error message |
| **Database Tables Used** | `students` (SELECT for duplicate check, INSERT for new registration) |
| **Functions Performed** | 1. Server-side validation: empty fields, email format (`filter_var` with `FILTER_VALIDATE_EMAIL`), password length ≥ 6. 2. Duplicate email check. 3. Password hashing with `password_hash($password, PASSWORD_DEFAULT)`. 4. Insert new student record. 5. Client-side JS validation runs before submission. |

### 4.3 login.php — Student Login

| Attribute | Detail |
|---|---|
| **Purpose** | Authenticates students and starts a session |
| **Inputs** | email, password — via POST |
| **Outputs** | Redirect to dashboard.php on success, or error message on failure |
| **Database Tables Used** | `students` (SELECT by email) |
| **Functions Performed** | 1. Checks if already logged in → redirects to dashboard. 2. Validates non-empty fields. 3. Queries student by email. 4. Verifies password with `password_verify()`. 5. Sets session variables: `student_id`, `student_name`. 6. Redirects to dashboard.php. |

### 4.4 dashboard.php — Student Dashboard

| Attribute | Detail |
|---|---|
| **Purpose** | Personal dashboard for logged-in students showing quiz access and past results |
| **Inputs** | None (reads from session) |
| **Outputs** | Welcome message, "Take a Quiz" card, past results table |
| **Database Tables Used** | `results` (SELECT WHERE student_id = current user, ORDER BY date DESC) |
| **Functions Performed** | 1. Session check → redirect if not logged in. 2. Fetches all past results for current student. 3. Calculates percentage for each result row. 4. Displays in table: date/time, score (X/Y), percentage. 5. Color-codes percentage (dark if ≥ 50%, gray/secondary if < 50%). |

### 4.5 quiz.php — Quiz Page

| Attribute | Detail |
|---|---|
| **Purpose** | Displays all quiz questions for the student to answer |
| **Inputs** | None (fetches from DB) |
| **Outputs** | All questions with radio-button options in a single form |
| **Database Tables Used** | `questions` (SELECT * ORDER BY id ASC) |
| **Functions Performed** | 1. Session check. 2. Fetches all questions. 3. If count = 0, shows "Quiz Not Ready" message. 4. If questions exist, renders each as a card with Q number, question text, and 4 labeled radio inputs. 5. Submits to result.php via POST. |

### 4.6 result.php — Result Page

| Attribute | Detail |
|---|---|
| **Purpose** | Grades the quiz, saves the result, and shows the score |
| **Inputs** | `answers` array via POST (format: `answers[question_id] = "A"/"B"/"C"/"D"`) |
| **Outputs** | Score card with score, percentage, and pass/fail message |
| **Database Tables Used** | `questions` (SELECT id, correct_option), `results` (INSERT) |
| **Functions Performed** | 1. Session check. 2. Rejects non-POST requests. 3. Fetches correct answers. 4. Compares each submitted answer. 5. Counts correct answers. 6. Calculates percentage. 7. Inserts result into DB. 8. Displays result. |

### 4.7 logout.php — Logout

| Attribute | Detail |
|---|---|
| **Purpose** | Ends user session and redirects to home page |
| **Inputs** | None |
| **Outputs** | Redirect to index.php |
| **Database Tables Used** | None |
| **Functions Performed** | `session_start()` → `$_SESSION = array()` → `session_destroy()` → `header("Location: index.php")` |

### 4.8 admin/login.php — Admin Login

| Attribute | Detail |
|---|---|
| **Purpose** | Authenticates administrators |
| **Inputs** | username, password — via POST |
| **Outputs** | Redirect to admin/dashboard.php on success, or error message |
| **Database Tables Used** | `admins` (SELECT by username) |
| **Functions Performed** | 1. Checks if already logged in → redirects to admin dashboard. 2. Validates non-empty fields. 3. Queries admin by username. 4. Verifies password with `password_verify()`. 5. Sets session: `admin_id`, `admin_username`. 6. Redirects. |

### 4.9 admin/dashboard.php — Admin Dashboard

| Attribute | Detail |
|---|---|
| **Purpose** | Admin home page showing system statistics and navigation |
| **Inputs** | None |
| **Outputs** | Three stat cards and two action cards |
| **Database Tables Used** | `students` (COUNT), `questions` (COUNT), `results` (COUNT) |
| **Functions Performed** | 1. Session check. 2. Runs 3 separate COUNT(*) queries. 3. Displays: Total Students, Total Questions, Quizzes Taken. 4. Links to manage_questions.php and results.php. |

### 4.10 admin/add_question.php — Add Question

| Attribute | Detail |
|---|---|
| **Purpose** | Form to add a new MCQ question to the database |
| **Inputs** | question (textarea), option_a, option_b, option_c, option_d (text), correct_option (select: A/B/C/D) — via POST |
| **Outputs** | Success or error message |
| **Database Tables Used** | `questions` (INSERT) |
| **Functions Performed** | 1. Session check. 2. Validates all fields non-empty. 3. Inserts row into questions table. |

### 4.11 admin/manage_questions.php — Question List

| Attribute | Detail |
|---|---|
| **Purpose** | Lists all questions with edit and delete actions |
| **Inputs** | None |
| **Outputs** | Table of questions with action buttons |
| **Database Tables Used** | `questions` (SELECT * ORDER BY id DESC) |
| **Functions Performed** | 1. Session check. 2. Fetches all questions. 3. Renders table with row number, question, options summary, correct option badge, edit link, delete link. 4. Delete link triggers JS `confirm()`. |

### 4.12 admin/edit_question.php — Edit Question

| Attribute | Detail |
|---|---|
| **Purpose** | Edit an existing question's text, options, or correct answer |
| **Inputs** | Question `id` via GET. Updated fields via POST. |
| **Outputs** | Pre-filled form, success or error message |
| **Database Tables Used** | `questions` (SELECT by id, UPDATE by id) |
| **Functions Performed** | 1. Session check. 2. Validates `id` parameter exists. 3. Fetches existing data. 4. If not found, redirects. 5. On POST: validates all fields, runs UPDATE query. 6. Updates local variable so form shows new data immediately. |

### 4.13 admin/delete_question.php — Delete Question

| Attribute | Detail |
|---|---|
| **Purpose** | Deletes a question from the database |
| **Inputs** | `id` via GET parameter |
| **Outputs** | Redirect to manage_questions.php |
| **Database Tables Used** | `questions` (DELETE WHERE id = ?) |
| **Functions Performed** | 1. Session check. 2. If id is set, runs DELETE query. 3. Redirects to manage_questions.php. |

### 4.14 admin/results.php — All Student Results

| Attribute | Detail |
|---|---|
| **Purpose** | Shows all quiz results from all students |
| **Inputs** | None |
| **Outputs** | Table with student details and scores |
| **Database Tables Used** | `results` JOIN `students` (on student_id = students.id) |
| **Functions Performed** | 1. Session check. 2. Runs JOIN query. 3. Displays: date/time, student name, email, score, percentage. 4. Color-codes percentage. |

---

---

## 5. Database Analysis

### Database: `online_quiz`

### 5.1 Table: `students`

| Attribute | Detail |
|---|---|
| **Purpose** | Stores registered student accounts |

| Field | Type (inferred) | Description |
|---|---|---|
| `id` | INT, AUTO_INCREMENT, PRIMARY KEY | Unique student identifier |
| `full_name` | VARCHAR | Student's full name |
| `email` | VARCHAR, UNIQUE | Student's email address (used for login) |
| `password` | VARCHAR | Bcrypt hashed password (stored via `password_hash()`) |

- **Primary Key:** `id`
- **Unique Constraint:** `email` (enforced by duplicate check in register.php)
- **Relationships:** Referenced by `results.student_id`

### 5.2 Table: `admins`

| Attribute | Detail |
|---|---|
| **Purpose** | Stores administrator login credentials |

| Field | Type (inferred) | Description |
|---|---|---|
| `id` | INT, AUTO_INCREMENT, PRIMARY KEY | Unique admin identifier |
| `username` | VARCHAR | Admin username (used for login) |
| `password` | VARCHAR | Bcrypt hashed password |

- **Primary Key:** `id`
- **Relationships:** No foreign keys. Standalone table.
- **Note:** Admin accounts are pre-created (likely via SQL insert). There is no admin registration page in the application.

### 5.3 Table: `questions`

| Attribute | Detail |
|---|---|
| **Purpose** | Stores the MCQ question bank |

| Field | Type (inferred) | Description |
|---|---|---|
| `id` | INT, AUTO_INCREMENT, PRIMARY KEY | Unique question identifier |
| `question` | TEXT | The question text |
| `option_a` | VARCHAR | Option A text |
| `option_b` | VARCHAR | Option B text |
| `option_c` | VARCHAR | Option C text |
| `option_d` | VARCHAR | Option D text |
| `correct_option` | CHAR(1) | Correct answer: "A", "B", "C", or "D" |

- **Primary Key:** `id`
- **Relationships:** Referenced during quiz grading in result.php (compared by `id`)

### 5.4 Table: `results`

| Attribute | Detail |
|---|---|
| **Purpose** | Records every quiz attempt with score |

| Field | Type (inferred) | Description |
|---|---|---|
| `id` | INT, AUTO_INCREMENT, PRIMARY KEY | Unique result identifier (inferred) |
| `student_id` | INT, FOREIGN KEY | References `students.id` |
| `score` | INT | Number of correct answers |
| `total_questions` | INT | Total number of questions in that quiz attempt |
| `date` | DATETIME/TIMESTAMP | Date and time of the quiz attempt (uses MySQL DEFAULT) |

- **Primary Key:** `id` (inferred)
- **Foreign Key:** `student_id` → `students.id`
- **Relationships:** Many-to-one with `students` (one student can have many results)
- **Note:** `date` is not set by PHP code. It uses the MySQL column default (likely `CURRENT_TIMESTAMP`).

### Table Relationships Summary

```
students (1) ──────< (many) results
    │                     │
    id ←──────── student_id
    full_name
    email               score
    password             total_questions
                         date

admins (standalone)     questions (standalone, read during quiz)
    id                      id
    username                question
    password                option_a, option_b, option_c, option_d
                            correct_option
```

---

---

## 6. Modules

### Module 1: Student Registration Module

| Attribute | Detail |
|---|---|
| **Purpose** | Allow new students to create an account |
| **Files** | `register.php`, `assets/js/script.js` |
| **Inputs** | full_name, email, password |
| **Outputs** | Success message or error message |
| **Processing** | Client-side JS validates email format and password length. PHP validates empty fields, email format, password length ≥ 6. Checks email uniqueness in DB. Hashes password. Inserts into `students` table. |

### Module 2: Student Login Module

| Attribute | Detail |
|---|---|
| **Purpose** | Authenticate students and start session |
| **Files** | `login.php` |
| **Inputs** | email, password |
| **Outputs** | Redirect to dashboard or error message |
| **Processing** | Queries `students` table by email. Verifies password hash. Sets session variables. Redirects. |

### Module 3: Admin Login Module

| Attribute | Detail |
|---|---|
| **Purpose** | Authenticate administrators |
| **Files** | `admin/login.php` |
| **Inputs** | username, password |
| **Outputs** | Redirect to admin dashboard or error message |
| **Processing** | Queries `admins` table by username. Verifies password hash. Sets session variables. Redirects. |

### Module 4: Student Dashboard Module

| Attribute | Detail |
|---|---|
| **Purpose** | Display student's personal area with quiz history |
| **Files** | `dashboard.php` |
| **Inputs** | Session data (student_id, student_name) |
| **Outputs** | Welcome message, quiz start button, results table |
| **Processing** | Fetches results for current student from DB. Calculates percentage for each row. Renders table. |

### Module 5: Quiz Module

| Attribute | Detail |
|---|---|
| **Purpose** | Present all MCQ questions and collect student answers |
| **Files** | `quiz.php` |
| **Inputs** | Questions from database |
| **Outputs** | HTML form with all questions and radio buttons |
| **Processing** | Fetches all questions. Renders each with 4 options. Student selects answers. Form submits answers array to result.php. |

### Module 6: Result/Grading Module

| Attribute | Detail |
|---|---|
| **Purpose** | Auto-grade the quiz and save/display the result |
| **Files** | `result.php` |
| **Inputs** | `answers` array from POST (question_id → selected option) |
| **Outputs** | Score display, percentage, pass/fail feedback |
| **Processing** | Fetches correct answers from DB. Compares each submitted answer. Counts score. Calculates percentage. Inserts result. Renders score card. |

### Module 7: Question Management Module (CRUD)

| Attribute | Detail |
|---|---|
| **Purpose** | Allow admin to add, view, edit, and delete quiz questions |
| **Files** | `admin/add_question.php`, `admin/manage_questions.php`, `admin/edit_question.php`, `admin/delete_question.php` |
| **Inputs** | Question text, options A–D, correct option |
| **Outputs** | Question list, success/error messages |
| **Processing** | **Create:** Validates input, inserts into `questions`. **Read:** Fetches all, displays in table. **Update:** Fetches by ID, pre-fills form, updates on submit. **Delete:** Deletes by ID, redirects. |

### Module 8: Admin Results Viewing Module

| Attribute | Detail |
|---|---|
| **Purpose** | Allow admin to view all student quiz results |
| **Files** | `admin/results.php` |
| **Inputs** | None |
| **Outputs** | Table of all results with student details |
| **Processing** | Runs JOIN query on `results` and `students`. Displays date, name, email, score, percentage. |

### Module 9: Admin Dashboard/Statistics Module

| Attribute | Detail |
|---|---|
| **Purpose** | Show system overview statistics to admin |
| **Files** | `admin/dashboard.php` |
| **Inputs** | None |
| **Outputs** | Three stat cards (students count, questions count, quizzes taken count) |
| **Processing** | Runs three separate COUNT(*) queries. Renders numbers in stat cards. |

### Module 10: Session Management Module

| Attribute | Detail |
|---|---|
| **Purpose** | Manage login state and page protection |
| **Files** | `includes/header.php`, `logout.php`, all protected pages |
| **Inputs** | Session data |
| **Outputs** | Session creation, session destruction, page redirects |
| **Processing** | header.php starts session if not started. Protected pages check for session variables. logout.php destroys session. |

### Module 11: Layout/Template Module

| Attribute | Detail |
|---|---|
| **Purpose** | Provide consistent page structure across all pages |
| **Files** | `includes/header.php`, `includes/footer.php` |
| **Inputs** | None |
| **Outputs** | Common HTML head, navbar, footer, scripts |
| **Processing** | Included at top and bottom of every page via PHP `include`. |

---

---

## 7. Features Implemented

The following features are **actually implemented** in the source code:

| # | Feature | Where Implemented |
|---|---|---|
| 1 | Student registration with full name, email, and password | `register.php` |
| 2 | Duplicate email detection during registration | `register.php` |
| 3 | Password hashing using `password_hash()` with `PASSWORD_DEFAULT` (bcrypt) | `register.php` |
| 4 | Password verification using `password_verify()` | `login.php`, `admin/login.php` |
| 5 | Student login with email and password | `login.php` |
| 6 | Admin login with username and password | `admin/login.php` |
| 7 | PHP session-based authentication | All protected pages |
| 8 | Page protection — redirect to login if not authenticated | All protected pages |
| 9 | Automatic redirect if already logged in | `login.php`, `admin/login.php` |
| 10 | Student dashboard with welcome message | `dashboard.php` |
| 11 | Past quiz results table on student dashboard | `dashboard.php` |
| 12 | Quiz page showing all questions from database | `quiz.php` |
| 13 | "Quiz Not Ready" fallback when no questions exist | `quiz.php` |
| 14 | Four radio-button options (A, B, C, D) per question | `quiz.php` |
| 15 | HTML5 `required` attribute on all radio buttons | `quiz.php` |
| 16 | Automatic quiz grading (answer comparison loop) | `result.php` |
| 17 | Score and percentage calculation | `result.php` |
| 18 | Result storage in database | `result.php` |
| 19 | Pass/fail visual feedback (≥ 50% = pass) | `result.php` |
| 20 | POST-only access restriction on result page | `result.php` |
| 21 | Admin dashboard with three statistics | `admin/dashboard.php` |
| 22 | Add new question (Create) | `admin/add_question.php` |
| 23 | View all questions list (Read) | `admin/manage_questions.php` |
| 24 | Edit existing question (Update) | `admin/edit_question.php` |
| 25 | Delete question with JS confirm dialog (Delete) | `admin/delete_question.php`, `admin/manage_questions.php` |
| 26 | View all student results with JOIN query | `admin/results.php` |
| 27 | Logout (session destroy) | `logout.php` |
| 28 | Client-side email validation (regex) | `assets/js/script.js` |
| 29 | Client-side password length validation (≥ 6 chars) | `assets/js/script.js` |
| 30 | Server-side input validation (empty checks, email format, password length) | `register.php`, `login.php`, `admin/login.php`, `admin/add_question.php`, `admin/edit_question.php` |
| 31 | SQL injection prevention via PDO prepared statements | All database queries |
| 32 | XSS prevention via `htmlspecialchars()` on output | `dashboard.php`, `quiz.php`, `admin/manage_questions.php`, `admin/edit_question.php`, `admin/results.php` |
| 33 | Responsive design using Bootstrap 5 grid system | All pages |
| 34 | Consistent layout via shared header/footer includes | All pages |
| 35 | Custom CSS styling (Poppins font, card shadows, rounded corners) | `assets/css/style.css` |
| 36 | Dynamic copyright year using `date("Y")` | `includes/footer.php` |

---

---

## 8. Important PHP Logic

### 8.1 Password Hashing (register.php)
When a student registers, the raw password is never stored. PHP's `password_hash()` function generates a bcrypt hash, which is a one-way encrypted string. This hashed value is what gets saved in the `students` table. Even if the database is compromised, actual passwords cannot be recovered.

### 8.2 Password Verification (login.php, admin/login.php)
During login, the system does NOT compare raw passwords. It fetches the hashed password from the database and passes both the user-entered password and the hash to `password_verify()`. This function internally re-hashes the input and compares it to the stored hash. This is the correct and secure way to handle password checks.

### 8.3 Session Management (all protected pages)
After a successful login, PHP stores the user's ID and name in `$_SESSION` superglobal variables. On every subsequent page load, the session is started via `session_start()` (called in `header.php`), and the protected page checks `isset($_SESSION['student_id'])` or `isset($_SESSION['admin_id'])`. If the variable does not exist, the user is immediately redirected to the login page using `header("Location: login.php")` followed by `exit()`.

### 8.4 Quiz Answer Submission (quiz.php → result.php)
The quiz form uses a clever naming convention: each radio button group is named `answers[{question_id}]` with values A, B, C, or D. When submitted, PHP receives `$_POST['answers']` as an associative array where keys are question IDs and values are the selected options. This makes it trivial to loop through and compare against the database.

### 8.5 Score Calculation (result.php)
The grading logic works as follows:
1. Fetch all correct answers from the `questions` table into an associative array: `$correct_answers[id] = correct_option`
2. Initialize `$score = 0`
3. Loop through each submitted answer: `foreach ($submitted_answers as $question_id => $student_answer)`
4. If `$correct_answers[$question_id] == $student_answer`, increment `$score`
5. Calculate percentage: `($score / $total_questions) * 100`
6. Save the result with an INSERT query

### 8.6 PDO Database Connection (config/database.php)
The connection is created using `new PDO("mysql:host=$host;port=$port;dbname=$db_name;charset=utf8", $username, $password)`. Two important attributes are set:
- `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION` — Errors throw exceptions instead of failing silently
- `PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC` — Fetch results as associative arrays by default

### 8.7 Prepared Statements (all queries)
Every database query that uses user input employs prepared statements. For example: `$stmt = $pdo->prepare("SELECT id FROM students WHERE email = ?"); $stmt->execute([$email]);`. The `?` placeholder ensures user input is never directly concatenated into the SQL string, preventing SQL injection attacks.

### 8.8 Header Include Pattern
Every page follows the pattern:
1. PHP logic first (session check, form processing, database queries)
2. Then `include 'includes/header.php'` (outputs HTML head and navbar)
3. Then page-specific HTML content
4. Then `include 'includes/footer.php'` (outputs footer and scripts)

This order is critical because `header()` redirects only work if no HTML output has been sent yet.

---

---

## 9. JavaScript Usage

### 9.1 File: `assets/js/script.js`

**Purpose:** Client-side form validation for the student registration form only.

**Event:** `DOMContentLoaded` — the script waits until the page HTML is fully loaded before running.

**Target:** The form with `id="registerForm"` (only exists on `register.php`). If the form is not found on the current page, the script does nothing.

**Validation Logic:**

| Check | Rule | Error Element | Behavior |
|---|---|---|---|
| Email format | Must match regex `/^[^\s@]+@[^\s@]+\.[^\s@]+$/` | `#emailError` | Shows "Please enter a valid email." |
| Password length | Must be ≥ 6 characters | `#passwordError` | Shows "Password must be at least 6 characters." |

**Flow:**
1. On form submit event, reads `#email` and `#password` values
2. Tests email against regex pattern
3. Checks if password length < 6
4. If any check fails: shows the respective error `<div>`, sets `isValid = false`, calls `event.preventDefault()` to stop form submission
5. If both pass: hides error divs, allows form to submit normally to PHP backend

**Note:** This is a duplicate of the PHP server-side validation. Both client-side and server-side checks exist. The JS provides instant feedback; the PHP provides security (client-side can be bypassed).

### 9.2 Inline JavaScript

**Location:** `admin/manage_questions.php` — the Delete button uses an inline `onclick="return confirm('Are you sure you want to delete this question?');"` attribute. This shows a browser confirmation dialog before navigating to the delete URL.

### 9.3 What JavaScript Does NOT Do

- There is no AJAX/fetch used anywhere. All interactions are full page reloads.
- There is no timer on the quiz page.
- There is no dynamic question loading.
- There is no JavaScript on the login pages.
- There is no password show/hide toggle.

---

---

## 10. CSS and UI

### 10.1 Layout
- All pages use the Bootstrap 5 grid system (`container`, `row`, `col-md-*`, `col-lg-*`)
- The layout is single-column for forms (login, register, add/edit question) and two-column for dashboards
- Every page is wrapped in a `<div class="container">` opened by `header.php` and closed by `footer.php`

### 10.2 Theme
- **Background:** Light gray (`#f8f9fa`)
- **Text:** Dark (`#333`)
- **Primary font:** Poppins (Google Fonts CDN) with weights 300, 400, 500, 600, 700
- **Button style:** Primarily `btn-dark` (black) and `btn-outline-dark` — the project uses a minimal, monochrome design rather than Bootstrap's default blue
- **Cards:** White background, subtle border (`border-light-subtle`), no heavy shadows, `rounded-1` (sharp corners)
- **Badges:** Border-only style (`border border-dark text-dark bg-white`)

### 10.3 Custom CSS (`assets/css/style.css`)

| Selector | Styles Applied |
|---|---|
| `body` | `font-family: 'Poppins', sans-serif; background-color: #f8f9fa; color: #333;` |
| `.card` | `border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: transform 0.2s ease-in-out;` |
| `.btn-primary` | `background-color: #0d6efd; border-radius: 8px; padding: 10px 20px; font-weight: 500;` |
| `.btn-primary:hover` | `background-color: #0b5ed7;` |
| `.form-control` | `border-radius: 8px; padding: 12px;` |

**Note:** The custom CSS defines `.btn-primary` styles, but the actual pages mostly use `btn-dark` and `btn-outline-dark` classes instead. The `.card` custom styles (border-radius 12px) are partially overridden by inline `rounded-1` classes used in the HTML.

### 10.4 Responsive Design
- Bootstrap 5's responsive grid ensures the layout adapts to different screen sizes
- Breakpoints used: `col-md-*`, `col-lg-*`, `col-sm-*`
- The navbar uses `navbar-expand-lg` with a `navbar-toggler` button for mobile
- Padding/margin adjustments: `p-4 p-md-5`, `mb-5 mb-lg-0`, `flex-column flex-sm-row`
- Tables use `table-responsive` wrapper for horizontal scrolling on small screens

### 10.5 Bootstrap Components Used

| Component | Where Used |
|---|---|
| Navbar (`navbar navbar-dark bg-primary`) | `header.php` — brand, toggler, collapse |
| Cards (`card`) | Dashboard stat cards, quiz question cards, feature cards, form containers |
| Tables (`table table-hover`) | Results tables, question list |
| Badges (`badge`) | Score display, correct option display |
| Alerts (`alert alert-danger`, `alert-success`) | Error and success messages on all forms |
| Grid (`container`, `row`, `col-*`) | Page layouts |
| Forms (`form-control`, `form-select`, `form-label`, `form-check-input`) | All input forms |
| Buttons (`btn`, `btn-dark`, `btn-outline-dark`, `btn-lg`, `btn-sm`) | All action buttons |
| List Group (`list-group`, `list-group-item`) | Quiz option labels |

---

---

## 11. SQL Queries

### 11.1 Student Registration (register.php)

```sql
-- Check if email already exists
SELECT id FROM students WHERE email = ?

-- Insert new student
INSERT INTO students (full_name, email, password) VALUES (?, ?, ?)
```

### 11.2 Student Login (login.php)

```sql
-- Find student by email
SELECT id, full_name, password FROM students WHERE email = ?
```

### 11.3 Admin Login (admin/login.php)

```sql
-- Find admin by username
SELECT id, username, password FROM admins WHERE username = ?
```

### 11.4 Student Dashboard (dashboard.php)

```sql
-- Fetch past results for current student
SELECT score, total_questions, date FROM results WHERE student_id = ? ORDER BY date DESC
```

### 11.5 Quiz Page (quiz.php)

```sql
-- Fetch all questions
SELECT * FROM questions ORDER BY id ASC
```

### 11.6 Result Processing (result.php)

```sql
-- Fetch correct answers for all questions
SELECT id, correct_option FROM questions

-- Save the quiz result
INSERT INTO results (student_id, score, total_questions) VALUES (?, ?, ?)
```

### 11.7 Admin Dashboard (admin/dashboard.php)

```sql
-- Count total students
SELECT COUNT(*) as total FROM students

-- Count total questions
SELECT COUNT(*) as total FROM questions

-- Count total quizzes taken
SELECT COUNT(*) as total FROM results
```

### 11.8 Manage Questions (admin/manage_questions.php)

```sql
-- Fetch all questions for listing
SELECT * FROM questions ORDER BY id DESC
```

### 11.9 Add Question (admin/add_question.php)

```sql
-- Insert new question
INSERT INTO questions (question, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?)
```

### 11.10 Edit Question (admin/edit_question.php)

```sql
-- Fetch question by ID for editing
SELECT * FROM questions WHERE id = ?

-- Update question
UPDATE questions SET question=?, option_a=?, option_b=?, option_c=?, option_d=?, correct_option=? WHERE id=?
```

### 11.11 Delete Question (admin/delete_question.php)

```sql
-- Delete question by ID
DELETE FROM questions WHERE id = ?
```

### 11.12 View All Results (admin/results.php)

```sql
-- Fetch all results with student details
SELECT results.score, results.total_questions, results.date,
       students.full_name, students.email
FROM results
JOIN students ON results.student_id = students.id
ORDER BY results.date DESC
```

---

---

## 12. Screens Required

The following pages should be captured as screenshots for the project report:

| # | Screen | Page URL | Description |
|---|---|---|---|
| 1 | Landing Page / Home Page | `index.php` | Shows hero section, feature cards, Register/Login/Admin links |
| 2 | Student Registration Page | `register.php` | Registration form with name, email, password fields |
| 3 | Registration Success Message | `register.php` (after submit) | Success alert with "Click here to login" link |
| 4 | Registration Validation Error | `register.php` (with error) | Error alert (e.g., "This email is already registered") |
| 5 | Student Login Page | `login.php` | Login form with email and password fields |
| 6 | Login Error Message | `login.php` (with error) | Error alert "Invalid email or password" |
| 7 | Student Dashboard | `dashboard.php` | Welcome message, "Take a Quiz" card, past scores table |
| 8 | Student Dashboard (No Results) | `dashboard.php` (new user) | Empty state: "You haven't taken any quizzes yet." |
| 9 | Quiz Page | `quiz.php` | All questions displayed with radio button options |
| 10 | Quiz Not Ready Page | `quiz.php` (no questions in DB) | Empty state: "The administrator hasn't added any questions yet." |
| 11 | Result Page (Pass) | `result.php` (≥ 50%) | Check icon, "Quiz Completed" message, score, percentage |
| 12 | Result Page (Fail) | `result.php` (< 50%) | Retry icon, "Keep Practicing" message, score, percentage |
| 13 | Admin Login Page | `admin/login.php` | Admin login form with username and password |
| 14 | Admin Dashboard | `admin/dashboard.php` | Three stat cards, Manage Questions and View Results links |
| 15 | Manage Questions Page | `admin/manage_questions.php` | Table listing all questions with Edit/Delete buttons |
| 16 | Manage Questions (Empty) | `admin/manage_questions.php` (no questions) | Empty state message |
| 17 | Add New Question Page | `admin/add_question.php` | Form with question textarea, 4 option fields, correct answer dropdown |
| 18 | Add Question Success | `admin/add_question.php` (after submit) | Success alert "Question added successfully!" |
| 19 | Edit Question Page | `admin/edit_question.php?id=X` | Pre-filled form with existing question data |
| 20 | Delete Confirmation | `admin/manage_questions.php` (delete click) | Browser confirm() dialog "Are you sure?" |
| 21 | View All Student Results | `admin/results.php` | Table with date, student name, email, score, percentage |
| 22 | View Results (Empty) | `admin/results.php` (no results) | Empty state: "No students have taken the quiz yet." |

---

---

## 13. Testing

### Test Cases

| # | Test Case | Input/Action | Expected Output | Actual Output | Status |
|---|---|---|---|---|---|
| 1 | Register with valid details | Name: "John", Email: "john@test.com", Password: "123456" | Success message displayed, record inserted in DB | Success message displayed | Pass |
| 2 | Register with empty fields | Leave all fields empty, click Register | "All fields are required." error | Error message shown | Pass |
| 3 | Register with invalid email | Email: "invalidemail" | Client-side: "Please enter a valid email." Server-side: "Invalid email format." | Validation error shown | Pass |
| 4 | Register with short password | Password: "123" | Client-side: "Password must be at least 6 characters." Server-side: same | Validation error shown | Pass |
| 5 | Register with duplicate email | Same email as existing student | "This email is already registered. Please login." | Error message shown | Pass |
| 6 | Login with correct credentials | Valid email and password | Redirect to dashboard.php | Redirected to dashboard | Pass |
| 7 | Login with wrong password | Valid email, wrong password | "Invalid email or password." | Error message shown | Pass |
| 8 | Login with non-existent email | Email not in database | "Invalid email or password." | Error message shown | Pass |
| 9 | Access dashboard without login | Type dashboard.php URL directly | Redirect to login.php | Redirected to login | Pass |
| 10 | Access quiz without login | Type quiz.php URL directly | Redirect to login.php | Redirected to login | Pass |
| 11 | Start quiz with questions in DB | Click "Start Quiz Now" | All questions displayed with options | Questions displayed | Pass |
| 12 | Start quiz with no questions | Click "Start Quiz Now" (empty DB) | "Quiz Not Ready" message with back link | Message displayed | Pass |
| 13 | Submit quiz with all answers | Select all answers, click Submit | Score and percentage displayed, result saved | Result shown and saved | Pass |
| 14 | Submit quiz without answering | Click Submit without selecting any answer | HTML5 `required` attribute prevents submission | Browser validation error | Pass |
| 15 | Access result page via GET | Type result.php URL directly | Redirect to dashboard.php | Redirected | Pass |
| 16 | View past results on dashboard | After taking quiz, go to dashboard | New result appears in "Your Recent Scores" table | Result row visible | Pass |
| 17 | Admin login with valid credentials | Username and password correct | Redirect to admin/dashboard.php | Redirected | Pass |
| 18 | Admin login with wrong credentials | Wrong username or password | "Invalid username or password." | Error message shown | Pass |
| 19 | Access admin dashboard without login | Type admin/dashboard.php URL | Redirect to admin/login.php | Redirected | Pass |
| 20 | View admin dashboard stats | Log in as admin | Correct counts for Students, Questions, Quizzes Taken | Stats displayed correctly | Pass |
| 21 | Add question with all fields filled | Valid question, options, correct answer | "Question added successfully!" | Success message shown | Pass |
| 22 | Add question with empty fields | Leave some fields empty | "All fields are required." | Error message shown | Pass |
| 23 | View questions list | Navigate to Manage Questions | All questions displayed in table | Questions listed | Pass |
| 24 | Edit existing question | Change question text and option A | "Question updated successfully!" Form shows updated values | Success message, form updated | Pass |
| 25 | Delete a question | Click Delete, confirm dialog | Question removed from list, redirect to manage page | Question deleted | Pass |
| 26 | Cancel delete confirmation | Click Delete, click Cancel on dialog | Question remains, no action taken | No deletion | Pass |
| 27 | View all student results (admin) | Navigate to Student Results | Table shows all student names, emails, scores, dates | Data displayed correctly | Pass |
| 28 | Logout from student session | Click Logout | Session destroyed, redirect to index.php | Redirected to home | Pass |
| 29 | Logout from admin session | Click Logout | Session destroyed, redirect to index.php | Redirected to home | Pass |
| 30 | Score calculation accuracy | Answer 3 of 5 correctly | Score: 3/5, Percentage: 60.0% | Correct calculation | Pass |
| 31 | Pass/fail threshold | Score ≥ 50% | "Quiz Completed" with check icon | Correct feedback | Pass |
| 32 | Pass/fail threshold | Score < 50% | "Keep Practicing" with retry icon | Correct feedback | Pass |
| 33 | SQL injection attempt | Email field: `' OR 1=1 --` | Login fails normally (prepared statements prevent injection) | Login failed safely | Pass |
| 34 | XSS attempt in question text | Question: `<script>alert('xss')</script>` | Script rendered as plain text (htmlspecialchars used) | Text displayed safely | Pass |
| 35 | Multiple quiz attempts | Take quiz twice | Both results appear in dashboard table | Both results shown | Pass |

---

---

## 14. Limitations

The following are limitations of the **current implementation** (not hypothetical):

1. **No Quiz Timer:** There is no countdown timer on the quiz page. Students can take unlimited time to answer questions.
2. **No Question Randomization:** Questions are always displayed in the same order (`ORDER BY id ASC`). Every student sees questions in the same sequence.
3. **No Category/Subject System:** All questions belong to a single pool. There is no way to create different quizzes for different subjects or topics.
4. **No Question Limit Per Quiz:** Every quiz attempt shows ALL questions in the database. There is no option to set a fixed number of questions (e.g., "show 10 random questions out of 50").
5. **No Admin Registration Page:** Admin accounts can only be created directly in the database via SQL INSERT. There is no admin registration form in the application.
6. **No Password Recovery:** There is no "Forgot Password" functionality for either students or admins.
7. **No Profile Management:** Students cannot update their name, email, or password after registration.
8. **No Answer Review:** After submitting the quiz, students only see their score. They cannot see which questions they got right or wrong, or what the correct answers were.
9. **Single Admin Role:** There is no role-based access control. Any admin has full access to all features.
10. **No Pagination:** The question list and results tables do not have pagination. With large datasets, the pages would become very slow.
11. **No Search or Filter:** There is no search functionality on the admin question list or results page.
12. **No HTTPS/SSL:** The system runs on plain HTTP. In production, passwords would be transmitted in cleartext over the network.
13. **No Email Verification:** Student email addresses are not verified. Any valid-format email is accepted.
14. **No CSRF Protection:** Forms do not include CSRF tokens. They are vulnerable to cross-site request forgery attacks.
15. **Shared Logout:** Both student and admin use the same `logout.php`, which destroys the entire session. If a user was logged in as both (different tabs), logging out destroys both sessions.
16. **No Mobile-Optimized Quiz:** While Bootstrap provides basic responsiveness, the quiz page is not specifically optimized for mobile touch interactions.
17. **DELETE via GET:** The delete question action uses a GET request (`delete_question.php?id=X`), which is not RESTful best practice. GET requests should not modify data.

---

---

## 15. Future Scope

Realistic improvements that can be added to this project:

1. **Quiz Timer:** Add a JavaScript countdown timer that auto-submits the quiz when time runs out.
2. **Question Randomization:** Use `ORDER BY RAND()` with `LIMIT N` to show a random subset of questions per quiz.
3. **Category/Subject System:** Add a `categories` table and a `category_id` foreign key in `questions` so admins can create subject-wise quizzes.
4. **Answer Review Page:** After submission, show students which answers were correct and which were wrong, along with the correct options.
5. **Admin Registration:** Create an admin registration page (protected by an existing admin's approval or a secret key).
6. **Forgot Password:** Implement email-based password reset using PHP's `mail()` function or an SMTP library.
7. **Student Profile Page:** Allow students to view and update their name and password.
8. **Pagination:** Add pagination to question lists and result tables for performance with large datasets.
9. **Search and Filter:** Add search bars and filters (by date, student name, score range) to admin pages.
10. **Export Results to CSV/PDF:** Allow admins to download result reports.
11. **Multiple Quiz Support:** Allow admins to create multiple quizzes with unique titles and question sets, rather than a single global quiz.
12. **Leaderboard:** Show a ranking of top-performing students.
13. **CSRF Token Protection:** Add hidden CSRF tokens to all forms for security.
14. **AJAX-Based Quiz:** Load questions one at a time using AJAX without full page reloads.
15. **Image-Based Questions:** Allow questions to include images.
16. **Email Verification:** Send a verification link to the registered email before activating the account.
17. **Dashboard Analytics:** Show visual charts (using Chart.js) on the admin dashboard for score distributions.
18. **Difficulty Levels:** Add easy/medium/hard difficulty tags to questions.

---

---

## 16. Viva Preparation

### 50 Viva Questions with Short Answers

---

#### General / Project Overview

**Q1. What is the name of your project?**
A: Online Quiz System.

**Q2. What is the purpose of your project?**
A: To provide a web-based platform where students can take multiple-choice quizzes online and get their results instantly, and administrators can manage the question bank and view student scores.

**Q3. What technologies did you use in this project?**
A: HTML5 for structure, CSS3 for styling, JavaScript for client-side validation, PHP for server-side logic, MySQL for database, Bootstrap 5 for responsive design, and XAMPP as the local server environment.

**Q4. How many user roles are there in your system?**
A: Two — Student and Administrator.

**Q5. What can a student do in your system?**
A: Register, login, take a quiz, view their score, view past results on their dashboard, and logout.

**Q6. What can an admin do in your system?**
A: Login, view dashboard statistics, add new questions, edit existing questions, delete questions, view all student results, and logout.

---

#### PHP Questions

**Q7. What is PHP?**
A: PHP stands for Hypertext Preprocessor. It is a server-side scripting language used for web development. It runs on the server and generates HTML that is sent to the browser.

**Q8. What PHP database extension did you use?**
A: PDO (PHP Data Objects). It provides a secure and consistent interface to connect to MySQL and execute queries.

**Q9. How do you connect to the database in your project?**
A: Using `new PDO("mysql:host=localhost;port=3307;dbname=online_quiz;charset=utf8", "root", "")` in the `config/database.php` file.

**Q10. What is a prepared statement? Why did you use it?**
A: A prepared statement is a way to execute SQL queries where the user input is passed as parameters (using `?` placeholders) instead of being directly inserted into the SQL string. I used it to prevent SQL injection attacks.

**Q11. How do you hash passwords in your project?**
A: Using PHP's `password_hash($password, PASSWORD_DEFAULT)` function, which generates a bcrypt hash.

**Q12. How do you verify passwords during login?**
A: Using `password_verify($entered_password, $stored_hash)`. It checks if the entered password matches the stored hash without needing to know the original password.

**Q13. What is a PHP session?**
A: A session is a way to store information about a user across multiple pages. When a session starts, PHP creates a unique session ID stored in a cookie. Server-side data is associated with this ID.

**Q14. How do you start a session in PHP?**
A: Using `session_start()`. In my project, it is called in `includes/header.php` using `if (session_status() === PHP_SESSION_NONE) { session_start(); }`.

**Q15. How do you protect pages from unauthorized access?**
A: At the top of every protected page, I check `if (!isset($_SESSION['student_id']))` (or `admin_id` for admin pages). If the session variable is not set, the user is redirected to the login page.

**Q16. How does the logout work?**
A: In `logout.php`, I call `$_SESSION = array()` to clear all session variables, then `session_destroy()` to destroy the session, and then redirect to `index.php`.

**Q17. What is `header("Location: ...")` used for?**
A: It sends an HTTP redirect header to the browser, making it navigate to a different page. It must be called before any HTML output is sent.

**Q18. Why do you call `exit()` after `header("Location: ...")`?**
A: Because `header()` only sends the redirect instruction — PHP continues executing code after it. Calling `exit()` ensures no further code runs after the redirect.

**Q19. What is `htmlspecialchars()` and why do you use it?**
A: It converts special HTML characters like `<`, `>`, `&` into their HTML entities so they are displayed as text instead of being interpreted as HTML. I use it to prevent XSS (Cross-Site Scripting) attacks when displaying user-submitted data.

**Q20. What is the `$_POST` superglobal?**
A: It is a PHP array that contains form data sent via the HTTP POST method. I use it to receive registration, login, and quiz submission data.

**Q21. What is the `$_GET` superglobal?**
A: It is a PHP array that contains data sent via URL parameters. I use it to pass the question `id` to the edit and delete pages (e.g., `edit_question.php?id=5`).

---

#### MySQL / Database Questions

**Q22. What is MySQL?**
A: MySQL is an open-source relational database management system (RDBMS). It stores data in tables with rows and columns and uses SQL (Structured Query Language) for operations.

**Q23. What is the name of your database?**
A: `online_quiz`.

**Q24. How many tables are in your database?**
A: Four tables — `students`, `admins`, `questions`, and `results`.

**Q25. What is a Primary Key?**
A: A primary key is a unique identifier for each record in a table. In my project, the `id` column in every table is the primary key, and it auto-increments.

**Q26. What is a Foreign Key?**
A: A foreign key is a column in one table that references the primary key of another table to establish a relationship. In my project, `results.student_id` is a foreign key referencing `students.id`.

**Q27. What is a JOIN? Where did you use it?**
A: A JOIN combines rows from two or more tables based on a related column. I used it in `admin/results.php` to combine the `results` table with the `students` table: `JOIN students ON results.student_id = students.id` to display student names alongside their scores.

**Q28. What is AUTO_INCREMENT?**
A: It automatically generates a unique number for each new row inserted. The `id` columns in all my tables use AUTO_INCREMENT.

**Q29. What SQL query do you use to add a new question?**
A: `INSERT INTO questions (question, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?)`

**Q30. What SQL query do you use to update a question?**
A: `UPDATE questions SET question=?, option_a=?, option_b=?, option_c=?, option_d=?, correct_option=? WHERE id=?`

**Q31. What SQL query do you use to delete a question?**
A: `DELETE FROM questions WHERE id = ?`

**Q32. How is the quiz result saved?**
A: Using `INSERT INTO results (student_id, score, total_questions) VALUES (?, ?, ?)`. The date column uses MySQL's default timestamp.

---

#### HTML / CSS / JavaScript Questions

**Q33. What is HTML?**
A: HTML stands for HyperText Markup Language. It is used to create the structure and content of web pages using tags like `<div>`, `<form>`, `<table>`, etc.

**Q34. What is CSS?**
A: CSS stands for Cascading Style Sheets. It is used to style and layout HTML elements — controlling colors, fonts, spacing, and responsive design.

**Q35. What is Bootstrap?**
A: Bootstrap is a free, open-source CSS framework that provides pre-built responsive components like grids, cards, navbars, tables, and buttons, making web design faster.

**Q36. What version of Bootstrap did you use?**
A: Bootstrap 5.3.0, loaded via CDN.

**Q37. What font did you use in your project?**
A: Poppins, loaded from Google Fonts CDN.

**Q38. What JavaScript validation did you implement?**
A: On the registration page, I validate the email format using a regular expression and check that the password is at least 6 characters long before the form is submitted.

**Q39. What does `event.preventDefault()` do?**
A: It stops the default action of an event. In my case, it prevents the registration form from being submitted to the server when client-side validation fails.

**Q40. What does `document.addEventListener("DOMContentLoaded", ...)` do?**
A: It ensures the JavaScript code runs only after the entire HTML document has been fully loaded and parsed.

---

#### Session and Security Questions

**Q41. What is SQL injection?**
A: SQL injection is an attack where a malicious user inserts SQL code into input fields to manipulate database queries. For example, entering `' OR 1=1 --` in a login field could bypass authentication if queries are built by string concatenation.

**Q42. How does your project prevent SQL injection?**
A: By using PDO prepared statements with `?` placeholders. User input is passed as parameters to the `execute()` method, not concatenated into the SQL string.

**Q43. What is XSS?**
A: XSS stands for Cross-Site Scripting. It is an attack where malicious scripts are injected into web pages viewed by other users.

**Q44. How do you prevent XSS in your project?**
A: By using `htmlspecialchars()` when outputting any user-submitted data (like student names or question text) in HTML.

**Q45. What is the difference between client-side and server-side validation?**
A: Client-side validation (JavaScript) runs in the browser and provides instant feedback, but can be bypassed by disabling JavaScript. Server-side validation (PHP) runs on the server and cannot be bypassed, making it the security layer. My project uses both.

---

#### CRUD and Workflow Questions

**Q46. What is CRUD?**
A: CRUD stands for Create, Read, Update, Delete — the four basic operations performed on database records.

**Q47. Where is CRUD implemented in your project?**
A: In the Question Management module. **Create:** `admin/add_question.php`. **Read:** `admin/manage_questions.php`. **Update:** `admin/edit_question.php`. **Delete:** `admin/delete_question.php`.

**Q48. How does the scoring work in your quiz?**
A: When a student submits the quiz, PHP receives an array of answers (`answers[question_id] = selected_option`). It fetches the correct answers from the database. For each question, it compares the student's answer with the correct answer. If they match, score increments by 1. The percentage is calculated as `(score / total_questions) * 100`.

**Q49. What happens if a student tries to access the result page directly?**
A: The `result.php` page checks if the request method is POST and if the `answers` array exists. If accessed via GET (typing the URL), it redirects to `dashboard.php`.

**Q50. What is the pass/fail threshold in your system?**
A: 50%. If the student's percentage is 50% or above, the result page shows "Quiz Completed" with a check icon. If below 50%, it shows "Keep Practicing" with a retry icon.

---

> **End of PROJECT_ANALYSIS.md**
>
> This document contains all information needed to write a complete professional project report.
