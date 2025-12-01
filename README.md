# ZESTRA Loan Calculator

## Overview

The **ZESTRA Loan Calculator** is a robust, web-based financial tool designed for **Zestra Capital Limited**. It enables agents and loan officers to accurately calculate loan repayment schedules, processing fees, and potential penalties for various loan products. The application features a modern, responsive user interface and generates detailed PDF reports for clients.

## Features

### 1. Loan Products
The calculator supports multiple configurable loan products, each with specific terms:
*   **Soft Loan**: Emergency funds for immediate needs (4 weeks tenure).
*   **Growth Loan**: Business growth and inventory support (12 weeks tenure).
*   **Biashara Loan**: Working capital for established businesses (24 weeks tenure).
*   **Asset Loan**: Asset-backed financing for expansion (52 weeks tenure).

### 2. Core Functionality
*   **Dynamic Eligibility Check**: Validates loan requests based on savings balance and product-specific limits.
*   **Flat Rate Interest Calculation**: Calculates interest based on the principal amount and a fixed rate, independent of the repayment period.
*   **Processing Fee Handling**: Automatically adds processing fees to the principal to determine the total disbursed amount.
*   **Rolling Weekly Amortization**: Generates a detailed weekly repayment schedule.
*   **Penalty Calculation**: Includes a standalone calculator for post-maturity penalties (10% on Total Outstanding Exposure).

### 3. User Interface
*   **Modern Dashboard Design**: Features a clean, card-based layout with gradient headers and intuitive navigation.
*   **Responsive Layout**: Fully optimized for desktop, tablet, and mobile devices.
*   **Interactive Elements**: Real-time input validation, dynamic sliders, and toast notifications for user feedback.

### 4. Reporting
*   **PDF Export**: Generates professional, branded PDF reports including:
    *   Loan Summary (Principal, Fees, Interest, NPR).
    *   Detailed Weekly Repayment Schedule.
    *   Zestra Capital branding and contact details.

## Technology Stack

*   **Frontend**: HTML5, CSS3 (Custom Variables & Flexbox/Grid), JavaScript (ES6+).
*   **Libraries**:
    *   `jspdf` & `jspdf-autotable`: For client-side PDF generation.
    *   `FontAwesome`: For scalable vector icons.
    *   `Google Fonts`: Using 'Nunito' for typography.
*   **Backend**: PHP (for serving the application, though the core logic is client-side JavaScript).

## Installation & Setup

1.  **Clone the Repository**:
    ```bash
    git clone https://github.com/josephpetersw/zestra_loan_calculator.git
    ```
2.  **Deploy**:
    *   Place the project files in your web server's root directory (e.g., `htdocs` for XAMPP/Apache, or `www` for Nginx).
    *   Ensure the `assets` folder contains the `logo.png` file.
3.  **Run**:
    *   Open your web browser and navigate to `http://localhost/zestra_loan_calculator` (or your specific local path).

## Configuration

Loan products and global settings can be configured in `js/config.js`.

```javascript
const CONFIG = {
    currency: 'KES',
    products: {
        soft_loan: {
            name: 'Soft Loan',
            min_savings: 10000,
            loan_limit_percent: 20,
            interest_rate: 12.2,
            // ... other parameters
        },
        // ... other products
    }
};
```

## Project Structure

```
zestra_loan_calculator/
├── assets/             # Images and static assets
├── css/
│   └── styles.css      # Main stylesheet
├── js/
│   ├── app.js          # Main application entry point
│   ├── calculator.js   # Core calculation logic
│   ├── config.js       # Configuration settings
│   ├── ui.js           # UI manipulation and event handling
│   └── amortization.js # Schedule generation logic
├── index.php           # Main calculator page
├── penalty.php         # Standalone penalty calculator
├── settings.php        # Settings configuration page
├── documentation.php   # User documentation
└── README.md           # Project documentation
```

## Contact Information

**ZESTRA CAPITAL LIMITED**
*   **Phone**: +254 720 012 374
*   **Email**: zestracapitallimited@gmail.com
*   **Address**: Moi Avenue, Nairobi

## License

© 2026 ZESTRA CAPITAL LIMITED. All Rights Reserved.
Regulated by the Central Bank of Kenya (CBK).
