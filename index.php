<?php
/**
 * ZESTRA Loan Calculator - Main Application Page
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZESTRA Loan Calculator</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
    <style>
        .page-header {
            text-align: center;
            padding: 40px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-size: 2.5rem;
            margin: 0 0 10px 0;
            font-weight: 800;
        }

        .page-header p {
            font-size: 1.2rem;
            opacity: 0.95;
            margin: 0;
        }

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 1.8rem;
            }
            .page-header p {
                font-size: 1rem;
            }
        }

        .calculator-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px 60px;
        }

        .calculator-grid {
            display: grid;
            grid-template-columns: 500px 1fr;
            gap: 30px;
            align-items: start;
        }

        .input-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            position: sticky;
            top: 20px;
        }

        .input-card h2 {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin: 0 0 10px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .input-card .subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 25px;
        }

        .product-selector {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .product-selector label {
            color: white;
            font-weight: 700;
            margin-bottom: 10px;
            display: block;
        }

        .product-selector select {
            background: white;
            border: none;
            font-weight: 600;
            color: var(--primary-color);
        }

        .calculate-btn {
            width: 100%;
            padding: 15px;
            font-size: 1.1rem;
            font-weight: 700;
            margin-top: 20px;
        }

        .results-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }

        .results-card h3 {
            color: var(--primary-color);
            font-size: 1.4rem;
            margin: 0 0 20px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @media (max-width: 1200px) {
            .calculator-grid {
                grid-template-columns: 1fr;
            }

            .input-card {
                position: relative;
                top: 0;
            }
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
                <a href="index.php" class="active"><i class="fas fa-calculator"></i> Calculator</a>
                <a href="penalty.php"><i class="fas fa-exclamation-triangle"></i> Penalty Calculator</a>
                <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
                <a href="documentation.php"><i class="fas fa-book"></i> Documentation</a>
            </div>
        </div>
    </nav>

    <div class="page-header">
        <h1><i class="fas fa-calculator"></i> Loan Calculator</h1>
        <p>Calculate your loan repayment schedule with accurate projections</p>
    </div>

    <main class="calculator-wrapper">
        <div class="calculator-grid">
            <!-- Left Column: Input Form -->
            <div class="input-card">
                <h2><i class="fas fa-sliders-h"></i> Loan Configuration</h2>
                <p class="subtitle">Select a loan product and enter your details below</p>

                <div class="product-selector">
                    <label><i class="fas fa-tags"></i> Select Loan Product</label>
                    <div class="select-wrapper">
                        <select id="productSelect" class="form-control">
                            <!-- Populated by JS -->
                        </select>
                    </div>
                </div>

                <form id="loanForm">
                    <div id="dynamicForm">
                        <!-- Dynamic inputs injected here -->
                    </div>

                    <button type="button" id="calculateBtn" class="btn btn-primary calculate-btn">
                        <i class="fas fa-calculator"></i> Calculate Loan
                    </button>

                    <div id="eligibilityStatus" class="mt-4">
                        <!-- Eligibility alerts go here -->
                    </div>
                </form>
            </div>

            <!-- Right Column: Results -->
            <div id="resultsSection" class="results-section hidden">
                <div id="loanSummary">
                    <!-- Summary Card injected here -->
                </div>

                <div class="results-card">
                    <h3><i class="fas fa-list-alt"></i> Weekly Repayment Schedule</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Week</th>
                                    <th>Opening Principal</th>
                                    <th>Principal Payment</th>
                                    <th>Interest Payment</th>
                                    <th>Weekly Deduction</th>
                                    <th>Closing Principal</th>
                                </tr>
                            </thead>
                            <tbody id="amortizationTableBody">
                                <!-- Rows injected here -->
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top: 20px; text-align: right;">
                        <button id="exportPdfBtn" class="btn btn-secondary">
                            <i class="fas fa-file-pdf"></i> Export to PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
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
            <div style="text-align: center; line-height: 1.8;">
                <p style="margin: 10px 0; font-weight: 700; font-size: 1.1rem;">ZESTRA CAPITAL LIMITED</p>
                <p style="margin: 5px 0;"><i class="fas fa-phone"></i> +254 720 012 374</p>
                <p style="margin: 5px 0;"><i class="fas fa-envelope"></i> zestracapitallimited@gmail.com</p>
                <p style="margin: 5px 0;"><i class="fas fa-map-marker-alt"></i> Moi Avenue, Nairobi</p>
                <div class="footer-links" style="margin-top: 15px;">
                    <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="js/config.js"></script>
    <script src="js/calculator.js"></script>
    <script src="js/amortization.js"></script>
    <script src="js/ui.js"></script>
    <script src="js/app.js"></script>
</body>

</html>