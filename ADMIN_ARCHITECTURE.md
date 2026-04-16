# Admin Panel Architecture & System Overview

## System Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                        FRONTEND (Vue.js)                         │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  LoginWithRoleCheck.vue          AdminPanel.vue                 │
│  ├─ Email/Password Form          ├─ Dashboard Tab               │
│  ├─ Role Detection               ├─ Users Management            │
│  └─ Redirect Logic               ├─ Role Editor                 │
│                                  └─ Settings (Super Admin)       │
│                                                                   │
└────────────────────────────┬──────────────────────────────────────┘
                             │ API Calls (JWT Token)
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                      BACKEND (Laravel API)                       │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  ┌──────────────────────────────────────────────────────┐       │
│  │           Route: /api/admin/*                        │       │
│  │  (Protected by AdminMiddleware + SuperAdminMiddleware)      │
│  └──────────────────────────────────────────────────────┘       │
│           │                                                      │
│           ├─── AdminController                                  │
│           │     ├─ getDashboard()                               │
│           │     ├─ getAllUsers()                                │
│           │     ├─ getUserDetails()                             │
│           │     ├─ updateUserRole()  [Super Admin]              │
│           │     └─ deleteUser()      [Super Admin]              │
│           │                                                      │
│           └─── AuthController                                   │
│                 ├─ login() [Returns should_redirect_to_admin]   │
│                 ├─ register()                                   │
│                 ├─ me()                                         │
│                 └─ logout()                                     │
│                                                                   │
└────────────────────────────┬──────────────────────────────────────┘
                             │ Model Layer
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                      DATABASE (MySQL/SQLite)                     │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  users table:                                                    │
│  ├─ id (integer)                                                │
│  ├─ name (string)                                               │
│  ├─ email (string, unique)                                      │
│  ├─ password (string)                                           │
│  ├─ role (enum: user, admin, super_admin)  ← NEW               │
│  ├─ created_at (timestamp)                                      │
│  └─ updated_at (timestamp)                                      │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

## Authentication & Authorization Flow

### Login Process
```
User Input
  │
  ├─ Email + Password
  │
  ▼
POST /api/auth/login
  │
  ├─ Validate credentials
  │
  ├─ Generate JWT Token
  │
  ├─ Retrieve user data (including role)
  │
  └─ Response:
     {
       token: "jwt_token",
       user: { id, name, email, role },
       should_redirect_to_admin: true/false
     }
  │
  ├─ Frontend: Store token in localStorage
  │
  └─ Frontend: Check should_redirect_to_admin
     ├─ true  → /admin (AdminPanel.vue)
     └─ false → /dashboard (Regular user area)
```

### Authorization Flow
```
Request to /api/admin/* endpoint
  │
  ├─ Extract JWT from Authorization header
  │
  ├─ Verify JWT signature & expiration
  │
  ├─ Retrieve authenticated user
  │
  ├─ AdminMiddleware:
  │  ├─ Check user->role
  │  ├─ Is 'admin' OR 'super_admin' ?
  │  │  ├─ YES → Continue to controller
  │  │  └─ NO  → Return 403 Forbidden
  │
  ├─ SuperAdminMiddleware (if required):
  │  ├─ Check user->role
  │  ├─ Is 'super_admin' ?
  │  │  ├─ YES → Continue to controller
  │  │  └─ NO  → Return 403 Forbidden
  │
  └─ Execute controller action
```

## Role Hierarchy

```
super_admin
    │
    ├─ Full admin panel access
    ├─ Can view dashboard
    ├─ Can manage all users
    ├─ Can edit user roles
    ├─ Can delete users
    └─ Can access settings
             │
             ▼
        admin
            │
            ├─ Admin panel access
            ├─ Can view dashboard
            ├─ Can view users
            └─ Cannot edit roles or delete
                     │
                     ▼
                user
                    │
                    ├─ No admin access
                    ├─ Regular app access only
                    └─ Cannot see admin panel
```

## API Endpoint Details

### Group: `/api/admin/*` - Protected Routes
All endpoints require:
1. Valid JWT token in `Authorization: Bearer {token}` header
2. User role must be `admin` or `super_admin`

| Method | Endpoint | Role Required | Description |
|--------|----------|---------------|-------------|
| GET | `/admin/dashboard` | admin+ | Get dashboard statistics |
| GET | `/admin/users` | admin+ | Get all users (paginated) |
| GET | `/admin/users/{id}` | admin+ | Get specific user details |
| PUT | `/admin/users/{id}/role` | super_admin | Update user role |
| DELETE | `/admin/users/{id}` | super_admin | Delete user |

### Response Format

**Success Response:**
```json
{
  "success": true,
  "data": { /* response data */ },
  "message": "Operation successful"
}
```

**Error Response:**
```json
{
  "success": false,
  "message": "Error description"
}
```

## Database Schema Changes

### Migration: `add_role_to_users_table`
```php
Schema::table('users', function (Blueprint $table) {
    $table->enum('role', ['user', 'admin', 'super_admin'])
          ->default('user')
          ->after('password');
});
```

### User Model Update
```php
protected $fillable = [
    'name',
    'email',
    'password',
    'role', // ← Added
];
```

## Middleware Registration

In `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'super_admin' => \App\Http\Middleware\SuperAdminMiddleware::class,
    ]);
})
```

## Vue Component Structure

### AdminPanel.vue
```
AdminPanel (Main Component)
├── State
│   ├── activeTab (dashboard | users | settings)
│   ├── currentUser (logged in user)
│   ├── users (list of all users)
│   ├── dashboard (stats data)
│   ├── searchQuery (user search)
│   └── Modal state (edit user role)
│
├── Lifecycle
│   └── onMounted: Fetch user, dashboard, users
│
├── UI Sections
│   ├── Navbar (logo, user info, logout)
│   ├── Sidebar (menu navigation)
│   ├── Main Content
│   │   ├── Dashboard Tab
│   │   │   └── Stats Grid (4 cards)
│   │   ├── Users Tab
│   │   │   ├── Search bar
│   │   │   └── Users table with actions
│   │   └── Settings Tab (Super Admin only)
│   └── Modal (edit role)
│
└── Methods
    ├── fetchCurrentUser()
    ├── fetchDashboard()
    ├── fetchUsers()
    ├── filterUsers()
    ├── editUserRole()
    ├── saveUserRole()
    ├── deleteUser()
    ├── logout()
    └── closeEditModal()
