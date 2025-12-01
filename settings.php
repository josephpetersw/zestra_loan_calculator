<?php
/**
 * ZESTRA Loan Calculator - Settings Page
 * 
 * This page allows administrators or users to configure the application's core variables.
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZESTRA Calculator Settings</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .settings-container {
            max-width: 1400px;
            margin: 40px auto;
            padding: 20px;
        }

        .settings-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .settings-header h2 {
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .settings-header p {
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(600px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        .product-card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--accent-color);
        }

        .product-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .product-icon.soft { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .product-icon.growth { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .product-icon.biashara { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .product-icon.asset { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }

        .product-card-header h3 {
            margin: 0;
            color: var(--primary-color);
            font-size: 1.4rem;
        }

        .settings-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group label {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 8px;
            display: block;
        }

        .actions-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
        }

        .btn-large {
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <div class="brand">
                <img src="assets/logo.png" alt="ZESTRA Logo" class="logo">
                <h1>Loan Calculator</h1>
            </div>
            <div class="nav-links">
                <a href="index.php"><i class="fas fa-calculator"></i> Calculator</a>
                <a href="penalty.php"><i class="fas fa-exclamation-triangle"></i> Penalty Calculator</a>
                <a href="settings.php" class="active"><i class="fas fa-cog"></i> Settings</a>
                <a href="documentation.php"><i class="fas fa-book"></i> Documentation</a>
            </div>
        </div>
    </nav>

    <main class="settings-container">
        <div class="settings-header">
            <h2><i class="fas fa-cogs"></i> Application Configuration</h2>
            <p>Adjust loan parameters for each product. Changes are saved locally in your browser.</p>
        </div>

        <form id="settingsForm">
            <div id="productsContainer" class="products-grid">
                <!-- Injected by JS -->
            </div>

            <div class="actions-container">
                <button type="submit" class="btn btn-primary btn-large">
                    <i class="fas fa-save"></i> Save All Settings
                </button>
                <button type="button" id="resetBtn" class="btn btn-secondary btn-large">
                    <i class="fas fa-undo"></i> Reset to Defaults
                </button>
            </div>
        </form>
    </main>

    <!-- Custom Modal -->
    <div id="customModal" class="modal-overlay hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Title</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body" id="modalBody">
                Message
            </div>
            <div class="modal-footer">
                <button id="modalCancelBtn" class="btn btn-secondary">Cancel</button>
                <button id="modalConfirmBtn" class="btn btn-primary">Confirm</button>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toastContainer" class="toast-container"></div>

    <footer>
        <div class="container">
            <p>&copy; 2026 ZESTRA CAPITAL LIMITED. Regulated by the CBK.</p>
            <div class="footer-links">
                <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
            </div>
        </div>
    </footer>

    <script src="js/config.js"></script>
    <script>
        // Settings management with custom modals and toasts
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('productsContainer');
            const form = document.getElementById('settingsForm');

            // Icon mapping for each product
            const productIcons = {
                'soft_loan': { icon: 'fa-hand-holding-heart', class: 'soft' },
                'growth_loan': { icon: 'fa-chart-line', class: 'growth' },
                'biashara_loan': { icon: 'fa-briefcase', class: 'biashara' },
                'asset_boost_loan': { icon: 'fa-building', class: 'asset' }
            };

            // Render Settings for each product in individual cards
            Object.values(CONFIG.products).forEach(product => {
                const iconData = productIcons[product.id] || { icon: 'fa-cog', class: 'soft' };
                
                const card = document.createElement('div');
                card.className = 'product-card';
                card.innerHTML = `
                    <div class="product-card-header">
                        <div class="product-icon ${iconData.class}">
                            <i class="fas ${iconData.icon}"></i>
                        </div>
                        <h3>${product.name}</h3>
                    </div>
                    <div class="settings-grid">
                        <div class="form-group">
                            <label><i class="fas fa-percentage"></i> Interest Rate (%)</label>
                            <input type="number" step="0.1" name="${product.id}_rate" value="${product.interest_rate}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-calendar-alt"></i> Max Tenure (Weeks)</label>
                            <input type="number" name="${product.id}_tenure" value="${product.max_tenure_weeks}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-piggy-bank"></i> Min Savings (KES)</label>
                            <input type="number" name="${product.id}_savings" value="${product.min_savings}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-chart-bar"></i> Loan Limit (% of Savings)</label>
                            <input type="number" name="${product.id}_limit" value="${product.loan_limit_percent}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-receipt"></i> Processing Fee (%)</label>
                            <input type="number" step="0.1" name="${product.id}_fee" value="${product.processing_fee_percent}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-exclamation-triangle"></i> Penalty Rate (%)</label>
                            <input type="number" step="0.1" name="${product.id}_penalty" value="${product.penalty_rate_percent || 10}" class="form-control" required>
                        </div>
                    </div>
                `;
                container.appendChild(card);
            });

            // Modal and Toast functions
            function showModal(title, message, onConfirm) {
                const modal = document.getElementById('customModal');
                const modalTitle = document.getElementById('modalTitle');
                const modalBody = document.getElementById('modalBody');
                const confirmBtn = document.getElementById('modalConfirmBtn');
                const cancelBtn = document.getElementById('modalCancelBtn');
                const closeBtn = document.querySelector('.close-modal');

                modalTitle.textContent = title;
                modalBody.textContent = message;
                modal.classList.remove('hidden');

                // Remove old listeners
                const newConfirmBtn = confirmBtn.cloneNode(true);
                confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);

                newConfirmBtn.addEventListener('click', () => {
                    if (onConfirm) onConfirm();
                    modal.classList.add('hidden');
                });

                cancelBtn.onclick = () => modal.classList.add('hidden');
                closeBtn.onclick = () => modal.classList.add('hidden');
            }

            function showToast(message, type = 'success') {
                const toastContainer = document.getElementById('toastContainer');
                const toast = document.createElement('div');
                toast.className = `toast ${type}`;
                
                const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
                
                toast.innerHTML = `
                    <i class="fas ${icon}"></i>
                    <span>${message}</span>
                `;
                
                toastContainer.appendChild(toast);
                
                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }

            // Save Handler with custom modal
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                
                showModal(
                    'Confirm Save',
                    'Are you sure you want to save these settings? This will update all loan product configurations.',
                    () => {
                        const formData = new FormData(form);

                        Object.keys(CONFIG.products).forEach(key => {
                            const product = CONFIG.products[key];
                            product.interest_rate = parseFloat(formData.get(`${key}_rate`));
                            product.max_tenure_weeks = parseInt(formData.get(`${key}_tenure`));
                            product.min_savings = parseFloat(formData.get(`${key}_savings`));
                            product.loan_limit_percent = parseFloat(formData.get(`${key}_limit`));
                            product.processing_fee_percent = parseFloat(formData.get(`${key}_fee`));
                            product.penalty_rate_percent = parseFloat(formData.get(`${key}_penalty`));
                        });

                        CONFIG.save();
                        showToast('Settings saved successfully! Changes will apply to new calculations.', 'success');
                    }
                );
            });

            // Reset Handler with custom modal
            document.getElementById('resetBtn').addEventListener('click', () => {
                showModal(
                    'Reset to Defaults',
                    'Are you sure you want to reset all settings to factory defaults? This action cannot be undone.',
                    () => {
                        CONFIG.reset();
                        showToast('Settings reset to defaults. Reloading page...', 'success');
                        setTimeout(() => location.reload(), 1500);
                    }
                );
            });
        });
    </script>
</body>

</html>