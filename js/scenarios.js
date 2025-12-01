const Scenarios = {
    compareAllProducts: function (inputs) {
        const results = [];
        Object.values(CONFIG.products).forEach(product => {
            // Clone inputs to avoid modifying original
            const testInputs = { ...inputs };

            // Adjust tenure if it exceeds product max
            if (testInputs.tenure_weeks > product.max_tenure_weeks) {
                testInputs.tenure_weeks = product.max_tenure_weeks;
            }

            const eligibility = Calculator.checkEligibility(testInputs, product);
            if (eligibility.eligible) {
                const details = Calculator.calculateLoan(testInputs, product);
                results.push(details);
            }
        });
        return results;
    }
};

window.Scenarios = Scenarios;
