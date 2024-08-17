API Endpoints
Authentication
POST /api/login

Description: Authenticates users and returns a JWT token.
Request Body: { "email": "user@example.com", "password": "password" }
Response: { "token": "jwt_token" }
POST /api/register

Description: Registers a new user.
Request Body: { "name": "User", "email": "user@example.com", "password": "password" }
Response: { "message": "User registered successfully" }
Rooms
GET /api/rooms

Description: List all rooms.
Response: [ { "id": 1, "name": "Room 1" }, { "id": 2, "name": "Room 2" } ]
POST /api/rooms

Description: Create a new room.
Request Body: { "name": "New Room" }
Response: { "id": 3, "name": "New Room" }
GET /api/rooms/{id}

Description: Get details of a specific room.
Response: { "id": 1, "name": "Room 1" }
PUT /api/rooms/{id}

Description: Update a specific room.
Request Body: { "name": "Updated Room" }
Response: { "id": 1, "name": "Updated Room" }
DELETE /api/rooms/{id}

Description: Delete a specific room.
Response: { "message": "Room deleted successfully" }
WebRTC
POST /room/{id}/signal

Description: Send signaling data for WebRTC connections.
Request Body: { "userId": 1, "offer": { ... }, "answer": { ... }, "candidate": { ... } }
Response: { "status": "success" }
POST /room/{id}/new-peer

Description: Notify the server of a new peer in the room.
Request Body: { "userId": 1 }
Response: { "status": "success" }
Usage Guidelines
Frontend
Local Development: Use npm run dev to start the development server with hot reloading.
Build for Production: Use npm run build to compile and minify assets for production.
Backend
Artisan Commands: Use Laravel's artisan commands for tasks such as migrations, seeders, and testing.
Testing
Unit Testing: Write tests in the tests directory. Use vendor/bin/pest to run tests.
Libraries & Services
Laravel Framework
Version: ^10.10
Purpose: Core framework for the application.
Livewire
Version: ^3.5
Purpose: Provides reactive components for Laravel applications.
Pusher
Version: ^7.2
Purpose: Real-time event broadcasting.
Spatie Laravel Permission
Version: ^6.9
Purpose: Role and permission management.
FakerPHP
Version: ^1.9.1
Purpose: Generating fake data for testing and seeding.
Laravel Breeze
Version: ^1.29
Purpose: Simple authentication scaffold for Laravel.
Laravel Sail
Version: ^1.18
Purpose: Docker development environment for Laravel.
PestPHP
Version: ^2.35
Purpose: Testing framework for PHP.
Laravel Pint
Version: ^1.0
Purpose: Code style fixer for Laravel.
Laravel Ignition
Version: ^2.0
Purpose: Error handling and debugging for Laravel.
