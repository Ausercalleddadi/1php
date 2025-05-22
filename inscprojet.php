<?php
class UserRegistration {
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $errors = [];
    
    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleRegistration();
        }
    }
    
    private function handleRegistration() {
        $this->firstName = trim($_POST['firstName'] ?? '');
        $this->lastName = trim($_POST['lastName'] ?? '');
        $this->email = trim($_POST['email'] ?? '');
        $this->password = $_POST['password'] ?? '';
        
        $this->validateForm();
        
        if (empty($this->errors)) {
            $this->registerUser();
        }
    }
    
    private function validateForm() {
        if (empty($this->firstName)) {
            $this->errors[] = "Le prénom est requis";
        }
        
        if (empty($this->lastName)) {
            $this->errors[] = "Le nom est requis";
        }
        
        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Email valide requis";
        }
        
        if (strlen($this->password) < 8) {
            $this->errors[] = "Le mot de passe doit contenir au moins 8 caractères";
        }
        
        if (!preg_match('/[A-Z]/', $this->password)) {
            $this->errors[] = "Le mot de passe doit contenir une majuscule";
        }
        
        if (!preg_match('/[0-9]/', $this->password)) {
            $this->errors[] = "Le mot de passe doit contenir un chiffre";
        }
    }
    
    private function registerUser() {
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        echo "<script>alert('Inscription réussie!');</script>";
    }
    
    public function getErrors() {
        return $this->errors;
    }
}

