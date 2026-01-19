<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <title>Permanent Make-up Artist Survey</title>
    <style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: #ffffff;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.page-wrapper {
    width: 100%;
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.survey-container {
    background: white;
    border-radius: 24px;
    width: 100%;
    max-width: 900px;
    padding: 40px;
    position: relative;
    overflow: hidden;
    margin: auto;
}

.close-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    background: none;
    border: none;
    font-size: 24px;
    color: #999;
    cursor: pointer;
}

.toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background: linear-gradient(135deg, #ff6b6b, #ee5a52);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(255, 107, 107, 0.3);
    z-index: 1000;
    transform: translateX(400px);
    opacity: 0;
    transition: all 0.3s ease;
}

.toast.show {
    transform: translateX(0);
    opacity: 1;
}

.toast.success {
    background: linear-gradient(135deg, #4ecdc4, #44a08d);
    box-shadow: 0 8px 24px rgba(78, 205, 196, 0.3);
}

.survey-header {
    text-align: center;
    margin-bottom: 40px;
}

.survey-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 16px;
}

.survey-description {
    color: #666;
    font-size: 1.1rem;
    line-height: 1.6;
}

.progress-container {
    margin-bottom: 40px;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background: #f0f0f0;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 16px;
}

.progress-fill {
    height: 100%;
    background: #2563eb;
    border-radius: 4px;
    transition: width 0.3s ease;
}

.progress-text {
    text-align: center;
    color: #666;
    font-size: 14px;
}

.section {
    display: none;
}

.section.active {
    display: block;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.section-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 8px;
}

.section-subtitle {
    color: #666;
    margin-bottom: 32px;
    font-size: 1rem;
}

.question {
    margin-bottom: 32px;
}

.question-title {
    font-weight: 600;
    margin-bottom: 16px;
    color: #1a1a2e;
    font-size: 1.1rem;
}

.required {
    color: #ff6b6b;
    font-weight: bold;
}

.rating-container {
    margin: 20px 0;
}

.rating-question {
    font-weight: 600;
    margin-bottom: 16px;
    color: #1a1a2e;
}

.rating-scale {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    margin: 16px 0;
    gap: 12px;
}

.rating-label {
    font-size: 14px;
    color: #666;
    text-align: center;
}

