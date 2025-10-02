# 📚 Library Management API (Laravel 12)

A **Library Management REST API** built with **Laravel 12**, providing CRUD operations for managing users, authors, books, members, and borrowings.  
The API uses **Laravel Sanctum** for authentication and includes features like **form requests**, **resources**, **API response traits**, **global exception handling**, **rate limiting/throttling**, and **book cover image management**.  

---

## 🚀 Features

- **Authentication**
  - User registration & login using **Laravel Sanctum**
  - Authenticated users can access all CRUD operations

- **CRUD Operations**
  - **Users** – Manage system users
  - **Authors** – Manage author records
  - **Books** – Manage book details including cover images
  - **Members** – Manage library members
  - **Borrowings** – Manage book borrowing records

- **Additional Features**
  - Book **cover image upload & update**  
  - **Rate limiting & throttling** for API protection  
  - **Form Request validation** for clean input handling  
  - **API Resource classes** for structured JSON responses  
  - **Traits** for consistent API response format  
  - **Global exception handling** for error management  
  - **Postman collection** available for testing endpoints  

---

## 🛠️ Tech Stack

- **Laravel 12**
- **MySQL** (or any supported database)
- **Laravel Sanctum** (API authentication)
- **Postman** (API testing)
- **PHP 8.2+**

---

## 📂 Database Schema (Main Tables)

1. **Users** – Manage registered users  
2. **Authors** – Store author details  
3. **Books** – Store book information with cover images  
4. **Members** – Store member details  
5. **Borrowings** – Track which member borrows which book  

---

## 🔐 Authentication

This API uses **Laravel Sanctum** for token-based authentication.  
- Register → Login → Receive Token  
- Pass token in headers:  

```http
Authorization: Bearer <token>
