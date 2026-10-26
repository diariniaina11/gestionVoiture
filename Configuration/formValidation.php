<?php
class formValidation {
    private static $vehicleBrands = array(
        'Acura', 'Alfa Romeo', 'Aston Martin', 'Audi', 'Bentley', 'BMW', 'Bugatti',
        'Buick', 'BYD', 'Cadillac', 'Chery', 'Chevrolet', 'Chrysler', 'Citroën',
        'Cupra', 'Dacia', 'Dodge', 'DS Automobiles', 'Ferrari', 'Fiat', 'Ford',
        'Genesis', 'GMC', 'Great Wall', 'Honda', 'Hyundai', 'Infiniti', 'Isuzu',
        'Jaguar', 'Jeep', 'Kia', 'Lamborghini', 'Lancia', 'Land Rover', 'Lexus',
        'Lincoln', 'Lotus', 'Lucid', 'Maserati', 'Mazda', 'McLaren', 'Mercedes-Benz',
        'MG', 'Mini', 'Mitsubishi', 'Nissan', 'Opel', 'Peugeot', 'Polestar',
        'Porsche', 'Ram', 'Renault', 'Rivian', 'Rolls-Royce', 'Saab', 'Seat',
        'Škoda', 'Smart', 'Subaru', 'Suzuki', 'Tesla', 'Toyota', 'Volkswagen',
        'Volvo', 'Geely', 'Mahindra', 'Tata'
    );

    public static function csrfToken() {
        self::startSession();
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function hasValidCsrfToken($token) {
        self::startSession();
        return is_string($token) &&
            isset($_SESSION['csrf_token']) &&
            hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function isValidText($value, $maxLength) {
        if (!is_string($value)) {
            return false;
        }

        $value = trim($value);
        $length = mb_strlen($value, 'UTF-8');
        return $value !== '' &&
            $length !== false &&
            $length <= $maxLength &&
            preg_match('//u', $value) === 1 &&
            preg_match('/[\x00-\x1F\x7F]/u', $value) !== 1;
    }

    public static function isValidEmail($email) {
        return is_string($email) &&
            strlen($email) <= 254 &&
            filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function isValidPassword($password) {
        return is_string($password) && strlen($password) >= 8 && strlen($password) <= 72;
    }

    public static function isValidVehicleNumber($number) {
        return self::isValidText($number, 10) &&
            preg_match('/^[\p{L}\p{N} -]+$/u', trim($number)) === 1;
    }

    public static function isValidVehicleType($type) {
        return self::isValidText($type, 20) &&
            preg_match('/^[\p{L}\p{N} .-]+$/u', trim($type)) === 1;
    }

    public static function vehicleBrands() {
        return array_values(array_unique(self::$vehicleBrands));
    }

    public static function isValidVehicleBrand($brand) {
        return is_string($brand) && in_array($brand, self::vehicleBrands(), true);
    }

    private static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