.rating-numbers {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.rating-btn {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    border: 2px solid #e9ecef;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-weight: 600;
    color: #6b7280;
    margin: 0px 5px 0 5px;
}

.rating-btn:hover {
    border-color: #2563eb;
    background: #eff6ff;
}

.rating-btn.selected {
    background: #2563eb;
    border-color: #2563eb;
    color: white;
}

.options-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.option-item {
    display: flex;
    align-items: center;
    padding: 0;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    background: #f8f9fa;
    flex: 1 1 47%;
    max-width: 47%;
}

.option-item:hover,
.option-item.selected {
    border-color: #2563eb;
    background: #eff6ff;
}

.option-item input {
    margin: 0;
    accent-color: #2563eb;
}

.option-item label {
    cursor: pointer;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    margin: 0;
    padding: 0;
}

/* Убираем padding с option-item и переносим на label */
.option-item {
    padding: 0;
}

.option-item label {
    padding: 12px;
    width: 100%;
}



.option-item:has(input[type="checkbox"]) label {
    margin-left: 8px;
    font-size: 14px;
    line-height: 1.3;
}

.option-item:has(input[type="text"]) {
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
}

.option-item:has(input[type="text"]) input[type="text"] {
    margin-top: 4px;
    font-size: 14px;
    padding: 8px;
    height: auto;
}

.option-item:has(input[type="checkbox"]) {
    flex: 1 1 auto;
    max-width: none;
    min-width: 200px;
}

.option-item[style*="flex:unset"] {
    flex: 0 1 auto !important;
    max-width: none !important;
    min-width: 140px;
}

.option-item:has(input[type="checkbox"]:checked) {
    border-color: #2563eb;
    background: #eff6ff;
}

.option-item:has(input[type="checkbox"]:checked) label {
    color: #1e40af;
    font-weight: 600;
}

input[type="text"],
textarea {
    width: 100%;
    padding: 12px;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: #f8f9fa;
    font-family: inherit;
}

input[type="text"]:focus,
textarea:focus {
    outline: none;
    border-color: #2563eb;
    background: white;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.option-item input[type="radio"] {
    margin: 0;
    accent-color: #2563eb;
}

.option-item input[type="radio"],
.option-item input[type="checkbox"] {
    display: none;
}

.option-item label {
    position: relative;
    padding-left: 32px;
    cursor: pointer;
    font-weight: 500;
    color: #333;
    display: flex;
    align-items: center;
    width: 100%;
    line-height: 1.4;
    margin: 0;
    padding: 12px;
    padding-left: 44px; 
}


/* Кастомный стиль для радио (круглый) */
.option-item:has(input[type="radio"]) label::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    border: 2px solid #e9ecef;
    border-radius: 50%; /* Круглый для радио */
    background: #f8f9fa;
    transition: all 0.2s ease;
}

.option-item:has(input[type="checkbox"]) label::before {
    content: '';
    position: absolute;
    left: 12px; 
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    border: 2px solid #e9ecef;
    border-radius: 4px;
    background: #f8f9fa;
    transition: all 0.2s ease;
}

/* Точка для радио */
.option-item:has(input[type="radio"]) label::after {
    content: '';
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: white;
    opacity: 0;
    transition: all 0.2s ease;
}

.option-item:has(input[type="checkbox"]) label::after {
    content: '✓';
    position: absolute;
    left: 14px; 
    top: 50%;
    transform: translateY(-50%);
    color: white;
    font-size: 12px;
    font-weight: bold;
    opacity: 0;
    transition: all 0.2s ease;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}


/* Состояние при выборе радио */
.option-item input[type="radio"]:checked + label::before,
.option-item:has(input[type="radio"]:checked) label::before {
    background: #2563eb;
    border-color: #2563eb;
}

.option-item input[type="radio"]:checked + label::after,
.option-item:has(input[type="radio"]:checked) label::after {
    opacity: 1;
}

/* Состояние при выборе чекбокса */
.option-item input[type="checkbox"]:checked + label::before,
.option-item:has(input[type="checkbox"]:checked) label::before {
    background: #2563eb;
    border-color: #2563eb;
}

.option-item input[type="checkbox"]:checked + label::after,
.option-item:has(input[type="checkbox"]:checked) label::after {
    opacity: 1;
}

/* Hover эффект для всех */
.option-item:hover label::before {
    border-color: #2563eb;
    background: #eff6ff;
}

.option-item:has(.other-input) {
    flex-direction: column;
    align-items: flex-start;
}

.other-input {
    display: none;
    margin-top: 8px;
    width: 100%;
    padding: 8px 12px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    margin-left: 0;
}

.other-input.show {
    display: block;
}

.other-input:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

textarea {
    height: 120px;
    resize: vertical;
}

.emoji-rating {
    display: flex;
    justify-content: space-evenly;
    gap: 12px;
}

.emoji-btn {
    cursor: pointer;
    text-align: center;
    transition: transform 0.2s ease;
    padding: 8px;
    border-radius: 12px;
}

.emoji-btn:hover {
    transform: scale(1.05);
}

/* Индивидуальная подсветка по позиции */
.emoji-rating .emoji-btn:nth-child(1):hover {
    background-color: #ffcccc; /* very bad - red */
}
.emoji-rating .emoji-btn:nth-child(2):hover {
    background-color: #ffd1a9; /* bad - orange */
}
.emoji-rating .emoji-btn:nth-child(3):hover {
    background-color: #fff4b3; /* okay - yellow */
}
.emoji-rating .emoji-btn:nth-child(4):hover {
    background-color: #d4f4c3; /* good - light green */
}
.emoji-rating .emoji-btn:nth-child(5):hover {
    background-color: #b2f2bb; /* excellent - green */
}

.emoji-btn.selected {
    border-color: #2563eb;
}

.emoji-rating .emoji-btn:nth-child(1).selected {
    background-color: #ffcccc;
}
.emoji-rating .emoji-btn:nth-child(2).selected {
    background-color: #ffd1a9;
}
.emoji-rating .emoji-btn:nth-child(3).selected {
    background-color: #fff4b3;
}
.emoji-rating .emoji-btn:nth-child(4).selected {
    background-color: #d4f4c3;
}
.emoji-rating .emoji-btn:nth-child(5).selected {
    background-color: #b2f2bb;
}


.emoji {
    font-size: 24px;
    margin-bottom: 4px;
}

.emoji-label {
    font-size: 12px;
    font-weight: 600;
    text-align: center;
    line-height: 1.2;
}

.nav-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 40px;
    padding-top: 32px;
    border-top: 1px solid #e0e0e0;
}

.btn {
    padding: 14px 24px;
    border-radius: 50px;
    border: none;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

.btn-secondary {
    background: #f8f9fa;
    color: #666;
    border: 2px solid #e0e0e0;
}

.btn-secondary:hover {
    background: #e9ecef;
}

.btn-primary {
    background-color: #2563eb; /* насыщенный синий */
    color: white;
    font-weight: 600;
    border: none;
    border-radius: 50px;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #1e4ed8; /* чуть темнее при наведении */
    box-shadow: 0 6px 18px rgba(30, 78, 216, 0.4);
    transform: translateY(-1px);
}

.btn-primary:disabled {
    background-color: #93c5fd;
    cursor: not-allowed;
    opacity: 0.6;
}



.success-message {
    text-align: center;
    padding: 40px 20px;
}

.success-icon {
    font-size: 48px;
    margin-bottom: 24px;
    color: #4ecdc4;
}

.success-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 12px;
}

.success-text {
    color: #666;
    font-size: 1rem;
}

.survey-logo {
    max-width: 148px;
    height: auto;
    display: block;
    margin: 0 auto 24px;
}


.option-item.error {
    border-color: #ff6b6b !important;
    background: #fff5f5 !important;
    animation: shake 0.5s ease-in-out;
}

.rating-container.error .rating-btn {
    border-color: #ff6b6b !important;
    animation: shake 0.5s ease-in-out;
}

input.error,
textarea.error {
    border-color: #ff6b6b !important;
    background: #fff5f5 !important;
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 20%, 40%, 60%, 80%, 100% {
        transform: translateX(0);
    }
    10%, 30%, 50%, 70%, 90% {
        transform: translateX(-3px);
    }
}

/* Убираем ошибку при фокусе */
input.error:focus,
textarea.error:focus {
    border-color: #2563eb !important;
    background: white !important;
}
    </style>
