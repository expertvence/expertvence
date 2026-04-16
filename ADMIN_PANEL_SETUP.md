# Admin Panel Setup Guide

## Overview
This admin panel system provides role-based access control with three user roles:
- **Super Admin**: Full access to all admin features including user management and role changes
- **Admin**: Can view dashboard and users but cannot modify roles or delete users
- **User**: Regular user with no admin access

## Features Implemented

### 1. **Role-Based User System**
- Roles stored in the `role` column of the `users` table
- Enum values: `user`, `admin`, `super_admin`
- Default role for new registrations: `user`

### 2. **Admin Panel Dashboard**
- View total users count
- View breakdown by role (Super Admin, Admin, Regular Users)
- Search and filter users
- View all users with their roles

### 3. **User Management**
- View all users with pagination
- Edit user roles (Super Admin only)
- Delete users (Super Admin only)
- Search users by name or email

### 4. **Authentication & Authorization**
- Middleware protection for admin routes
- JWT-based authentication
- Role-based access control
- Automatic redirect for admin/super_admin users during login

## Installation & Setup

### Step 1: Run Migrations
```bash
php artisan migrate
```

This will add the `role` column to the `users` table.

### Step 2: Seed Admin Users
```bash
php artisan db:seed --class=AdminUserSeeder
```

Or run all seeders including admin users:
```bash
php artisan db:seed
```

### Pre-created Users (after seeding):
| Email | Password | Role |
|-------|----------|------|
| superadmin@example.com | password123 | Super Admin |
| admin@example.com | password123 | Admin |
| john@example.com | password123 | User |
| jane@example.com | password123 | User |

### Step 3: Mount the Admin Panel Component
In your main Vue app (e.g., `app.js` or `main.js`), import and register the AdminPanel component:

```javascript
import AdminPanel from './components/AdminPanel.vue';

// Register globally or use in specific routes
app.component('AdminPanel', AdminPanel);
```

### Step 4: Create Routes
Add a route to display the admin panel in your frontend:

```javascript
// In your Vue Router configuration
{
  path: '/admin',
  component: AdminPanel,
  meta: { requiresAuth: true, requiresAdmin: true }
}
```

## API Endpoints

### Admin Routes (Protected with `auth:api` and `admin` middleware)

#### Get Dashboard Stats
```
GET /api/admin/dashboard
```
Response:
```json
{
  "success": true,
  "data": {
    "total_users": 10,
    "super_admins": 1,
    "admins": 1,
    "regular_users": 8
  }
}
```

#### Get All Users (Paginated)
```
GET /api/admin/users
```
Response:
```json
{
  "success": true,
  "data": {
    "data": [...],
    "current_page": 1,
    "total": 10,
    "per_page": 15
  }
}
```

#### Get User Details
```
GET /api/admin/users/{id}
```

#### Update User Role (Super Admin Only)
```
PUT /api/admin/users/{id}/role
Content-Type: application/json

{
  "role": "admin"
}
```

#### Delete User (Super Admin Only)
```
DELETE /api/admin/users/{id}
```

## Login Flow with Role Detection

When a user logs in, the API returns:
```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "user": {
    "id": 1,
    "name": "Super Admin",
    "email": "superadmin@example.com",
    "role": "super_admin",
    "created_at": "2026-04-12T00:00:00.000000Z",
    "updated_at": "2026-04-12T00:00:00.000000Z"
  },
  "should_redirect_to_admin": true
}
```

### Client-Side Implementation
```javascript
const login = async (email, password) => {
  const response = await fetch('/api/auth/login', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ email, password })
  });

  const data = await response.json();
  
  if (data.should_redirect_to_admin) {
    // Redirect to admin panel
    window.location.href = '/admin';
  } else {
    // Redirect to regular dashboard
    window.location.href = '/dashboard';
  }
};
```

## Middleware Details

### AdminMiddleware
Located at: `app/Http/Middleware/AdminMiddleware.php`
- Checks if user is authenticated
- Allows access if role is `admin` or `super_admin`
- Returns 403 Forbidden for regular users

### SuperAdminMiddleware
Located at: `app/Http/Middleware/SuperAdminMiddleware.php`
- Checks if user is authenticated
- Allows access only if role is `super_admin`
- Returns 403 Forbidden for admin and regular users

## File Structure Overview

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       ├── AdminController.php          (New)
│   │       └── AuthController.php           (Updated)
│   └── Middleware/
│       ├── AdminMiddleware.php              (New)
│       └── SuperAdminMiddleware.php         (New)
├── Models/
│   └── User.php                             (Updated)
├── Mail/
│   └── ...
└── ...

database/
├── migrations/
│   ├── ...
│   └── 2026_04_12_000000_add_role_to_users_table.php (New)
└── seeders/
    ├── DatabaseSeeder.php                   (Updated)
    └── AdminUserSeeder.php                  (New)

resources/
├── js/
│   └── components/
│       └── AdminPanel.vue                   (New)
└── ...

routes/
├── api.php                                  (Updated)
└── ...

bootstrap/
└── app.php                                  (Updated)
```

## Environment Variables

Make sure these are set in your `.env`:
```
VITE_API_URL=http://localhost:8000/api
JWT_ALGORITHM=HS256
JWT_SECRET=your-secret-key
```

## Testing the Admin Panel

1. **Login as Super Admin:**
   - Email: `superadmin@example.com`
   - Password: `password123`
   - Access: Full admin panel with all features

2. **Login as Admin:**
   - Email: `admin@example.com`
   - Password: `password123`
   - Access: Dashboard and user listing, but cannot edit roles or delete users

3. **Login as Regular User:**
   - Email: `john@example.com`
   - Password: `password123`
   - Access: Regular dashboard (no admin panel access)

## Security Notes

1. **Always validate roles on the backend** - Don't rely solely on frontend checks
2. **Use HTTPS in production** - JWT tokens should be transmitted over secure connections
3. **Protect sensitive endpoints** - Use middleware to protect admin routes
4. **Regular token rotation** - Implement token refresh mechanism for long-lived sessions
5. **Audit logging** - Consider adding audit logs for admin actions

## Customization

### Change Default Role
Edit `app/Http/Controllers/Api/AuthController.php` and modify the `register` method.

### Add More Roles
1. Update the migration to add new enum values
2. Create new middleware as needed
3. Update the AdminPanel.vue component

### Customize Styling
Edit the `<style>` section in `resources/js/components/AdminPanel.vue`

## Troubleshooting

### Admin Panel Not Loading
- Check that JWT token is valid and stored in localStorage
- Verify middleware aliases are registered in `bootstrap/app.php`
- Check browser console for API errors

### Can't See Admin Users
- Run migrations: `php artisan migrate`
- Run seeders: `php artisan db:seed`
- Clear application cache: `php artisan cache:clear`

### Middleware Not Protecting Routes
- Ensure middleware names are correct in routes
- Verify user's role is properly set in database
- Check JWT token payload contains the authenticated user

## Future Enhancements

- Add audit logging for all admin actions
- Implement user permissions/abilities
- Add email notifications for role changes
- Create admin activity dashboard
- Implement two-factor authentication for admins
- Add role-based API rate limiting

---

## Support & Questions

For more information, check:
- Laravel Documentation: https://laravel.com/docs
- JWT Auth Documentation: https://jwt-auth.readthedocs.io
- Vue 3 Documentation: https://vuejs.org
