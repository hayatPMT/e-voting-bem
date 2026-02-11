# 🧪 QUICK TEST GUIDE - Database Management

## How to Test Admin Management Features

### Step 1: Login as Admin

```
1. Go to http://localhost:8000
2. Email: admin@bem.ac.id
3. Password: admin12345
4. Click Login
```

### Step 2: Access Admin Management Routes

After login, you can access management pages directly via URL:

#### Admin Management

- **List admins**: `/admin/admins`
- **Create admin**: `/admin/admins/create`
- **Edit admin**: `/admin/admins/{id}/edit`
- **View admin**: `/admin/admins/{id}`

#### Mahasiswa Management

- **List mahasiswa**: `/admin/mahasiswa`
- **Create mahasiswa**: `/admin/mahasiswa/create`
- **Edit mahasiswa**: `/admin/mahasiswa/{id}/edit`
- **View mahasiswa**: `/admin/mahasiswa/{id}`
- **Export CSV**: `/admin/mahasiswa/export/csv`

### Step 3: Test Voting as Mahasiswa

```
1. Logout as admin
2. Login as mahasiswa:
   - Email: budi@student.ac.id
   - Password: password123
3. Click "Voting" menu
4. Select a candidate and click "Pilih Kandidat"
5. Database will automatically:
   - Create vote record
   - Mark mahasiswa as has_voted = true
   - Record voted_at timestamp
```

### Step 4: Verify Data in Database

```bash
# List all users
php artisan tinker
User::with('adminProfile', 'mahasiswaProfile')->get();

# Check voting status
MahasiswaProfile::where('has_voted', true)->get();

# Check votes
Vote::with('user', 'kandidat')->get();
```

---

## Test Data Ready to Use

### Admin Account

```
Email: admin@bem.ac.id
Password: admin12345
```

### Sample Mahasiswa

```
1. Email: budi@student.ac.id | Pass: password123 | NIM: 19081234001
2. Email: siti@student.ac.id | Pass: password123 | NIM: 19081234002
3. Email: ahmad@student.ac.id | Pass: password123 | NIM: 20081234001
4. Email: diana@student.ac.id | Pass: password123 | NIM: 20081234002
5. Email: rahmat@student.ac.id | Pass: password123 | NIM: 21081234001
```

---

## Common Operations

### As Admin

#### Add New Mahasiswa

```bash
POST /admin/mahasiswa
{
    "name": "Student Name",
    "email": "student@email.com",
    "password": "securepass123",
    "password_confirmation": "securepass123",
    "nim": "22081234001",
    "program_studi": "Teknik Informatika",
    "angkatan": "2022",
    "semester": 4,
    "phone": "0812xxxxx"
}
```

#### Edit Mahasiswa Status

```bash
PUT /admin/mahasiswa/{id}
{
    "name": "Updated Name",
    "status": "active|inactive|graduated|suspended"
}
```

#### Reset Mahasiswa Voting Status

```bash
PATCH /admin/mahasiswa/{id}/toggle-voting
```

This will:

- Set has_voted = false
- Clear voted_at timestamp
- Allow them to vote again

#### Export Mahasiswa List

```
GET /admin/mahasiswa/export/csv
```

Downloads CSV file with all mahasiswa data

### As Mahasiswa

#### Vote for Candidate

```bash
GET /vote/{kandidat_id}
```

Automatically:

- Creates vote record
- Marks as has_voted
- Records voted_at time
- Redirects to dashboard

#### Check Voting Status

```php
$mahasiswa = Auth::user()->mahasiswaProfile;
echo $mahasiswa->voting_status;
// Output: "Sudah Memilih pada 09-02-2026 14:30"
// Or: "Belum Memilih"
```

---

## Database Integrity Checks

### Verify All Tables Created

```bash
php artisan migrate:status
```

### Check Record Counts

```bash
php artisan tinker
User::count()        // Should be 6
AdminProfile::count()      // Should be 1
MahasiswaProfile::count()  // Should be 5
Vote::count()        // Initially 0
```

### Check Relationships

```bash
$admin = User::where('role', 'admin')->first();
$admin->adminProfile;     // Should return admin profile
$admin->vote;             // Should be null (admin can't vote)

$mahasiswa = User::where('role', 'mahasiswa')->first();
$mahasiswa->mahasiswaProfile;  // Should return mahasiswa profile
$mahasiswa->vote;              // Initially null until they vote
```

---

## Troubleshooting

### 401 Unauthorized when accessing /admin/\* routes

**Solution**: Login as admin account (admin@bem.ac.id)

### Cannot delete users

**Make sure**:

- You're logged in as admin
- The user exists
- You have proper permissions

### Voting not working

**Check**:

- Voting period is active in settings table
- Mahasiswa hasn't already voted
- There are candidates created

### Export CSV not working

**Ensure**:

- Storage permissions are correct
- There are mahasiswa records to export
- Your browser allows downloads

---

## API Testing with Tinker

### Test Creating User Programmatically

```bash
php artisan tinker

$user = User::create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => bcrypt('password'),
    'role' => 'mahasiswa'
]);

MahasiswaProfile::create([
    'user_id' => $user->id,
    'nim' => '22081234999',
    'program_studi' => 'Test',
    'angkatan' => '2022'
]);

$user->load('mahasiswaProfile');
$user->mahasiswaProfile;  // Check relationship works
```

### Test Voting Process

```bash
$mahasiswa = User::find(2)->mahasiswaProfile;
$mahasiswa->markAsVoted();

// Verify
$mahasiswa->refresh();
$mahasiswa->has_voted;    // true
$mahasiswa->voted_at;     // timestamp
$mahasiswa->voting_status; // "Sudah Memilih pada..."
```

---

## Performance Testing

### Load All Relationships

```php
$users = User::with('adminProfile', 'mahasiswaProfile', 'votes')->get();
// Or
$mahasiswa = MahasiswaProfile::with('user', 'votes')->get();
```

### Query Optimization

All frequently used fields have indexes:

- role
- is_active
- status
- has_voted
- nim

Queries should be fast even with large datasets.

---

## Security Notes

1. **Passwords**: All passwords are bcrypted before storing
2. **Middleware**: All admin routes protected by AdminMiddleware
3. **Validation**: Form inputs validated server-side
4. **Access Control**: Role-based access enforced
5. **Timestamps**: All changes tracked with created_at/updated_at

---

**Everything is ready to test!** 🚀
