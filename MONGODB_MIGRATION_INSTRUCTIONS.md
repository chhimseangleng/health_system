# MongoDB Migration Instructions for Adding 'role' Field to Patients

This document provides comprehensive instructions for migrating the `patients` collection in MongoDB to include the new `role` field.

## Overview

We are adding a new `role` field to the `patients` collection with the following specifications:
- **Field Name**: `role`
- **Data Type**: `string`
- **Allowed Values**: `['vaccine', 'common disease', 'gynecology', 'medicine']`
- **Default Value**: `'common disease'` (for existing patients)
- **Required**: Yes (for all patients)

## Migration Methods

### Method 1: Using Laravel Artisan Command (Recommended)

We've created a custom Artisan command that handles the migration safely with progress tracking and error handling.

#### Command Usage

```bash
# Basic usage - adds 'common disease' as default role
php artisan patients:add-role

# With custom default role
php artisan patients:add-role --default="vaccine"

# Dry run to preview changes without making them
php artisan patients:add-role --dry-run

# Help information
php artisan patients:add-role --help
```

#### Command Features

- ✅ **Safe Execution**: Validates role values before applying
- ✅ **Dry Run Mode**: Preview changes without making them
- ✅ **Progress Tracking**: Shows real-time progress with progress bar
- ✅ **Batch Processing**: Processes records in batches for performance
- ✅ **Error Handling**: Gracefully handles errors and provides summary
- ✅ **Verification**: Confirms migration completion

#### Step-by-Step Process

1. **Backup your database** (highly recommended):
   ```bash
   mongodump --db your_database_name --collection patients
   ```

2. **Run in dry-run mode first**:
   ```bash
   php artisan patients:add-role --dry-run
   ```

3. **Execute the migration**:
   ```bash
   php artisan patients:add-role
   ```

4. **Verify the migration** (optional):
   ```bash
   # Check if any patients still lack the role field
   php artisan tinker
   >>> App\Models\Patient::whereNull('role')->count()
   ```

### Method 2: Direct MongoDB Command

If you prefer to run the migration directly in MongoDB:

#### 1. Connect to MongoDB
```bash
# Connect to MongoDB shell
mongosh

# Switch to your database
use your_database_name
```

#### 2. Check Current State
```javascript
// Count patients without role field
db.patients.countDocuments({ role: { $exists: false } })

// View sample patient without role
db.patients.findOne({ role: { $exists: false } })
```

#### 3. Apply Migration
```javascript
// Add role field with default value to all patients without it
db.patients.updateMany(
    { role: { $exists: false } },
    { $set: { role: "common disease" } }
)
```

#### 4. Verify Migration
```javascript
// Check if any patients still lack the role field
db.patients.countDocuments({ role: { $exists: false } })

// Count patients by role
db.patients.aggregate([
    { $group: { _id: "$role", count: { $sum: 1 } } }
])
```

### Method 3: Using Laravel Tinker

```bash
php artisan tinker
```

```php
// Count patients without role
$count = App\Models\Patient::whereNull('role')->count();
echo "Patients without role: $count\n";

// Update all patients without role
App\Models\Patient::whereNull('role')->update(['role' => 'common disease']);

// Verify
$remaining = App\Models\Patient::whereNull('role')->count();
echo "Remaining patients without role: $remaining\n";
```

## Post-Migration Tasks

### 1. Index Creation (Recommended for Performance)

Since you'll likely query by role frequently, create an index:

```javascript
// In MongoDB shell
db.patients.createIndex({ "role": 1 })
```

Or using Laravel:
```bash
php artisan tinker
```
```php
// Create index using Laravel MongoDB
DB::connection('mongodb')->collection('patients')->createIndex(['role' => 1]);
```

### 2. Validation Testing

Test the new validation rules:

```bash
php artisan tinker
```
```php
// Test creating a patient with valid role
$patient = new App\Models\Patient([
    'first_name' => 'Test',
    'last_name' => 'Patient',
    'phone' => '1234567890',
    'address' => 'Test Address',
    'date_of_birth' => '1990-01-01',
    'gender' => 'male',
    'role' => 'vaccine',
    'patient_id' => 'PAT-TEST123'
]);
$patient->save();

// Test creating a patient with invalid role (should fail)
$patient2 = new App\Models\Patient([
    'first_name' => 'Test2',
    'last_name' => 'Patient2',
    'phone' => '1234567891',
    'address' => 'Test Address 2',
    'date_of_birth' => '1990-01-02',
    'gender' => 'female',
    'role' => 'invalid_role', // This should cause validation error
    'patient_id' => 'PAT-TEST124'
]);
$patient2->save(); // Should throw validation error
```

## Rollback Procedure (If Needed)

If you need to remove the role field:

### Using MongoDB Command
```javascript
// Remove role field from all patients
db.patients.updateMany(
    {},
    { $unset: { role: "" } }
)
```

### Using Laravel
```bash
php artisan tinker
```
```php
// Remove role field using Laravel
DB::connection('mongodb')->collection('patients')->update(
    [],
    ['$unset' => ['role' => '']],
    ['multiple' => true]
);
```

## Verification Queries

### Check Migration Success
```javascript
// Total patients
db.patients.countDocuments({})

// Patients with role field
db.patients.countDocuments({ role: { $exists: true } })

// Patients by role
db.patients.aggregate([
    { $group: { _id: "$role", count: { $sum: 1 } } },
    { $sort: { count: -1 } }
])
```

### Sample Role Distribution Query
```javascript
db.patients.aggregate([
    {
        $group: {
            _id: "$role",
            count: { $sum: 1 },
            patients: { 
                $push: { 
                    name: { $concat: ["$first_name", " ", "$last_name"] },
                    patient_id: "$patient_id"
                } 
            }
        }
    },
    { $sort: { count: -1 } }
])
```

## Troubleshooting

### Common Issues

1. **Command not found**: Ensure the command is properly registered
   ```bash
   php artisan list | grep patients
   ```

2. **Permission errors**: Ensure proper MongoDB permissions
   ```bash
   # Check MongoDB connection
   php artisan tinker
   >>> DB::connection('mongodb')->collection('patients')->count()
   ```

3. **Memory issues with large datasets**: Use batch processing
   ```bash
   # The artisan command automatically handles batching
   php artisan patients:add-role
   ```

4. **Validation errors after migration**: Clear application cache
   ```bash
   php artisan config:cache
   php artisan route:cache
   ```

## Security Considerations

1. **Backup First**: Always backup your database before migrations
2. **Test Environment**: Run migration in staging environment first
3. **Dry Run**: Always use `--dry-run` flag first
4. **Monitor**: Monitor application logs during and after migration
5. **Rollback Plan**: Have a tested rollback procedure ready

## Performance Considerations

1. **Index Creation**: Create index on role field for better query performance
2. **Batch Processing**: The artisan command processes in batches of 100
3. **Off-Peak Hours**: Run during low-traffic periods
4. **Monitoring**: Monitor database performance during migration

## Files Modified

- `app/Models/Patient.php` - Added role field and validation
- `app/Http/Controllers/PatientController.php` - Updated validation rules
- `app/Console/Commands/AddRoleToExistingPatients.php` - Custom migration command
- `routes/console.php` - Registered the custom command

## Next Steps

After successful migration:
1. Update your frontend forms to include role selection
2. Update any API documentation
3. Consider adding role-based filtering to patient lists
4. Update any existing reports or dashboards
5. Train users on the new role field functionality
