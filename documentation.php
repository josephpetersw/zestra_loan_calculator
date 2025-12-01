<?php
/**
 * ZESTRA Loan Calculator - Documentation & Terms
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentation - ZESTRA Loan Calculator</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
                <a href="penalty.php"><i class="fas fa-exclamation-triangle"></i> Penalty Calculator</a>
                <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
                <a href="documentation.php" class="active"><i class="fas fa-book"></i> Documentation</a>
            </div>
        </div>
    </nav>

    <main class="container">
        <div class="card" style="max-width: 1200px; margin: 40px auto;">
            <h1 style="color: var(--primary-color); margin-bottom: 30px;">
                <i class="fas fa-file-contract"></i> ZESTRA Loans Module - Complete Documentation
            </h1>

            <!-- Introduction -->
            <section style="margin-bottom: 40px;">
                <h2 style="color: var(--secondary-color); border-bottom: 2px solid var(--accent-color); padding-bottom: 10px;">
                    1. Introduction
                </h2>
                <p style="line-height: 1.8; margin-top: 20px;">
                    The ZESTRA Loans Module is a <strong>Savings-Backed Credit Facility</strong> with Rolling Weekly Amortisation and Post-Maturity Penalty enforcement. 
                    It enables agents to access short-term and medium-term financing based on their savings balance, repayment behavior, business performance, and KYC level.
                </p>
                <p style="line-height: 1.8; margin-top: 15px;">
                    The module is fully integrated with ZESTRA Savings, Wallet, KYC & Risk Engine, Commission Engine, and Admin Back-Office Suite.
                </p>
            </section>

            <!-- Loan Products -->
            <section style="margin-bottom: 40px;">
                <h2 style="color: var(--secondary-color); border-bottom: 2px solid var(--accent-color); padding-bottom: 10px;">
                    2. Loan Product Framework
                </h2>
                <p style="line-height: 1.8; margin-top: 15px;">
                    ZESTRA provides four core loan products. All parameters are <strong>admin-configurable</strong>.
                </p>

                <div style="margin-top: 25px;">
                    <h3 style="color: var(--primary-color); margin-top: 25px;">
                        <i class="fas fa-hand-holding-heart"></i> 2.1 Soft Loan (Instant Support)
                    </h3>
                    <div style="background: #E3F2FD; padding: 20px; border-radius: 8px; border-left: 4px solid #2196F3; margin-top: 15px;">
                        <p style="margin: 0 0 10px 0;"><strong>Purpose:</strong> Short-term emergency support, liquidity bridging</p>
                        <ul style="margin-left: 20px; line-height: 2;">
                            <li><strong>Minimum Savings:</strong> KES 10,000</li>
                            <li><strong>Loan Limit:</strong> 20% of savings balance (admin-adjustable)</li>
                            <li><strong>Interest Rate:</strong> 12.2% (flat)</li>
                            <li><strong>Maximum Tenure:</strong> 4 weeks</li>
                            <li><strong>Processing Fee:</strong> 0.5% (deducted at disbursement)</li>
                            <li><strong>Penalty:</strong> 10% on Outstanding Exposure Post-Maturity</li>
                            <li><strong>Collateral:</strong> Not required</li>
                            <li><strong>KYC Level:</strong> Standard KYC</li>
                        </ul>
                    </div>

                    <h3 style="color: var(--primary-color); margin-top: 25px;">
                        <i class="fas fa-chart-line"></i> 2.2 Growth Loan (Flexi Growth)
                    </h3>
                    <div style="background: #E8F5E9; padding: 20px; border-radius: 8px; border-left: 4px solid #4CAF50; margin-top: 15px;">
                        <p style="margin: 0 0 10px 0;"><strong>Purpose:</strong> Business expansion, restocking, scaling operations</p>
                        <ul style="margin-left: 20px; line-height: 2;">
                            <li><strong>Minimum Savings:</strong> KES 50,000</li>
                            <li><strong>Loan Limit:</strong> 25% of savings balance</li>
                            <li><strong>Interest Rate:</strong> 12.2% (flat)</li>
                            <li><strong>Maximum Tenure:</strong> 12 weeks</li>
                            <li><strong>Processing Fee:</strong> 1.0%</li>
                            <li><strong>Penalty:</strong> 10% Post-Maturity Penalty</li>
                            <li><strong>Collateral:</strong> Not required</li>
                            <li><strong>KYC Level:</strong> Standard KYC</li>
                        </ul>
                    </div>

                    <h3 style="color: var(--primary-color); margin-top: 25px;">
                        <i class="fas fa-briefcase"></i> 2.3 Biashara Loan (Business Advance)
                    </h3>
                    <div style="background: #FFF3E0; padding: 20px; border-radius: 8px; border-left: 4px solid #FF9800; margin-top: 15px;">
                        <p style="margin: 0 0 10px 0;"><strong>Purpose:</strong> Structured business support for mature micro-enterprises</p>
                        <ul style="margin-left: 20px; line-height: 2;">
                            <li><strong>Minimum Savings:</strong> Admin-defined (Baseline ≥30% credit line rule)</li>
                            <li><strong>Loan Limit:</strong> 30% of savings balance</li>
                            <li><strong>Interest Rate:</strong> 12.2% (flat)</li>
                            <li><strong>Maximum Tenure:</strong> 24 weeks</li>
                            <li><strong>Processing Fee:</strong> 1.5%</li>
                            <li><strong>Penalty:</strong> 10% Post-Maturity Penalty</li>
                            <li><strong>Collateral:</strong> Mandatory</li>
                            <li><strong>Business Age:</strong> Minimum 6 months</li>
                            <li><strong>KYC Level:</strong> Advanced KYC + Business verification</li>
                        </ul>
                    </div>

                    <h3 style="color: var(--primary-color); margin-top: 25px;">
                        <i class="fas fa-building"></i> 2.4 Asset Boost Loan (Asset-Backed Financing)
                    </h3>
                    <div style="background: #FCE4EC; padding: 20px; border-radius: 8px; border-left: 4px solid #E91E63; margin-top: 15px;">
                        <p style="margin: 0 0 10px 0;"><strong>Purpose:</strong> High-value asset acquisition and business scaling</p>
                        <ul style="margin-left: 20px; line-height: 2;">
                            <li><strong>Minimum Savings:</strong> KES 350,000</li>
                            <li><strong>Loan Limit:</strong> 40% of savings balance (Adjustable 35-45%)</li>
                            <li><strong>Interest Rate:</strong> 12.2% (flat)</li>
                            <li><strong>Maximum Tenure:</strong> 52 weeks</li>
                            <li><strong>Processing Fee:</strong> 2.0%</li>
                            <li><strong>Penalty:</strong> 10% Post-Maturity Penalty</li>
                            <li><strong>Collateral:</strong> Mandatory (Asset-based lending assessment)</li>
                            <li><strong>Physical Shop:</strong> Required</li>
                            <li><strong>Business Age:</strong> Minimum 12 months</li>
                            <li><strong>KYC Level:</strong> Enhanced/Enterprise KYC + Background check</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Universal Loan Logic -->
            <section style="margin-bottom: 40px;">
                <h2 style="color: var(--secondary-color); border-bottom: 2px solid var(--accent-color); padding-bottom: 10px;">
                    3. Universal Loan Logic
                </h2>

                <h3 style="color: var(--primary-color); margin-top: 25px;">3.1 Savings-Based Collateral Model</h3>
                <div style="background: #FFF3E0; padding: 15px; border-radius: 8px; border-left: 4px solid var(--accent-color); margin-top: 15px;">
                    <p style="line-height: 1.8; margin: 0;">
                        <strong>Mandatory Savings Reserve Requirement:</strong> At least <strong>40% of savings</strong> must always remain intact. 
                        Savings act as first-loss protection and cannot be fully withdrawn if a loan is active.
                    </p>
                </div>

                <h3 style="color: var(--primary-color); margin-top: 25px;">3.2 Rolling Weekly Amortisation Schedule</h3>
                <p style="line-height: 1.8; margin-top: 15px;">
                    This is the core repayment method:
                </p>
                <ul style="margin-left: 30px; line-height: 2;">
                    <li>System generates <strong>weekly instalments</strong></li>
                    <li>Weekly payment becomes due every <strong>Monday</strong> (or admin-set day)</li>
                    <li>If not paid, it becomes <strong>arrears</strong></li>
                    <li>Arrears <strong>carry forward to the next week</strong></li>
                    <li>They stack into <strong>Total Weekly Due</strong></li>
                </ul>
                <div style="background: #f5f5f5; padding: 15px; border-radius: 5px; margin-top: 15px; font-family: monospace;">
                    <strong>Formula:</strong><br>
                    weekly_due = scheduled_weekly_amount + carried_forward_arrears
                </div>
                <p style="margin-top: 10px; font-style: italic;">
                    This is known as: <strong>"Arrears Capitalization & Carry-Forward Repayment Model"</strong>
                </p>

                <h3 style="color: var(--primary-color); margin-top: 25px;">3.3 Post-Maturity Penalty (Default Penalty)</h3>
                <div style="background: #FFEBEE; padding: 15px; border-radius: 8px; border-left: 4px solid #F44336; margin-top: 15px;">
                    <p style="line-height: 1.8; margin: 0 0 10px 0;">
                        <strong>Important:</strong> If a loan is unpaid at maturity, a <strong>10% Penalty</strong> is applied to the 
                        <strong>Total Outstanding Exposure</strong> (not just the principal).
                    </p>
                    <div style="background: #fff; padding: 10px; border-radius: 5px; font-family: monospace; margin-top: 10px;">
                        outstanding_exposure = principal + flat_interest<br>
                        penalty = outstanding_exposure × 10%
                    </div>
                    <p style="margin-top: 10px; font-style: italic;">
                        This is called: <strong>"Penalty on Outstanding Exposure Post-Maturity"</strong>
                    </p>
                </div>
            </section>

            <!-- Wallet Integration -->
            <section style="margin-bottom: 40px;">
                <h2 style="color: var(--secondary-color); border-bottom: 2px solid var(--accent-color); padding-bottom: 10px;">
                    4. Wallet Integration & Repayment Enforcement
                </h2>

                <h3 style="color: var(--primary-color); margin-top: 25px;">4.1 Lien-Based Repayment Enforcement</h3>
                <p style="line-height: 1.8; margin-top: 15px;">
                    The wallet enforces a <strong>repayment lien</strong>. All wallet inflows automatically settle arrears first.
                </p>
                <div style="background: #f5f5f5; padding: 15px; border-radius: 5px; margin-top: 15px; font-family: monospace;">
                    available_balance = wallet_balance – weekly_due_outstanding
                </div>

                <h3 style="color: var(--primary-color); margin-top: 25px;">4.2 Wallet Withdrawal Freeze</h3>
                <div style="background: #FFF3E0; padding: 15px; border-radius: 8px; margin-top: 15px;">
                    <p style="margin: 0; line-height: 1.8;">
                        <strong>If an agent has any arrears:</strong> Withdrawals are paused until arrears are cleared.
                    </p>
                    <p style="margin: 10px 0 0 0; font-style: italic; color: #666;">
                        "Your withdrawals are temporarily paused due to overdue weekly repayment. Clear the overdue amount to restore access."
                    </p>
                </div>

                <h3 style="color: var(--primary-color); margin-top: 25px;">4.3 Wallet Inflow Auto-Deduction Order</h3>
                <ol style="margin-left: 30px; line-height: 2;">
                    <li>Loan arrears</li>
                    <li>Current weekly due</li>
                    <li>Penalties (if any)</li>
                    <li>Available for agent</li>
                </ol>
            </section>

            <!-- KYC Levels -->
            <section style="margin-bottom: 40px;">
                <h2 style="color: var(--secondary-color); border-bottom: 2px solid var(--accent-color); padding-bottom: 10px;">
                    5. KYC & Risk Levels
                </h2>

                <h3 style="color: var(--primary-color); margin-top: 25px;">5.1 Standard KYC</h3>
                <ul style="margin-left: 30px; line-height: 2;">
                    <li>Selfie</li>
                    <li>ID Front/Back</li>
                    <li>Basic validation</li>
                </ul>
                <p style="margin-top: 10px;"><strong>Applies to:</strong> Soft Loan, Growth Loan</p>

                <h3 style="color: var(--primary-color); margin-top: 25px;">5.2 Advanced KYC</h3>
                <ul style="margin-left: 30px; line-height: 2;">
                    <li>Standard KYC</li>
                    <li>Business documentation</li>
                    <li>Cashflow validation</li>
                    <li>Business age proof</li>
                    <li>Guarantor/Next of Kin</li>
                    <li>Alternative ID checks</li>
                </ul>
                <p style="margin-top: 10px;"><strong>Applies to:</strong> Biashara Loan</p>

                <h3 style="color: var(--primary-color); margin-top: 25px;">5.3 Enhanced/Enterprise KYC</h3>
                <ul style="margin-left: 30px; line-height: 2;">
                    <li>Advanced KYC</li>
                    <li>Physical shop inspection</li>
                    <li>Collateral valuation</li>
                    <li>Background checks</li>
                    <li>Business verification through admin</li>
                </ul>
                <p style="margin-top: 10px;"><strong>Applies to:</strong> Asset Boost Loan</p>
            </section>

            <!-- Repayment Flow -->
            <section style="margin-bottom: 40px;">
                <h2 style="color: var(--secondary-color); border-bottom: 2px solid var(--accent-color); padding-bottom: 10px;">
                    6. Repayment Flow
                </h2>

                <h3 style="color: var(--primary-color); margin-top: 25px;">6.1 Weekly Billing Cycle</h3>
                <p style="line-height: 1.8; margin-top: 15px;">
                    <strong>Every Monday</strong> (or admin-set day):
                </p>
                <ul style="margin-left: 30px; line-height: 2;">
                    <li>System generates a weekly invoice</li>
                    <li>Invoice = weekly instalment + arrears from previous week</li>
                    <li>Agent receives notification</li>
                </ul>

                <h3 style="color: var(--primary-color); margin-top: 25px;">6.2 If Agent Pays Weekly Amount</h3>
                <p style="line-height: 1.8; margin-top: 15px;">
                    Status: <strong style="color: #4CAF50;">Current</strong><br>
                    Wallet withdrawals remain available.
                </p>

                <h3 style="color: var(--primary-color); margin-top: 25px;">6.3 If Agent Fails to Pay</h3>
                <ul style="margin-left: 30px; line-height: 2;">
                    <li>Arrears carry forward</li>
                    <li>Added to next week's due</li>
                    <li>Wallet withdrawals pause</li>
                    <li>System attempts auto-deduction from any new inflow</li>
                </ul>
                <p style="margin-top: 15px;"><strong>Warning Timeline:</strong></p>
                <ul style="margin-left: 30px; line-height: 2;">
                    <li>Day 1 – Soft reminder</li>
                    <li>Day 4 – Warning</li>
                    <li>Day 7 – Withdrawal freeze</li>
                    <li>Day 14 – Arrears flag escalated</li>
                    <li>Day 21 – Risk escalation & admin intervention</li>
                </ul>

                <h3 style="color: var(--primary-color); margin-top: 25px;">6.4 End-of-Tenor Default</h3>
                <div style="background: #FFEBEE; padding: 20px; border-radius: 8px; margin-top: 15px;">
                    <p style="margin: 0 0 15px 0;"><strong>If the loan end date passes and is unpaid:</strong></p>
                    <ol style="margin-left: 20px; line-height: 2;">
                        <li><strong>Exposure Crystallization:</strong> outstanding_exposure = principal + flat_interest</li>
                        <li><strong>Penalty Applied:</strong> penalty = outstanding_exposure × 10%</li>
                        <li><strong>Recovery Attempt:</strong>
                            <ul style="margin-left: 20px;">
                                <li>Wallet</li>
                                <li>Savings (up to reserve rules)</li>
                                <li>Remaining → defaulted balance</li>
                            </ul>
                        </li>
                        <li><strong>Agent May Be Blacklisted</strong></li>
                    </ol>
                </div>
            </section>

            <!-- Terms and Conditions -->
            <section style="margin-bottom: 40px;">
                <h2 style="color: var(--secondary-color); border-bottom: 2px solid var(--accent-color); padding-bottom: 10px;">
                    7. Terms and Conditions
                </h2>

                <h3 style="color: var(--primary-color); margin-top: 25px;">7.1 Calculator Accuracy</h3>
                <p style="line-height: 1.8; margin-top: 15px;">
                    The ZESTRA Loan Calculator provides <strong>estimates only</strong>. Actual loan terms may vary based on 
                    credit profile, savings consistency, and current policies.
                </p>

                <h3 style="color: var(--primary-color); margin-top: 25px;">7.2 Interest Calculation Method</h3>
                <p style="line-height: 1.8; margin-top: 15px;">
                    All loan products use a <strong>Fixed/Flat Interest Rate</strong> calculation method:
                </p>
                <ul style="margin-left: 30px; line-height: 2;">
                    <li><strong>Formula:</strong> Interest = Principal × Interest Rate</li>
                    <li>The interest amount is <strong>fixed</strong> and does not depend on the repayment period</li>
                    <li>The repayment period only affects your <strong>weekly installment amount</strong></li>
                </ul>

                <h3 style="color: var(--primary-color); margin-top: 25px;">7.3 Regulatory Compliance</h3>
                <p style="line-height: 1.8; margin-top: 15px;">
                    ZESTRA CAPITAL LIMITED is regulated by the Central Bank of Kenya (CBK). All loan products comply with 
                    the Banking Act, CBK Prudential Guidelines, Consumer Protection Regulations, and Anti-Money Laundering (AML) requirements.
                </p>
            </section>

            <!-- Disclaimer -->
            <section style="margin-bottom: 40px;">
                <h2 style="color: var(--secondary-color); border-bottom: 2px solid var(--accent-color); padding-bottom: 10px;">
                    8. Disclaimer
                </h2>
                <div style="background: #FFF3E0; padding: 20px; border-radius: 10px; margin-top: 20px; border-left: 5px solid var(--accent-color);">
                    <p style="line-height: 1.8;">
                        <strong>Important:</strong> This calculator is for informational purposes only. It does not constitute 
                        a loan offer or financial advice. Always consult with a ZESTRA loan officer for accurate, personalized 
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 10px;">
                    © 2026 ZESTRA CAPITAL LIMITED. Regulated by the Central Bank of Kenya.
                </p>
            </div>
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
</body>

</html>