```

### LoginWithRoleCheck.vue
```
LoginWithRoleCheck Component
├── State
│   ├── formData (email, password)
│   ├── loading (during login)
│   ├── error (error message)
│   └── isLoggedIn (check localStorage)
│
├── Methods
│   └── handleLogin()
│       ├── POST /api/auth/login
│       ├── Store token in localStorage
│       ├── Check should_redirect_to_admin
│       └── Redirect to /admin or /dashboard
│
└── UI
    ├── Email input
    ├── Password input
    ├── Login button
    ├── Error message
    └── Demo credentials box
```

## Data Flow Diagram

### User Creation
```
User Form
  │
  ▼
POST /api/auth/register
  │
  ├─ Hash password
  │
  ├─ Create user with role='user'
  │
  └─ Return user data
```

### User Role Update
```
Admin selects user + new role
  │
  ▼
AdminPanel.vue: PUT /api/admin/users/{id}/role
  │
  ├─ SuperAdminMiddleware checks auth
  │
  ├─ AdminController.updateUserRole()
  │
  ├─ Validate new role value
  │
  ├─ UPDATE users table SET role=?
  │
  └─ Return updated user
     │
     ▼
   Refresh users list
```

### Dashboard Data Flow
```
AdminPanel.vue mounted
  │
  ├─ Fetch current user
  │
  ├─ Fetch dashboard stats
  │  │
  │  └─ GET /api/admin/dashboard
  │      │
  │      ├─ Count all users
  │      ├─ Count admin users
  │      ├─ Count super_admin users
  │      └─ Count user-role users
  │
  └─ Fetch users list
     │
     └─ GET /api/admin/users
         │
         ├─ Paginate results
         └─ Display in table
```

## Security Considerations

### Authentication
- ✅ JWT tokens for stateless authentication
- ✅ Tokens stored in localStorage (consider httpOnly cookies for production)
- ✅ Token expiration configured in `config/jwt.php`

### Authorization
- ✅ Middleware checks on every admin endpoint
- ✅ Backend validation of role on role-change operations
- ✅ Prevents users from accessing admin panel via URL manipulation

### Data Protection
- ✅ Password hashed with bcrypt
- ✅ Password not returned in API responses
- ✅ Email uniqueness enforced
- ✅ Enum type for role (prevents invalid roles)

### Input Validation
- ✅ Email format validation
- ✅ Password length validation
- ✅ Role whitelist validation (enum)
- ✅ User existence checks before operations

## Scaling Considerations

### For Large User Databases
1. **Pagination**: Already implemented in users endpoint
2. **Indexing**: Add indexes on `email` and `role` columns:
   ```php
   $table->index('email');
   $table->index('role');
   ```
3. **Search Optimization**: Use database search instead of in-memory filtering

### For Many Admins
1. **Implement Permissions System**: Instead of just roles
2. **Add Audit Logging**: Track admin actions
3. **Rate Limiting**: Implement per-admin API rate limits

## Testing Strategy

### Unit Tests
- Test role validation
- Test middleware authorization
- Test password hashing

### Feature Tests
- Test admin endpoints
- Test role changes
- Test user deletion operations

### Integration Tests
- Test complete login → admin access flow
- Test role-based redirects

## Future Enhancements

1. **Two-Factor Authentication**
   - Add TOTP/SMS verification for admin accounts
   - Store 2FA secrets in database

2. **Advanced Permissions**
   - Replace role-based with permission-based system
   - Use package like `spatie/laravel-permission`

3. **Audit Logging**
   - Log all admin actions
   - Track who changed what and when

4. **Email Notifications**
   - Notify users of role changes
   - Notify admins of new registrations

5. **Activity Dashboard**
   - Track admin login history
   - Monitor API usage

6. **Export Functionality**
   - Export user lists to CSV
   - Generate admin activity reports

7. **Advanced Search**
   - Filter by role, date range, status
   - Full-text search capabilities

8. **Admin Impersonation**
   - Allow super admin to login as other users
   - Useful for debugging customer issues

---

**Architecture Version**: 1.0
**Created**: April 12, 2026
**Framework**: Laravel + Vue.js
**Database**: MySQL/SQLite compatible
