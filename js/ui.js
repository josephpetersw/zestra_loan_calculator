/**
 * ZESTRA Loan Calculator - UI Controller
 * 
 * This module handles all user interface interactions, including:
 * - Dynamic form generation based on selected product
 * - Input validation and formatting (commas)
 * - Displaying results (Summary and Amortization Table)
 * - Excel Export functionality
 * 
 * @module UI
 */
const UI = {
    /**
     * Initialize the UI Controller.
     */
    init: function () {
        this.cacheDOM();
        this.bindEvents();
        this.renderProductSelector();
        // Select the first product by default
        this.handleProductChange('soft_loan');
    },

    /**
     * Cache DOM elements.
     */
    cacheDOM: function () {
        this.productSelect = document.getElementById('productSelect');
        this.dynamicForm = document.getElementById('dynamicForm');
        this.resultsSection = document.getElementById('resultsSection');
        this.calculateBtn = document.getElementById('calculateBtn');
        this.eligibilityStatus = document.getElementById('eligibilityStatus');
        this.loanSummary = document.getElementById('loanSummary');
        this.amortizationTableBody = document.getElementById('amortizationTableBody');

        // Tabs (may not exist on all pages)
        this.tabBtns = document.querySelectorAll('.tab-btn');
        this.tabContents = document.querySelectorAll('.tab-content');

        // Penalty Calculator (may not exist on all pages)
        this.penaltyLoanBalance = document.getElementById('penaltyLoanBalance');
        this.calculatePenaltyBtn = document.getElementById('calculatePenaltyBtn');
        this.penaltyResult = document.getElementById('penaltyResult');

        // Modals & Toasts
        this.modalOverlay = document.getElementById('customModal');
        this.modalTitle = document.getElementById('modalTitle');
        this.modalBody = document.getElementById('modalBody');
        this.modalCancelBtn = document.getElementById('modalCancelBtn');
        this.modalConfirmBtn = document.getElementById('modalConfirmBtn');
        this.closeModalBtn = document.querySelector('.close-modal');
        this.toastContainer = document.getElementById('toastContainer');
    },

    /**
     * Bind event listeners.
     */
    bindEvents: function () {
        // Product Selection
        if (this.productSelect) {
            this.productSelect.addEventListener('change', (e) => {
                this.handleProductChange(e.target.value);
            });
        }

        // Calculate Loan
        if (this.calculateBtn) {
            this.calculateBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.showModal('Confirm Calculation', 'Are you sure you want to calculate this loan?', () => {
                    this.calculateLoan();
                });
            });
        }

        // Dynamic Form Inputs
        if (this.dynamicForm) {
            this.dynamicForm.addEventListener('input', (e) => {
                if (e.target.id === 'savings') {
                    this.updateLoanSliderLimit();
                    this.formatInputWithCommas(e.target);
                }
                if (e.target.id === 'loanAmount') {
                    const slider = document.getElementById('loanSlider');
                    const numericValue = this.getNumericValue(e.target.value);
                    if (slider) slider.value = numericValue;
                    this.formatInputWithCommas(e.target);
                }
                if (e.target.id === 'loanSlider') {
                    document.getElementById('loanAmount').value = this.formatNumberInput(e.target.value);
                }
            });
        }

        // Tabs Switching
        if (this.tabBtns && this.tabBtns.length > 0) {
            this.tabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    this.switchTab(btn.dataset.tab);
                });
            });
        }

        // Penalty Calculator
        if (this.calculatePenaltyBtn) {
            this.calculatePenaltyBtn.addEventListener('click', () => {
                this.calculatePenalty();
            });
        }

        if (this.penaltyLoanBalance) {
            this.penaltyLoanBalance.addEventListener('input', (e) => {
                this.formatInputWithCommas(e.target);
            });
        }

        // Modal Actions
        if (this.closeModalBtn) {
            this.closeModalBtn.addEventListener('click', () => this.hideModal());
        }
        if (this.modalCancelBtn) {
            this.modalCancelBtn.addEventListener('click', () => this.hideModal());
        }

        // Export PDF (Event delegation as button might be re-rendered)
        document.addEventListener('click', (e) => {
            if (e.target && e.target.id === 'exportPdfBtn') {
                this.exportToPDF();
            }
        });
    },

    /**
     * Switch between Tabs.
     */
    switchTab: function (tabId) {
        this.tabBtns.forEach(btn => {
            btn.classList.toggle('active', btn.dataset.tab === tabId);
        });
        this.tabContents.forEach(content => {
            content.classList.toggle('active', content.id === tabId);
        });
    },

    /**
     * Format input value with commas.
     */
    formatInputWithCommas: function (input) {
        const cursorPos = input.selectionStart;
        const oldLength = input.value.length;
        input.value = this.formatNumberInput(input.value);
        const newLength = input.value.length;
        input.setSelectionRange(cursorPos + (newLength - oldLength), cursorPos + (newLength - oldLength));
    },

    formatNumberInput: function (value) {
        const numericValue = value.replace(/\D/g, '');
        return numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    },

    getNumericValue: function (formattedValue) {
        return parseFloat(formattedValue.replace(/,/g, '')) || 0;
    },

    /**
     * Render Product Selector.
     */
    renderProductSelector: function () {
        this.productSelect.innerHTML = '';
        Object.values(CONFIG.products).forEach(product => {
            const option = document.createElement('option');
            option.value = product.id;
            option.textContent = product.name;
            this.productSelect.appendChild(option);
        });
    },

    handleProductChange: function (productId) {
        const product = CONFIG.products[productId];
        this.renderForm(product);
        this.resultsSection.classList.add('hidden');
        this.eligibilityStatus.innerHTML = '';
    },

    renderForm: function (product) {
        let html = `
            <div class="form-group">
                <label>
                    <i class="fas fa-piggy-bank"></i> Savings Amount (${CONFIG.currency})
                    <div class="ribbon-container">
                        <span class="ribbon-badge">?</span>
                        <span class="tooltip-text">Your current savings balance. Determines your maximum loan limit.</span>
                    </div>
                </label>
                <input type="text" id="savings" class="form-control" placeholder="Enter your savings" required>
                <small class="hint">Min required: ${CONFIG.currency} ${product.min_savings.toLocaleString()}</small>
            </div>
            
            <div class="form-group">
                <label>
                    <i class="fas fa-money-bill-wave"></i> Loan Amount (${CONFIG.currency})
                    <div class="ribbon-container">
                        <span class="ribbon-badge">Max ${product.loan_limit_percent}%</span>
                        <span class="tooltip-text">You can borrow up to ${product.loan_limit_percent}% of your savings.</span>
                    </div>
                </label>
                <input type="text" id="loanAmount" class="form-control" placeholder="Enter desired amount" required>
                <div class="range-container">
                    <input type="range" id="loanSlider" min="0" max="0" value="0" step="100">
                </div>
                <small class="hint" id="loanLimitHint">Enter savings to see limit</small>
            </div>

            <div class="form-group">
                <label>
                    <i class="fas fa-calendar-alt"></i> Tenure (Weeks)
                    <div class="ribbon-container">
                        <span class="ribbon-badge">Max ${product.max_tenure_weeks}w</span>
                        <span class="tooltip-text">Duration for repayment. Maximum allowed is ${product.max_tenure_weeks} weeks.</span>
                    </div>
                </label>
                <input type="number" id="tenure" class="form-control" placeholder="Weeks" required min="1" max="${product.max_tenure_weeks}">
            </div>
        `;

        if (product.business_age_months) {
            html += `
                <div class="form-group">
                    <label><i class="fas fa-briefcase"></i> Business Age (Months)</label>
                    <input type="number" id="businessAge" class="form-control" placeholder="Months" required min="0">
                    <small class="hint">Min required: ${product.business_age_months} months</small>
                </div>
            `;
        }

        if (product.collateral_required) {
            html += `
                <div class="form-group">
                    <label><i class="fas fa-home"></i> Collateral Details</label>
                    <input type="text" id="collateral" class="form-control" placeholder="Describe collateral (if applicable)">
                    <small class="hint">Required for this loan</small>
                </div>
            `;
        }

        this.dynamicForm.innerHTML = html;
        this.updateLoanSliderLimit();
    },

    updateLoanSliderLimit: function () {
        const savingsInput = document.getElementById('savings');
        const loanSlider = document.getElementById('loanSlider');
        const loanLimitHint = document.getElementById('loanLimitHint');
        const product = CONFIG.products[this.productSelect.value];

        if (savingsInput && loanSlider && product) {
            const savings = this.getNumericValue(savingsInput.value);
            const maxLoan = (savings * product.loan_limit_percent) / 100;

            loanSlider.max = maxLoan;
            loanLimitHint.textContent = `Max Limit: ${CONFIG.currency} ${maxLoan.toLocaleString()} (${product.loan_limit_percent}% of savings)`;

            if (parseFloat(loanSlider.value) > maxLoan) {
                loanSlider.value = maxLoan;
                document.getElementById('loanAmount').value = this.formatNumberInput(maxLoan.toString());
            }
        }
    },

    getInputs: function () {
        return {
            savings: this.getNumericValue(document.getElementById('savings').value),
            loan_amount: this.getNumericValue(document.getElementById('loanAmount').value),
            tenure_weeks: parseInt(document.getElementById('tenure').value) || 0,
            business_age_months: document.getElementById('businessAge') ? parseInt(document.getElementById('businessAge').value) : 0,
            has_collateral: document.getElementById('collateral') && document.getElementById('collateral').value.trim() !== '',
            early_repayment: 0
        };
    },

    validateInputs: function (inputs, product) {
        if (inputs.savings < product.min_savings) {
            this.showToast(`Minimum savings of ${CONFIG.currency} ${product.min_savings.toLocaleString()} required.`, 'error');
            return false;
        }

        if (inputs.loan_amount <= 0) {
            this.showToast("Please enter a valid loan amount.", 'error');
            return false;
        }

        if (inputs.tenure_weeks <= 0 || inputs.tenure_weeks > product.max_tenure_weeks) {
            this.showToast(`Tenure must be between 1 and ${product.max_tenure_weeks} weeks.`, 'error');
            return false;
        }

        return true;
    },

    calculateLoan: function () {
        const productId = this.productSelect.value;
        const product = CONFIG.products[productId];
        const inputs = this.getInputs();

        if (!this.validateInputs(inputs, product)) return;

        const eligibility = Calculator.checkEligibility(inputs, product);
        this.renderEligibility(eligibility);

        if (eligibility.eligible) {
            const loanDetails = Calculator.calculateLoan(inputs, product);
            const schedule = Amortization.generateSchedule(loanDetails);

            this.renderSummary(loanDetails);
            this.renderAmortizationTable(schedule);

            this.resultsSection.classList.remove('hidden');
            this.resultsSection.scrollIntoView({ behavior: 'smooth' });
            this.showToast('Loan calculated successfully!', 'success');
        } else {
            this.resultsSection.classList.add('hidden');
            this.showToast('You are not eligible for this loan.', 'error');
        }
    },

    renderEligibility: function (eligibility) {
        if (eligibility.eligible) {
            this.eligibilityStatus.innerHTML = `
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <strong>Eligible!</strong> You qualify for this loan.
                </div>
            `;
        } else {
            const reasonsHtml = eligibility.reasons.map(r => `<li>${r}</li>`).join('');
            this.eligibilityStatus.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-times-circle"></i> <strong>Not Eligible</strong>
                    <ul>${reasonsHtml}</ul>
                    ${eligibility.max_loan > 0 ? `<p>Based on your savings, you can borrow up to <strong>${CONFIG.currency} ${eligibility.max_loan.toLocaleString()}</strong>.</p>` : ''}
                </div>
            `;
        }
    },

    renderSummary: function (details) {
        this.loanSummary.innerHTML = `
            <div class="results-card">
                <h3><i class="fas fa-file-invoice-dollar"></i> Loan Summary - ${details.product.name}</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px;">
                    <div class="summary-item">
                        <span class="label">Requested Principal</span>
                        <span class="value">KES ${details.principal.toLocaleString()}</span>
                    </div>
                    <div class="summary-item">
                        <span class="label">Processing Fee (${details.product.processing_fee_percent}%)</span>
                        <span class="value">+ KES ${details.processing_fee.toLocaleString()}</span>
                    </div>
                    <div class="summary-item" style="background: #E3F2FD; padding: 15px; border-radius: 8px;">
                        <span class="label">💰 Disbursed Amount</span>
                        <span class="value" style="color: var(--primary-color); font-weight: 800;">KES ${details.disbursed_amount.toLocaleString()}</span>
                    </div>
                    <div class="summary-item">
                        <span class="label">Total Interest (${details.product.interest_rate}%)</span>
                        <span class="value">KES ${details.interest.toLocaleString(undefined, { maximumFractionDigits: 2 })}</span>
                    </div>
                    <div class="summary-item" style="background: #E8F5E9; padding: 15px; border-radius: 8px;">
                        <span class="label">📊 Total Repayment</span>
                        <span class="value" style="color: #4CAF50; font-weight: 800;">KES ${details.total_repayment.toLocaleString(undefined, { maximumFractionDigits: 2 })}</span>
                    </div>
                    <div class="summary-item">
                        <span class="label">Weekly Installment</span>
                        <span class="value">KES ${details.weekly_installment.toLocaleString(undefined, { maximumFractionDigits: 2 })}</span>
                    </div>
                    <div class="summary-item">
                        <span class="label">Tenure</span>
                        <span class="value">${details.tenure_weeks} Weeks</span>
                    </div>
                </div>
                
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 10px; margin-top: 25px; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 700; font-size: 1.1rem;"><i class="fas fa-chart-line"></i> Net Portfolio Revenue (NPR)</span>
                    <span style="font-size: 1.5rem; font-weight: 800; color: #FFD700;">KES ${details.total_cost.toLocaleString(undefined, { maximumFractionDigits: 2 })}</span>
                </div>
                
                <div style="background: #FFF3E0; padding: 15px; border-radius: 8px; margin-top: 15px; border-left: 4px solid var(--accent-color);">
                    <small style="line-height: 1.6;">
                        <i class="fas fa-info-circle"></i> <strong>Penalty Note:</strong> If unpaid after ${details.tenure_weeks} weeks, a 10% penalty applies on the Total Exposure (KES ${details.total_repayment.toLocaleString()}). Potential Penalty: <strong>KES ${details.potential_penalty.toLocaleString()}</strong>.
                    </small>
                </div>
            </div>
        `;
    },


    renderAmortizationTable: function (schedule) {
        const rows = schedule.map(row => `
            <tr>
                <td>${row.week}</td>
                <td class="nowrap">${CONFIG.currency} ${row.opening_principal.toLocaleString(undefined, { maximumFractionDigits: 2 })}</td>
                <td class="nowrap">${CONFIG.currency} ${row.principal_payment.toLocaleString(undefined, { maximumFractionDigits: 2 })}</td>
                <td class="nowrap">${CONFIG.currency} ${row.interest_payment.toLocaleString(undefined, { maximumFractionDigits: 2 })}</td>
                <td class="bg-highlight text-money-out nowrap">- ${CONFIG.currency} ${row.total_payment.toLocaleString(undefined, { maximumFractionDigits: 2 })}</td>
                <td class="nowrap">${CONFIG.currency} ${row.closing_principal.toLocaleString(undefined, { maximumFractionDigits: 2 })}</td>
            </tr>
        `).join('');
        this.amortizationTableBody.innerHTML = rows;
    },

    /**
     * Penalty Calculator Logic
     */
    calculatePenalty: function () {
        const balance = this.getNumericValue(this.penaltyLoanBalance.value);
        if (balance <= 0) {
            this.showToast('Please enter a valid outstanding balance.', 'error');
            return;
        }

        const penaltyRate = 10; // Fixed at 10% as per requirements
        const penaltyAmount = balance * (penaltyRate / 100);
        const totalDue = balance + penaltyAmount;

        this.penaltyResult.innerHTML = `
            <div class="alert alert-danger">
                <h4><i class="fas fa-exclamation-circle"></i> Penalty Calculation</h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px;">
                    <div>
                        <small>Outstanding Exposure</small>
                        <div style="font-weight: 800; font-size: 1.1rem;">${CONFIG.currency} ${balance.toLocaleString()}</div>
                    </div>
                    <div>
                        <small>Penalty (10%)</small>
                        <div style="font-weight: 800; font-size: 1.1rem; color: var(--danger-color);">${CONFIG.currency} ${penaltyAmount.toLocaleString()}</div>
                    </div>
                </div>
                <hr style="margin: 15px 0; border-color: rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <strong>Total Amount Due:</strong>
                    <span style="font-size: 1.4rem; font-weight: 800;">${CONFIG.currency} ${totalDue.toLocaleString()}</span>
                </div>
            </div>
        `;
        this.penaltyResult.classList.remove('hidden');
        this.showToast('Penalty calculated.', 'success');
    },

    /**
     * Export to PDF using jsPDF
     */
    exportToPDF: function () {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        const productId = this.productSelect.value;
        const product = CONFIG.products[productId];
        const inputs = this.getInputs();
        const loanDetails = Calculator.calculateLoan(inputs, product);
        const schedule = Amortization.generateSchedule(loanDetails);

        // Add centered logo (rectangular)
        const logo = new Image();
        logo.src = 'assets/logo.png';

        // Add logo centered at top (rectangular dimensions)
        try {
            doc.addImage(logo, 'PNG', 75, 10, 60, 25); // Centered, rectangular
        } catch (e) {
            console.log('Logo not loaded, skipping');
        }

        // Header
        doc.setFontSize(22);
        doc.setFont('helvetica', 'bold');
        doc.setTextColor(102, 126, 234);
        doc.text("ZESTRA LOAN CALCULATOR", 105, 45, null, null, "center");

        doc.setFontSize(11);
        doc.setFont('helvetica', 'normal');
        doc.setTextColor(100);
        doc.text(`Loan Product: ${product.name}`, 105, 52, null, null, "center");
        doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 105, 58, null, null, "center");

        // Summary Table
        const summaryData = [
            ["Principal Requested", `KES ${loanDetails.principal.toLocaleString()}`],
            ["Processing Fee", `- KES ${loanDetails.processing_fee.toLocaleString()}`],
            ["Disbursed Amount", `KES ${loanDetails.disbursed_amount.toLocaleString()}`],
            ["Interest Rate", `${product.interest_rate}% (Flat)`],
            ["Total Interest", `KES ${loanDetails.interest.toLocaleString()}`],
            ["Total Repayment", `KES ${loanDetails.total_repayment.toLocaleString()}`],
            ["Weekly Installment", `KES ${loanDetails.weekly_installment.toLocaleString()}`],
            ["Tenure", `${loanDetails.tenure_weeks} Weeks`],
            ["Net Portfolio Revenue (NPR)", `KES ${loanDetails.total_cost.toLocaleString()}`]
        ];

        doc.autoTable({
            startY: 65,
            head: [['Item', 'Value']],
            body: summaryData,
            theme: 'striped',
            headStyles: {
                fillColor: [102, 126, 234],
                fontStyle: 'bold',
                fontSize: 11
            },
            styles: {
                fontSize: 10,
                font: 'helvetica'
            },
            columnStyles: {
                0: { fontStyle: 'bold', cellWidth: 80 },
                1: { cellWidth: 80 }
            }
        });

        // Schedule Table with matching columns
        const scheduleData = schedule.map(row => [
            row.week,
            `KES ${row.opening_principal.toLocaleString(undefined, { maximumFractionDigits: 2 })}`,
            `KES ${row.principal_payment.toLocaleString(undefined, { maximumFractionDigits: 2 })}`,
            `KES ${row.interest_payment.toLocaleString(undefined, { maximumFractionDigits: 2 })}`,
            `KES ${row.total_payment.toLocaleString(undefined, { maximumFractionDigits: 2 })}`,
            `KES ${row.closing_principal.toLocaleString(undefined, { maximumFractionDigits: 2 })}`
        ]);

        doc.setFontSize(12);
        doc.setFont('helvetica', 'bold');
        doc.setTextColor(102, 126, 234);
        doc.text("Weekly Repayment Schedule", 14, doc.lastAutoTable.finalY + 12);

        doc.autoTable({
            startY: doc.lastAutoTable.finalY + 17,
            head: [['Week', 'Opening Principal', 'Principal Payment', 'Interest Payment', 'Weekly Deduction', 'Closing Principal']],
            body: scheduleData,
            theme: 'grid',
            headStyles: {
                fillColor: [255, 111, 0],
                fontStyle: 'bold',
                fontSize: 9
            },
            styles: {
                fontSize: 8,
                font: 'helvetica'
            },
            columnStyles: {
                0: { cellWidth: 15 },
                1: { cellWidth: 30 },
                2: { cellWidth: 30 },
                3: { cellWidth: 30 },
                4: { cellWidth: 30, fontStyle: 'bold' },
                5: { cellWidth: 30 }
            }
        });

        // Footer with contact details
        const pageCount = doc.internal.getNumberOfPages();
        for (let i = 1; i <= pageCount; i++) {
            doc.setPage(i);
            doc.setFontSize(8);
            doc.setFont('helvetica', 'bold');
            doc.setTextColor(102, 126, 234);
            doc.text('ZESTRA CAPITAL LIMITED', 105, 280, null, null, 'center');
            doc.setFont('helvetica', 'normal');
            doc.setTextColor(100);
            doc.text('+254 720 012 374 | zestracapitallimited@gmail.com | Moi Avenue, Nairobi', 105, 285, null, null, 'center');
            doc.setFontSize(7);
            doc.setTextColor(150);
            doc.text('Regulated by the Central Bank of Kenya', 105, 290, null, null, 'center');
        }

        doc.save(`Zestra_Loan_${Date.now()}.pdf`);
        this.showToast('PDF downloaded successfully!', 'success');
    },

    /**
     * Show Custom Modal
     */
    showModal: function (title, message, onConfirm) {
        this.modalTitle.textContent = title;
        this.modalBody.textContent = message;
        this.modalOverlay.classList.remove('hidden');

        // Remove old listeners to prevent stacking
        const newConfirmBtn = this.modalConfirmBtn.cloneNode(true);
        this.modalConfirmBtn.parentNode.replaceChild(newConfirmBtn, this.modalConfirmBtn);
        this.modalConfirmBtn = newConfirmBtn;

        this.modalConfirmBtn.addEventListener('click', () => {
            if (onConfirm) onConfirm();
            this.hideModal();
        });
    },

    hideModal: function () {
        this.modalOverlay.classList.add('hidden');
    },

    /**
     * Show Toast Notification
     */
    showToast: function (message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;

        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

        toast.innerHTML = `
            <i class="fas ${icon}"></i>
            <span>${message}</span>
        `;

        this.toastContainer.appendChild(toast);

        // Auto remove after 3 seconds
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
};

window.UI = UI;

