const Recommendations = {
    analyze: function (inputs, loanDetails) {
        const warnings = [];
        const suggestions = [];

        // Risk Warning: High Loan to Savings Ratio
        const ratio = (inputs.loan_amount / inputs.savings) * 100;
        if (ratio > 30) {
            warnings.push("High Leverage: You are borrowing a significant portion relative to your savings.");
        }

        // Suggestion: Savings Growth
        if (!loanDetails) {
            // If not eligible, suggest how much more savings needed
            // This logic would need to know WHICH product failed.
            // For now, generic suggestion.
            suggestions.push("Increasing your savings will unlock higher loan limits.");
        }

        return { warnings, suggestions };
    }
};

window.Recommendations = Recommendations;
