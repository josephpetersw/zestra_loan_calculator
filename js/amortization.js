/**
 * ZESTRA Loan Calculator - Amortization Schedule Generator
 * 
 * This module generates the week-by-week repayment schedule.
 * It follows standard accounting principles where:
 * - Principal = The remaining loan balance at the start of the period.
 * - Payments are split into Principal and Interest components.
 * 
 * @module Amortization
 */
const Amortization = {
    /**
     * Generate the repayment schedule.
     * 
     * @param {Object} loanDetails - The calculated loan details from Calculator.calculateLoan()
     * @returns {Array} Array of objects representing each week's payment details
     */
    generateSchedule: function (loanDetails) {
        const schedule = [];
        const principal = loanDetails.principal;
        const weeks = loanDetails.tenure_weeks;
        const totalInterest = loanDetails.interest;

        // FLAT RATE AMORTIZATION LOGIC
        // In a flat rate loan, the total interest and total principal are simply divided by the number of weeks.
        // This results in equal weekly payments.

        const weeklyPrincipal = principal / weeks;      // Portion of payment going towards principal
        const weeklyInterest = totalInterest / weeks;   // Portion of payment going towards interest
        const weeklyPayment = weeklyPrincipal + weeklyInterest; // Total weekly payment

        let remainingPrincipal = principal;

        for (let i = 1; i <= weeks; i++) {
            const openingPrincipal = remainingPrincipal;

            // Reduce the remaining balance by the principal portion of the payment
            remainingPrincipal -= weeklyPrincipal;

            // Correction for floating point errors on the final week
            // Ensures the loan is exactly paid off
            if (i === weeks) {
                remainingPrincipal = 0;
            }

            schedule.push({
                week: i,
                opening_principal: openingPrincipal, // Balance at start of week
                principal_payment: weeklyPrincipal,  // Amount reducing the balance
                interest_payment: weeklyInterest,    // Interest cost for this week
                total_payment: weeklyPayment,        // Total amount paid by user
                closing_principal: Math.max(0, remainingPrincipal) // Balance at end of week
            });
        }

        return schedule;
    }
};

window.Amortization = Amortization;
