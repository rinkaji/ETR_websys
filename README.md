Supply Management System
Overview
The Supply Management System is a web-based application designed to streamline and enhance the management of supplies within an organization. It provides distinct functionalities for Admin and Office users to efficiently handle inventory, requests, and user accounts in a secure and confidential environment.

Developed using Laravel, the system supports seamless supply tracking, request management, and detailed reporting through user-friendly dashboards.

Features
Admin Side
Dashboard Overview: Real-time view of total items, low stock alerts, and pending requests.
Supply Management: Add, edit, and delete supplies; manage units of measurement dynamically.
User Management: Create and manage user accounts for supply offices and departments.
Request Management: Monitor, accept, or reject supply requests; automatically update inventory.
Stock Card: View and download detailed stock cards including monthly balances and transactions.
Transaction History: Filterable request history grouped by department or office.
Office Side
Dashboard Overview: Summary of past requests and current supply availability in real time.
Supply Requests: Create new requests by selecting supplies and specifying quantities.
Request Tracking: View status and details of all submitted requests.
User Profile: View profile information with office and email details.
Logout: Securely log out from the system.
Installation & Setup
Clone the repository

bash
Run
Copy code
git clone https://github.com/your-repo/supply-management-system.git
cd supply-management-system
Install dependencies
Make sure you have Composer installed. Then run:

bash
Run
Copy code
composer install
Configure environment
Copy .env.example to .env and set your database credentials and other environment variables.

Generate application key

bash
Run
Copy code
php artisan key:generate
Run migrations

bash
Run
Copy code
php artisan migrate
Seed database (optional, if seeders are included)

bash
Run
Copy code
php artisan db:seed
Run the application

bash
Run
Copy code
php artisan serve
Access the application at http://localhost:8000.

User Accounts
The system provides a default Admin account upon setup.
Admin users are responsible for creating all Office/Department user accounts to ensure confidentiality and proper tracking.
Troubleshooting
Ensure your database server (such as MySQL via XAMPP) is running.
Check Laravel logs at storage/logs/laravel.log for errors.
Clear cached config using:
bash
Run
Copy code
php artisan config:cache
If you lose access, contact your Admin user for account recovery.
Support
For any issues or assistance, contact:

Email: jmillena_21ur0307@psu.edu.ph
Phone: (075) 5625412
Live Chat: John Pert Millena