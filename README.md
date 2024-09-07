Here's a GitHub `README.md` format that includes Laravel project setup instructions and API documentation:

```markdown
# Booking System API

This project provides a basic booking system with essential features including user authentication, booking management, and service search functionality. 

## Table of Contents

1. [Project Setup](#project-setup)
2. [API Documentation](#api-documentation)
   - [User Authentication](#user-authentication)
   - [Booking APIs](#booking-apis)
   - [Service APIs](#service-apis)
3. [User Guide](#user-guide)
4. [Error Handling](#error-handling)

## Project Setup

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/booking-system-api.git
cd booking-system-api
```

### 2. Install Dependencies

Make sure you have PHP and Composer installed. Then run:

```bash
composer install
```

### 3. Set Up Environment Variables

Copy the example environment file and set up your environment configuration:

```bash
cp .env.example .env
```

Edit the `.env` file to configure your database and other settings.

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Migrate and Seed the Database

Run migrations and seed the database with test data:

```bash
php artisan migrate
php artisan db:seed
```

### 6. Start the Laravel Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`.

## API Documentation

### User Authentication

**Endpoints:**
- `POST /api/login` - User login
- `POST /api/register` - User registration
- `POST /api/password/reset` - Password recovery

### Booking APIs

#### Create Booking

**Endpoint:** `POST /api/bookings`

**Description:** Create a new booking.

**Headers:**
- `Authorization: Bearer <token>`

**Request Body:**
```json
{
    "service_id": 1,
    "booking_date": "2024-09-30T15:00:00Z"
}
```

**Response:**
- **201 Created**
  ```json
  {
      "id": 1,
      "service_id": 1,
      "booking_date": "2024-09-30T15:00:00Z",
      "status": "pending"
  }
  ```

#### Update Booking

**Endpoint:** `PUT /api/bookings/{id}`

**Description:** Update an existing booking.

**Headers:**
- `Authorization: Bearer <token>`

**Request Body:**
```json
{
    "booking_date": "2024-10-01T15:00:00Z"
}
```

**Response:**
- **200 OK**
  ```json
  {
      "id": 1,
      "service_id": 1,
      "booking_date": "2024-10-01T15:00:00Z",
      "status": "pending"
  }
  ```

#### Delete Booking

**Endpoint:** `DELETE /api/bookings/{id}`

**Description:** Delete an existing booking.

**Headers:**
- `Authorization: Bearer <token>`

**Response:**
- **204 No Content**

#### Confirm Booking

**Endpoint:** `POST /api/bookings/{id}/confirm`

**Description:** Confirm a booking.

**Headers:**
- `Authorization: Bearer <token>`

**Response:**
- **200 OK**
  ```json
  {
      "id": 1,
      "service_id": 1,
      "booking_date": "2024-09-30T15:00:00Z",
      "status": "confirmed"
  }
  ```

### Service APIs

#### Search Services

**Endpoint:** `GET /api/services/search`

**Description:** Search for services within a specified range.

**Headers:**
- `Authorization: Bearer <token>`

**Query Parameters:**
- `latitude` (required) - Latitude of the search location
- `longitude` (required) - Longitude of the search location
- `range` (optional) - Range in kilometers (default is 25)

**Example Request:**
```
GET /api/services/search?latitude=31.5497&longitude=74.3436&range=25
```

**Response:**
- **200 OK**
  ```json
  {
      "message": "Services found",
      "services": [
          {
              "id": 1,
              "name": "House Cleaning",
              "description": "Basic house cleaning service",
              "price": 50.00,
              "latitude": 31.5497,
              "longitude": 74.3436,
              "distance": 0.00
          },
          {
              "id": 2,
              "name": "Car Wash",
              "description": "Complete car washing service",
              "price": 25.00,
              "latitude": 31.5497,
              "longitude": 74.3436,
              "distance": 10.00
          }
      ]
  }
  ```

- **404 Not Found**
  ```json
  {
      "message": "No services found within the specified range"
  }
  ```

## User Guide

### Authentication

1. **Register a User**
   - Send a `POST` request to `/api/register` with user details.

2. **Login**
   - Send a `POST` request to `/api/login` with email and password to obtain a Bearer token.

3. **Use Token**
   - Include the Bearer token in the `Authorization` header of your API requests.

### Booking Operations

#### Create a Booking

1. **Endpoint:** `POST /api/bookings`
2. **Headers:** Include `Authorization: Bearer <token>`
3. **Request:** Provide `service_id` and `booking_date` in the request body.
4. **Response:** On success, a new booking record is created.

#### Update a Booking

1. **Endpoint:** `PUT /api/bookings/{id}`
2. **Headers:** Include `Authorization: Bearer <token>`
3. **Request:** Provide updated `booking_date` in the request body.
4. **Response:** The booking record is updated with the new date.

#### Delete a Booking

1. **Endpoint:** `DELETE /api/bookings/{id}`
2. **Headers:** Include `Authorization: Bearer <token>`
3. **Response:** The booking record is deleted.

#### Confirm a Booking

1. **Endpoint:** `POST /api/bookings/{id}/confirm`
2. **Headers:** Include `Authorization: Bearer <token>`
3. **Response:** The booking status is updated to confirmed.

### Searching for Services

1. **Endpoint:** `GET /api/services/search`
2. **Headers:** Include `Authorization: Bearer <token>`
3. **Query Parameters:**
   - `latitude` and `longitude` are required.
   - `range` is optional, default is 25 km.
4. **Response:** A list of services within the specified range is returned. If no services are found, an appropriate message is displayed.

## Error Handling

- **404 Not Found:** Returned when no records match the search criteria.
- **400 Bad Request:** Returned when required parameters are missing or invalid.

---

Feel free to adjust the details based on your specific implementation and requirements.
