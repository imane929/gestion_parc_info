# AssetFlow - IT Asset Management System

## Project Overview

**AssetFlow** is an IT Asset Management System designed to help organizations track and manage their IT equipment, handle support tickets, schedule maintenance, and manage software licenses and vendor contracts.

---

## Purpose / Objective

The main goal of this system is to:
1. **Track IT Assets** - Know what equipment exists, who has it, and where it is
2. **Manage IT Support** - Allow users to report problems via tickets, technicians to handle them
3. **Schedule Maintenance** - Keep equipment running smoothly with preventive maintenance
4. **Manage Licenses** - Track software licenses and avoid expirations
5. **Track Contracts** - Manage vendor contracts and service agreements
6. **Generate Reports** - Get insights on IT inventory and performance

---

## User Roles

The system has 5 user roles with different access levels:

### 1. Admin
**Full system administrator**
- Access to ALL features
- Can manage users and roles
- Can access settings and system configuration
- Can approve/reject access requests

### 2. Responsable IT (IT Manager)
**Manages the IT department**
- Dashboard
- Assets (view, add, edit, delete)
- Tickets (view, add, edit, assign, resolve)
- Software (view, add, edit, delete)
- Locations (view, add, edit, delete)
- Contracts (view, add, edit, delete)
- Providers (view, add, edit, delete)
- Maintenance (view, add, edit, delete)
- Reports (view, generate)

### 3. Technicien (Technician)
**IT support staff who fixes problems**
- Dashboard
- Assets (view, add, edit)
- Tickets (view, add, edit, resolve)
- Software (view, add, edit)
- Locations (view, add, edit)
- Maintenance (view, add, edit)

### 4. Manager
**Department manager for budget/planning**
- Dashboard
- Assets (view only)
- Tickets (view only)
- Contracts (view, add, edit)
- Providers (view, add, edit)
- Reports (view, generate)

### 5. Utilisateur (Regular User)
**End user who uses the equipment**
- Dashboard
- My Assets (view equipment assigned to them)
- Tickets (view own tickets, submit new ticket)
- Notifications (view notifications about their tickets)
- Profile (view and edit own profile)

---

## Sidebar Navigation by Role

| Feature | Admin | Responsable IT | Technicien | Manager | Utilisateur |
|---------|-------|----------------|------------|---------|-------------|
| Dashboard | ✅ | ✅ | ✅ | ✅ | ✅ |
| My Assets | ❌ | ❌ | ❌ | ❌ | ✅ |
| Assets | ✅ | ✅ | ✅ | ✅ View only | ❌ |
| Tickets | ✅ | ✅ | ✅ | ✅ View only | ✅ Submit only |
| Notifications | ✅ | ✅ | ✅ | ✅ | ✅ |
| Software | ✅ | ✅ | ✅ | ❌ | ❌ |
| Locations | ✅ | ✅ | ✅ | ❌ | ❌ |
| Contracts | ✅ | ✅ | ❌ | ✅ | ❌ |
| Providers | ✅ | ✅ | ❌ | ✅ | ❌ |
| Maintenance | ✅ | ✅ | ✅ | ❌ | ❌ |
| Reports | ✅ | ✅ | ❌ | ✅ | ❌ |
| Access Requests | ✅ | ❌ | ❌ | ❌ | ❌ |
| Users | ✅ | ❌ | ❌ | ❌ | ❌ |
| Roles | ✅ | ❌ | ❌ | ❌ | ❌ |
| Settings | ✅ | ❌ | ❌ | ❌ | ❌ |

---

## Main Features

### 1. Asset Management
- Track computers, laptops, phones, servers, etc.
- Assign assets to users
- Track asset status (new, in use, in repair, retired)
- View asset history and maintenance records

### 2. Ticket Management
- Users submit tickets when they have IT problems
- Technicians can view, assign, and resolve tickets
- Track ticket status (open, in progress, resolved, closed)
- Add comments and interventions to tickets

### 3. Maintenance
- Schedule preventive maintenance
- Track maintenance history
- Assign maintenance to technicians
- Track maintenance status and delays

### 4. Software Management
- Track installed software
- Manage software licenses
- Monitor license expirations
- Track which software is installed on which asset

### 5. Contract Management
- Track vendor contracts
- Monitor contract expirations
- Renew contracts when needed
- View contract details and terms

### 6. Reporting
- Generate reports on assets
- Generate reports on tickets
- Generate reports on maintenance
- Export data to Excel

---

## Access Request System

New users can request access through the `/request-access` page. An admin must approve these requests before the user can log in.

**Flow:**
1. User fills out the request form with their information
2. Admin sees the request in the Access Requests section
3. Admin can approve (creates user) or reject the request
4. If approved, the user receives login credentials

---

## Technical Stack

- **Backend:** Laravel (PHP)
- **Frontend:** Blade templates with Tailwind CSS
- **Database:** MySQL
- **Authentication:** Laravel Breeze with Spatie roles
- **Icons:** Material Symbols

---

## Database Tables (Main)

- `utilisateurs` - Users
- `roles` - User roles
- `role_utilisateur` - User-Role mapping
- `actifs_informatiques` - IT Assets
- `ticket_maintenance` - Support tickets
- `maintenances_preventives` - Maintenance schedules
- `interventions` - Maintenance interventions
- `logiciels` - Software
- `licences_logiciels` - Software licenses
- `localisations` - Locations
- `contrats_maintenance` - Contracts
- `prestataires` - Vendors/Providers
- `demandes_acces` - Access requests
- `notifications` - User notifications
- `commentaires` - Comments on tickets/assets

---

## Quick Reference

### Role Codes
- `admin` - Administrator
- `responsable_it` - IT Manager
- `technicien` - IT Technician
- `manager` - Department Manager
- `utilisateur` - Regular User

### Key Routes
- `/` - Welcome page
- `/login` - Login page
- `/request-access` - Request access page
- `/dashboard` - Main dashboard
- `/my-assets` - User's assigned assets (for Utilisateur role)
- `/admin/actifs` - Assets management
- `/admin/tickets` - Tickets management
- `/admin/maintenances` - Maintenance management
- `/admin/notifications` - Notifications

---

## Notes for Developers

1. The system uses a custom `role_utilisateur` table instead of Spatie's default `model_has_roles`
2. The `hasRoleByCode()` method in User model checks the `role_utilisateur` table
3. All role checks in views use `hasRoleByCode()` method
4. Gates are defined in `AuthServiceProvider` for authorization logic
5. Policies are used for model-level authorization
6. MyAssetsController handles the "My Assets" page for regular users
7. Utilisateur role is filtered to see only their own tickets and assets

---

## Current Implementation Status

✅ Completed:
- Role-based sidebar navigation
- Mobile bottom navigation
- Dark mode toggle
- Profile editing with photo upload
- Access request system
- 403/419 error handling
- My Assets page for regular users
- Notifications link in sidebar
- Tickets filtered by user for Utilisateur role
- Sidebar items updated for all roles

📋 TODO:
- Test all features with each role
- Add permissions for create/edit/delete on specific pages
- Update mobile bottom nav for Utilisateur role
