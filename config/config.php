<?php

// =======================
// FUNÇÕES AUXILIARES
// =======================

function getClientIP() {
    $keys = [
        'HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED',
        'HTTP_FORWARDED_FOR','HTTP_FORWARDED','REMOTE_ADDR'
    ];
    foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
    }
    return '0.0.0.0';
}

function logMalware($file, $reason) {
    $ip = getClientIP();
    $line = date('Y-m-d H:i:s') . " | IP: {$ip} | Arquivo/Pasta: {$file} | Motivo: {$reason}\n";
    file_put_contents(__DIR__ . '/malware_scan.log', $line, FILE_APPEND);
}

function logBlock($ip, $country = 'Unknown', $reason) {
    $line = date('Y-m-d H:i:s') . " | IP: {$ip} | País: {$country} | Motivo: {$reason}\n";
    file_put_contents(__DIR__ . '/access_block.log', $line, FILE_APPEND);
}

// =======================
// BLOQUEIO PARA APENAS BRASIL
// =======================

$ip = getClientIP();
$cacheFile = __DIR__ . '/geo_cache_' . md5($ip) . '.json';
$geoData = null;

if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 3600)) {
    $geoData = json_decode(file_get_contents($cacheFile), true);
} else {
    $ctx = stream_context_create(['http' => ['timeout' => 2]]);
    $json = @file_get_contents("http://ip-api.com/json/{$ip}?fields=countryCode,status,message", false, $ctx);
    if ($json) {
        $geoData = json_decode($json, true);
        if ($geoData && $geoData['status'] === 'success') {
            file_put_contents($cacheFile, $json);
        }
    }
}

if ($geoData && $geoData['status'] === 'success') {
    if ($geoData['countryCode'] !== 'BR') {
        logBlock($ip, $geoData['countryCode'], 'Acesso fora do Brasil');
        header('HTTP/1.1 403 Forbidden');
        exit('Acesso permitido apenas para usuários do Brasil.');
    }
} else {
    logBlock($ip, $geoData['countryCode'] ?? 'Desconhecido', 'Falha ao obter localização');
    header('HTTP/1.1 403 Forbidden');
    exit('Acesso negado.');
}

// =======================
// SCANNER DE MALWARE + BLOQUEIO DE PASTAS
// =======================

function scanProject($dir) {
    $suspiciousPatterns = [
        '/eval\s*\(/i',
        '/base64_decode\s*\(/i',
        '/shell_exec\s*\(/i',
        '/system\s*\(/i',
        '/exec\s*\(/i',
        '/passthru\s*\(/i',
        '/preg_replace\s*\(\s*[\'"].*\/e[\'"]/i',
    ];

    $blockedFolders = ['service', 'int'];
    $blockedFiles = ['.env', '.htaccess', 'composer.json', 'composer.lock'];

    $rii = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($rii as $file) {
        $parts = array_map('strtolower', explode(DIRECTORY_SEPARATOR, $file->getPath()));

        // Bloqueia pastas críticas
        foreach ($blockedFolders as $folder) {
            if (in_array($folder, $parts)) {
                logMalware($file->getPathname(), "Pasta bloqueada ({$folder})");
                exit('Acesso bloqueado: Pasta proibida detectada.');
            }
        }

        // Bloqueia arquivos críticos, exceto este config
        foreach ($blockedFiles as $bf) {
            if (strpos($file->getFilename(), $bf) !== false && $file->getFilename() !== basename(__FILE__)) {
                logMalware($file->getPathname(), 'Arquivo crítico bloqueado');
                exit('Acesso bloqueado: arquivo crítico detectado.');
            }
        }

        if ($file->isDir()) continue;
        if (pathinfo($file, PATHINFO_EXTENSION) !== 'php') continue;

        $content = file_get_contents($file->getPathname());
        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                logMalware($file->getPathname(), 'Código suspeito detectado');
                exit('Malware detectado. Execução bloqueada.');
            }
        }
    }
}

// Executa scan no diretório do projeto
scanProject(__DIR__);

// =======================
// CONFIGURAÇÕES NORMAIS DO SISTEMA
// =======================

date_default_timezone_set('America/Sao_Paulo');

// URL da aplicação
define("BASE_URL" ,"https://fabidaprotecaoveicular.com.br/");

// Configuração do Data Base
define("DB_HOST", "");
define("DB_NAME", "");
define("DB_USER", "");
define("DB_PASS", "");

// Configuração de email
define('HOTS_EMAIL', 'smtp.gmail.com');
define('PORT_EMAIL', 465);
define('USER_EMAIL', 'desenvolvedorweb21@gmail.com');
define('PASS_EMAIL', 'fgip hdva gvep mdso');

// =======================
// AUTOLOAD
// =======================

spl_autoload_register(function ($classe) {
    $dirs = ['app/controllers/', 'app/models/', 'core/'];
    foreach ($dirs as $dir) {
        $path = $dir . $classe . '.php';
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});
