Markdown
# Halcon: A Construction Logistics & Order Management System

## Project Description
**Halcon** is a dedicated internal management platform designed for a construction material distributor. The application digitizes the entire lifecycle of a customer order—from the initial sales call to the final physical delivery at the construction site. 

The system serves as a bridge between the office, the warehouse, and the field, providing real-time visibility to both employees and customers through a secure, role-based dashboard and a public tracking interface.

---

## Project Objectives
* **Process Automation:** Replace manual tracking with a digital workflow that reduces human error.
* **Operational Transparency:** Allow customers to self-serve their order status without needing to call the office.
* **Accountability:** Implement mandatory photographic evidence at key stages (Loading and Delivery).
* **Data Integrity:** Maintain a full history of all orders, including "deleted" entries, to ensure no record is ever truly lost.

---

## Stakeholders & Roles
The system is built around the specific hierarchy of the Halcon team:

| Role | Key Responsibility |
| :--- | :--- |
| **Admin** | User onboarding and permission management. |
| **Sales** | Order entry, customer data management, and fiscal record linking. |
| **Warehouse** | Inventory verification, order preparation, and stock alerts for Purchasing. |
| **Purchasing** | Sourcing materials that are out of stock or low in inventory. |
| **Route** | Logistics execution and uploading photographic Proof of Delivery (PoD). |

---

## The Halcon Order Life Cycle
To ensure consistency, orders must progress through the following mandatory statuses:

1.  **Ordered:** Initial state created by Sales.
2.  **In Process:** Claimed by the Warehouse for picking and packing.
3.  **In Route:** Unit is loaded; **Photo 1 (Loaded Unit)** is required.
4.  **Delivered:** Material arrives at the destination; **Photo 2 (Unloaded Material)** is required.

---

## Key Functional Modules

### Customer Tracking Portal
A simplified public view where customers enter their **Invoice Number** to see their status. Upon delivery, the system displays the final delivery photo as proof.

### Administrative Dashboard
A private environment for staff to manage the "live" list of orders.
* **Search Engine:** Filter by Invoice, Customer ID, Date, or Status.
* **Soft-Delete Logic:** Orders are never hard-deleted; they are moved to a "Restoration Screen" (Archived Orders) where they can be recovered if needed.
* **Evidence Management:** Role-specific functionality for uploading and viewing logistical photos.

---

## Technical Stack & Architecture (Evidence 2 Implementation)
This platform was built leveraging modern web development standards and MVC architecture:
* **Backend Framework:** Laravel (PHP)
* **Database:** MySQL / SQLite (Eloquent ORM)
* **Authentication:** Custom session-based login with Middleware protection.
* **File Storage:** Local storage system for secure evidence image uploads (`storage:link`).
* **Database Design:** Implementation of Foreign Keys (1:N relationships between Orders, Customers, Users, and Photo Evidences) and SoftDeletes.

---

## Local Setup Instructions
To run this project locally for testing and evaluation:

1. Clone the repository:
   ```bash
   git clone [https://github.com/lRawec/halcon-logistics-web-app.git](https://github.com/lRawec/halcon-logistics-web-app.git)
Install dependencies:

Bash
composer install
npm install && npm run build
Setup the environment file (.env) and configure your database credentials.

Run migrations and seeders (loads initial Admin and Customers):

Bash
php artisan migrate --seed
Link the storage folder (crucial for evidence images to load):

Bash
php artisan storage:link
Start the local server:

Bash
php artisan serve
Future Roadmap
Integration with email services for automated fiscal invoice delivery.

GPS tracking for the Route department.

Inventory level analytics for the Purchasing department.