</head>
<body>
    <div class="survey-container">
        <div class="survey-header">
    <a href="https://sviato.academy"><img src="https://sviato.academy/logo_dark.png" alt="Sviato Logo" class="survey-logo"></a>
            
            <h1 class="survey-title">Permanent Make-up Artist Survey</h1>
            <p class="survey-description">
                Help us understand your needs and shopping habits. This anonymous survey takes about 5 minutes.
            </p>
        </div>


        <div class="progress-container">
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill" style="width: 25%"></div>
            </div>
            <p class="progress-text" id="progressText">Step 1 of 4</p>
        </div>

        <form id="surveyForm">
            <input type="hidden" name="token" value="{{ request('token') }}">
            <!-- Section 1: Professional Background -->
            <div class="section active" id="section1">
                <h2 class="section-title">Professional Background</h2>
                <p class="section-subtitle">Tell us about your role and experience in permanent makeup</p>
                
                <div class="question">
                    <div class="question-title">What is your current role or professional status? <span class="required">*</span></div>
                    <div class="options-grid">
                        <div class="option-item" onclick="selectOption(this, 'role', 'Top trainer')">
                            <input type="radio" name="role" value="Top trainer" required>
                            <label>Top trainer</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'role', 'Trainer')">
                            <input type="radio" name="role" value="Trainer">
                            <label>Trainer</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'role', 'Master')">
                            <input type="radio" name="role" value="Master">
                            <label>Master</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'role', 'Stylist')">
                            <input type="radio" name="role" value="Stylist">
                            <label>Stylist</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'role', 'Student')">
                            <input type="radio" name="role" value="Student">
                            <label>Student</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'role', 'Ambassador')">
                            <input type="radio" name="role" value="Ambassador">
                            <label>Ambassador</label>
                        </div>
                    </div>
                </div>

                <div class="question">
                    <div class="question-title">How many years of experience do you have? <span class="required">*</span></div>
                    <div class="options-grid">
                        <div class="option-item" onclick="selectOption(this, 'experience', 'Less than 1 year')">
                            <input type="radio" name="experience" value="Less than 1 year" required>
                            <label>< 1 year</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'experience', '1-3 years')">
                            <input type="radio" name="experience" value="1-3 years">
                            <label>1-3 years</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'experience', '3-5 years')">
                            <input type="radio" name="experience" value="3-5 years">
                            <label>3-5 years</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'experience', 'More than 5 years')">
                            <input type="radio" name="experience" value="More than 5 years">
                            <label>> 5 years</label>
                        </div>
                    </div>
                </div>

                <div class="question">
                    <div class="question-title">On average, how many PMU procedures do you perform per month? <span class="required">*</span></div>
                    <div class="options-grid">
                        <div class="option-item" onclick="selectOption(this, 'procedures_month', 'Less than 20')">
                            <input type="radio" name="procedures_month" value="Less than 20" required>
                            <label>< 20</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'procedures_month', '20-50')">
                            <input type="radio" name="procedures_month" value="20-50">
                            <label>20-50</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'procedures_month', '50-100')">
                            <input type="radio" name="procedures_month" value="50-100">
                            <label>50-100</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'procedures_month', '100+')">
                            <input type="radio" name="procedures_month" value="100+">
                            <label>100+</label>
                        </div>
                    </div>
                </div>

                <div class="question">
                    <div class="question-title">What type of PMU machine do you currently use?</div>
                    <input type="text" name="machine_type" placeholder="Enter your machine type">
                </div>

                <div class="question">
                    <div class="question-title">What type(s) of needles/cartridges do you prefer?</div>
                    <input type="text" name="needles" placeholder="Enter your preferred needles/cartridges">
                </div>
            </div>

            <!-- Section 2: Shopping Preferences -->
            <div class="section" id="section2">
                <h2 class="section-title">Shopping Preferences</h2>
                <p class="section-subtitle">Help us understand how you purchase PMU supplies</p>
                
                <div class="question">
                    <div class="question-title">Where do you usually purchase your PMU supplies? <span class="required">*</span></div>
                    <div class="options-grid">
                        <div class="option-item" onclick="selectOption(this, 'purchase_location', 'Online shop')">
                            <input type="radio" name="purchase_location" value="Online shop" required>
                            <label>Online</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'purchase_location', 'Distributor')">
                            <input type="radio" name="purchase_location" value="Distributor">
                            <label>Distributor</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'purchase_location', 'Local store')">
                            <input type="radio" name="purchase_location" value="Local store">
                            <label>Local store</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'purchase_location', 'Manufacturer')">
                            <input type="radio" name="purchase_location" value="Manufacturer">
                            <label>Manufact.</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'purchase_location', 'Other')">
                            <input type="radio" name="purchase_location" value="Other">
                            <label>Other</label>
                        </div>
                    </div>
                </div>

                <div class="question">
                    <div class="question-title">How frequently do you order PMU supplies? <span class="required">*</span></div>
                    <div class="options-grid">
                        <div class="option-item" onclick="selectOption(this, 'order_frequency', 'Every 2 weeks')">
                            <input type="radio" name="order_frequency" value="Every 2 weeks" required>
                            <label>1× / 2 weeks</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'order_frequency', 'Monthly')">
                            <input type="radio" name="order_frequency" value="Monthly">
                            <label>Monthly</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'order_frequency', 'Once in three months')">
                            <input type="radio" name="order_frequency" value="Once in three months">
                            <label>1× / 3 months</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'order_frequency', 'Less often')">
                            <input type="radio" name="order_frequency" value="Less often">
                            <label>Less often</label>
                        </div>
                    </div>
                </div>

                <div class="question">
                    <div class="question-title">Would you prefer to purchase all your PMU supplies from one reliable shop? <span class="required">*</span></div>
                    <div class="options-grid">
                        <div class="option-item" onclick="selectOption(this, 'one_shop', 'Yes')">
                            <input type="radio" name="one_shop" value="Yes" required>
                            <label>Yes</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'one_shop', 'No')">
                            <input type="radio" name="one_shop" value="No">
                            <label>No</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'one_shop', 'Maybe')">
                            <input type="radio" name="one_shop" value="Maybe (depends on prices/products)">
                            <label>Maybe</label>
                        </div>
                    </div>
                </div>

                <div class="question">
                    <div class="question-title">How often do you replace or upgrade your PMU machine? <span class="required">*</span></div>
                    <div class="options-grid">
                    <div class="option-item" onclick="selectOption(this, 'replace_machine', 'Every year')">
                        <input type="radio" name="replace_machine" value="Every year" required>
                        <label>1× / year</label>
                    </div>
                    <div class="option-item" onclick="selectOption(this, 'replace_machine', 'Every 2-3 years')">
                        <input type="radio" name="replace_machine" value="Every 2-3 years">
                        <label>1× / 2–3 yrs</label>
                    </div>
                    <div class="option-item" onclick="selectOption(this, 'replace_machine', 'Only when necessary')">
                        <input type="radio" name="replace_machine" value="Only when necessary">
                        <label>When needed</label>
                    </div>
                    <div class="option-item" onclick="selectOption(this, 'replace_machine', 'Never replaced')">
                        <input type="radio" name="replace_machine" value="Never replaced">
                        <label>Never</label>
                    </div>
                </div>
                </div>
            </div>

            <!-- Section 3: Importance Factors -->
            <div class="section" id="section3">
                <h2 class="section-title">What Matters Most</h2>
                <p class="section-subtitle">Rate how important these factors are when choosing where to purchase supplies</p>
                
                <div class="rating-container">
                    <div class="rating-question">How important is PRICE when choosing where to purchase supplies? <span class="required">*</span></div>
                    <div class="rating-scale">
                        <span class="rating-label">Not at all likely</span>
                        <div class="rating-numbers" data-name="price_importance">
                            <div class="rating-btn" onclick="selectRating(this, 'price_importance', '1')">1</div>
                            <div class="rating-btn" onclick="selectRating(this, 'price_importance', '2')">2</div>
                            <div class="rating-btn" onclick="selectRating(this, 'price_importance', '3')">3</div>
                            <div class="rating-btn" onclick="selectRating(this, 'price_importance', '4')">4</div>
                            <div class="rating-btn" onclick="selectRating(this, 'price_importance', '5')">5</div>
                            <div class="rating-btn" onclick="selectRating(this, 'price_importance', '6')">6</div>
                            <div class="rating-btn" onclick="selectRating(this, 'price_importance', '7')">7</div>
                            <div class="rating-btn" onclick="selectRating(this, 'price_importance', '8')">8</div>
                            <div class="rating-btn" onclick="selectRating(this, 'price_importance', '9')">9</div>
                            <div class="rating-btn" onclick="selectRating(this, 'price_importance', '10')">10</div>
                        </div>
                        <span class="rating-label right">Extremely likely</span>
                    </div>
                    <input type="hidden" name="price_importance" required>
                </div>

                <div class="rating-container">
                    <div class="rating-question">How important is PRODUCT QUALITY? <span class="required">*</span></div>
                    <div class="rating-scale">
                        <span class="rating-label">Not important</span>
                        <div class="rating-numbers" data-name="quality_importance">
                            <div class="rating-btn" onclick="selectRating(this, 'quality_importance', '1')">1</div>
                            <div class="rating-btn" onclick="selectRating(this, 'quality_importance', '2')">2</div>
                            <div class="rating-btn" onclick="selectRating(this, 'quality_importance', '3')">3</div>
                            <div class="rating-btn" onclick="selectRating(this, 'quality_importance', '4')">4</div>
                            <div class="rating-btn" onclick="selectRating(this, 'quality_importance', '5')">5</div>
                            <div class="rating-btn" onclick="selectRating(this, 'quality_importance', '6')">6</div>
                            <div class="rating-btn" onclick="selectRating(this, 'quality_importance', '7')">7</div>
                            <div class="rating-btn" onclick="selectRating(this, 'quality_importance', '8')">8</div>
                            <div class="rating-btn" onclick="selectRating(this, 'quality_importance', '9')">9</div>
                            <div class="rating-btn" onclick="selectRating(this, 'quality_importance', '10')">10</div>
                        </div>
                        <span class="rating-label right">Very important</span>
                    </div>
                    <input type="hidden" name="quality_importance" required>
                </div>

                <div class="rating-container">
                    <div class="rating-question">How important is DELIVERY SPEED? <span class="required">*</span></div>
                    <div class="rating-scale">
                        <span class="rating-label">Not important</span>
                        <div class="rating-numbers" data-name="delivery_importance">
                            <div class="rating-btn" onclick="selectRating(this, 'delivery_importance', '1')">1</div>
                            <div class="rating-btn" onclick="selectRating(this, 'delivery_importance', '2')">2</div>
                            <div class="rating-btn" onclick="selectRating(this, 'delivery_importance', '3')">3</div>
                            <div class="rating-btn" onclick="selectRating(this, 'delivery_importance', '4')">4</div>
                            <div class="rating-btn" onclick="selectRating(this, 'delivery_importance', '5')">5</div>
                            <div class="rating-btn" onclick="selectRating(this, 'delivery_importance', '6')">6</div>
                            <div class="rating-btn" onclick="selectRating(this, 'delivery_importance', '7')">7</div>
                            <div class="rating-btn" onclick="selectRating(this, 'delivery_importance', '8')">8</div>
                            <div class="rating-btn" onclick="selectRating(this, 'delivery_importance', '9')">9</div>
                            <div class="rating-btn" onclick="selectRating(this, 'delivery_importance', '10')">10</div>
                        </div>
                        <span class="rating-label right">Very important</span>
                    </div>
                    <input type="hidden" name="delivery_importance" required>
                </div>

                <div class="rating-container">
                    <div class="rating-question">How important is CUSTOMER SERVICE? <span class="required">*</span></div>
                    <div class="rating-scale">
                        <span class="rating-label">Not important</span>
                        <div class="rating-numbers" data-name="service_importance">
                            <div class="rating-btn" onclick="selectRating(this, 'service_importance', '1')">1</div>
                            <div class="rating-btn" onclick="selectRating(this, 'service_importance', '2')">2</div>
                            <div class="rating-btn" onclick="selectRating(this, 'service_importance', '3')">3</div>
                            <div class="rating-btn" onclick="selectRating(this, 'service_importance', '4')">4</div>
                            <div class="rating-btn" onclick="selectRating(this, 'service_importance', '5')">5</div>
                            <div class="rating-btn" onclick="selectRating(this, 'service_importance', '6')">6</div>
                            <div class="rating-btn" onclick="selectRating(this, 'service_importance', '7')">7</div>
                            <div class="rating-btn" onclick="selectRating(this, 'service_importance', '8')">8</div>
                            <div class="rating-btn" onclick="selectRating(this, 'service_importance', '9')">9</div>
                            <div class="rating-btn" onclick="selectRating(this, 'service_importance', '10')">10</div>
                        </div>
                        <span class="rating-label right">Very important</span>
                    </div>
                    <input type="hidden" name="service_importance" required>
                </div>
            </div>

            <!-- Section 4: Demographics & Feedback -->
            <div class="section" id="section4">
                <h2 class="section-title">About You & Feedback</h2>
                <p class="section-subtitle">Final questions about your demographics and experience</p>
                
                <div class="question">
                    <div class="question-title">What is your age range? <span class="required">*</span></div>
                    <div class="options-grid">
                        <div class="option-item" onclick="selectOption(this, 'age_range', 'Under 20')">
                            <input type="radio" name="age_range" value="Under 20" required>
                            <label>Under 20</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'age_range', '21-30')">
                            <input type="radio" name="age_range" value="21-30">
                            <label>21-30</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'age_range', '31-40')">
                            <input type="radio" name="age_range" value="31-40">
                            <label>31-40</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'age_range', '41-50')">
                            <input type="radio" name="age_range" value="41-50">
                            <label>41-50</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'age_range', '51+')">
                            <input type="radio" name="age_range" value="51+">
                            <label>51+</label>
                        </div>
                    </div>
                </div>

                <div class="question">
                    <div class="question-title">In which region are you based? <span class="required">*</span></div>
                    <div class="options-grid">
                        <div class="option-item" onclick="selectOption(this, 'country_group', 'European Union')">
                            <input type="radio" name="country_group" value="European Union" required>
                            <label>European Union</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'country_group', 'Rest of Europe')">
                            <input type="radio" name="country_group" value="Rest of Europe">
                            <label>Rest of Europe</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'country_group', 'Asia')">
                            <input type="radio" name="country_group" value="Asia">
                            <label>Asia</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'country_group', 'Americas')">
                            <input type="radio" name="country_group" value="Americas">
                            <label>Americas</label>
                        </div>
                    </div>
                </div>

                <div class="question">
                    <div class="question-title">Are there any PMU products you currently find difficult to get?</div>
                    <textarea name="difficult_products" placeholder="Please specify which items or write 'None' if you don't have any issues"></textarea>
                </div>

                <div class="question">
                    <div class="question-title">How would you rate your overall experience with PMU supply shopping?</div>
                    <div class="emoji-rating">
                        <div class="emoji-btn" onclick="selectEmoji(this, 'shopping_experience', '1')">
                            <div class="emoji">😞</div>
                            <div class="emoji-label">Very Bad</div>
                        </div>
                        <div class="emoji-btn" onclick="selectEmoji(this, 'shopping_experience', '2')">
                            <div class="emoji">🙁</div>
                            <div class="emoji-label">Bad</div>
                        </div>
                        <div class="emoji-btn" onclick="selectEmoji(this, 'shopping_experience', '3')">
                            <div class="emoji">😐</div>
                            <div class="emoji-label">Okay</div>
                        </div>
                        <div class="emoji-btn" onclick="selectEmoji(this, 'shopping_experience', '4')">
                            <div class="emoji">🙂</div>
                            <div class="emoji-label">Good</div>
                        </div>
                        <div class="emoji-btn" onclick="selectEmoji(this, 'shopping_experience', '5')">
                            <div class="emoji">😊</div>
                            <div class="emoji-label">Excellent</div>
                        </div>
                    </div>
                    <input type="hidden" name="shopping_experience">
                </div>

