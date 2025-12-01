<?php
/**
 * ZESTRA Loan Calculator - Penalty Calculator
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penalty Calculator - ZESTRA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
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
                <a href="penalty.php" class="active"><i class="fas fa-exclamation-triangle"></i> Penalty Calculator</a>
                <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
                <a href="documentation.php"><i class="fas fa-book"></i> Documentation</a>
            </div>
        </div>
    </nav>

    <main class="container" style="margin-top: 40px;">
        <div class="card" style="max-width: 700px; margin: 0 auto;">
            <h2 style="color: var(--primary-color); margin-bottom: 10px;">
                <i class="fas fa-exclamation-triangle"></i> Penalty Calculator
            </h2>
            <p class="text-muted" style="margin-bottom: 30px;">
                Calculate penalties on overdue loan balances. Enter the loan details below.
            </p>

            <form id="penaltyForm">
                <div class="form-group">
                    <label>
                        <i class="fas fa-money-bill-wave"></i> Principal Amount (KES)
                        <div class="ribbon-container">
                            <span class="ribbon-badge">?</span>
                            <span class="tooltip-text">The original loan amount borrowed</span>
                        </div>
                    </label>
                    <input type="text" id="principalAmount" class="form-control" placeholder="Enter principal amount" required>
                </div>

                <div class="form-group">
                    <label>
                        <i class="fas fa-percentage"></i> Interest Rate (%)
                        <div class="ribbon-container">
                            <span class="ribbon-badge">Flat</span>
                            <span class="tooltip-text">The flat interest rate applied to the loan</span>
                        </div>
                    </label>
                    <input type="number" step="0.1" id="interestRate" class="form-control" placeholder="e.g., 12.2" value="12.2" required>
                </div>

                <div class="form-group">
                    <label>
                        <i class="fas fa-exclamation-circle"></i> Penalty Rate (%)
                        <div class="ribbon-container">
                            <span class="ribbon-badge">Default 10%</span>
                            <span class="tooltip-text">Penalty applied to total exposure if unpaid at maturity</span>
                        </div>
                    </label>
                    <input type="number" step="0.1" id="penaltyRate" class="form-control" placeholder="e.g., 10" value="10" required>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px;">
                    <i class="fas fa-calculator"></i> Calculate Penalty
                </button>
            </form>

            <div id="penaltyResults" class="hidden" style="margin-top: 30px;">
                <!-- Results will be injected here -->
            </div>
        </div>

        <!-- Info Card -->
        <div class="card" style="max-width: 700px; margin: 30px auto; background: #FFF3E0; border-left: 5px solid var(--accent-color);">
            <h4 style="color: var(--primary-color); margin-bottom: 15px;">
                <i class="fas fa-info-circle"></i> Important Information
            </h4>
            <ul style="line-height: 2; margin-left: 20px;">
                <li>Penalties are applied to the <strong>Total Exposure</strong> (Principal + Accrued Interest)</li>
                <li>The default penalty rate is <strong>10%</strong> as per Zestra policy</li>
                <li>Penalties apply when loans are unpaid at maturity</li>
                <li><strong>Note:</strong> Actual penalties may vary based on your loan agreement and payment history</li>
                <li>This calculator provides estimates only - consult with your loan officer for exact figures</li>
            </ul>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 ZESTRA CAPITAL LIMITED. Regulated by the CBK.</p>
            <div class="footer-links">
                <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
            </div>
        </div>
    </footer>

    <script>
        // Format number with commas
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        function getNumericValue(str) {
            return parseFloat(str.replace(/,/g, '')) || 0;
        }

        // Format input with commas as user types
        document.getElementById('principalAmount').addEventListener('input', function(e) {
            const cursorPos = e.target.selectionStart;
            const oldLength = e.target.value.length;
            const numericValue = e.target.value.replace(/\D/g, '');
            e.target.value = formatNumber(numericValue);
            const newLength = e.target.value.length;
            e.target.setSelectionRange(cursorPos + (newLength - oldLength), cursorPos + (newLength - oldLength));
        });

        // Handle form submission
        document.getElementById('penaltyForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const principal = getNumericValue(document.getElementById('principalAmount').value);
            const interestRate = parseFloat(document.getElementById('interestRate').value);
            const penaltyRate = parseFloat(document.getElementById('penaltyRate').value);

            if (principal <= 0 || interestRate < 0 || penaltyRate < 0) {
                alert('Please enter valid positive values');
                return;
            }

            // Calculate interest
            const interest = principal * (interestRate / 100);
            
            // Calculate total exposure
            const totalExposure = principal + interest;
            
            // Calculate penalty
            const penalty = totalExposure * (penaltyRate / 100);
            
            // Calculate total amount due
            const totalDue = totalExposure + penalty;

            // Display results
            const resultsDiv = document.getElementById('penaltyResults');
            resultsDiv.innerHTML = `
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px;">
                    <h3 style="margin: 0 0 20px 0; color: white;">
                        <i class="fas fa-chart-line"></i> Penalty Calculation Results
                    </h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 8px;">
                            <small style="opacity: 0.9; display: block; margin-bottom: 5px;">Principal Amount</small>
                            <div style="font-size: 1.3rem; font-weight: 800;">KES ${formatNumber(principal.toFixed(2))}</div>
                        </div>
                        <div style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 8px;">
                            <small style="opacity: 0.9; display: block; margin-bottom: 5px;">Interest (${interestRate}%)</small>
                            <div style="font-size: 1.3rem; font-weight: 800;">KES ${formatNumber(interest.toFixed(2))}</div>
                        </div>
                    </div>
                    <div style="background: rgba(255,255,255,0.15); padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <small style="opacity: 0.9; display: block; margin-bottom: 5px;">Total Exposure (Principal + Interest)</small>
                        <div style="font-size: 1.5rem; font-weight: 800;">KES ${formatNumber(totalExposure.toFixed(2))}</div>
                    </div>
                    <div style="background: rgba(255,255,255,0.2); padding: 20px; border-radius: 8px; border: 2px solid rgba(255,255,255,0.3);">
                        <small style="opacity: 0.9; display: block; margin-bottom: 5px;">Penalty Amount (${penaltyRate}%)</small>
                        <div style="font-size: 1.8rem; font-weight: 800; color: #FFD700;">KES ${formatNumber(penalty.toFixed(2))}</div>
                    </div>
                </div>

                <div class="alert alert-danger" style="margin-top: 20px;">
                    <h4 style="margin-top: 0;"><i class="fas fa-exclamation-triangle"></i> Total Amount Due</h4>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                        <span style="font-size: 1.1rem;">Total Outstanding Balance:</span>
                        <span style="font-size: 2rem; font-weight: 800; color: var(--danger-color);">KES ${formatNumber(totalDue.toFixed(2))}</span>
                    </div>
                    <hr style="margin: 15px 0; border-color: rgba(0,0,0,0.1);">
                    <small style="display: block; margin-top: 10px; opacity: 0.8;">
                        <i class="fas fa-info-circle"></i> This includes the principal (KES ${formatNumber(principal.toFixed(2))}), 
                        interest (KES ${formatNumber(interest.toFixed(2))}), and penalty (KES ${formatNumber(penalty.toFixed(2))}).
                    </small>
                </div>

                <div style="background: #E3F2FD; padding: 15px; border-radius: 8px; border-left: 4px solid #2196F3; margin-top: 20px;">
                    <p style="margin: 0; line-height: 1.6;">
                        <strong><i class="fas fa-lightbulb"></i> Note:</strong> These figures are estimates based on the inputs provided. 
                        Actual penalties may vary depending on your specific loan agreement, payment history, and Zestra's current policies. 
                        Please contact your loan officer for the exact penalty amount.
                    </p>
                </div>
            `;
            resultsDiv.classList.remove('hidden');
            resultsDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
    </script>
</body>

</html>
