
# Easy Clinical

Easy Clinical is a system developed to facilitate the management of medical clinics, offering features for patient management, appointments, medical records, and other administrative aspects.

## Features

- Patient registration and management
- Appointment scheduling
- Electronic medical record management
- Reports and dashboards
- User and permission control

## Technologies Used

- **Backend:** PHP (Laravel)
- **Frontend:** Blade
- **Database:** MySQL
- **ORM:** Eloquent
- **Dependency Management:** Composer and npm

## Project Structure

```
easy-clinical/
├── backend/
├── frontend/
├── .gitignore
├── LICENSE
└── README.md
```

## Prerequisites

- **Backend:**
  - PHP 8.x
  - Composer installed
  - MySQL database configured

- **Frontend:**
  - Node.js (Recommended version: 16 or higher)
  - npm installed

## How to Run

1. Clone the repository:

   ```bash
   git clone https://github.com/victorfg21/easy-clinical.git
   ```

2. For the **Backend**, navigate to the 'backend' folder and run:

   ```bash
   composer install
   ```

3. Configure the environment variables for the database connection in the `.env` file.

4. Run the migrations:

   ```bash
   php artisan migrate
   ```

5. Start the server:

   ```bash
   php artisan serve
   ```

6. For the **Frontend**, navigate to the 'frontend' folder and run:

   ```bash
   npm install
   npm run dev
   ```

7. Access the system through the URL provided by the backend.

## License

MIT License
