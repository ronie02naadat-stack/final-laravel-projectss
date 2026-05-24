# Laravel MVC Activity #6 - Files Created/Modified

## Models Created
- `app/Models/Degree.php` - Degree model with relationships
- `app/Models/Student.php` - Student model with relationships

## Migrations Created
- `database/migrations/2026_03_18_100602_create_degrees_table.php`
- `database/migrations/2026_03_18_100853_create_students_table.php`

## Controllers Created
- `app/Http/Controllers/DegreeController.php` - Resource controller for Degrees
- `app/Http/Controllers/StudentController.php` - Resource controller for Students

## Routes Modified
- `routes/web.php` - Added resource routes for degrees and students

## Views Created

### Degree Views
- `resources/views/degrees/index.blade.php` - List all degrees with table
- `resources/views/degrees/create.blade.php` - Form to create degree
- `resources/views/degrees/edit.blade.php` - Form to edit degree
- `resources/views/degrees/show.blade.php` - Display degree details

### Student Views
- `resources/views/students/index.blade.php` - List all students with pagination
- `resources/views/students/create.blade.php` - Form to create student (with degree dropdown)
- `resources/views/students/edit.blade.php` - Form to edit student (with degree dropdown)
- `resources/views/students/show.blade.php` - Display student details

### Layout
- `resources/views/layouts/app.blade.php` - Master layout with Bootstrap 5 and navigation

## Database
- All migrations successfully run
- Tables created: users, cache, jobs, degrees, students
- Foreign key relationship configured: students.degree_id -> degrees.id

## Key Features

### Degree Management
- ✓ View all degrees in a table
- ✓ Create new degree with form validation
- ✓ Edit existing degree
- ✓ View individual degree details
- ✓ Delete degree

### Student Management
- ✓ View all students with pagination (10 per page)
- ✓ Create new student with degree selection dropdown
- ✓ Edit existing student
- ✓ View individual student details
- ✓ Delete student
- ✓ Foreign key constraint with cascade delete

### Security & Validation
- ✓ CSRF token protection on all forms
- ✓ Server-side form validation
- ✓ Error messages display below form fields
- ✓ Method spoofing for PUT and DELETE requests
- ✓ Confirmation dialogs on delete operations

### UI/UX
- ✓ Bootstrap 5 responsive design
- ✓ Navigation menu with quick links
- ✓ Success messages with dismissible alerts
- ✓ Pagination controls
- ✓ Action buttons (View, Edit, Delete)
- ✓ Professional styling

## How to Run

1. **Start the Server**
   ```bash
   php artisan serve --port=8000
   ```

2. **Access Application**
   - Open browser to: http://localhost:8000/degrees
   - Or: http://localhost:8000/students

3. **Use Navigation Menu**
   - Top navigation bar provides quick links to:
     - Degrees management
     - Students management

## Testing Checklist

### Degree Operations
- [ ] View all degrees (GET /degrees)
- [ ] Add new degree (POST /degrees)
- [ ] View degree details (GET /degrees/{id})
- [ ] Edit degree (PUT /degrees/{id})
- [ ] Delete degree (DELETE /degrees/{id})

### Student Operations
- [ ] View all students with pagination (GET /students)
- [ ] Add new student (POST /students)
- [ ] View student details (GET /students/{id})
- [ ] Edit student (PUT /students/{id})
- [ ] Delete student (DELETE /students/{id})
- [ ] Test pagination

### Form Features
- [ ] All required fields validation
- [ ] CSRF token validation
- [ ] Degree dropdown population on create/edit
- [ ] Error messages display
- [ ] Success messages display
- [ ] Back buttons work correctly

All requirements from Activity #6 have been successfully implemented!
