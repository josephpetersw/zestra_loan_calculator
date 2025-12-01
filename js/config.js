/**
 * ZESTRA Loan Calculator - Configuration Module
 * 
 * This file contains the core configuration for all loan products.
 * It defines interest rates, limits, fees, and eligibility criteria.
 * 
 * @module CONFIG
 */
const CONFIG = {
    // Application-wide currency setting
    currency: 'KES',

    // Loan Product Definitions
    // Each product has specific limits, interest rates, and eligibility criteria.
    products: {
        soft_loan: {
            id: 'soft_loan',
            name: 'Soft Loan',
            min_savings: 10000,
            loan_limit_percent: 20,
            interest_rate: 12.2,    // Flat Rate
            interest_type: 'flat',
            max_tenure_weeks: 4,
            processing_fee_percent: 0.5,
            penalty_rate_percent: 10,
            collateral_required: false,
            description: 'Emergency funds for immediate needs.'
        },
        growth_loan: {
            id: 'growth_loan',
            name: 'Growth Loan',
            min_savings: 50000,
            loan_limit_percent: 25,
            interest_rate: 12.2,
            interest_type: 'flat',
            max_tenure_weeks: 12,
            processing_fee_percent: 1.0,
            penalty_rate_percent: 10,
            collateral_required: false,
            description: 'Business growth and inventory support.'
        },
        biashara_loan: {
            id: 'biashara_loan',
            name: 'Biashara Loan',
            min_savings: 150000, // Admin-defined, using previous baseline or reasonable default
            loan_limit_percent: 30,
            interest_rate: 12.2,
            interest_type: 'flat',
            max_tenure_weeks: 24,
            processing_fee_percent: 1.5,
            penalty_rate_percent: 10,
            collateral_required: true,
            business_age_months: 6,
            description: 'Working capital for established businesses.'
        },
        asset_boost_loan: {
            id: 'asset_boost_loan',
            name: 'Asset Loan',
            min_savings: 350000,
            loan_limit_percent: 40,
            interest_rate: 12.2,
            interest_type: 'flat',
            max_tenure_weeks: 52,
            processing_fee_percent: 2.0,
            penalty_rate_percent: 10,
            collateral_required: true,
            business_age_months: 12,
            description: 'Asset-backed financing for expansion.'
        }
    },

    /**
     * Save current configuration to local storage.
     * Useful for the Settings page to persist changes.
     */
    save: function () {
        localStorage.setItem('zestra_loan_config', JSON.stringify(this.products));
    },

    /**
     * Load configuration from local storage if available.
     * Overwrites default values with user-saved settings.
     */
    load: function () {
        const saved = localStorage.getItem('zestra_loan_config');
        if (saved) {
            try {
                const parsed = JSON.parse(saved);
                // Merge saved config with defaults to ensure structure integrity
                Object.keys(parsed).forEach(key => {
                    if (this.products[key]) {
                        this.products[key] = { ...this.products[key], ...parsed[key] };
                    }
                });
            } catch (e) {
                console.error("Failed to load settings", e);
            }
        }
    },

    /**
     * Reset configuration to hardcoded defaults.
     */
    reset: function () {
        localStorage.removeItem('zestra_loan_config');
    }
};

// Initialize configuration on load
CONFIG.load();

// Expose to window for global access
window.CONFIG = CONFIG;
