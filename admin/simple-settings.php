<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - AA DIGITS Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8fafc; }
        .header { background: #1e40af; color: white; padding: 1rem 2rem; }
        .header h1 { font-size: 1.5rem; }
        .container { max-width: 800px; margin: 2rem auto; padding: 0 1rem; }
        .back-btn { background: #6b7280; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 6px; margin-bottom: 1rem; display: inline-block; }
        .card { background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; }
        .form-control { width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; }
        .btn { padding: 0.75rem 1.5rem; border: none; border-radius: 6px; cursor: pointer; }
        .btn-primary { background: #3b82f6; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-cog"></i> Settings</h1>
    </div>
    
    <div class="container">
        <a href="dashboard.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        
        <div class="card">
            <h2 style="margin-bottom: 1rem;">General Settings</h2>
            <form>
                <div class="form-group">
                    <label>Site Name</label>
                    <input type="text" class="form-control" value="AA DIGITS">
                </div>
                <div class="form-group">
                    <label>Site Description</label>
                    <textarea class="form-control" rows="3">Premium digital products, templates, and software solutions for modern businesses and developers.</textarea>
                </div>
                <div class="form-group">
                    <label>Admin Email</label>
                    <input type="email" class="form-control" value="admin@aadigits.com">
                </div>
                <div class="form-group">
                    <label>Currency</label>
                    <select class="form-control">
                        <option value="USD">USD - US Dollar</option>
                        <option value="EUR">EUR - Euro</option>
                        <option value="GBP">GBP - British Pound</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary" onclick="alert('Save feature coming soon!')">
                    <i class="fas fa-save"></i> Save Settings
                </button>
            </form>
        </div>
        
        <div class="card">
            <h2 style="margin-bottom: 1rem;">Payment Settings</h2>
            <form>
                <div class="form-group">
                    <label>PayPal Client ID</label>
                    <input type="text" class="form-control" placeholder="Enter PayPal Client ID">
                </div>
                <div class="form-group">
                    <label>Stripe Publishable Key</label>
                    <input type="text" class="form-control" placeholder="Enter Stripe Publishable Key">
                </div>
                <div class="form-group">
                    <label>Razorpay Key ID</label>
                    <input type="text" class="form-control" placeholder="Enter Razorpay Key ID">
                </div>
                <button type="button" class="btn btn-primary" onclick="alert('Save feature coming soon!')">
                    <i class="fas fa-save"></i> Save Payment Settings
                </button>
            </form>
        </div>
        
        <div class="card">
            <h2 style="margin-bottom: 1rem;">Email Settings</h2>
            <form>
                <div class="form-group">
                    <label>SMTP Host</label>
                    <input type="text" class="form-control" placeholder="smtp.gmail.com">
                </div>
                <div class="form-group">
                    <label>SMTP Port</label>
                    <input type="number" class="form-control" value="587">
                </div>
                <div class="form-group">
                    <label>SMTP Username</label>
                    <input type="text" class="form-control" placeholder="your-email@gmail.com">
                </div>
                <div class="form-group">
                    <label>SMTP Password</label>
                    <input type="password" class="form-control" placeholder="Your app password">
                </div>
                <button type="button" class="btn btn-primary" onclick="alert('Save feature coming soon!')">
                    <i class="fas fa-save"></i> Save Email Settings
                </button>
            </form>
        </div>
    </div>
</body>
</html>
