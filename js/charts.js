const Charts = {
    generateTextGraph: function (schedule) {
        // Simple ASCII bar chart for console or text output
        let output = "Weekly Balance Reduction:\n";
        const maxBalance = schedule[0].opening_balance;

        schedule.forEach(row => {
            const barLength = Math.round((row.closing_balance / maxBalance) * 20);
            const bar = '█'.repeat(barLength) + '░'.repeat(20 - barLength);
            output += `W${row.week.toString().padStart(2, '0')}: ${bar} ${CONFIG.currency} ${row.closing_balance.toFixed(0)}\n`;
        });

        return output;
    }
};

window.Charts = Charts;
