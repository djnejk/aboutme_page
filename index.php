<?php

declare(strict_types=1);

/**
 * Simple inline translation helper.
 * Usage in template: <?= t('Česky', 'English') ?>
 */

function current_lang(): string
{
  $allowed = ['cs', 'en'];

  if (isset($_GET['lang']) && in_array($_GET['lang'], $allowed, true)) {
    $lang = $_GET['lang'];
    setcookie('lang', $lang, [
      'expires' => time() + 60 * 60 * 24 * 365,
      'path' => '/',
      'secure' => isset($_SERVER['HTTPS']),
      'httponly' => false,
      'samesite' => 'Lax',
    ]);
    return $lang;
  }

  if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], $allowed, true)) {
    return $_COOKIE['lang'];
  }

  $al = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '');
  if (str_starts_with($al, 'en')) return 'en';

  return 'cs';
}

$lang = current_lang();

function t(string $cs, string $en): string
{
  global $lang;
  return $lang === 'en' ? $en : $cs;
}

function lang_url(string $target): string
{
  $path = strtok($_SERVER['REQUEST_URI'] ?? '/', '?') ?: '/';
  return htmlspecialchars($path . '?lang=' . $target, ENT_QUOTES);
}
?>
<!doctype html>
<html lang="<?= $lang === 'en' ? 'en' : 'cs' ?>">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= t('Jiří Januš (Dj Nejk) | djdevs.eu', 'Jiří Januš (Dj Nejk) | djdevs.eu') ?></title>
  <meta name="description" content="<?= t(
                                      'Osobní prezentace Jiřího Januše (Dj Nejk) — webové aplikace a prezentace, Minecraft pluginy, projekt Filmy pod Hvězdami, Run For Planet, ovládání MHD panelů a 3D tisk.',
                                      'Personal site of Jiří Januš (Dj Nejk) — websites & web apps, Minecraft plugins, Filmy pod Hvězdami, Run For Planet, public transport display control and 3D printing.'
                                    ) ?>" />
  <meta name="theme-color" content="#05060a" />

  <link rel="icon" type="image/png" href="assets/favicon/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="assets/favicon/favicon.svg" />
  <link rel="shortcut icon" href="assets/favicon/favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png" />
  <link rel="manifest" href="assets/favicon/site.webmanifest" />

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <style>
    :root {
      --bg0: #000000;
      --bg1: #070810;
      --card: rgba(255, 255, 255, .04);
      --muted: rgba(255, 255, 255, .75);
      --muted2: rgba(255, 255, 255, .58);
      --accent: #6ea8fe;
      --accent2: #9b7bff;
      --border: rgba(255, 255, 255, .10);
      --shadow: 0 20px 60px rgba(0, 0, 0, .50);
    }

    body {
      background:
        radial-gradient(900px 650px at 12% 12%, rgba(110, 168, 254, .12), transparent 55%),
        radial-gradient(900px 650px at 90% 18%, rgba(155, 123, 255, .10), transparent 55%),
        linear-gradient(180deg, var(--bg0), var(--bg1));
      color: #fff;
    }

    .navbar {
      backdrop-filter: blur(10px);
      background: rgba(0, 0, 0, .55);
      border-bottom: 1px solid var(--border);
    }

    .brand-badge {
      display: inline-flex;
      align-items: center;
      gap: .55rem;
      padding: .35rem .65rem;
      border: 1px solid var(--border);
      border-radius: 999px;
      background: rgba(255, 255, 255, .03);
    }

    .hero {
      padding-top: 6.25rem;
      padding-bottom: 2.25rem;
    }

    .hero-card {
      background: linear-gradient(180deg, rgba(255, 255, 255, .06), rgba(255, 255, 255, .02));
      border: 1px solid var(--border);
      border-radius: 1.25rem;
      box-shadow: var(--shadow);
    }

    .pill {
      border: 1px solid var(--border);
      background: rgba(255, 255, 255, .03);
      border-radius: 999px;
      padding: .35rem .65rem;
      color: var(--muted);
      font-size: .95rem;
    }

    .section-title {
      letter-spacing: .3px;
    }

    .card-soft {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 1rem;
    }

    .muted {
      color: var(--muted);
    }

    .muted2 {
      color: var(--muted2);
    }

    a {
      color: #fff;
    }

    a.link-soft {
      color: var(--accent);
      text-decoration: none;
    }

    a.link-soft:hover {
      text-decoration: underline;
    }

    .tag {
      display: inline-flex;
      align-items: center;
      padding: .25rem .55rem;
      border-radius: 999px;
      border: 1px solid var(--border);
      background: rgba(255, 255, 255, .03);
      font-size: .85rem;
      color: var(--muted);
      margin: .2rem .2rem 0 0;
      white-space: nowrap;
    }

    .btn-accent {
      background: linear-gradient(90deg, rgba(110, 168, 254, .95), rgba(155, 123, 255, .95));
      border: 0;
    }

    .btn-accent:hover {
      filter: brightness(1.05);
    }

    .kbd {
      font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
      padding: .05rem .35rem;
      border-radius: .35rem;
      border: 1px solid var(--border);
      background: rgba(0, 0, 0, .35);
      color: var(--muted);
      font-size: .9rem;
    }

    .hr-soft {
      border-color: rgba(255, 255, 255, .10) !important;
    }

    .profile-wrap {
      display: flex;
      gap: 1.25rem;
      align-items: center;
      flex-wrap: wrap;
    }

    .profile-img {
      width: 112px;
      height: 112px;
      border-radius: 18px;
      object-fit: cover;
      border: 1px solid var(--border);
      box-shadow: 0 12px 35px rgba(0, 0, 0, .55);
      background: rgba(255, 255, 255, .03);
    }

    /* Gallery */
    .gallery-item {
      border: 1px solid var(--border);
      border-radius: .9rem;
      overflow: hidden;
      background: rgba(255, 255, 255, .03);
      cursor: pointer;
      height: 190px;
      position: relative;
    }

    .gallery-item:hover {
      border-color: rgba(110, 168, 254, .35);
    }

    .gallery-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: .92;
      transform: scale(1.01);
    }

    .gallery-badge {
      position: absolute;
      left: 10px;
      top: 10px;
      padding: .25rem .55rem;
      border-radius: 999px;
      border: 1px solid var(--border);
      background: rgba(0, 0, 0, .55);
      color: rgba(255, 255, 255, .85);
      font-size: .82rem;
      backdrop-filter: blur(6px);
    }

    .gallery-fallback {
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--muted2);
      padding: 1rem;
      text-align: center;
    }

    .footer {
      border-top: 1px solid var(--border);
      padding: 2.5rem 0;
      color: var(--muted2);
    }
  </style>