<div class="question">
    <div class="question-title">
        Which of the following products would you prefer to purchase from us if they were available in stock?
    </div>
    <div class="options-grid" style="flex-direction: column;">
        <div style="flex:unset;" class="option-item"><label><input type="checkbox" name="products[]" value="Table cover"> Table cover</label></div>
        <div style="flex:unset;" class="option-item"><label><input type="checkbox" name="products[]" value="Ink mixer"> Ink mixer</label></div>
        <div style="flex:unset;" class="option-item"><label><input type="checkbox" name="products[]" value="Lip pencil"> Lip pencil</label></div>
        <div style="flex:unset;" class="option-item"><label><input type="checkbox" name="products[]" value="Cotton pads"> Cotton pads</label></div>
        <div style="flex:unset;" class="option-item"><label><input type="checkbox" name="products[]" value="Gloves"> Gloves</label></div>
        <div style="flex:unset;" class="option-item"><label><input type="checkbox" name="products[]" value="Flat latex for practice"> Flat latex for practice</label></div>
        <div style="flex:unset;" class="option-item"><label><input type="checkbox" name="products[]" value="Disposable head caps"> Disposable head caps</label></div>
        <div style="flex:unset;" class="option-item"><label><input type="checkbox" name="products[]" value="Tipped cotton swabs"> Tipped cotton swabs</label></div>
        <div style="flex:unset;" class="option-item"><label><input type="checkbox" name="products[]" value="Couch rolls"> Couch rolls</label></div>
        <div style="flex:unset;" class="option-item"><label><input type="checkbox" name="products[]" value="Bed covers/sheets"> Bed covers/sheets</label></div>
        <div style="flex:unset;" class="option-item"><label><input type="checkbox" name="products[]" value="Sharpening tool for eyebrow pencil"> Sharpening tool for eyebrow pencil</label></div>
        <div style="flex:unset;" class="option-item"><label><input type="checkbox" name="products[]" value="Color mapping paste"> Color mapping paste</label></div>
        <div style="flex:unset;" class="option-item"><label><input type="checkbox" name="products[]" value="Liquid glass for lips"> Liquid glass for lips</label></div>
        <div style="flex:unset;" class="option-item"><label><input type="checkbox" name="products[]" value="Lip scrub"> Lip scrub</label></div>
        <div style="flex:unset;" class="option-item"><label><input type="checkbox" name="products[]" value="Macro lens for smartphone"> Macro lens for smartphone</label></div>
        <div style="flex:unset;" class="option-item"><label><input type="checkbox" name="products[]" value="Eyebrow razors"> Eyebrow razors</label></div>
       <div class="option-item">
    <input type="checkbox" name="products[]" value="Other" id="products_other_cb">
    <label for="products_other_cb">Other</label>
    <input type="text" name="products_other" placeholder="Please specify" class="other-input" style="margin-bottom:10px">
