<?php
function emi_calculator_shortcode() {
    ob_start();
    ?>
    <div class="emi-calculator-container">
        <h2>EMI Calculator</h2>
        
        <label for="loanAmount">Loan Amount (₹):</label>
        <input type="number" id="loanAmount" placeholder="Enter loan amount">

        <label for="interestRate">Annual Interest Rate (%):</label>
        <input type="number" id="interestRate" placeholder="Enter interest rate">

        <label for="tenureType">Tenure Type:</label>
        <select id="tenureType" onchange="updateTenureOptions()">
            <option value="yearly">Years</option>
            <option value="monthly">Months</option>
            <option value="weekly">Weeks</option>
        </select>

        <label for="tenureValue">Tenure:</label>
        <select id="tenureValue">
            <!-- Options will be dynamically updated based on tenure type -->
        </select>

        <button onclick="calculateEMI()">Calculate EMI</button>

        <div id="emiResult" style="margin-top: 20px;">
            <h3>Calculation Results:</h3>
            <p id="monthlyEMI"></p>
            <p id="totalInterestPayable"></p>
            <p id="totalPayment"></p>
        </div>
    </div>

    <script>
        function updateTenureOptions() {
            const tenureType = document.getElementById("tenureType").value;
            const tenureValue = document.getElementById("tenureValue");

            tenureValue.innerHTML = "";

            if (tenureType === "yearly") {
                for (let i = 1; i <= 30; i++) {
                    let option = document.createElement("option");
                    option.value = i;
                    option.text = `${i} Year${i > 1 ? 's' : ''}`;
                    tenureValue.appendChild(option);
                }
            } else if (tenureType === "monthly") {
                for (let i = 1; i <= 360; i++) {
                    let option = document.createElement("option");
                    option.value = i;
                    option.text = `${i} Month${i > 1 ? 's' : ''}`;
                    tenureValue.appendChild(option);
                }
            } else if (tenureType === "weekly") {
                for (let i = 1; i <= 1560; i++) {
                    let option = document.createElement("option");
                    option.value = i;
                    option.text = `${i} Week${i > 1 ? 's' : ''}`;
                    tenureValue.appendChild(option);
                }
            }
        }

     function calculateEMI() {
    const loanAmount = parseFloat(document.getElementById("loanAmount").value);
    const interestRate = parseFloat(document.getElementById("interestRate").value);
    const tenureValue = parseInt(document.getElementById("tenureValue").value);
    const tenureType = document.getElementById("tenureType").value;

    if (loanAmount && interestRate && tenureValue) {
        const monthlyInterestRate = interestRate / 12 / 100;
        let numberOfMonths;

        if (tenureType === "yearly") {
            numberOfMonths = tenureValue * 12;
        } else if (tenureType === "monthly") {
            numberOfMonths = tenureValue;
        } else if (tenureType === "weekly") {
            numberOfMonths = tenureValue / 4.345;
        }

        // EMI Calculation using the formula
        const emi = (loanAmount * monthlyInterestRate * Math.pow(1 + monthlyInterestRate, numberOfMonths)) /
                    (Math.pow(1 + monthlyInterestRate, numberOfMonths) - 1);

        const totalPayment = emi * numberOfMonths;
        const totalInterestPayable = totalPayment - loanAmount;

        // Display the results
        document.getElementById("monthlyEMI").innerHTML = `Loan EMI: ₹${emi.toFixed(2)}`;
        document.getElementById("totalInterestPayable").innerHTML = `Total Interest Payable: ₹${totalInterestPayable.toFixed(2)}`;
        document.getElementById("totalPayment").innerHTML = `Total Payment (Principal + Interest): ₹${totalPayment.toFixed(2)}`;
    } else {
        document.getElementById("emiResult").innerHTML = "Please fill in all fields.";
    }
}


        document.addEventListener("DOMContentLoaded", updateTenureOptions);
    </script>

    <style>
        .emi-calculator-container {
            max-width: 100%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
        }
        .emi-calculator-container input, .emi-calculator-container select, .emi-calculator-container button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .emi-calculator-container button {
            background-color: #6939ff;
            color: white;
            border: none;
        }
    </style>
    <?php
    return ob_get_clean();
}
add_shortcode('emi_calculator', 'emi_calculator_shortcode');

?>