</head>

<body>
  <!-- NAV -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand text-white fw-semibold" href="#top">
        <span class="brand-badge">
          <i class="bi bi-code-slash"></i>
          <span>djdevs.eu</span>
        </span>
      </a>

      <button class="navbar-toggler text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon" style="filter:invert(1);"></span>
      </button>

      <div class="collapse navbar-collapse" id="nav">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2 mt-3 mt-lg-0">
          <li class="nav-item"><a class="nav-link text-white-50" href="#about"><?= t('O mně', 'About') ?></a></li>
          <li class="nav-item"><a class="nav-link text-white-50" href="#projects"><?= t('Projekty', 'Projects') ?></a></li>
          <li class="nav-item"><a class="nav-link text-white-50" href="#skills"><?= t('Dovednosti', 'Skills') ?></a></li>
          <li class="nav-item"><a class="nav-link text-white-50" href="#gallery"><?= t('Galerie', 'Gallery') ?></a></li>
          <li class="nav-item"><a class="nav-link text-white-50" href="#contact"><?= t('Kontakt', 'Contact') ?></a></li>

          <li class="nav-item ms-lg-2">
            <div class="btn-group" role="group" aria-label="Language switcher">
              <a class="btn btn-sm btn-outline-light <?= $lang === 'cs' ? 'active' : '' ?>" href="<?= lang_url('cs') ?>">CZ</a>
              <a class="btn btn-sm btn-outline-light <?= $lang === 'en' ? 'active' : '' ?>" href="<?= lang_url('en') ?>">EN</a>
            </div>
          </li>

          <li class="nav-item ms-lg-2">
            <a class="btn btn-sm btn-accent text-dark fw-semibold" href="#contact">
              <i class="bi bi-chat-dots"></i>
              <span class="ms-1"><?= t('Napiš mi', 'Message me') ?></span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <header id="top" class="hero">
    <div class="container">
      <div class="row g-4 align-items-stretch">
        <div class="col-lg-8">
          <div class="p-4 p-md-5 hero-card h-100">

            <div class="profile-wrap mb-3">
              <img class="profile-img" src="assets/profile.jpg" alt="<?= t('Profilová fotka', 'Profile photo') ?>">
              <div>
                <div class="d-flex flex-wrap gap-2 mb-2">
                  <span class="pill"><i class="bi bi-geo-alt me-1"></i><?= t('Královehradecký kraj, CZ', 'Hradec Králové Region, CZ') ?></span>
                  <span class="pill"><i class="bi bi-calendar3 me-1"></i><?= t('Věk:', 'Age:') ?> <span id="age"></span></span>
                  <span class="pill"><i class="bi bi-lightning-charge me-1"></i><?= t('Web apps • Projekty • Hardware', 'Web apps • Projects • Hardware') ?></span>
                </div>

                <h1 class="display-6 fw-semibold mb-1">
                  <?= t('Ahoj, jsem', 'Hi, I’m') ?>
                  <span class="text-white">Jiří Januš</span>
                  <span class="muted2">(Dj Nejk)</span>
                </h1>
                <div class="muted2">jiri.janus@djdevs.eu • +420 730 596 072</div>
              </div>
            </div>

            <p class="lead muted mb-4">
              <?= t(
                'Dělám webové prezentace a webové aplikace, píšu Minecraft pluginy a baví mě projekty, kde se potkává software s hardwarem — ovládání MHD informačních panelů a 3D tisk.',
                'I build websites and web apps, develop Minecraft plugins, and I enjoy projects where software meets hardware — public transport display control and 3D printing.'
              ) ?>
            </p>

            <div class="d-flex flex-wrap gap-2">
              <a class="btn btn-accent text-dark fw-semibold" href="#projects">
                <i class="bi bi-stars"></i>
                <span class="ms-1"><?= t('Projekty', 'Projects') ?></span>
              </a>
              <a class="btn btn-outline-light" href="#contact">
                <i class="bi bi-envelope"></i>
                <span class="ms-1"><?= t('Kontakt', 'Contact') ?></span>
              </a>
              <a class="btn btn-outline-light" href="https://www.spigotmc.org/resources/mysql-commands.123854/" target="_blank" rel="noreferrer">
                <i class="bi bi-boxes"></i>
                <span class="ms-1"><?= t('Spigot plugin', 'Spigot plugin') ?></span>
              </a>
            </div>

            <div class="mt-4 muted2">
              <span class="kbd">PHP</span> <span class="mx-1">+</span>
              <span class="kbd">JS</span> <span class="mx-1">+</span>
              <span class="kbd">MySQL</span> <span class="mx-1">+</span>
              <span class="kbd">Bootstrap</span>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card-soft p-4 p-md-5 h-100">
            <h2 class="h5 fw-semibold section-title mb-3"><?= t('Rychlý přehled', 'Quick overview') ?></h2>

            <div class="d-grid gap-3">
              <div class="d-flex gap-3">
                <div class="fs-4"><i class="bi bi-window-stack"></i></div>
                <div>
                  <div class="fw-semibold"><?= t('Weby & webové aplikace', 'Websites & web apps') ?></div>
                  <div class="muted2"><?= t('Prezentace, registrace, formuláře, admin, databáze.', 'Websites, registrations, forms, admin panels, databases.') ?></div>
                </div>
              </div>

              <div class="d-flex gap-3">
                <div class="fs-4"><i class="bi bi-people"></i></div>
                <div>
                  <div class="fw-semibold"><?= t('Projekty s kamarády', 'Projects with friends') ?></div>
                  <div class="muted2"><?= t('Filmy pod Hvězdami • Run For Planet.', 'Filmy pod Hvězdami • Run For Planet.') ?></div>
                </div>
              </div>

              <div class="d-flex gap-3">
                <div class="fs-4"><i class="bi bi-hdd-network"></i></div>
                <div>
                  <div class="fw-semibold"><?= t('MHD panely', 'Transport displays') ?></div>
                  <div class="muted2"><?= t('Vlastní ovladač, elektronika + software.', 'Custom controller, electronics + software.') ?></div>
                </div>
              </div>

              <div class="d-flex gap-3">
                <div class="fs-4"><i class="bi bi-printer"></i></div>
                <div>
                  <div class="fw-semibold"><?= t('3D tisk', '3D printing') ?></div>
                  <div class="muted2"><?= t('Prototypy i velké projekty (např. socha 1:1).', 'From prototypes to large builds (e.g., 1:1 statue).') ?></div>
                </div>
              </div>

              <hr class="hr-soft my-1">

              <div class="d-flex flex-wrap gap-2">
                <a class="btn btn-sm btn-outline-light" href="https://www.instagram.com/djnejk/" target="_blank" rel="noreferrer">
                  <i class="bi bi-instagram"></i><span class="ms-1">Instagram</span>
                </a>
                <a class="btn btn-sm btn-outline-light" href="https://www.facebook.com/nejkdj/" target="_blank" rel="noreferrer">
                  <i class="bi bi-facebook"></i><span class="ms-1">Facebook</span>
                </a>
              </div>

              <div class="muted2 small">
                <?= t('Tip: Klikni na projekty dole — je tam web i registrace pro běhy.', 'Tip: Check the projects below — there’s a website + registration app.') ?>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </header>

  <!-- ABOUT -->
  <section id="about" class="py-5">
    <div class="container">
      <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-3">
        <h2 class="h4 fw-semibold section-title mb-0"><?= t('O mně', 'About me') ?></h2>
        <div class="muted2"><?= t('Krátce a přehledně — co dělám a na čem pracuju.', 'Clear overview — what I do and what I’m building.') ?></div>
      </div>

      <div class="row g-4">
        <div class="col-lg-7">
          <div class="card-soft p-4 p-md-5">
            <h3 class="h5 fw-semibold mb-3"><?= t('Bio', 'Bio') ?></h3>

            <p class="muted mb-3">
              <?= t(
                'Jmenuju se Jiří Januš (Dj Nejk) a baví mě tvořit věci, které lidi reálně používají — webové prezentace, webové aplikace a různé custom projekty.',
                'My name is Jiří Januš (Dj Nejk). I enjoy building things people actually use — websites, web apps, and custom projects.'
              ) ?>
            </p>

            <p class="muted mb-3">
              <?= t(
                'S kamarády děláme na projektu Filmy pod Hvězdami — v létě děláme letní kino pod širým nebem. Další projekt je Run For Planet: charitativní běhy, kde je potřeba řešit web i registrace.',
                'With my friends, we run Filmy pod Hvězdami — an open-air summer cinema project. Another project is Run For Planet: charity runs that need a website and online registration.'
              ) ?>
            </p>

            <p class="muted mb-0">
              <?= t(
                'Kromě webu mě baví i hardware: vyvíjím vlastní ovladač pro MHD informační panely a věnuju se 3D tisku (od prototypů až po velké výtisky).',
                'Besides web development, I also enjoy hardware: I’m developing a custom controller for public transport information displays and I do 3D printing (from prototypes to large prints).'
              ) ?>
            </p>

            <hr class="hr-soft my-4">

            <div class="row g-3">
              <div class="col-md-6">
                <div class="fw-semibold mb-1"><i class="bi bi-check2-circle me-2"></i><?= t('Co umím dodat', 'What I can deliver') ?></div>
                <div class="muted2">
                  <?= t(
                    'Prezentace, webové aplikace (registrace/formuláře/admin), nasazení a údržba, Minecraft pluginy.',
                    'Websites, web apps (registrations/forms/admin), deployment & maintenance, Minecraft plugins.'
                  ) ?>
                </div>
              </div>
              <div class="col-md-6">
                <div class="fw-semibold mb-1"><i class="bi bi-rocket-takeoff me-2"></i><?= t('Co mě baví nejvíc', 'What I enjoy most') ?></div>
                <div class="muted2">
                  <?= t(
                    'Praktické projekty, automatizace a propojení software ↔ hardware.',
                    'Practical projects, automation, and software ↔ hardware integration.'
                  ) ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="card-soft p-4 p-md-5 mb-4">
            <h3 class="h5 fw-semibold mb-3"><?= t('Rychlá fakta', 'Quick facts') ?></h3>
            <ul class="list-unstyled mb-0 muted">
              <li class="mb-2"><i class="bi bi-person-badge me-2"></i><?= t('Věk: ', 'Age: ') ?><span id="age2"></span></li>
              <li class="mb-2"><i class="bi bi-geo me-2"></i><?= t('Královehradecký kraj (CZ).', 'Hradec Králové Region (CZ).') ?></li>
              <li class="mb-2"><i class="bi bi-mortarboard me-2"></i><?= t('SPŠ/SOŠ/SOU Hradec Králové — elektrotechnika.', 'Technical high school — Electrical engineering (HK).') ?></li>
              <li class="mb-0"><i class="bi bi-lightning me-2"></i><?= t('Focus: web apps, projekty, pluginy, hardware.', 'Focus: web apps, projects, plugins, hardware.') ?></li>
            </ul>
          </div>

          <div class="card-soft p-4 p-md-5">
            <h3 class="h5 fw-semibold mb-3"><?= t('Jak spolupráce probíhá', 'How collaboration works') ?></h3>
            <ol class="muted mb-0">
              <li class="mb-2"><?= t('Napíšeš mi co potřebuješ (co, do kdy, odkaz/inspirace).', 'You message me what you need (what, deadline, links/inspiration).') ?></li>
              <li class="mb-2"><?= t('Navrhnu řešení + domluvíme rozsah.', 'I propose a solution and scope.') ?></li>
              <li class="mb-2"><?= t('Dodám první verzi, vyladíme detaily.', 'I deliver a first version and we polish details.') ?></li>
              <li class="mb-0"><?= t('Nasazení + domluvená údržba/úpravy.', 'Deployment + agreed maintenance/updates.') ?></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- PROJECTS -->
  <section id="projects" class="py-5">
    <div class="container">
      <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-3">
        <h2 class="h4 fw-semibold section-title mb-0"><?= t('Projekty a reference', 'Projects & work') ?></h2>
        <div class="muted2"><?= t('Ukázky toho, co jsem dělal (weby, aplikace, projekty).', 'Examples of what I’ve built (websites, apps, projects).') ?></div>
      </div>

      <div class="row g-4">
        <?php
        $cards = [
          [
            'icon' => 'bi-film',
            'title' => 'filmypodhvezdami.cz',
            'text' => [
              'Filmy pod Hvězdami — letní kino pod širým nebem. Dělám web a věci kolem online prezentace.',
              'Filmy pod Hvězdami — open-air summer cinema. I work on the website and online presence.',
            ],
            'url'  => 'http://filmypodhvezdami.cz/',
            'badge' => ['Projekt', 'Project'],
          ],
          [
            'icon' => 'bi-tree',
            'title' => 'runforplanet.cz',
            'text' => [
              'Run For Planet — charitativní běhy. Webová prezentace projektu + info pro běžce.',
              'Run For Planet — charity runs. Website with event info for runners.',
            ],
            'url'  => 'https://www.runforplanet.cz/',
            'badge' => ['Projekt', 'Project'],
          ],
          [
            'icon' => 'bi-ui-checks',
            'title' => 'dsb.runforplanet.cz',
            'text' => [
              'Online registrace na běhy — webová aplikace pro přihlášení (a další funkce podle potřeby).',
              'Online registration app for runs — web application for sign-up (and more features as needed).',
            ],
            'url'  => 'https://dsb.runforplanet.cz/',
            'badge' => ['Web app', 'Web app'],
          ],
          [
            'icon' => 'bi-building',
            'title' => 'obeclibrice.cz',
            'text' => [
              'Obec Libřice — webová prezentace + část funkčnosti jako aplikace.',
              'Municipality of Libřice — website plus application functionality.',
            ],
            'url'  => 'https://obeclibrice.cz/',
            'badge' => ['Web', 'Web'],
          ],
        ];
        foreach ($cards as $c):
        ?>
          <div class="col-md-6 col-lg-3">
            <div class="card-soft p-4 h-100">
              <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                <div class="d-flex align-items-center gap-2">
                  <i class="bi <?= htmlspecialchars($c['icon']) ?> fs-4"></i>
                  <div class="fw-semibold"><?= htmlspecialchars($c['title']) ?></div>
                </div>
                <span class="tag"><?= t($c['badge'][0], $c['badge'][1]) ?></span>
              </div>
              <p class="muted2 mb-3"><?= t($c['text'][0], $c['text'][1]) ?></p>
              <a class="link-soft" href="<?= htmlspecialchars($c['url']) ?>" target="_blank" rel="noreferrer">
                <i class="bi bi-box-arrow-up-right me-1"></i><?= t('Otevřít', 'Open') ?>
              </a>
            </div>
          </div>
        <?php endforeach; ?>

        <div class="col-lg-6">
          <div class="card-soft p-4 h-100">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-boxes fs-4"></i>
              <div class="fw-semibold"><?= t('Minecraft pluginy (Spigot)', 'Minecraft plugins (Spigot)') ?></div>
              <span class="tag ms-auto"><?= t('Plugin', 'Plugin') ?></span>
            </div>
            <p class="muted2 mb-2"><?= t(
                                      'Vlastní plugin + věci na míru. Ukázka: MySQL Commands (SpigotMC).',
                                      'Custom plugins + tailored features. Example: MySQL Commands (SpigotMC).'
                                    ) ?></p>
            <a class="link-soft" href="https://www.spigotmc.org/resources/mysql-commands.123854/" target="_blank" rel="noreferrer">
              <i class="bi bi-box-arrow-up-right me-1"></i><?= t('Otevřít', 'Open') ?>
            </a>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card-soft p-4 h-100">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-cpu fs-4"></i>
              <div class="fw-semibold"><?= t('Ovladač MHD informačních panelů', 'Public transport display controller') ?></div>
              <span class="tag ms-auto"><?= t('Hardware', 'Hardware') ?></span>
            </div>
            <p class="muted2 mb-0"><?= t(
                                      'Vyvíjím vlastní ovladač pro informační panely z MHD — od elektroniky až po software. (Fotky najdeš v galerii.)',
                                      'I’m developing my own controller for public transport information displays — from electronics to software. (Photos in gallery.)'
                                    ) ?></p>
          </div>
        </div>

        <div class="col-12">
          <div class="card-soft p-4 p-md-5">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-printer fs-4"></i>
              <div class="fw-semibold"><?= t('3D tisk', '3D printing') ?></div>
              <span class="tag ms-auto"><?= t('Maker', 'Maker') ?></span>
            </div>
            <p class="muted2 mb-3"><?= t(
                                      'Tisknu prototypy i velké projekty. Největší projekt: tisk sochy pro youtubera MenT v životní velikosti (fotky v galerii).',
                                      'From prototypes to large builds. Biggest project: a life-size statue print for YouTuber MenT (see gallery).'
                                    ) ?></p>
            <div class="d-flex flex-wrap gap-2">
              <span class="tag">2× Creality Ender S1</span>
              <span class="tag">CR-10 (32-bit mod)</span>
              <span class="tag"><?= t('Socha 1:1', '1:1 statue') ?></span>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- SKILLS -->
  <section id="skills" class="py-5">
    <div class="container">
      <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-3">
        <h2 class="h4 fw-semibold section-title mb-0"><?= t('Dovednosti', 'Skills') ?></h2>
        <div class="muted2"><?= t('Co používám a v čem se pohybuju.', 'Tools and stack I actually use.') ?></div>
      </div>

      <div class="row g-4">
        <div class="col-md-6 col-lg-4">
          <div class="card-soft p-4 h-100">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-braces fs-4"></i>
              <div class="fw-semibold"><?= t('Daily', 'Daily') ?></div>
            </div>
            <div id="tagsDaily"></div>
            <div class="muted2 small mt-2">
              <?= t('Každodenní práce na webech a aplikacích.', 'My day-to-day web & app stack.') ?>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card-soft p-4 h-100">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-layers fs-4"></i>
              <div class="fw-semibold"><?= t('Také', 'Also') ?></div>
            </div>
            <div id="tagsAlso"></div>
            <div class="muted2 small mt-2">
              <?= t('Další jazyky a věci, které umím použít.', 'Other languages and tools I can use.') ?>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-lg-4">
          <div class="card-soft p-4 h-100">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-tools fs-4"></i>
              <div class="fw-semibold"><?= t('Nástroje', 'Tools') ?></div>
            </div>
            <div id="tagsTools"></div>
            <hr class="hr-soft my-3">
            <div class="muted2 small">
              <?= t('Umím i nasazení a základní správu/údržbu podle domluvy.', 'I can also handle deployment and basic maintenance as needed.') ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- GALLERY -->
  <section id="gallery" class="py-5">
    <div class="container">
      <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-3">
        <h2 class="h4 fw-semibold section-title mb-0"><?= t('Galerie', 'Gallery') ?></h2>
        <div class="muted2"><?= t('Fotky projektů (klikni pro zvětšení).', 'Project photos (click to view).') ?></div>
      </div>

      <div class="row g-3">
        <?php
        $gallery = [
          ['file' => 'assets/mhd-panel-1.jpg', 'label' => ['MHD panel', 'Display'], 'caption' => ['MHD ovladač — prototyp', 'Display controller — prototype']],
          ['file' => 'assets/mhd-panel-2.jpg', 'label' => ['MHD panel', 'Display'], 'caption' => ['MHD ovladač — detail', 'Display controller — details']],
          ['file' => 'assets/3d-ment-1.jpg',   'label' => ['3D tisk', '3D print'], 'caption' => ['Socha — tisk', 'Statue — printing']],
          ['file' => 'assets/3d-ment-2.jpg',   'label' => ['3D tisk', '3D print'], 'caption' => ['Socha — hotovo', 'Statue — finished']],
        ];
        foreach ($gallery as $g):
          $file = $g['file'];
          $label = t($g['label'][0], $g['label'][1]);
          $caption = t($g['caption'][0], $g['caption'][1]);
          $safeFile = htmlspecialchars($file, ENT_QUOTES);
          $safeCaption = htmlspecialchars($caption, ENT_QUOTES);
          $safeLabel = htmlspecialchars($label, ENT_QUOTES);
        ?>
          <div class="col-6 col-lg-3">
            <div class="gallery-item"
              data-bs-toggle="modal"
              data-bs-target="#imgModal"
              data-img="<?= $safeFile ?>"
              data-caption="<?= $safeCaption ?>">
              <span class="gallery-badge"><i class="bi bi-image me-1"></i><?= $safeLabel ?></span>

              <!-- If image missing, browser will trigger onerror and show fallback -->
              <img src="<?= $safeFile ?>" alt="<?= $safeLabel ?>"
                onerror="this.style.display='none'; this.closest('.gallery-item').querySelector('.gallery-fallback').style.display='flex';">
              <div class="gallery-fallback" style="display:none;">
                <div>
                  <i class="bi bi-image fs-3"></i>
                  <div class="mt-2"><?= $safeLabel ?></div>
                  <div class="small muted2 mt-1"><?= t('Chybí soubor', 'Missing file') ?>:<br><span class="kbd"><?= htmlspecialchars(basename($file)) ?></span></div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="mt-3 muted2">
        <?= t(
          'Tip: Profilovku dej jako assets/profile.jpg (ideálně čtverec, min. 600×600).',
          'Tip: Put your profile photo as assets/profile.jpg (square recommended, min 600×600).'
        ) ?>
      </div>
    </div>
  </section>

  <!-- CONTACT -->
  <section id="contact" class="py-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-6">
          <div class="card-soft p-4 p-md-5 h-100">
            <h2 class="h4 fw-semibold section-title mb-3"><?= t('Kontakt', 'Contact') ?></h2>
            <p class="muted mb-4">
              <?= t(
                'Chceš web, aplikaci nebo plugin? Napiš mi. Nejvíc pomůže, když pošleš co chceš udělat, do kdy a případně ukázku/inspiraci.',
                'Need a website, web app, or a plugin? Message me. It helps if you include what you need, deadline, and a link/inspiration.'
              ) ?>
            </p>

            <div class="d-grid gap-3">
              <div class="d-flex align-items-center gap-3">
                <div class="fs-4"><i class="bi bi-envelope"></i></div>
                <div>
                  <div class="muted2"><?= t('E-mail', 'Email') ?></div>
                  <a class="link-soft" href="mailto:jiri.janus@djdevs.eu?subject=<?= rawurlencode('Poptávka z djdevs.eu') ?>">jiri.janus@djdevs.eu</a>
                </div>
              </div>

              <div class="d-flex align-items-center gap-3">
                <div class="fs-4"><i class="bi bi-telephone"></i></div>
                <div>
                  <div class="muted2"><?= t('Telefon', 'Phone') ?></div>
                  <a class="link-soft" href="tel:+420730596072">+420 730 596 072</a>
                </div>
              </div>

              <div class="d-flex align-items-center gap-3">
                <div class="fs-4"><i class="bi bi-share"></i></div>
                <div>
                  <div class="muted2"><?= t('Sociální sítě', 'Socials') ?></div>
                  <div class="d-flex flex-wrap gap-2 mt-1">
                    <a class="btn btn-sm btn-outline-light" href="https://www.instagram.com/djnejk/" target="_blank" rel="noreferrer">
                      <i class="bi bi-instagram"></i><span class="ms-2">Instagram</span>
                    </a>
                    <a class="btn btn-sm btn-outline-light" href="https://www.facebook.com/nejkdj/" target="_blank" rel="noreferrer">
                      <i class="bi bi-facebook"></i><span class="ms-2">Facebook</span>
                    </a>
                  </div>
                  <div class="muted2 mt-2">@djnejk • @nejkdj • Dj Nejk</div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-lg-6">
          <div class="card-soft p-4 p-md-5 h-100">
            <h3 class="h5 fw-semibold mb-3"><?= t('Rychlé zadání', 'Quick brief') ?></h3>

            <div class="muted2 mb-2"><?= t('Když mi napíšeš, pošli ideálně:', 'When you message me, ideally include:') ?></div>
            <ul class="muted">
              <li><?= t('co chceš vytvořit (web / aplikace / plugin)', 'what you want (website / app / plugin)') ?></li>
              <li><?= t('termín (do kdy)', 'deadline') ?></li>
              <li><?= t('odkaz/inspiraci + co se ti líbí', 'links/inspiration + what you like') ?></li>
              <li><?= t('případně rozpočet (volitelné)', 'budget (optional)') ?></li>
            </ul>

            <hr class="hr-soft my-4">

            <div class="d-flex flex-wrap gap-2">
              <a class="btn btn-accent text-dark fw-semibold" href="mailto:jiri.janus@djdevs.eu?subject=<?= rawurlencode('Poptávka z djdevs.eu') ?>&body=<?= rawurlencode(t(
                                                                                                                                                            "Ahoj Jiří,\n\nChci: \nTermín: \nOdkaz/inspirace: \nPoznámka: \n\nDíky!",
                                                                                                                                                            "Hi Jiří,\n\nI need: \nDeadline: \nLinks/inspiration: \nNotes: \n\nThanks!"
                                                                                                                                                          )) ?>">
                <i class="bi bi-send"></i><span class="ms-2"><?= t('Napsat e-mail', 'Send email') ?></span>
              </a>

              <a class="btn btn-outline-light" href="#projects">
                <i class="bi bi-stars"></i><span class="ms-2"><?= t('Mrknout na projekty', 'View projects') ?></span>
              </a>
            </div>

            <div class="muted2 small mt-3">
              <?= t('Odpovídám co nejdřív, většinou ten samý den.', 'I reply as soon as possible, usually the same day.') ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
      <p class="text-center">© <?php echo '2025-' . date('Y'); ?> DjDevs.eu - <?= t('S láskou ❤️ vytvořilo', 'Made with love ❤️ by') ?> <a target="_blank" href="https://djdevs.eu" rel="noopener" style="text-decoration: none; color: #fff;">DjDevs.eu</a></p>
      <p><?php require('/version.txt') ?></p>
    </div>
  </footer>

  <!-- Image modal -->
  <div class="modal fade" id="imgModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content" style="background: rgba(0,0,0,.92); border:1px solid var(--border);">
        <div class="modal-header border-0">
          <h5 class="modal-title"><?= t('Galerie', 'Gallery') ?></h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pt-0">
          <img id="imgModalEl" src="" alt="" class="img-fluid rounded" style="border:1px solid var(--border);">
          <div class="muted2 mt-3" id="imgModalCaption"></div>
          <div class="muted2 mt-2">
            <?= t(
              'Tip: Pokud se obrázek nenačte, nahraj ho do složky assets a zkontroluj název souboru.',
              'Tip: If the image doesn’t load, upload it to the assets folder and verify the filename.'
            ) ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JS: jQuery + Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Age auto-calc from 22.3.2006 (month is 0-based)
    const DOB = new Date(2006, 2, 22);

    function calculateAge(dob) {
      const now = new Date();
      let age = now.getFullYear() - dob.getFullYear();
      const m = now.getMonth() - dob.getMonth();
      if (m < 0 || (m === 0 && now.getDate() < dob.getDate())) age--;
      return age;
    }

    const age = calculateAge(DOB);
    document.getElementById("age").textContent = age;
    document.getElementById("age2").textContent = age;
    document.getElementById("year").textContent = new Date().getFullYear();

    // Skills tags (more "meaningful" grouping)
    const tagSets = {
      daily: ["HTML", "CSS", "JavaScript", "PHP", "MySQL", "Bootstrap", "jQuery", "REST/API"],
      also: ["Java", "C++", "C#", "Linux", "Hardware tinkering"],
      tools: ["VS Code", "Visual Studio", "IntelliJ IDEA", "Git (basic)", "Synology", "Adobe"]
    };

    function renderTags(containerId, arr) {
      const el = document.getElementById(containerId);
      if (!el) return;
      el.innerHTML = arr.map(x => `<span class="tag">${x}</span>`).join("");
    }

    renderTags("tagsDaily", tagSets.daily);
    renderTags("tagsAlso", tagSets.also);
    renderTags("tagsTools", tagSets.tools);

    // Smooth scroll (offset for fixed navbar)
    $('a[href^="#"]').on("click", function(e) {
      const href = this.getAttribute("href");
      if (!href || href === "#") return;
      const target = $(href);
      if (target.length) {
        e.preventDefault();
        const top = target.offset().top - 78;
        $("html, body").animate({
          scrollTop: top
        }, 420);
      }
    });

    // Gallery modal
    $("#imgModal").on("show.bs.modal", function(e) {
      const trigger = e.relatedTarget;
      const img = trigger.getAttribute("data-img");
      const caption = trigger.getAttribute("data-caption") || "";
      $("#imgModalEl").attr("src", img);
      $("#imgModalCaption").text(caption);
    });
  </script>
</body>

</html>