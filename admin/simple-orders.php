<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders - AA DIGITS Admin</title>
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
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-shopping-cart"></i> View Orders</h1>
    </div>
    
    <div class="container">
        <a href="dashboard.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        
        <div class="card">
            <h2 style="margin-bottom: 1rem;">All Orders</h2>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Products</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#ORD-001</td>
                        <td>John Doe<br><small>john@example.com</small></td>
                        <td>Modern Website Template</td>
                        <td>$49.99</td>
                        <td><span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem;">Completed</span></td>
                        <td>Nov 15, 2025</td>
                        <td>
                            <button class="btn btn-primary" onclick="alert('View details coming soon!')">View</button>
                        </td>
                    </tr>
                    <tr>
                        <td>#ORD-002</td>
                        <td>Jane Smith<br><small>jane@example.com</small></td>
                        <td>Mobile App UI Kit</td>
                        <td>$79.99</td>
                        <td><span style="background: #fef3c7; color: #92400e; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem;">Pending</span></td>
                        <td>Nov 14, 2025</td>
                        <td>
                            <button class="btn btn-primary" onclick="alert('View details coming soon!')">View</button>
                        </td>
                    </tr>
                    <tr>
                        <td>#ORD-003</td>
                        <td>Mike Johnson<br><small>mike@example.com</small></td>
                        <td>Logo Design Bundle</td>
                        <td>$29.99</td>
                        <td><span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem;">Completed</span></td>
                        <td>Nov 13, 2025</td>
                        <td>
                            <button class="btn btn-primary" onclick="alert('View details coming soon!')">View</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
