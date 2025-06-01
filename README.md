Event Management System

A Laravel-based web application for creating, managing, and tracking events, invitations, and requisition lists. This system allows users to organize events, invite guests, and manage item requisitions with public or private visibility.

Features





Event Management: Create, view, and filter events by type and status.



Invitations: Send invitations, track responses (accepted, pending, rejected), and manage guest lists.



Requisition Lists: Add items to events, mark them as gifts, and allow invited users to claim items.



Public/Private Visibility: Control whether requisition lists are visible to all users or only invited guests.



Responsive Design: Built with Tailwind CSS for a modern, mobile-friendly interface.



Livewire Integration: Real-time updates for dynamic components like requisition lists and invitations.

Prerequisites





PHP >= 8.1



Composer



Node.js and npm



MySQL or another supported database



Git

Installation





Clone the Repository

git clone https://github.com/saranyaunni08/event-management-system
cd event-management-system



Install PHP Dependencies

composer install



Install JavaScript Dependencies

npm install
npm run build



Set Up Environment





Copy the example environment file:

cp .env.example .env



Update .env with your database credentials and other settings (e.g., DB_DATABASE, DB_USERNAME, DB_PASSWORD).



Generate an application key:

php artisan key:generate



Run Database Migrations

php artisan migrate



Start the Development Server

php artisan serve

Access the application at http://localhost:8000.

Usage





Create an Event: Log in, go to "My Events," and click "Create Event" to add a new event with details like date, time, and type.



Manage Invitations: Invite users to events and track their responses (accepted, pending, rejected).



Requisition Lists: Add items to an event’s requisition list, toggle public/private visibility, and allow invited users to claim items.



Filter Events: Use the search and filter options to view upcoming or past events by type or status.

Project Structure

event-management-system/
├── app/
│   ├── Livewire/
│   │   ├── EventShow.php
│   │   ├── RequisitionList.php
│   ├── Models/
│   │   ├── Event.php
│   │   ├── Invitation.php
│   │   ├── RequisitionItem.php
├── resources/
│   ├── views/
│   │   ├── livewire/
│   │   │   ├── event-show.blade.php
│   │   │   ├── requisition-list.blade.php
│   ├── css/
│   ├── js/
├── public/
├── .gitignore
├── composer.json
├── package.json
├── README.md

Contributing

Contributions are welcome! To contribute:





Fork the repository.



Create a feature branch: git checkout -b feature/your-feature.



Commit your changes: git commit -m "Add your feature".



Push to the branch: git push origin feature/your-feature.



Open a pull request.

License

This project is licensed under the MIT License. See the LICENSE file for details.

Contact

For questions or feedback, open an issue or contact saranyaunnikrishnan08@gmail.com.