</div>
    </div>
</div>



                <div class="question">
                    <div class="question-title">Any suggestions for improving our web shop?</div>
                    <textarea name="improvements" placeholder="Share your thoughts and suggestions..."></textarea>
                </div>

                <div class="question">
                    <div class="question-title">Would you be interested in visiting Tallinn Masterclass in 2026? <span class="required">*</span></div>
                    <div class="options-grid">
                        <div class="option-item" onclick="selectOption(this, 'tallinn_interest', 'Yes')">
                            <input type="radio" name="tallinn_interest" value="Yes" required>
                            <label>Yes</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'tallinn_interest', 'No')">
                            <input type="radio" name="tallinn_interest" value="No">
                            <label>No</label>
                        </div>
                        <div class="option-item" onclick="selectOption(this, 'tallinn_interest', 'Maybe')">
                            <input type="radio" name="tallinn_interest" value="Maybe">
                            <label>Maybe</label>
                        </div>
                    </div>
                </div>

<div class="question">
    <div class="question-title">
        What would you be most interested to see on the stage of Tallinn Masterclass?
    </div>
    <div class="options-grid" style="flex-direction: column;">
        <div class="option-item">
            <label>
                <input type="checkbox" name="masterclass_content[]" value="Practical demo">
                Practical demo
            </label>
        </div>
        <div class="option-item">
            <label>
                <input type="checkbox" name="masterclass_content[]" value="Theory about new techniques">
                Theory about new techniques
            </label>
        </div>
        <div class="option-item">
            <label>
                <input type="checkbox" name="masterclass_content[]" value="Marketing courses">
                Marketing courses
            </label>
        </div>
        <div class="option-item">
            <label>
                <input type="checkbox" name="masterclass_content[]" value="Not interested in Tallinn Masterclass">
                Not interested in Tallinn Masterclass
            </label>
        </div>
       <div class="option-item">
    <input type="checkbox" name="masterclass_content[]" value="Other" id="masterclass_other_cb">
    <label for="masterclass_other_cb">Other</label>
    <input type="text" name="masterclass_other" placeholder="Please specify" class="other-input" style="margin-bottom:10px">
