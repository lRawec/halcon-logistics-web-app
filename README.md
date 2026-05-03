# Halcon: A Construction Logistics & Order Management System

## Project Description
**Halcon** is a dedicated internal management platform designed for a construction material distributor. The application digitizes the entire lifecycle of a customer order—from the initial sales call to the final physical delivery at the construction site. 

The system serves as a bridge between the office, the warehouse, and the field, providing real-time visibility to both employees and customers through a secure, role-based dashboard and a public tracking interface.

---

## Project Objectives
* **Process Automation:** Replace manual tracking with a digital workflow that reduces human error.
* **Operational Transparency:** Allow customers to self-serve their order status dynamically without needing to call the office.
* **Accountability:** Implement mandatory photographic evidence at key logistics stages.
* **Data Integrity & Security:** Maintain a full history of all orders using logical deletions (Soft Deletes) and restrict system access through strict Role-Based Access Control (RBAC).

---

## Stakeholders & Roles
The system is built around the specific hierarchy of the Halcon team, safeguarded by custom middleware:

| Role | Key Responsibility | System Access Level |
| :--- | :--- | :--- |
| **Admin** | User onboarding and permission management. | Full access to all modules and user creation. |
| **Sales** | Order entry, customer data management. | Can create orders and view active/archived lists. |
| **Warehouse** | Inventory verification and order preparation. | Can update statuses to *In Process* and *In Route*. |
| **Purchasing** | Sourcing materials out of stock. | View-only access to specific dashboard metrics. |
| **Route** | Logistics execution and evidence uploads. | Can update to *Delivered* and upload photos. |

---

## The Halcon Order Life Cycle
To ensure consistency, orders must progress through the following mandatory statuses:

1.  **Ordered:** Initial state created by Sales.
2.  **In Process:** Claimed by the Warehouse for picking and packing.
3.  **In Route:** Unit is loaded; **Photo 1 (Loaded Unit)** is required.
4.  **Delivered:** Material arrives at the destination; **Photo 2 (Unloaded Material)** is required.

---

## Key Functional Modules (Evidence 3 Implementation)

### 1. Customer Tracking Portal (Welcome View)
A public, Tailwind CSS-styled portal where customers enter their **Customer Number** and **Invoice Number** to see their real-time status. Upon delivery, the system displays the final delivery photo as proof.

### 2. Administrative Dashboard & Order Management
A private, role-protected environment for staff to manage the "live" list of orders:
* **Advanced Search Engine:** Filter active orders by Invoice, Customer ID, Date, or Status.
* **Soft-Delete Logic (Trash):** Orders are never hard-deleted. They are hidden and moved to an "Archived Orders" screen where they can be restored or audited.
* **Photo Evidence System:** Role-specific file upload functionality securely storing logistics photos via Laravel's local storage.

### 3. User Experience (UX) & Notifications
* **Visual Alerts:** Integration of Toastr notifications to provide immediate user feedback on all CRUD operations, status changes, and permission denials (403 Custom View).
* **Responsive Design:** Complete UI overhaul using modern frameworks to ensure accessibility across desktop and mobile devices.

---

## Technical Stack & Architecture
This platform leverages modern web development standards and MVC architecture:
* **Backend Framework:** Laravel 11 (PHP 8.2)
* **Frontend:** Blade Templating Engine, Tailwind CSS (via Vite), Toastr.
* **Database:** MySQL (Eloquent ORM, Migrations, Seeders).
* **Authentication & Security:** Custom session-based login, RBAC Middleware, Custom 403 pages.
* **File Storage:** Local storage system for secure evidence image uploads.

---

## Local Setup Instructions
To run this project locally for testing and evaluation:

1. Clone the repository:
   ```bash
   git clone [https://github.com/lRawec/halcon-logistics-web-app.git](https://github.com/lRawec/halcon-logistics-web-app.git)
   ```

## Install dependencies:

   ```Bash
   composer install
   npm install && npm run build
   ```

3. Setup the environment file (.env) and configure your database credentials.

4. Run migrations and seeders (loads initial users and test data):

   ```Bash
   php artisan migrate:fresh --seed
   ```

5. Link the storage folder (crucial for evidence images to load):
   ```Bash
   php artisan storage:link
   ```

6. Start the local server:

   ```Bash
   php artisan serve

## Test Credentials

* **Admin:** admin / admin123

* **Sales:** sales_user / sales123

* **Warehouse:** warehouse_user / warehouse123

* **Route:** route_user / route123