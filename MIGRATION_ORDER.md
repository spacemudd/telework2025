# Migration Order for Teams Implementation

## Production Deployment Order

**IMPORTANT**: These migrations must be run in this exact order to avoid foreign key constraint errors.

### 1. Create Teams Infrastructure
```bash
php artisan migrate --path=database/migrations/2025_06_14_213002_create_teams_table.php
```

### 2. Add team_id to users table
```bash
php artisan migrate --path=database/migrations/2025_06_14_214808_add_team_id_to_users_table.php
```

### 3. Enable teams in config and run Spatie's teams migration FIRST
```bash
# First, update config/permission.php to set 'teams' => true
php artisan migrate --path=database/migrations/2025_06_14_204511_add_teams_fields.php
```

### 4. Setup teams for existing users (DATA MIGRATION)
```bash
php artisan migrate --path=database/migrations/2025_06_14_214855_setup_teams_for_existing_users.php
```

## What Each Migration Does

1. **create_teams_table**: Creates the teams table with owner_id and company_id
2. **add_team_id_to_users_table**: Adds team_id foreign key to users table
3. **add_teams_fields**: Spatie's migration that adds team_id to roles and permission pivot tables
4. **setup_teams_for_existing_users**: Creates teams for all existing users and assigns them properly

## Important Notes

- **CRITICAL**: The Spatie migration must run BEFORE the data migration
- The Spatie migration adds the team_id columns to model_has_roles and model_has_permissions tables
- Our data migration depends on these columns existing
- The companies table already has user_id column representing the company owner
- The admin user (it@hadaf-hq.com) will get their own "Admin Team"
- Each company owner will get a team named "{Company Name} Team"
- All employees of a company will be assigned to their company's team
- Users without companies will get individual teams
- All existing roles and permissions are preserved
- The migration is reversible for rollback scenarios

## After Migration

- All users will have a team_id
- All role assignments will work with the team system
- The application will be ready for team-based permissions 