# Company Invoice Manager with VAT

A simple web-based invoice management system built using PHP and MySQL.  
This application allows users to manage clients, create invoices, and automatically calculate VAT.

---

## 🚀 Features

- User authentication (login system)
- Add and manage clients
- Create invoices with VAT calculation
- View invoice details
- Dashboard overview
- Simple and clean UI

---

## 🛠️ Technologies Used

- PHP (Core PHP)
- MySQL (Database)
- HTML, CSS
- XAMPP (Apache server for local development)

---

## 📂 Project Structure

```
invoice-manager/
├── db.php
├── login.php
├── logout.php
├── dashboard.php
├── clients.php
├── add_client.php
├── invoices.php
├── add_invoice.php
├── view_invoice.php
└── style.css
```

---

## ⚙️ How to Run the Project

### 1. Clone the repository

```bash
git clone https://github.com/kgoti/Invoice-Manager-With-VAT.git
```

---

### 2. Move project to XAMPP

Copy the folder to:

```
C:\xampp\htdocs\
```

---

### 3. Start server

Open XAMPP Control Panel and start:

- Apache
- MySQL

---

### 4. Setup database

Open:

```
http://localhost/phpmyadmin
```

Create a database:

```
invoice_manager
```

Then run the following SQL:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150),
    address VARCHAR(255)
);

CREATE TABLE invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    invoice_number VARCHAR(20) NOT NULL,
    amount_netto DECIMAL(10,2) NOT NULL,
    vat_rate INT NOT NULL DEFAULT 19,
    vat_amount DECIMAL(10,2) NOT NULL,
    amount_brutto DECIMAL(10,2) NOT NULL,
    status ENUM('unpaid','paid') DEFAULT 'unpaid',
    created_at DATE NOT NULL,
    due_date DATE NOT NULL,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);
```

---

### 5. Configure database connection

Update `db.php`:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "invoice_manager";
```

---

### 6. Run the project

Open in browser:

```
http://localhost/invoice-manager/login.php
```

---

## 🔐 Default Login

You need to manually insert a user into the database.

Example:

```sql
INSERT INTO users (name, email, password)
VALUES (
  'admin',
  'admin@gmail.com',
  '$2y$10$wH9/fu2CPSGeLgxevX5M5uV3TkINfHQJ.mfOPzPW.ZVgRh6Fz0aiG'
);
```

Login with:

```
Email: admin@gmail.com
Password: admin123
```

---

## 📌 Future Improvements

- User registration system
- Invoice PDF export
- Improved UI/UX
- Role-based authentication
- Deployment to cloud (Render/Railway)

---

## 👨‍💻 Author

Kartik Goti