</div>
    </div>
</div>
            </div>
            <!-- Success Screen -->
            <div class="section" id="success" style="display: none;">
                <div class="success-message">
                    <div class="success-icon">🎉</div>
                    <h2 class="success-title">Thank You!</h2>
                    <p class="success-text">Your responses have been submitted successfully. We appreciate your time and valuable feedback.</p>
                </div>
            </div>

        </form>

        <!-- Navigation Buttons -->
        <div class="nav-buttons">
            <button type="button" class="btn btn-secondary" id="prevBtn" onclick="changeStep(-1)">Previous</button>
            <button type="button" class="btn btn-primary" id="nextBtn" onclick="changeStep(1)">Next</button>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 4;

        function updateProgress() {
    const progress = (currentStep / totalSteps) * 100;
    document.getElementById('progressFill').style.width = progress + '%';
    document.getElementById('progressText').textContent = `Step ${currentStep} of ${totalSteps}`;

    // Update Previous button visibility
    const prevBtn = document.getElementById('prevBtn');
    if (currentStep > 1) {
        prevBtn.style.display = 'block';
    } else {
        prevBtn.style.display = 'none';
    }

    // Update Next button text
    const nextBtn = document.getElementById('nextBtn');
    nextBtn.textContent = currentStep === totalSteps ? 'Submit' : 'Next';
}


        function changeStep(direction) {
            if (direction === 1) {
                // Validate current section before proceeding
                if (!validateCurrentSection()) {
                    return;
                }
                
                if (currentStep === totalSteps) {
                    // Submit form
                    submitForm();
                    return;
                }
                
                if (currentStep < totalSteps) {
                    currentStep++;
                }
            } else if (direction === -1) {
                if (currentStep > 1) {
                    currentStep--;
                }
            }
            
            showCurrentSection();
            updateProgress();
            
            // Прокручиваем к началу формы
            document.querySelector('.survey-container').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }

        function showCurrentSection() {
            // Hide all sections
            document.querySelectorAll('.section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Show current section
            document.getElementById(`section${currentStep}`).classList.add('active');
        }

    function validateCurrentSection() {
    const currentSection = document.getElementById(`section${currentStep}`);
    const requiredInputs = currentSection.querySelectorAll('input[required], textarea[required]');
    let hasErrors = false;
    
    // Убираем предыдущие ошибки
    clearValidationErrors(currentSection);
    
    // Валидация обычных полей
    for (let input of requiredInputs) {
        if (input.type === 'radio') {
            const radioGroup = currentSection.querySelectorAll(`input[name="${input.name}"]`);
            const isChecked = Array.from(radioGroup).some(radio => radio.checked);
            if (!isChecked) {
                highlightRadioError(input.name, currentSection);
                hasErrors = true;
            }
        } else if (input.type === 'hidden') {
            if (!input.value) {
                highlightRatingError(input.name, currentSection);
                hasErrors = true;
            }
        } else {
            if (!input.value.trim()) {
                highlightInputError(input);
                hasErrors = true;
            }
        }
    }
    
    // Проверка полей "Other"
    if (!validateOtherFields(currentSection)) {
        hasErrors = true;
    }
    
    if (hasErrors) {
        showToast('Please answer all required questions before proceeding.', 'error');
        scrollToFirstError(currentSection);
        return false;
    }
    
    return true;
}


function highlightCheckboxError(name, section) {
    const checkboxOptions = section.querySelectorAll(`input[name="${name}"]`);
    checkboxOptions.forEach(checkbox => {
        checkbox.closest('.option-item').classList.add('error');
    });
}


        // Убирает все подсветки ошибок
        function clearValidationErrors(section) {
            // Убираем классы ошибок с радио кнопок
            section.querySelectorAll('.option-item').forEach(item => {
                item.classList.remove('error');
            });
            
            // Убираем классы ошибок с рейтингов
            section.querySelectorAll('.rating-container').forEach(container => {
                container.classList.remove('error');
            });
            
            // Убираем классы ошибок с текстовых полей
            section.querySelectorAll('input, textarea').forEach(input => {
                input.classList.remove('error');
            });
        }

        // Подсвечивает радио-кнопки
        function highlightRadioError(name, section) {
            const radioOptions = section.querySelectorAll(`input[name="${name}"]`);
            radioOptions.forEach(radio => {
                radio.closest('.option-item').classList.add('error');
            });
        }

        // Подсвечивает рейтинги
        function highlightRatingError(name, section) {
            const ratingContainer = section.querySelector(`input[name="${name}"]`).closest('.rating-container');
            ratingContainer.classList.add('error');
        }

        // Подсвечивает текстовые поля
        function highlightInputError(input) {
            input.classList.add('error');
        }

        // Прокручивает к первой ошибке
        function scrollToFirstError(section) {
            const firstError = section.querySelector('.error, input.error, textarea.error');
            if (firstError) {
                firstError.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
            }
        }

        function showToast(message, type = 'error') {
            // Remove existing toast
            const existingToast = document.querySelector('.toast');
            if (existingToast) {
                existingToast.remove();
            }

            // Create toast element
            const toast = document.createElement('div');
            toast.className = `toast ${type === 'success' ? 'success' : ''}`;
            toast.textContent = message;
            
            // Add to body
            document.body.appendChild(toast);
            
            // Trigger animation
            setTimeout(() => {
                toast.classList.add('show');
            }, 100);
            
            // Remove after 3 seconds
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);
        }

        function selectOption(element, name, value) {
    // Remove selected class from siblings
    element.parentNode.querySelectorAll('.option-item').forEach(item => {
        item.classList.remove('selected');
        item.classList.remove('error');
    });

    // Add selected class to clicked element
    element.classList.add('selected');

    // Check the radio button
    const input = element.querySelector('input');
    input.checked = true;

    // Manually set value for all radios with same name to avoid overwriting
    const allRadios = document.querySelectorAll(`input[name="${name}"]`);
    allRadios.forEach(radio => {
        if (radio !== input) {
            radio.removeAttribute('checked');
        }
    });
}


        function selectRating(element, name, value) {
            // Remove selected class from siblings
            element.parentNode.querySelectorAll('.rating-btn').forEach(btn => {
                btn.classList.remove('selected');
            });
            
            // Add selected class to clicked element
            element.classList.add('selected');
            
            // Set hidden input value
            document.querySelector(`input[name="${name}"]`).value = value;
            
            // Убираем ошибку при выборе рейтинга
            element.closest('.rating-container').classList.remove('error');
        }

        function selectEmoji(element, name, value) {
            // Remove selected class from siblings
            element.parentNode.querySelectorAll('.emoji-btn').forEach(btn => {
                btn.classList.remove('selected');
            });
            
            // Add selected class to clicked element
            element.classList.add('selected');
            
            // Set hidden input value
            document.querySelector(`input[name="${name}"]`).value = value;
        }

        let formSubmitted = false;


        function submitForm() {
        formSubmitted = true;
    const form = document.getElementById('surveyForm');
    const formData = new FormData();
    
    // Добавляем CSRF токен
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        formData.append('_token', csrfToken.getAttribute('content'));
    }
    
    // Собираем все обычные поля
    const radios = form.querySelectorAll('input[type="radio"]:checked');
