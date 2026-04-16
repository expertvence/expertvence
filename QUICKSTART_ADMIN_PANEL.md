# Admin Panel - Quick Start Guide

## What's Been Created

✅ **Role-Based User System**
- 3 user roles: `super_admin`, `admin`, `user`
- Role migration automatically applied
- Default role for new users: `user`

✅ **Admin Panel Interface** (Vue Component)
- Dashboard with statistics
- User management interface
- User role editing (Super Admin only)
- User deletion capability (Super Admin only)
- Search and filter functionality
- Responsive design

✅ **Backend API Endpoints**
- `GET /api/admin/dashboard` - Dashboard statistics
- `GET /api/admin/users` - List all users
- `GET /api/admin/users/{id}` - User details
- `PUT /api/admin/users/{id}/role` - Update user role (Super Admin)
- `DELETE /api/admin/users/{id}` - Delete user (Super Admin)

✅ **Middleware Protection**
- `AdminMiddleware` - Requires admin or super_admin role
- `SuperAdminMiddleware` - Requires super_admin role only

## How to Use

### 1. Run Migrations
```bash
cd c:\Users\user\Desktop\backup\expertvence
php artisan migrate
```

### 2. Seed Admin Users (Optional)
```bash
php artisan db:seed
```

This creates:
- **Super Admin**: superadmin@example.com / password123
- **Admin**: admin@example.com / password123
- **Users**: john@example.com & jane@example.com / password123

### 3. Register Admin Panel Component

In your Vue app's main entry file (e.g., `resources/js/app.js`):

```javascript
import AdminPanel from './components/AdminPanel.vue';
import LoginWithRoleCheck from './components/LoginWithRoleCheck.vue';

// Register components (globally or locally)
app.component('AdminPanel', AdminPanel);
app.component('LoginWithRoleCheck', LoginWithRoleCheck);
```

### 4. Create Routes

Add to your frontend router configuration:

```javascript
// For login with role detection
{
  path: '/login',
  component: LoginWithRoleCheck
}

// For admin panel (protected)
{
  path: '/admin',
  component: AdminPanel,
  meta: { requiresAuth: true, requiresAdmin: true }
}
```

### 5. Test the System

**Option A: Quick Test**
1. Run: `php artisan tinker`
2. Create a super admin user:
   ```php
   User::create(['name' => 'Test Admin', 'email' => 'test@admin.com', 'password' => Hash::make('password'), 'role' => 'super_admin'])
   ```
3. Login with that account

**Option B: Use Seeded Users**
1. Run the seeder (step 2 above)
2. Login with superadmin@example.com / password123

## User Login Flow

When a user logs in:

```
User logs in → API checks credentials → 
Check if user is admin/super_admin → 
Return `should_redirect_to_admin` flag
```

**Response Example:**
```json
{
  "token": "eyJ0eXAi...",
  "user": {
    "id": 1,
    "name": "Super Admin",
    "email": "superadmin@example.com",
    "role": "super_admin"
  },
  "should_redirect_to_admin": true
}
```

**Frontend Logic:**
```javascript
if (response.should_redirect_to_admin) {
  window.location.href = '/admin';
} else {
  window.location.href = '/dashboard';
}
```

## Files Created/Modified

### New Files
- `app/Http/Controllers/Api/AdminController.php` - Admin API controller
- `app/Http/Middleware/AdminMiddleware.php` - Role-based middleware
- `app/Http/Middleware/SuperAdminMiddleware.php` - Super admin middleware
- `database/migrations/2026_04_12_000000_add_role_to_users_table.php` - Role column migration
- `database/seeders/AdminUserSeeder.php` - Admin user seeder
- `resources/js/components/AdminPanel.vue` - Admin panel UI component
- `resources/js/components/LoginWithRoleCheck.vue` - Login component with role detection
- `ADMIN_PANEL_SETUP.md` - Comprehensive setup documentation

### Modified Files
- `app/Models/User.php` - Added role to fillable
- `app/Http/Controllers/Api/AuthController.php` - Updated login response with role flag
- `routes/api.php` - Added admin routes with middleware
- `bootstrap/app.php` - Registered middleware aliases
- `database/seeders/DatabaseSeeder.php` - Integrated AdminUserSeeder

## Admin Panel Features

### Dashboard (All Admins)
- View total user count
- View breakdown by role
- Real-time statistics

### User Management (All Admins)
- View all users with details
- Search by name or email
- Pagination support
- View user roles

### Role Editor (Super Admin Only)
- Change any user's role
- Promote users to admin
- Promote admins to super admin
- Modal dialog for safe role changes

### User Deletion (Super Admin Only)
- Delete user accounts
- Confirmation dialog prevents accidents
- Cannot delete other super admin accounts

## Permissions Matrix

| Feature | User | Admin | Super Admin |
|---------|------|-------|------------|
| Access Admin Panel | ❌ | ✅ | ✅ |
| View Dashboard | ❌ | ✅ | ✅ |
| View Users | ❌ | ✅ | ✅ |
| Edit User Roles | ❌ | ❌ | ✅ |
| Delete Users | ❌ | ❌ | ✅ |
| Access Settings | ❌ | ❌ | ✅ |

## Styling Details

The admin panel includes:
- Modern gradient header (purple/blue)
- Sidebar navigation menu
- Responsive design (mobile-friendly)
- Status badges for roles
- Interactive modals
- Color-coded stats cards
- Hover effects and transitions

| Role | Badge Color |
|------|-------------|
| super_admin | Red (#ff6b6b) |
| admin | Orange (#ffa94d) |
| user | Blue (#74c0fc) |

## API Usage Examples

### Get Dashboard Stats
```bash
curl -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/admin/dashboard
```

### Get All Users
```bash
curl -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/admin/users
```

### Update User Role
```bash
curl -X PUT \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"role": "admin"}' \
  http://localhost:8000/api/admin/users/5/role
```

## Troubleshooting

**Q: Admin panel doesn't load**
- Ensure JWT token is in localStorage
- Check browser console for API errors
- Verify user has admin or super_admin role

**Q: Middleware errors**
- Check middleware names in `.bootstrap/app.php`
- Verify user's role in database
- Clear application cache: `php artisan cache:clear`

**Q: Login redirect not working**
- Check `should_redirect_to_admin` flag in login response
- Verify frontend is checking this flag
- Test with seeded admin user first

## Next Steps

1. ✅ Run migrations
2. ✅ Seed admin users
3. ✅ Register Vue components
4. ✅ Create routes
5. ✅ Test login with admin credential
6. ✅ Verify admin panel loads
7. ✅ Test user management features

## Support

For detailed information, see: `ADMIN_PANEL_SETUP.md`

---

**Status**: ✅ Ready for use

**Last Updated**: April 12, 2026

**Created by**: GitHub Copilot
