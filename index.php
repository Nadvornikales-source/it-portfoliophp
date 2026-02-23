<?php
// Načtení JSON souboru
$jsonCesta = __DIR__ . "/profile.json";

$chyba = "";
$data = [];

if (!file_exists($jsonCesta)) {
    $chyba = "Soubor profile.json nebyl nalezen.";
} else {
    $jsonText = file_get_contents($jsonCesta);

    if ($jsonText === false) {
        $chyba = "Nepodařilo se načíst profile.json.";
    } else {
        $data = json_decode($jsonText, true);

        if ($data === null) {
            $chyba = "JSON je neplatný (zkontroluj čárky/uvozovky).";
            $data = [];
        }
    }
}

// Bezpečný výpis
function e($text)
{
    return htmlspecialchars((string)$text, ENT_QUOTES, "UTF-8");
}

// Pomocná funkce pro výpis seznamu
function vypisSeznam($pole)
{
    if (!is_array($pole) || count($pole) === 0) {
        echo "<p class='muted'>Nic tu není.</p>";
        return;
    }

    echo "<ul>";
    foreach ($pole as $polozka) {
        echo "<li>" . e($polozka) . "</li>";
    }
    echo "</ul>";
}

$jmeno = $data["name"] ?? "Neznámý profil";
$skills = $data["skills"] ?? [];
$interests = $data["interests"] ?? null;
$projects = $data["projects"] ?? null;
?>
<!doctype html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($jmeno) ?> – IT Profil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="card">
        <?php if ($chyba !== ""): ?>
            <div class="alert"><?= e($chyba) ?></div>
        <?php endif; ?>

        <header class="header">
            <h1><?= e($jmeno) ?></h1>
            <p class="muted">Server-Side Rendering přes PHP (data z <code>profile.json</code>).</p>
        </header>

        <section class="section">
            <h2>Dovednosti</h2>
            <?php vypisSeznam($skills); ?>
        </section>

        <?php if ($interests !== null): ?>
            <section class="section">
                <h2>Zájmy</h2>
                <?php vypisSeznam($interests); ?>
            </section>
        <?php endif; ?>

        <?php if ($projects !== null): ?>
            <section class="section">
                <h2>Projekty</h2>
                <?php vypisSeznam($projects); ?>
            </section>
        <?php endif; ?>

        <footer class="footer muted">
            <span>✅ Bez JS</span>
            <span>✅ foreach + htmlspecialchars()</span>
            <span>✅ json_decode(..., true)</span>
        </footer>
    </main>
</body>
</html>