radios.forEach(input => {
    formData.append(input.name, input.value);
});

// Остальные поля
const others = form.querySelectorAll('input[type="hidden"], input[type="text"], input[type="number"], input[type="email"], textarea, select');
others.forEach(input => {
    if (input.name && input.value) {
        formData.append(input.name, input.value);
    }
});

    
    // Обрабатываем checkbox'ы отдельно
    const checkboxGroups = {};
    const checkboxes = form.querySelectorAll('input[type="checkbox"]:checked');
    
    checkboxes.forEach(checkbox => {
        const name = checkbox.name;
        if (name.includes('[]')) {
            const baseName = name.replace('[]', '');
            if (!checkboxGroups[baseName]) {
                checkboxGroups[baseName] = [];
            }
            checkboxGroups[baseName].push(checkbox.value);
        } else {
            formData.append(name, checkbox.value);
        }
    });
    
    // Добавляем группы checkbox'ов
    Object.keys(checkboxGroups).forEach(groupName => {
        checkboxGroups[groupName].forEach((value, index) => {
            formData.append(`${groupName}[${index}]`, value);
        });
    });
    
    // Логируем данные для отладки
    console.log('Отправляемые данные:');
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }
    
    // Показываем индикатор загрузки
    const submitBtn = document.getElementById('nextBtn');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Submitting...';
    submitBtn.disabled = true;

    // Отправляем данные
    fetch('/survey', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Server response:', text);
                throw new Error(`HTTP ${response.status}: ${text}`);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showSuccessScreen();
            showToast('Thank you! Your survey has been submitted successfully.', 'success');
        } else {
            throw new Error(data.message || 'Submission failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Sorry, there was an error submitting your survey. Please try again.', 'error');
        
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    });
}

