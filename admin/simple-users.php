<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - AA DIGITS Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8fafc; }
        .header { background: #1e40af; color: white; padding: 1rem 2rem; }
        .header h1 { font-size: 1.5rem; }
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
        .back-btn { background: #6b7280; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 6px; margin-bottom: 1rem; display: inline-block; }
        .card { background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 0.75rem; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .table th { background: #f8fafc; font-weight: 600; }
        .btn { padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #3b82f6; color: white; }
        .btn-danger { background: #dc2626; color: white; }
        .btn-success { background: #059669; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-users"></i> Manage Users</h1>
    </div>
    
    <div class="container">
        <a href="dashboard.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h2>All Users</h2>
                <button class="btn btn-success" onclick="alert('Add User feature coming soon!')">
                    <i class="fas fa-plus"></i> Add User
                </button>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Admin User</td>
                        <td>admin@aadigits.com</td>
                        <td><span style="background: #dc2626; color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem;">Super Admin</span></td>
                        <td><span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem;">Active</span></td>
                        <td>Nov 15, 2025</td>
                        <td>
                            <button class="btn btn-primary" onclick="alert('Edit feature coming soon!')">Edit</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>John Doe</td>
                        <td>john@example.com</td>
                        <td><span style="background: #f3f4f6; color: #374151; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem;">User</span></td>
                        <td><span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem;">Active</span></td>
                        <td>Nov 14, 2025</td>
                        <td>
                            <button class="btn btn-primary" onclick="alert('Edit feature coming soon!')">Edit</button>
                            <button class="btn btn-danger" onclick="alert('Block feature coming soon!')">Block</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Jane Smith</td>
                        <td>jane@example.com</td>
                        <td><span style="background: #f3f4f6; color: #374151; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem;">User</span></td>
                        <td><span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem;">Active</span></td>
                        <td>Nov 13, 2025</td>
                        <td>
                            <button class="btn btn-primary" onclick="alert('Edit feature coming soon!')">Edit</button>
                            <button class="btn btn-danger" onclick="alert('Block feature coming soon!')">Block</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