$registration = new UserRegistration();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeLearn - Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .main-container {
            display: flex;
            max-width: 900px;
            width: 100%;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
        }
        
        .form-section {
            flex: 1;
            padding: 48px 40px;
            background: white;
        }
        
        .purple-section {
            flex: 1;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }
        
        .form-title {
            font-size: 24px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }
        
        .form-subtitle {
            color: #6b7280;
            margin-bottom: 32px;
            font-size: 14px;
        }
        
        .form-row {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }
        
        .form-group {
            flex: 1;
        }
        
        .form-group.full-width {
            width: 100%;
            margin-bottom: 24px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 16px;
            padding-left: 44px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 16px;
            background: #f9fafb;
            transition: all 0.2s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #6366f1;
            background: white;
        }
        
        .form-input::placeholder {
            color: #9ca3af;
        }
        
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 16px;
        }
        
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9ca3af;
            font-size: 16px;
        }
        
        .password-requirements {
            margin-top: 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .requirement-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #6b7280;
        }
        
        .requirement-item.valid {
            color: #059669;
        }
        
        .requirement-icon {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #059669;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }
        
        .requirement-item:not(.valid) .requirement-icon {
            background: #e5e7eb;
            color: #9ca3af;
        }
        
        .terms-section {
            margin: 24px 0;
        }
        
        .terms-checkbox {
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }
        
        .terms-checkbox input[type="checkbox"] {
            margin-top: 2px;
            accent-color: #6366f1;
        }
        
        .terms-text {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.5;
        }
        
        .terms-text a {
            color: #6366f1;
            text-decoration: none;
        }
        
        .terms-text a:hover {
            text-decoration: underline;
        }
        
        .create-btn {
            width: 100%;
            padding: 14px 24px;
            background: #6366f1;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-bottom: 32px;
        }
        
        .create-btn:hover {
            background: #4f46e5;
        }
        
        .divider {
            text-align: center;
            margin: 24px 0;
            position: relative;
            color: #9ca3af;
            font-size: 14px;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e5e7eb;
        }
        
        .divider span {
            background: white;
            padding: 0 16px;
        }
        
        .social-buttons {
            display: flex;
            gap: 16px;
        }
        
        .social-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            text-decoration: none;
            color: #374151;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .social-btn:hover {
            border-color: #d1d5db;
            background: #f9fafb;
            color: #374151;
            text-decoration: none;
        }
        
        .google-icon {
            color: #ea4335;
            font-size: 18px;
        }
        
        .github-icon {
            color: #24292e;
            font-size: 18px;
        }
        
        .purple-content h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 16px;
            line-height: 1.2;
        }
        
        .purple-content p {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 48px;
            line-height: 1.5;
        }
        
        .login-section p {
            margin-bottom: 8px;
            font-size: 16px;
        }
        
        .login-section a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        .login-section a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
                margin: 10px;
            }
            
            .form-section, .purple-section {
                padding: 32px 24px;
            }
            
            .form-row {
                flex-direction: column;
            }
            
            .social-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="form-section">
            <h2 class="form-title">Créez votre compte</h2>
            <p class="form-subtitle">Rejoignez la communauté CodeLearn</p>
            
            <?php if (!empty($registration->getErrors())): ?>
                <div class="alert alert-danger">
                    <?php foreach ($registration->getErrors() as $error): ?>
                        <div><?php echo htmlspecialchars($error); ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" id="registrationForm">
                <div class="form-row">
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" class="form-input" name="firstName" placeholder="Votre prénom" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" class="form-input" name="lastName" placeholder="Votre nom" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group full-width">
                    <label class="form-label">Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" class="form-input" name="email" required>
                    </div>
                </div>
                
                <div class="form-group full-width">
                    <label class="form-label">Mot de passe</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" class="form-input" name="password" id="password" placeholder="••••••••••••" required>
                        <i class="fas fa-eye password-toggle" onclick="togglePassword()"></i>
                    </div>
                    
                    <div class="password-requirements">
                        <div class="requirement-item valid" id="length-req">
                            <div class="requirement-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Au moins 8 caractères</span>
                        </div>
                        <div class="requirement-item valid" id="uppercase-req">
                            <div class="requirement-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Au moins une majuscule</span>
                        </div>
                        <div class="requirement-item valid" id="number-req">
                            <div class="requirement-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Au moins un chiffre</span>
                        </div>
                    </div>
                </div>
                
                <div class="terms-section">
                    <div class="terms-checkbox">
                        <input type="checkbox" id="termsCheck" required>
                        <div class="terms-text">
                            J'accepte les <a href="#" target="_blank">conditions d'utilisation</a> et la <a href="#" target="_blank">politique de confidentialité</a>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="create-btn">
                    Créer un compte
                </button>
            </form>
            
            <div class="divider">
                <span>Ou inscrivez-vous avec</span>
            </div>
            
            <div class="social-buttons">
                <a href="#" class="social-btn">
                    <i class="fab fa-google google-icon"></i>
                    Google
                </a>
                <a href="#" class="social-btn">
                    <i class="fab fa-github github-icon"></i>
                    GitHub
                </a>
            </div>
        </div>
        
        <div class="purple-section">
            <div class="purple-content">
                <h1>Rejoignez notre communauté</h1>
                <p>Accédez à plusieurs cours gratuits et développez vos compétences en programmation.</p>
            </div>
            
            <div class="login-section">
                <p>Vous avez déjà un compte ?</p>
                <a href="#">Se connecter →</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            
            // Check length
            const lengthReq = document.getElementById('length-req');
            if (password.length >= 8) {
                lengthReq.classList.add('valid');
            } else {
                lengthReq.classList.remove('valid');
            }
            
            // Check uppercase
            const uppercaseReq = document.getElementById('uppercase-req');
            if (/[A-Z]/.test(password)) {
                uppercaseReq.classList.add('valid');
            } else {
                uppercaseReq.classList.remove('valid');
            }
            
            // Check number
            const numberReq = document.getElementById('number-req');
            if (/[0-9]/.test(password)) {
                numberReq.classList.add('valid');
            } else {
                numberReq.classList.remove('valid');
            }
        });
        
        // Form validation
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const termsCheck = document.getElementById('termsCheck').checked;
            
            if (!termsCheck) {
                e.preventDefault();
                alert('Veuillez accepter les conditions d\'utilisation');
                return;
            }
            
            if (password.length < 8 || !/[A-Z]/.test(password) || !/[0-9]/.test(password)) {
                e.preventDefault();
                alert('Le mot de passe ne respecte pas tous les critères requis');
                return;
            }
        });
    </script>
</body>
</html>