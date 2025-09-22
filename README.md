# PHP_LabTask4.3 – Mini Registration + Display

## Project Description
This is a simple PHP project demonstrating the use of **POST, SESSION, and GET**.  
Users can register with their **name, age, and email**, store the data in a session, and view the information on a profile page.

---

## Flow
1. **Registration Form (POST)**  
   - User fills out a form with **Name**, **Age**, and **Email**.  
   - Data is sent via **POST** to `register_process.php`.

2. **Session Storage**  
   - Submitted data is stored in a **SESSION** variable, allowing temporary storage across pages.

3. **Profile Page (GET)**  
   - After registration, the user is redirected to `profile.php?view=details`.  
   - The profile page reads the SESSION data and displays the user’s details.

---

## Files
- `register.php` – Registration form page (POST form).  
- `register_process.php` – Processes form data and stores it in SESSION.  
- `profile.php` – Displays the registered user’s information using GET and SESSION.

---

## Expected Output
After submitting the form, the profile page shows:  
- Name  
- Age  
- Email  

_(additional)_
- Date when it registerer _(DAY, MONTH, YEAR)_

---

## Technical Concepts Used
- **POST** – Secure form submission.  
- **SESSION** – Temporary storage of user data across pages.  
- **GET** – Navigation to profile page using query parameter (`profile.php?view=details`).  
- **Bootstrap 5** – Modern responsive design.

---

## How to Run
1. Place the project folder in your local server (e.g., `htdocs` in XAMPP).  
2. Open `register.php` in your browser (e.g., `http://localhost/PHP_LabTask4.3/register.php`).  
3. Fill out the form and submit.  
4. You will be redirected to `profile.php?view=details`, displaying your submitted information.

---

## Notes
- No database is used; all data is stored in PHP **sessions**.  
- Data is temporary and will be cleared when the session ends or the browser is closed.  
- Ideal for demonstrating basic **PHP form handling and session management**.
