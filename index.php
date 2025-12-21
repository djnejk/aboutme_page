<?php
declare(strict_types=1);

/**
 * Simple inline translation helper.
 * Usage in template: <?= t('Česky', 'English') ?>
 */

function current_lang(): string {
  $allowed = ['cs', 'en'];

  // 1) URL param has priority
  if (isset($_GET['lang']) && in_array($_GET['lang'], $allowed, true)) {
    $lang = $_GET['lang'];
    setcookie('lang', $lang, [
      'expires' => time() + 60*60*24*365,
      'path' => '/',
      'secure' => isset($_SERVER['HTTPS']),
      'httponly' => false,
      'samesite' => 'Lax',
    ]);
    return $lang;
  }

  // 2) Cookie
  if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], $allowed, true)) {
    return $_COOKIE['lang'];
  }

  // 3) Browser header
  $al = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '');
  if (str_starts_with($al, 'en')) return 'en';

  return 'cs';
}

$lang = current_lang();

function t(string $cs, string $en) : string {
  global $lang;
  return $lang === 'en' ? $en : $cs;
}

function lang_url(string $target): string {
  // Keep current path, drop other params; you can extend if needed
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
    'Osobní prezentace Jiřího Januše (Dj Nejk) — weby, aplikace, správa, Minecraft pluginy, 3D tisk a hardware projekty.',
    'Personal site of Jiří Januš (Dj Nejk) — websites, web apps, maintenance, Minecraft plugins, 3D printing and hardware projects.'
  ) ?>" />
  <meta name="theme-color" content="#05060a" />

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <style>
    :root{
      --bg0:#000000;
      --bg1:#070810;
      --card: rgba(255,255,255,.04);
      --muted: rgba(255,255,255,.75);
      --muted2: rgba(255,255,255,.58);
      --accent: #6ea8fe;
      --accent2:#9b7bff;
      --border: rgba(255,255,255,.10);
      --shadow: 0 20px 60px rgba(0,0,0,.50);
    }
    body{
      background:
        radial-gradient(900px 650px at 12% 12%, rgba(110,168,254,.12), transparent 55%),
        radial-gradient(900px 650px at 90% 18%, rgba(155,123,255,.10), transparent 55%),
        linear-gradient(180deg, var(--bg0), var(--bg1));
      color:#fff;
    }
    .navbar{
      backdrop-filter: blur(10px);
      background: rgba(0,0,0,.55);
      border-bottom: 1px solid var(--border);
    }
    .brand-badge{
      display:inline-flex; align-items:center; gap:.55rem;
      padding:.35rem .65rem;
      border:1px solid var(--border);
      border-radius:999px;
      background: rgba(255,255,255,.03);
    }
    .hero{ padding-top: 6.5rem; padding-bottom: 2.5rem; }
    .hero-card{
      background: linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.02));
      border:1px solid var(--border);
      border-radius: 1.25rem;
      box-shadow: var(--shadow);
    }
    .pill{
      border:1px solid var(--border);
      background: rgba(255,255,255,.03);
      border-radius:999px;
      padding:.35rem .65rem;
      color:var(--muted);
      font-size:.95rem;
    }
    .section-title{ letter-spacing:.3px; }
    .card-soft{
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 1rem;
      height:100%;
    }
    .muted{ color: var(--muted); }
    .muted2{ color: var(--muted2); }
    a{ color:#fff; }
    a.link-soft{ color: var(--accent); text-decoration: none; }
    a.link-soft:hover{ text-decoration: underline; }
    .tag{
      display:inline-flex; align-items:center;
      padding:.25rem .55rem;
      border-radius:999px;
      border:1px solid var(--border);
      background: rgba(255,255,255,.03);
      font-size:.85rem;
      color: var(--muted);
      margin: .2rem .2rem 0 0;
    }
    .btn-accent{
      background: linear-gradient(90deg, rgba(110,168,254,.95), rgba(155,123,255,.95));
      border:0;
    }
    .btn-accent:hover{ filter: brightness(1.05); }
    .kbd{
      font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
      padding:.05rem .35rem;
      border-radius:.35rem;
      border:1px solid var(--border);
      background: rgba(0,0,0,.35);
      color: var(--muted);
      font-size:.9rem;
    }
    .hr-soft{ border-color: rgba(255,255,255,.10) !important; }

    .profile-wrap{ display:flex; gap: 1.25rem; align-items:center; flex-wrap:wrap; }
    .profile-img{
      width: 108px; height: 108px; border-radius: 18px; object-fit: cover;
      border: 1px solid var(--border);
      box-shadow: 0 12px 35px rgba(0,0,0,.55);
      background: rgba(255,255,255,.03);
    }
    .gallery-item{
      border:1px solid var(--border);
      border-radius: .9rem;
      overflow:hidden;
      background: rgba(255,255,255,.03);
      cursor:pointer;
      height: 180px;
      display:flex;
      align-items:center;
      justify-content:center;
      color: var(--muted2);
    }
    .gallery-item:hover{ border-color: rgba(110,168,254,.35); }
    .footer{
      border-top:1px solid var(--border);
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
          <li class="nav-item"><a class="nav-link text-white-50" href="#services"><?= t('Služby', 'Services') ?></a></li>
          <li class="nav-item"><a class="nav-link text-white-50" href="#skills"><?= t('Dovednosti', 'Skills') ?></a></li>
          <li class="nav-item"><a class="nav-link text-white-50" href="#projects"><?= t('Reference', 'Work') ?></a></li>
          <li class="nav-item"><a class="nav-link text-white-50" href="#gallery"><?= t('Galerie', 'Gallery') ?></a></li>
          <li class="nav-item"><a class="nav-link text-white-50" href="#contact"><?= t('Kontakt', 'Contact') ?></a></li>

          <li class="nav-item ms-lg-2">
            <div class="btn-group" role="group" aria-label="Language switcher">
              <a class="btn btn-sm btn-outline-light <?= $lang==='cs'?'active':'' ?>" href="<?= lang_url('cs') ?>">CZ</a>
              <a class="btn btn-sm btn-outline-light <?= $lang==='en'?'active':'' ?>" href="<?= lang_url('en') ?>">EN</a>
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
                  <span class="pill"><i class="bi bi-mortarboard me-1"></i><?= t('Elektrotechnika • SPŠ/SOŠ/SOU HK', 'Electrical Engineering • Technical High School (HK)') ?></span>
                  <span class="pill"><i class="bi bi-calendar3 me-1"></i><?= t('Věk:', 'Age:') ?> <span id="age"></span></span>
                </div>

                <h1 class="display-6 fw-semibold mb-1">
                  <?= t('Ahoj, jsem', 'Hi, I’m') ?>
                  <span class="text-white">Jiří Januš</span>
                  <span class="muted2">(<?= t('přezdívka', 'nickname') ?> Dj Nejk)</span>
                </h1>
                <div class="muted2">jiri.janus@djdevs.eu • +420 730 596 072</div>
              </div>
            </div>

            <p class="lead muted mb-4">
              <?= t(
                'Developer zaměřený na webové prezentace a aplikace. Dělám i Minecraft pluginy, hardware projekty a 3D tisk.',
                'A developer focused on websites and web apps. I also build Minecraft plugins, hardware projects, and do 3D printing.'
              ) ?>
            </p>

            <div class="d-flex flex-wrap gap-2">
              <a class="btn btn-accent text-dark fw-semibold" href="#projects">
                <i class="bi bi-lightning-charge"></i>
                <span class="ms-1"><?= t('Moje práce', 'My work') ?></span>
              </a>
              <a class="btn btn-outline-light" href="#services">
                <i class="bi bi-briefcase"></i>
                <span class="ms-1"><?= t('Služby', 'Services') ?></span>
              </a>
              <a class="btn btn-outline-light" href="#contact">
                <i class="bi bi-envelope"></i>
                <span class="ms-1"><?= t('Kontakt', 'Contact') ?></span>
              </a>
            </div>

            <div class="mt-4 muted2">
              <span class="kbd">Bootstrap</span> <span class="mx-1">+</span>
              <span class="kbd">jQuery</span> <span class="mx-1">+</span>
              <span class="kbd">PHP</span> <span class="mx-1">+</span>
              <span class="kbd">JS</span>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card-soft p-4 p-md-5 h-100">
            <h2 class="h5 fw-semibold section-title mb-3"><?= t('Rychlý přehled', 'Quick overview') ?></h2>

            <div class="d-grid gap-3">
              <div class="d-flex gap-3">
                <div class="fs-4"><i class="bi bi-code-square"></i></div>
                <div>
                  <div class="fw-semibold"><?= t('Web & aplikace', 'Web & apps') ?></div>
                  <div class="muted2"><?= t('HTML/CSS/JS/PHP + Bootstrap + jQuery. Umím i Java, C++, C#.', 'HTML/CSS/JS/PHP + Bootstrap + jQuery. Also Java, C++, C#.') ?></div>
                </div>
              </div>

              <div class="d-flex gap-3">
                <div class="fs-4"><i class="bi bi-hdd-network"></i></div>
                <div>
                  <div class="fw-semibold"><?= t('MHD informační panely', 'Public transport displays') ?></div>
                  <div class="muted2"><?= t('Výroba a vývoj vlastního ovladače informačních panelů z MHD.', 'Designing and developing my own controller for public transport information panels.') ?></div>
                </div>
              </div>

              <div class="d-flex gap-3">
                <div class="fs-4"><i class="bi bi-printer"></i></div>
                <div>
                  <div class="fw-semibold"><?= t('3D tisk', '3D printing') ?></div>
                  <div class="muted2"><?= t('2× Ender S1 + upravená CR-10 (32bit).', '2× Ender S1 + a modified CR-10 (32-bit).') ?></div>
                </div>
              </div>

              <hr class="hr-soft my-1">

              <div class="d-flex flex-wrap gap-2">
                <a class="btn btn-sm btn-outline-light" href="https://www.spigotmc.org/resources/mysql-commands.123854/" target="_blank" rel="noreferrer">
                  <i class="bi bi-boxes"></i><span class="ms-1"><?= t('Spigot plugin', 'Spigot plugin') ?></span>
                </a>
                <a class="btn btn-sm btn-outline-light" href="https://www.instagram.com/djnejk/" target="_blank" rel="noreferrer">
                  <i class="bi bi-instagram"></i><span class="ms-1">Instagram</span>
                </a>
                <a class="btn btn-sm btn-outline-light" href="https://www.facebook.com/nejkdj/" target="_blank" rel="noreferrer">
                  <i class="bi bi-facebook"></i><span class="ms-1">Facebook</span>
                </a>
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
      <div class="row g-4">
        <div class="col-lg-6">
          <div class="card-soft p-4 p-md-5">
            <h2 class="h4 fw-semibold section-title mb-3"><?= t('O mně', 'About me') ?></h2>
            <p class="muted mb-3">
              <?= t(
                'Jmenuju se Jiří Januš a pocházím z Královehradeckého kraje. Mám vystudovanou technickou střední školu se zaměřením na elektrotechniku (SPŠ/SOŠ/SOU Hradec Králové).',
                'My name is Jiří Januš and I’m from the Hradec Králové Region (Czechia). I graduated from a technical secondary school focused on electrical engineering (SPŠ/SOŠ/SOU Hradec Králové).'
              ) ?>
            </p>
            <p class="muted mb-0">
              <?= t(
                'Baví mě vývoj webů a aplikací, ale taky projekty kolem hardware a 3D tisku — rád propojuju software s reálným světem.',
                'I enjoy building websites and web apps, and I also love hardware and 3D printing projects — I like connecting software with the real world.'
              ) ?>
            </p>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card-soft p-4 p-md-5">
            <h3 class="h5 fw-semibold mb-3"><?= t('Základní informace', 'Key facts') ?></h3>
            <ul class="list-unstyled mb-0 muted">
              <li class="mb-2"><i class="bi bi-person-badge me-2"></i><?= t('Věk se počítá automaticky podle data narození (22. 3. 2006).', 'Age is calculated automatically from date of birth (22 Mar 2006).') ?></li>
              <li class="mb-2"><i class="bi bi-geo me-2"></i><?= t('Původ: Královehradecký kraj.', 'Based in: Hradec Králové Region.') ?></li>
              <li class="mb-2"><i class="bi bi-mortarboard me-2"></i><?= t('Škola: SPŠ/SOŠ/SOU Hradec Králové (elektrotechnika).', 'Education: SPŠ/SOŠ/SOU Hradec Králové (Electrical engineering).') ?></li>
              <li class="mb-2"><i class="bi bi-layers me-2"></i><?= t('Zaměření: weby, webové aplikace, pluginy, automatizace.', 'Focus: websites, web apps, plugins, automation.') ?></li>
              <li class="mb-0"><i class="bi bi-wrench-adjustable me-2"></i><?= t('Další: MHD info panely (vlastní ovladač), 3D tisk.', 'Also: public transport panels (custom controller), 3D printing.') ?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SERVICES -->
  <section id="services" class="py-5">
    <div class="container">
      <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-3">
        <h2 class="h4 fw-semibold section-title mb-0"><?= t('Nabízím služby', 'Services') ?></h2>
        <div class="muted2"><?= t('Co ti můžu dodat / s čím pomoct.', 'What I can deliver / help with.') ?></div>
      </div>

      <div class="row g-4">
        <div class="col-md-6 col-lg-3">
          <div class="card-soft p-4 h-100">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-globe2 fs-4"></i>
              <div class="fw-semibold"><?= t('Weby', 'Websites') ?></div>
            </div>
            <p class="muted2 mb-0"><?= t('Moderní webové prezentace (Bootstrap), responzivní design, základní SEO.', 'Modern responsive websites (Bootstrap), clean UI, basic SEO.') ?></p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3">
          <div class="card-soft p-4 h-100">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-window-stack fs-4"></i>
              <div class="fw-semibold"><?= t('Aplikace', 'Web apps') ?></div>
            </div>
            <p class="muted2 mb-0"><?= t('Webové aplikace (PHP/JS), formuláře, registrace, administrace, databáze.', 'Web applications (PHP/JS), forms, registrations, admin panels, databases.') ?></p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3">
          <div class="card-soft p-4 h-100">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-shield-check fs-4"></i>
              <div class="fw-semibold"><?= t('Správa', 'Maintenance') ?></div>
            </div>
            <p class="muted2 mb-0"><?= t('Nasazení, údržba, úpravy, optimalizace, domény/hosting, backupy.', 'Deployment, updates, improvements, hosting/domains, backups.') ?></p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3">
          <div class="card-soft p-4 h-100">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-boxes fs-4"></i>
              <div class="fw-semibold"><?= t('MC pluginy', 'MC plugins') ?></div>
            </div>
            <p class="muted2 mb-0"><?= t('Pluginy na míru (Spigot), napojení na databázi, config, permissions.', 'Custom Spigot plugins, database integration, configs, permissions.') ?></p>
          </div>
        </div>
      </div>

      <div class="mt-4 card-soft p-4 p-md-5">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
          <div>
            <div class="fw-semibold"><?= t('Chceš web, aplikaci nebo plugin?', 'Need a website, app, or a plugin?') ?></div>
            <div class="muted2"><?= t('Napiš mi pár detailů a domluvíme se na řešení.', 'Send me a few details and we’ll figure out the right solution.') ?></div>
          </div>
          <a class="btn btn-accent text-dark fw-semibold" href="#contact">
            <i class="bi bi-send"></i><span class="ms-1"><?= t('Kontaktovat', 'Contact') ?></span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- SKILLS -->
  <section id="skills" class="py-5">
    <div class="container">
      <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-3">
        <h2 class="h4 fw-semibold section-title mb-0"><?= t('Dovednosti', 'Skills') ?></h2>
        <div class="muted2"><?= t('Stack, se kterým reálně pracuju.', 'Tools and stack I actually use.') ?></div>
      </div>

      <div class="row g-4">
        <div class="col-md-6 col-lg-4">
          <div class="card-soft p-4 h-100">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-braces fs-4"></i>
              <div class="fw-semibold"><?= t('Programovací jazyky', 'Languages') ?></div>
            </div>
            <div id="tagsLangs"></div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card-soft p-4 h-100">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-window fs-4"></i>
              <div class="fw-semibold"><?= t('Web stack', 'Web stack') ?></div>
            </div>
            <div id="tagsWeb"></div>
          </div>
        </div>

        <div class="col-md-12 col-lg-4">
          <div class="card-soft p-4 h-100">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-tools fs-4"></i>
              <div class="fw-semibold"><?= t('Nástroje', 'Tools') ?></div>
            </div>
            <div id="tagsTools"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- PROJECTS -->
  <section id="projects" class="py-5">
    <div class="container">
      <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-3">
        <h2 class="h4 fw-semibold section-title mb-0"><?= t('Reference a projekty', 'Work & projects') ?></h2>
        <div class="muted2"><?= t('Výběr veřejných věcí, na kterých jsem pracoval.', 'A selection of public work I’ve done.') ?></div>
      </div>

      <div class="row g-4">
        <?php
          $cards = [
            [
              'icon' => 'bi-building',
              'title' => 'obeclibrice.cz',
              'text' => [ 'Webová prezentace a aplikace pro Obec Libřice.', 'Website and web application for the municipality of Libřice.' ],
              'url'  => 'https://obeclibrice.cz/',
            ],
            [
              'icon' => 'bi-tree',
              'title' => 'runforplanet.cz',
              'text' => [ 'Webová prezentace projektu na ochranu přírody — charitativní běhy Run For Planet.', 'Website for a nature-protection project — charity runs Run For Planet.' ],
              'url'  => 'https://www.runforplanet.cz/',
            ],
            [
              'icon' => 'bi-ui-checks',
              'title' => 'dsb.runforplanet.cz',
              'text' => [ 'Webová aplikace pro online registraci na charitativní běhy.', 'Web app for online registration for charity runs.' ],
              'url'  => 'https://dsb.runforplanet.cz/',
            ],
            [
              'icon' => 'bi-film',
              'title' => 'filmypodhvezdami.cz',
              'text' => [ 'Webová prezentace projektu Filmy pod Hvězdami.', 'Website for the “Filmy pod Hvězdami” project.' ],
              'url'  => 'http://filmypodhvezdami.cz/',
            ],
          ];
          foreach ($cards as $c):
        ?>
        <div class="col-md-6 col-lg-3">
          <div class="card-soft p-4">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi <?= htmlspecialchars($c['icon']) ?> fs-4"></i>
              <div class="fw-semibold"><?= htmlspecialchars($c['title']) ?></div>
            </div>
            <p class="muted2 mb-3"><?= t($c['text'][0], $c['text'][1]) ?></p>
            <a class="link-soft" href="<?= htmlspecialchars($c['url']) ?>" target="_blank" rel="noreferrer">
              <i class="bi bi-box-arrow-up-right me-1"></i><?= t('Otevřít', 'Open') ?>
            </a>
          </div>
        </div>
        <?php endforeach; ?>

        <div class="col-md-6 col-lg-6">
          <div class="card-soft p-4 h-100">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-boxes fs-4"></i>
              <div class="fw-semibold"><?= t('Minecraft pluginy (Spigot)', 'Minecraft plugins (Spigot)') ?></div>
            </div>
            <p class="muted2 mb-2"><?= t('Plugin: MySQL Commands (SpigotMC).', 'Plugin: MySQL Commands (SpigotMC).') ?></p>
            <a class="link-soft" href="https://www.spigotmc.org/resources/mysql-commands.123854/" target="_blank" rel="noreferrer">
              <i class="bi bi-box-arrow-up-right me-1"></i><?= t('Otevřít', 'Open') ?>
            </a>
          </div>
        </div>

        <div class="col-md-6 col-lg-6">
          <div class="card-soft p-4 h-100">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-cpu fs-4"></i>
              <div class="fw-semibold"><?= t('Ovladač informačních panelů (MHD)', 'Information panel controller (public transport)') ?></div>
            </div>
            <p class="muted2 mb-0"><?= t(
              'Vyvíjím vlastní ovladač pro informační panely z MHD — od elektroniky až po software.',
              'I’m developing my own controller for public transport information panels — electronics + software.'
            ) ?></p>
          </div>
        </div>

        <div class="col-12">
          <div class="card-soft p-4 p-md-5">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-printer fs-4"></i>
              <div class="fw-semibold"><?= t('3D tisk', '3D printing') ?></div>
            </div>
            <p class="muted2 mb-3"><?= t(
              'Tisknu prototypy i velké projekty. Největší projekt: tisk sochy pro youtubera MenT v životní velikosti (fotky v galerii).',
              'From prototypes to large builds. Biggest project: a life-size statue print for YouTuber MenT (see gallery).'
            ) ?></p>
            <div class="d-flex flex-wrap gap-2">
              <span class="tag">2× Creality Ender S1</span>
              <span class="tag">CR-10 (32-bit mod)</span>
              <span class="tag"><?= t('Socha MenT — 1:1', 'MenT statue — 1:1') ?></span>
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
        <div class="muted2"><?= t('Nahraj fotky do složky assets a uprav názvy.', 'Upload photos into the assets folder and adjust filenames.') ?></div>
      </div>

      <div class="row g-3">
        <?php
          $gallery = [
            [ 'file' => 'assets/mhd-panel-1.jpg', 'label' => ['MHD panel / ovladač', 'Display / controller'], 'caption' => ['MHD ovladač — prototyp', 'Display controller — prototype'] ],
            [ 'file' => 'assets/mhd-panel-2.jpg', 'label' => ['MHD panel / ovladač', 'Display / controller'], 'caption' => ['MHD ovladač — detail', 'Display controller — details'] ],
            [ 'file' => 'assets/3d-ment-1.jpg',    'label' => ['MenT — 3D tisk', 'MenT — 3D print'],        'caption' => ['MenT socha — tisk', 'MenT statue — printing'] ],
            [ 'file' => 'assets/3d-ment-2.jpg',    'label' => ['MenT — 3D tisk', 'MenT — 3D print'],        'caption' => ['MenT socha — hotovo', 'MenT statue — finished'] ],
          ];
          foreach ($gallery as $g):
        ?>
        <div class="col-6 col-lg-3">
          <div class="gallery-item"
               data-bs-toggle="modal"
               data-bs-target="#imgModal"
               data-img="<?= htmlspecialchars($g['file']) ?>"
               data-caption="<?= htmlspecialchars(t($g['caption'][0], $g['caption'][1])) ?>">
            <span class="text-center px-3">
              <i class="bi <?= str_contains($g['file'], 'mhd') ? 'bi-hdd-network' : 'bi-printer' ?> me-1"></i>
              <?= t($g['label'][0], $g['label'][1]) ?>
            </span>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="mt-3 muted2">
        <?= t('Tip: Profilovku dej jako assets/profile.jpg (ideálně čtverec, min. 600×600).',
              'Tip: Put your profile photo as assets/profile.jpg (square recommended, min 600×600).') ?>
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
            <p class="muted mb-4"><?= t('Chceš web, aplikaci nebo plugin? Napiš mi a domluvíme se.', 'Need a website, web app, or a plugin? Send me a message.') ?></p>

            <div class="d-grid gap-3">
              <div class="d-flex align-items-center gap-3">
                <div class="fs-4"><i class="bi bi-envelope"></i></div>
                <div>
                  <div class="muted2"><?= t('E-mail', 'Email') ?></div>
                  <a class="link-soft" href="mailto:jiri.janus@djdevs.eu">jiri.janus@djdevs.eu</a>
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
            <h3 class="h5 fw-semibold mb-3"><?= t('Spolupráce', 'Collaboration') ?></h3>
            <p class="muted mb-3">
              <?= t(
                'Můžu pomoct s návrhem a realizací webu, aplikace, správou nebo custom řešením (registrace, formuláře, API, pluginy).',
                'I can help with building a website/app, maintenance, and custom solutions (registrations, forms, API integrations, plugins).'
              ) ?>
            </p>

            <div class="muted2 mb-3"><?= t('Typicky dodám:', 'Typically delivered:') ?></div>
            <ul class="muted mb-0">
              <li><?= t('responzivní web (Bootstrap) + základní SEO', 'responsive website (Bootstrap) + basic SEO') ?></li>
              <li><?= t('webovou aplikaci (PHP/JS) + DB podle potřeby', 'web app (PHP/JS) + database when needed') ?></li>
              <li><?= t('nasazení a jednoduchou údržbu', 'deployment and simple maintenance') ?></li>
            </ul>

            <hr class="hr-soft my-4">

            <div class="muted2"><?= t('Rychlé tagy (co dělám):', 'Quick tags (what I do):') ?></div>
            <div class="d-flex flex-wrap gap-2 mt-2">
              <span class="tag"><?= t('weby', 'websites') ?></span>
              <span class="tag"><?= t('aplikace', 'web apps') ?></span>
              <span class="tag"><?= t('správa', 'maintenance') ?></span>
              <span class="tag"><?= t('MC pluginy', 'MC plugins') ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
      <div>© <span id="year"></span> djdevs.eu</div>
      <div class="muted2"><?= t('Děláno s', 'Made with') ?> <i class="bi bi-heart-fill"></i> <?= t('Bootstrap + jQuery', 'Bootstrap + jQuery') ?></div>
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
          <div class="muted2 mt-2"><?= t('Tip: Pokud se obrázek nenačte, nahraj ho do složky assets a zkontroluj název souboru.', 'Tip: If the image doesn’t load, upload it to the assets folder and verify the filename.') ?></div>
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

    document.getElementById("age").textContent = calculateAge(DOB);
    document.getElementById("year").textContent = new Date().getFullYear();

    // Tags
    const tagSets = {
      langs: ["HTML", "CSS", "JavaScript", "PHP", "Java", "C++", "C#"],
      web: ["Bootstrap", "jQuery", "REST/API", "MySQL", "Responsive UI"],
      tools: ["VS Code", "Visual Studio", "IntelliJ IDEA", "Synology tools", "Adobe"]
    };

    function renderTags(containerId, arr){
      const el = document.getElementById(containerId);
      if (!el) return;
      el.innerHTML = arr.map(x => `<span class="tag">${x}</span>`).join("");
    }

    // Inject skills tags into the three boxes (simple: create boxes if missing)
    // We already have containers #tagsLangs/#tagsWeb/#tagsTools in HTML,
    // but in this PHP version they are present above.
    renderTags("tagsLangs", tagSets.langs);
    renderTags("tagsWeb", tagSets.web);
    renderTags("tagsTools", tagSets.tools);

    // Smooth scroll
    $('a[href^="#"]').on("click", function(e){
      const target = $(this.getAttribute("href"));
      if (target.length){
        e.preventDefault();
        const top = target.offset().top - 76;
        $("html, body").animate({ scrollTop: top }, 450);
      }
    });

    // Gallery modal
    $("#imgModal").on("show.bs.modal", function (e) {
      const trigger = e.relatedTarget;
      const img = trigger.getAttribute("data-img");
      const caption = trigger.getAttribute("data-caption") || "";
      $("#imgModalEl").attr("src", img);
      $("#imgModalCaption").text(caption);
    });
  </script>
</body>
</html>