// Исправленная обработка checkbox'ов с полем "Other"
document.addEventListener('change', function(e) {
    if (e.target.type === 'checkbox') {
        // Убираем ошибку с группы checkbox'ов
        const checkboxGroup = document.querySelectorAll(`input[name="${e.target.name}"]`);
        checkboxGroup.forEach(checkbox => {
            checkbox.closest('.option-item').classList.remove('error');
        });

        // Обработка поля "Other"
        if (e.target.value === 'Other') {
            const otherInput = e.target.closest('.option-item').querySelector('.other-input');
            if (otherInput) {
                if (e.target.checked) {
                    otherInput.classList.add('show');
                    otherInput.focus();
                    otherInput.required = true;
                } else {
                    otherInput.classList.remove('show');
                    otherInput.value = '';
                    otherInput.required = false;
                }
            }
        }
    }
});

function validateOtherFields(section) {
    const otherInputs = section.querySelectorAll('.other-input.show');
    let hasErrors = false;
    
    otherInputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('error');
            hasErrors = true;
        }
    });
    
    return !hasErrors;
}



        function showSuccessScreen() {
            // Скрываем все секции
            document.querySelectorAll('.section').forEach(section => {
                section.style.display = 'none';
            });
            
            // Скрываем шапку и прогресс для экрана спасибо
            document.querySelector('.survey-header').style.display = 'none';
            document.querySelector('.progress-container').style.display = 'none';
            
            // Показываем экран успеха
            document.getElementById('success').style.display = 'block';
            document.querySelector('.nav-buttons').style.display = 'none';
            
            // Прокручиваем к началу
            document.querySelector('.survey-container').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
           
            confetti({
            particleCount: 150,
            spread: 70,
            origin: { y: 0.6 }
        });

        }

        function closeSurvey() {
            if (confirm('Are you sure you want to close this survey? Your progress will be lost.')) {
                window.close();
                // Or redirect to homepage
                // window.location.href = '/';
            }
        }

        // Initialize
        updateProgress();
        
      document.addEventListener('input', function(e) {
    if (e.target.matches('input[type="text"], textarea')) {
        e.target.classList.remove('error');
    }
});

window.addEventListener('beforeunload', function (e) {
    if (!formSubmitted) {
        e.preventDefault();
        e.returnValue = '';
    }
});


document.addEventListener('change', function(e) {
    if (e.target.type === 'checkbox') {
        // Убираем ошибку с группы checkbox'ов при выборе любого из них
        const checkboxGroup = document.querySelectorAll(`input[name="${e.target.name}"]`);
        checkboxGroup.forEach(checkbox => {
            checkbox.closest('.option-item').classList.remove('error');
        });

        // Показываем/скрываем поле "Other"
        if (e.target.value === 'Other') {
            const otherInput = e.target.closest('.option-item').querySelector('.other-input');
            if (otherInput) {
                if (e.target.checked) {
                    otherInput.classList.add('show');
                    otherInput.focus();
                } else {
                    otherInput.classList.remove('show');
                    otherInput.value = '';
                }
            }
        }
    }
});
    </script>
</body>
</html>