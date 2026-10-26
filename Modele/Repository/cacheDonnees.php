<?php
class cacheDonnees {
    const DUREE_VIE = 60;
    const PREFIXE = 'gestionvoiture_v2_';
    const CLE_SESSION = 'gestionvoiture_cache_v2';
    const ANCIENNE_CLE_SESSION = 'gestionvoiture_cache';

    public static function remember($key, $loader) {
        $cacheKey = self::PREFIXE . $key;

        if (self::apcuDisponible()) {
            $value = apcu_fetch($cacheKey, $success);
            if ($success) {
                return $value;
            }
            $value = $loader();
            apcu_store($cacheKey, $value, self::DUREE_VIE);
            return $value;
        }

        self::supprimerAncienCache();
        if (isset($_SESSION[self::CLE_SESSION][$key]) &&
            $_SESSION[self::CLE_SESSION][$key]['expires_at'] > time()) {
            return $_SESSION[self::CLE_SESSION][$key]['value'];
        }

        $value = $loader();
        $_SESSION[self::CLE_SESSION][$key] = array(
            'expires_at' => time() + self::DUREE_VIE,
            'value' => $value
        );
        return $value;
    }

    public static function invalidate($key) {
        if (self::apcuDisponible()) {
            apcu_delete(self::PREFIXE . $key);
            return;
        }

        self::supprimerAncienCache();
        unset($_SESSION[self::CLE_SESSION][$key]);
    }

    private static function apcuDisponible() {
        return function_exists('apcu_fetch') &&
            function_exists('apcu_store') &&
            function_exists('apcu_enabled') &&
            apcu_enabled();
    }

    private static function demarrerSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private static function supprimerAncienCache() {
        self::demarrerSession();
        unset($_SESSION[self::ANCIENNE_CLE_SESSION]);
    }
}
