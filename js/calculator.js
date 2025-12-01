/**
 * ZESTRA Loan Calculator - Calculation Engine
 * 
 * This module handles all the mathematical logic for loan calculations.
 * It implements the "True Flat Rate" logic where interest is fixed regardless of tenure.
 * 
 * @module Calculator
 */
const Calculator = {
    /**
     * Check if a user is eligible for a specific loan product.
     * Validates savings, loan limits, tenure, and specific product requirements.
     * 
     * @param {Object} inputs - User inputs (savings, loan_amount, tenure, etc.)
     * @param {Object} productConfig - Configuration for the selected product
     * @returns {Object} Result containing eligibility status, reasons, and max loan amount
     */
    checkEligibility: function (inputs, productConfig) {
        const reasons = [];
        let eligible = true;

        // 1. Savings Check
        // Asset Boost has special logic: Collateral can substitute for savings
        if (productConfig.id === 'asset_boost') {
            if (inputs.savings < productConfig.min_savings && !inputs.has_collateral) {
                eligible = false;
                reasons.push(`Minimum savings of ${CONFIG.currency} ${productConfig.min_savings.toLocaleString()} OR collateral required.`);
            }
        } else {
            // Standard savings check for other products
            if (inputs.savings < productConfig.min_savings) {
                eligible = false;
                reasons.push(`Insufficient savings. Minimum required: ${CONFIG.currency} ${productConfig.min_savings.toLocaleString()}`);
            }
        }

        // 2. Loan Amount Limit Check (Based on Savings)
        // Calculate maximum allowed loan based on savings percentage
        const maxLoan = (inputs.savings * productConfig.loan_limit_percent) / 100;
        if (inputs.loan_amount > maxLoan) {
            eligible = false;
            reasons.push(`Loan amount exceeds limit. Max allowed: ${CONFIG.currency} ${maxLoan.toLocaleString()} (${productConfig.loan_limit_percent}% of savings)`);
        }

        // 3. Tenure Check
        if (inputs.tenure_weeks > productConfig.max_tenure_weeks) {
            eligible = false;
            reasons.push(`Tenure exceeds maximum of ${productConfig.max_tenure_weeks} weeks.`);
        }

        // 4. Biashara Specific: Business Age Check
        if (productConfig.id === 'biashara_advance') {
            if (inputs.business_age_months < productConfig.business_age_months) {
                eligible = false;
                reasons.push(`Business must be at least ${productConfig.business_age_months} months old.`);
            }
        }

        return {
            eligible: eligible,
            reasons: reasons,
            max_loan: maxLoan
        };
    },

    /**
     * Calculate Loan Details using True Flat Rate Logic.
     * 
     * LOGIC EXPLANATION:
     * - Interest is calculated as a fixed percentage of the Principal.
     * - Formula: Interest = Principal * (Rate / 100)
     * - This interest amount is CONSTANT regardless of the repayment period (weeks).
     * - Total Repayment = Principal + Interest
     * - Weekly Installment = Total Repayment / Tenure (Weeks)
     * 
     * @param {Object} inputs - User inputs
     * @param {Object} productConfig - Product configuration
     * @returns {Object} Calculated loan details
     */
    calculateLoan: function (inputs, productConfig) {
        const principal = inputs.loan_amount;
        const weeks = inputs.tenure_weeks;
        const ratePercent = productConfig.interest_rate;

        // Processing Fee Calculation (Percentage of Principal)
        // ADDED to Principal at disbursement
        const processingFee = (principal * productConfig.processing_fee_percent) / 100;
        const disbursedAmount = principal + processingFee;

        // TRUE FLAT RATE INTEREST CALCULATION
        // Interest is fixed based on principal and rate only. Time is NOT a factor in total interest.
        const totalInterest = principal * (ratePercent / 100);

        // Total amount to be repaid by the borrower
        const totalRepayment = principal + totalInterest;

        // Weekly payment amount
        const weeklyInstallment = totalRepayment / weeks;

        // Penalty Calculation (10% on Total Exposure)
        // Exposure = Principal + Accrued Flat Interest
        const totalExposure = totalRepayment;
        const penaltyRate = productConfig.penalty_rate_percent || 10;
        const potentialPenalty = totalExposure * (penaltyRate / 100);

        // Explanation string for the UI
        const formulaExplanation = `Fixed Interest = Principal (${CONFIG.currency} ${principal.toLocaleString()}) × Rate (${ratePercent}%)`;

        // Total cost of credit (Interest + Fees)
        const totalCost = totalInterest + processingFee;

        return {
            principal: principal,
            disbursed_amount: disbursedAmount,
            interest: totalInterest,
            processing_fee: processingFee,
            total_repayment: totalRepayment,
            total_cost: totalCost,
            weekly_installment: weeklyInstallment,
            tenure_weeks: weeks,
            product: productConfig,
            formula_explanation: formulaExplanation,
            potential_penalty: potentialPenalty,
            penalty_rate: penaltyRate
        };
    }
};

window.Calculator = Calculator;
