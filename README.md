﻿# selise-test-saas

Swagger
php artisan l5-swagger:generate
Go to http://127.0.0.1:8000/api/documentation


---


# Laravel + Vue.js Employee Management App

This is a simple Employee Management application built with **Laravel (API only)** and **Vue.js**. It supports CRUD operations for employees using a modal-based UI and a token-free public API.

---

## ⚙️ Tech Stack

- **Backend:** Laravel 10 (API), Eloquent, Sanctum-ready (optional)
- **Frontend:** Vue 3 + Vite
- **API Requests:** Axios (with centralized instance)
- **Styling:** Tailwind CSS

---

## 📦 Features

- ✅ List all employees  
- ✅ Create, edit, delete employees via modal forms  
- ✅ Centralized Axios setup  
- ✅ Form validation via Laravel FormRequest  
- ✅ RESTful API (public, no auth)

---

## 🛠️ Setup Instructions

### Backend (Laravel)

1. Clone the repo:
    ```bash
    git clone https://github.com/your-username/your-repo.git
    cd backend
    ````

2. Install dependencies:

   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

3. Configure your database in `.env` and then run:

   ```bash
   php artisan migrate
   php artisan serve
   ```

---

### Frontend (Vue.js)

1. Navigate to the frontend folder:

   ```bash
   cd frontend
   ```

2. Install dependencies:

   ```bash
   npm install
   ```

3. Run the dev server:

   ```bash
   npm run dev
   ```

Make sure Laravel is running at `http://localhost:8000`.

---

## 📄 API Endpoints

| Method | Endpoint               | Description        |
| ------ | ---------------------- | ------------------ |
| GET    | `/api/v1/employees`     | Get all employees   |
| POST   | `/api/v1/employees`     | Create new employee |
| GET    | `/api/v1/employees/:id` | Get employee by ID  |
| PUT    | `/api/v1/employees/:id` | Update employee     |
| DELETE | `/api/v1/employees/:id` | Delete employee     |

---

## 📌 Notes

* Axios requests are centralized in `axiosInstance.js` with `baseURL` and `withCredentials` pre-configured.
* If needed, Laravel Sanctum can be enabled for authentication.
* Validation rules are handled using Laravel’s `StoreEmployeeRequest` and `UpdateEmployeeRequest`.

---

## ✨ Author

**Md Pavel Rahman**

## Problems

* Not getting UUID, getting numeric Ids


## Application Performance Challenge

* Eager loading relationships: $query = Employee::with('detail', 'department');
* Index migrations: $table->index(['department_id']);
* Avoid unnecessary re-renders: v-if="showForm"
* Avoid calling API on every keystroke: 

   ```
   const debouncedSearch = debounce(() => {
      store.setFilter('search', search.value)
   }, 500)
   ```

## Project Demo Screenshots
![image](https://github.com/user-attachments/assets/0ecab921-5c37-4209-b947-7f9d6572d266)
![image](https://github.com/user-attachments/assets/045758b6-3214-4e79-9746-8ae8ca31d4d9)
![image](https://github.com/user-attachments/assets/023cb0c6-543d-45e7-9daf-d868ac833c41)
