@php
  $__themeCookie = Cookie::get('theme_mode', $general->default_theme_mode ?? 'theme-light');
  $__isThemeDark = ($__themeCookie === 'theme-dark');
@endphp
<!doctype html>
<html lang="{{ app()->getLocale() }}" class="{{ $__isThemeDark ? 'dark theme-dark' : 'light theme-light' }}" id="html-root">
<head>
  <script>
    (function(){
      try {
        var s = localStorage.getItem('site_theme') || localStorage.getItem('preview_theme');
        if (s === 'dark' || (!s && {{ $__isThemeDark ? 'true' : 'false' }})) {
          document.documentElement.classList.add('dark', 'theme-dark');
          document.documentElement.classList.remove('light', 'theme-light');
        } else if (s === 'light') {
          document.documentElement.classList.add('light', 'theme-light');
          document.documentElement.classList.remove('dark', 'theme-dark');
        }
      } catch(e) {}
    })();
  </script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  @php
    \Artesaos\SEOTools\Facades\SEOMeta::setTitle(__('Free SEO Tools for Backlinks, Websites & YouTube | FXN SEO'));
    \Artesaos\SEOTools\Facades\SEOMeta::setDescription(__('Check backlinks, inspect website metadata, trace redirects and research YouTube videos with free SEO tools and practical guides from FXN SEO.'));
    \Artesaos\SEOTools\Facades\SEOMeta::setCanonical(route('home'));
  @endphp
  @include('partials.meta-manager')
  @include('partials.seo-structured-data')
  @include('partials.hreflang')
  <link rel="preload" href="{{ asset('assets/fonts/google/inter-variable.woff2') }}" as="font" type="font/woff2" crossorigin>
  <link rel="icon" href="{{ asset('assets/img/favicon.svg') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/google-fonts-local.css') }}">
  <style>
    /* CSS Variables for Light Mode (Default) */
    :root, html.light {
      --font-family: var(--site-font-family);
      --bg: #f8fafc;
      --bg-surface: #ffffff;
      --bg-card: #ffffff;
      --bg-card-hover: #ffffff;
      --bg-alt: #f1f5f9;
      --border: #e2e8f0;
      --border-light: #edf2f7;
      --border-focus: rgba(108, 134, 245, 0.4);
      --text: #0f172a;
      --text-muted: #475569;
      --text-subtle: #64748b;
      --emerald: #2447e0;
      --emerald-dark: #1b38b8;
      --emerald-glow: rgba(36, 71, 224, 0.18);
      --emerald-soft: rgba(36, 71, 224, 0.08);
      --cyan: #0284c7;
      --indigo: #4f46e5;
      --amber: #d97706;
      --amber-soft: rgba(217, 119, 6, 0.1);
      --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.05);
      --shadow-md: 0 4px 20px -2px rgba(15, 23, 42, 0.06), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
      --shadow-lg: 0 20px 35px -8px rgba(15, 23, 42, 0.09), 0 1px 3px rgba(15, 23, 42, 0.05);
      --shadow-xl: 0 25px 60px -15px rgba(15, 23, 42, 0.12);
      --nav-bg: rgba(255, 255, 255, 0.92);
      --orb-opacity: 0.15;
    }

    /* Dark Mode Overrides (nxtsmarthome.com.au extracted color scheme) */
    html.dark {
      --font-family: var(--site-font-family);
      --bg: #151616;
      --bg-surface: #222324;
      --bg-card: rgba(34, 35, 36, 0.85);
      --bg-card-hover: rgba(41, 42, 44, 0.95);
      --bg-alt: #1f2937;
      --border: #313131;
      --border-light: rgba(255, 255, 255, 0.08);
      --border-focus: #8ba2ff;
      --text: #ffffff;
      --text-muted: #9ca3af;
      --text-subtle: #6b7280;
      --emerald: #6c86f5;
      --emerald-dark: #2447e0;
      --emerald-glow: rgba(108, 134, 245, 0.22);
      --emerald-soft: rgba(108, 134, 245, 0.12);
      --brand: #8ba2ff;
      --brand-hover: #6c86f5;
      --cyan: #38bdf8;
      --indigo: #8ba2ff;
      --amber: #ff9b1a;
      --amber-soft: rgba(255, 155, 26, 0.15);
      --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.35);
      --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.45);
      --shadow-lg: 0 16px 40px rgba(0, 0, 0, 0.55);
      --shadow-xl: 0 25px 60px rgba(0, 0, 0, 0.65);
      --nav-bg: rgba(21, 22, 22, 0.92);
      --footer-bg: #0d0f10;
      --orb-opacity: 0.18;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; font-family: inherit; }
    html { scroll-behavior: smooth; overflow-x: clip; }
    body {
      position: relative;
      overflow-x: clip;
      background: var(--bg);
      color: var(--text);
      font-family: var(--font-family);
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
      transition: background-color 0.3s ease, color 0.3s ease;
    }
    h1, h2, h3, h4, h5, h6, button, input, select, textarea {
      font-family: var(--font-family);
    }
    a { color: inherit; text-decoration: none; }
    .wrap { width: min(1280px, calc(100% - 48px)); margin: 0 auto; }

    .ambient-effects { position: absolute; inset: 0; overflow: clip; pointer-events: none; }

    /* Ambient Decorative Gradient Orbs */
    .ambient-glow {
      position: absolute;
      width: 750px;
      height: 750px;
      border-radius: 50%;
      pointer-events: none;
      z-index: 0;
      filter: blur(40px);
      opacity: var(--orb-opacity);
      animation: float 18s ease-in-out infinite alternate;
      transition: opacity 0.3s;
    }
    .glow-1 { top: -220px; left: 12%; background: radial-gradient(circle, #6c86f5 0%, transparent 70%); }
    .glow-2 { top: 380px; right: -120px; background: radial-gradient(circle, #38bdf8 0%, transparent 70%); animation-delay: -6s; }
    .glow-3 { top: 1300px; left: -140px; background: radial-gradient(circle, #6366f1 0%, transparent 70%); animation-delay: -11s; }
    @keyframes float {
      0% { transform: translate(0, 0) scale(1); }
      100% { transform: translate(50px, 35px) scale(1.08); }
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      font-size: 14px;
      font-weight: 700;
      padding: 10px 20px;
      border-radius: 12px;
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
      cursor: pointer;
      border: 1px solid transparent;
      white-space: nowrap;
    }
    .btn-ghost {
      color: var(--text);
      background: var(--bg-surface);
      border-color: var(--border);
      box-shadow: var(--shadow-sm);
    }
    .btn-ghost:hover {
      background: var(--bg-alt);
      border-color: var(--emerald);
      transform: translateY(-1px);
    }
    .btn-primary {
      background: linear-gradient(135deg, #6c86f5 0%, #2447e0 100%);
      color: #ffffff;
      font-weight: 800;
      box-shadow: 0 4px 18px var(--emerald-glow);
    }
    .btn-primary:hover {
      box-shadow: 0 8px 25px rgba(108, 134, 245, 0.4);
      transform: translateY(-2px);
      filter: brightness(1.04);
    }

    /* Hero Section */
    .hero-section {
      position: relative;
      padding: 90px 0 100px;
      overflow: hidden;
      border-bottom: 1px solid var(--border);
      background: radial-gradient(ellipse at 50% 0%, rgba(108, 134, 245, 0.08) 0%, transparent 65%),
                  linear-gradient(180deg, rgba(248, 250, 252, 0.8) 0%, var(--bg) 100%);
    }
    html.dark .hero-section,
    body.theme-dark .hero-section {
      background: radial-gradient(ellipse at 50% 0%, rgba(108, 134, 245, 0.12) 0%, transparent 65%),
                  linear-gradient(180deg, rgba(29, 30, 32, 0.85) 0%, var(--bg) 100%);
    }
    .hero-content {
      text-align: center;
      max-width: 920px;
      margin: 0 auto;
      position: relative;
      z-index: 2;
    }
    .hero-pill {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 7px 18px;
      border-radius: 999px;
      background: var(--bg-surface);
      border: 1px solid rgba(36, 71, 224, 0.3);
      color: var(--emerald);
      font-size: 12px;
      font-weight: 800;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      margin-bottom: 24px;
      box-shadow: 0 2px 12px var(--emerald-soft);
    }
    .pulse-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--emerald);
      box-shadow: 0 0 10px var(--emerald);
      animation: pulse 2s infinite;
    }
    @keyframes pulse {
      0%, 100% { opacity: 1; transform: scale(1); }
      50% { opacity: 0.4; transform: scale(0.8); }
    }
    .hero-title {
      font-family: var(--font-family);
      font-size: clamp(44px, 6.2vw, 76px);
      font-weight: 800 !important;
      line-height: 1.05;
      letter-spacing: -0.035em;
      margin-bottom: 24px;
      color: var(--text);
    }
    .hero-gradient-text {
      background: linear-gradient(135deg, #0f172a 15%, var(--emerald) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    html.dark .hero-gradient-text {
      background: linear-gradient(135deg, #ffffff 20%, #9ca3af 60%, var(--emerald) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .hero-desc {
      font-size: clamp(17px, 2vw, 20px);
      color: var(--text-muted);
      line-height: 1.65;
      max-width: 760px;
      margin: 0 auto 38px;
    }

    /* Hero Quick Launcher */
    .hero-launcher {
      background: var(--bg-surface);
      border: 1px solid var(--border);
      border-radius: 24px;
      padding: 10px;
      max-width: 780px;
      margin: 0 auto 44px;
      box-shadow: var(--shadow-xl);
      transition: all 0.3s;
    }
    .launcher-tabs {
      display: flex;
      gap: 6px;
      padding: 6px;
      border-bottom: 1px solid var(--border-light);
      overflow-x: auto;
    }
    .launcher-tab {
      padding: 8px 16px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      color: var(--text-muted);
      cursor: pointer;
      border: none;
      background: transparent;
      transition: all 0.2s;
      white-space: nowrap;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .launcher-tab.active {
      background: var(--bg-alt);
      color: var(--text);
      box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }
    .launcher-tab:hover:not(.active) {
      color: var(--text);
    }
    .launcher-form {
      display: flex;
      align-items: center;
      padding: 8px 8px 8px 16px;
      gap: 12px;
    }
    .launcher-icon {
      color: var(--emerald);
      font-size: 18px;
      display: flex;
      align-items: center;
    }
    .launcher-input {
      flex: 1;
      background: transparent;
      border: none;
      outline: none;
      color: var(--text);
      font-size: 16px;
      font-family: inherit;
      min-width: 180px;
    }
    .launcher-input::placeholder {
      color: var(--text-subtle);
    }

    /* Trust Stats */
    .hero-stats {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 40px;
      flex-wrap: wrap;
    }
    .stat-item {
      display: flex;
      align-items: center;
      gap: 12px;
      text-align: left;
    }
    .stat-number {
      font-family: var(--font-family);
      font-size: 26px;
      font-weight: 800;
      color: var(--text);
      line-height: 1;
    }
    .stat-number span { color: var(--emerald); }
    .stat-label {
      font-size: 12px;
      color: var(--text-muted);
      line-height: 1.35;
      font-weight: 500;
    }

    /* AdSense Responsive Slot Wrapper */
    .ad-container-slot {
      margin: 40px auto;
      max-width: 970px;
      padding: 12px;
      background: var(--bg-surface);
      border: 1px dashed var(--border);
      border-radius: 12px;
      text-align: center;
      color: var(--text-subtle);
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      box-shadow: var(--shadow-sm);
    }
    .ad-container-slot-inner {
      min-height: 90px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--bg-alt);
      border-radius: 8px;
      color: var(--text-subtle);
    }

    /* Tools Explorer Section */
    .section-tools {
      padding: 95px 0 60px;
      position: relative;
    }
    .section-head-bar {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      gap: 30px;
      margin-bottom: 36px;
      flex-wrap: wrap;
    }
    .section-kicker {
      font-size: 12px;
      font-weight: 800;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--emerald);
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 10px;
    }
    .section-title {
      font-family: var(--font-family);
      font-size: clamp(30px, 3.8vw, 44px);
      font-weight: 800;
      color: var(--text);
      line-height: 1.15;
    }
    .section-subtitle {
      color: var(--text-muted);
      font-size: 16px;
      max-width: 580px;
    }

    /* Filter Bar & Live Search */
    .filter-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 20px;
      margin-bottom: 32px;
      flex-wrap: wrap;
    }
    .category-pills {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
    }
    .category-pill {
      padding: 8px 18px;
      border-radius: 999px;
      font-size: 13px;
      font-weight: 700;
      background: var(--bg-surface);
      border: 1px solid var(--border);
      color: var(--text-muted);
      cursor: pointer;
      transition: all 0.2s;
      box-shadow: var(--shadow-sm);
    }
    .category-pill:hover {
      background: var(--bg-alt);
      color: var(--text);
      border-color: var(--emerald);
    }
    .category-pill.active {
      background: var(--emerald);
      color: #ffffff;
      border-color: var(--emerald);
      font-weight: 800;
      box-shadow: 0 4px 15px rgba(108, 134, 245, 0.3);
    }
    .search-input-box {
      position: relative;
      min-width: 280px;
      max-width: 380px;
      flex: 1;
    }
    .search-input-box input {
      width: 100%;
      background: var(--bg-surface);
      border: 1px solid var(--border);
      border-radius: 999px;
      padding: 10px 18px 10px 42px;
      color: var(--text);
      font-size: 14px;
      font-family: inherit;
      outline: none;
      transition: all 0.2s;
      box-shadow: var(--shadow-sm);
    }
    .search-input-box input:focus {
      border-color: var(--emerald);
      box-shadow: 0 0 0 3px rgba(108, 134, 245, 0.15);
    }
    .search-icon {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-subtle);
      font-size: 14px;
      pointer-events: none;
    }

    /* Tool Cards Grid */
    .tools-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 20px;
    }
    .tool-card {
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 24px;
      display: flex;
      flex-direction: column;
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
      position: relative;
      overflow: hidden;
      box-shadow: var(--shadow-md);
    }
    .tool-card:hover {
      border-color: rgba(108, 134, 245, 0.5);
      transform: translateY(-4px);
      box-shadow: var(--shadow-lg);
    }
    .card-top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 16px;
    }
    .tool-icon-wrap {
      width: 48px;
      height: 48px;
      border-radius: 14px;
      background: var(--emerald-soft);
      border: 1px solid rgba(36, 71, 224, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      color: var(--emerald);
    }
    .tool-icon-wrap img {
      width: 26px;
      height: 26px;
      object-fit: contain;
    }
    .card-tag {
      font-size: 10px;
      font-weight: 800;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      padding: 4px 10px;
      border-radius: 999px;
      background: var(--bg-alt);
      color: var(--text-muted);
      border: 1px solid var(--border);
    }
    .card-tag.tag-pop {
      background: #fef3c7;
      color: #b45309;
      border-color: #fde68a;
    }
    html.dark .card-tag.tag-pop {
      background: rgba(245, 158, 11, 0.15);
      color: #fbbf24;
      border-color: rgba(245, 158, 11, 0.3);
    }
    .card-tag.tag-yt {
      background: #fee2e2;
      color: #dc2626;
      border-color: #fecaca;
    }
    html.dark .card-tag.tag-yt {
      background: rgba(239, 68, 68, 0.15);
      color: #f87171;
      border-color: rgba(239, 68, 68, 0.3);
    }
    .card-tag.tag-moz {
      background: #e0f2fe;
      color: #0369a1;
      border-color: #bae6fd;
    }
    html.dark .card-tag.tag-moz {
      background: rgba(6, 182, 212, 0.15);
      color: var(--cyan);
      border-color: rgba(6, 182, 212, 0.3);
    }
    .tool-title {
      font-family: var(--font-family);
      font-size: 19px;
      font-weight: 700;
      color: var(--text);
      margin-bottom: 8px;
      line-height: 1.3;
    }
    .tool-desc {
      font-size: 14px;
      color: var(--text-muted);
      line-height: 1.55;
      margin-bottom: 20px;
      flex-grow: 1;
    }
    .card-bottom {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-top: 1px solid var(--border-light);
      padding-top: 14px;
      font-size: 13px;
      font-weight: 700;
      color: var(--emerald);
    }
    .card-arrow {
      transition: transform 0.2s;
    }
    .tool-card:hover .card-arrow {
      transform: translateX(4px);
    }

    /* Editorial Authority & Search Standards Section (AdSense Crucial) */
    .section-editorial {
      padding: 90px 0;
      border-top: 1px solid var(--border);
      background: var(--bg-surface);
    }
    .editorial-header {
      max-width: 820px;
      margin: 0 auto 50px;
      text-align: center;
    }
    .editorial-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 32px;
    }
    .editorial-block {
      background: var(--bg);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 36px 32px;
      box-shadow: var(--shadow-sm);
    }
    .editorial-icon {
      font-size: 28px;
      margin-bottom: 16px;
      display: inline-block;
    }
    .editorial-block h3 {
      font-family: var(--font-family);
      font-size: 22px;
      font-weight: 800;
      color: var(--text);
      margin-bottom: 12px;
    }
    .editorial-block p {
      font-size: 14.5px;
      color: var(--text-muted);
      line-height: 1.7;
      margin-bottom: 16px;
    }
    .editorial-points {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .editorial-points li {
      font-size: 13.5px;
      color: var(--text-muted);
      display: flex;
      align-items: flex-start;
      gap: 10px;
      margin-bottom: 10px;
      line-height: 1.5;
    }
    .editorial-points li:before {
      content: "✓";
      color: var(--emerald);
      font-weight: 900;
      flex-shrink: 0;
    }

    /* Features Section */
    .section-features {
      padding: 95px 0;
      border-top: 1px solid var(--border);
      border-bottom: 1px solid var(--border);
      background: var(--bg-alt);
    }
    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 24px;
      margin-top: 48px;
    }
    .feature-card {
      background: var(--bg-surface);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 32px;
      box-shadow: var(--shadow-sm);
      transition: all 0.25s;
    }
    .feature-card:hover {
      box-shadow: var(--shadow-md);
      transform: translateY(-2px);
    }
    .feature-icon-badge {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
      margin-bottom: 20px;
      background: var(--emerald-soft);
      color: var(--emerald);
      border: 1px solid rgba(36, 71, 224, 0.2);
    }
    .feature-card h3 {
      font-family: var(--font-family);
      font-size: 20px;
      font-weight: 700;
      color: var(--text);
      margin-bottom: 12px;
    }
    .feature-card p {
      font-size: 14px;
      color: var(--text-muted);
      line-height: 1.6;
    }

    /* 3-Step Process */
    .section-process {
      padding: 95px 0;
    }
    .process-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
      margin-top: 48px;
    }
    .process-card {
      background: var(--bg-surface);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 36px 30px;
      position: relative;
      box-shadow: var(--shadow-sm);
    }
    .process-number {
      font-family: var(--font-family);
      font-size: 42px;
      font-weight: 900;
      color: var(--border);
      position: absolute;
      top: 24px;
      right: 28px;
    }
    .process-step-pill {
      font-size: 11px;
      font-weight: 800;
      color: var(--emerald);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      margin-bottom: 16px;
      display: inline-block;
    }
    .process-card h3 {
      font-family: var(--font-family);
      font-size: 21px;
      font-weight: 700;
      color: var(--text);
      margin-bottom: 12px;
    }
    .process-card p {
      font-size: 14px;
      color: var(--text-muted);
      line-height: 1.6;
    }

    /* FAQ Accordion Section (AdSense Requirement) */
    .section-faq {
      padding: 95px 0;
      border-top: 1px solid var(--border);
      background: var(--bg);
    }
    .faq-container {
      max-width: 860px;
      margin: 40px auto 0;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }
    .faq-item {
      background: var(--bg-surface);
      border: 1px solid var(--border);
      border-radius: 16px;
      overflow: hidden;
      box-shadow: var(--shadow-sm);
      transition: all 0.2s ease;
    }
    .faq-question {
      width: 100%;
      text-align: left;
      padding: 22px 26px;
      font-family: var(--font-family);
      font-size: 18px;
      font-weight: 700;
      color: var(--text);
      background: transparent;
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
    }
    .faq-icon-arrow {
      color: var(--emerald);
      font-size: 20px;
      font-weight: 900;
      transition: transform 0.25s ease;
    }
    .faq-item.active .faq-icon-arrow {
      transform: rotate(45deg);
    }
    .faq-answer {
      display: none;
      padding: 0 26px 24px;
      font-size: 15px;
      color: var(--text-muted);
      line-height: 1.7;
      border-top: 1px solid var(--border-light);
      margin-top: 4px;
      padding-top: 18px;
    }
    .faq-item.active .faq-answer {
      display: block;
    }

    /* Blog & Guides Section */
    .section-guides {
      padding: 95px 0;
      border-top: 1px solid var(--border);
      background: var(--bg-surface);
    }
    .guides-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 24px;
      margin-top: 40px;
    }
    .guide-card {
      background: var(--bg);
      border: 1px solid var(--border);
      border-radius: 20px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: all 0.25s ease;
      box-shadow: var(--shadow-sm);
    }
    .guide-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-lg);
      border-color: rgba(36, 71, 224, 0.4);
    }
    .guide-image-wrap {
      height: 185px;
      width: 100%;
      background: #f1f5f9;
      overflow: hidden;
      position: relative;
    }
    .guide-image-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }
    .guide-card:hover .guide-image-wrap img {
      transform: scale(1.04);
    }
    .guide-body {
      padding: 24px;
      display: flex;
      flex-direction: column;
      flex-grow: 1;
    }
    .guide-meta {
      font-size: 12px;
      font-weight: 700;
      color: var(--emerald);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 10px;
    }
    .guide-title {
      font-family: var(--font-family);
      font-size: 19px;
      font-weight: 700;
      color: var(--text);
      line-height: 1.35;
      margin-bottom: 10px;
    }
    .guide-excerpt {
      font-size: 13.5px;
      color: var(--text-muted);
      line-height: 1.55;
      margin-bottom: 18px;
      flex-grow: 1;
    }
    .guide-link {
      font-size: 13px;
      font-weight: 700;
      color: var(--emerald);
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    /* Bottom High-Impact CTA */
    .section-cta {
      padding: 70px 0 100px;
    }
    .cta-card {
      background: linear-gradient(135deg, #0d1b47 0%, #162e96 50%, #0f172a 100%);
      color: #ffffff;
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 28px;
      padding: 56px 48px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 36px;
      box-shadow: 0 20px 50px rgba(13, 27, 71, 0.25);
      flex-wrap: wrap;
    }
    .cta-card h2 {
      font-family: var(--font-family);
      font-size: clamp(30px, 3.8vw, 44px);
      font-weight: 800;
      color: #fff;
      line-height: 1.15;
      margin-bottom: 12px;
    }
    .cta-card p {
      font-size: 16.5px;
      color: #d6dffd;
      max-width: 580px;
    }
    .cta-card .btn-primary {
      background: #ffffff;
      color: #0d1b47;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }
    .cta-card .btn-primary:hover {
      background: #f2f5ff;
      transform: translateY(-2px);
    }

    /* Rich AdSense-Compliant Multi-Column Footer */
    .site-footer {
      border-top: 1px solid var(--border);
      padding: 75px 0 45px;
      background: var(--bg-alt);
      font-size: 14px;
      color: var(--text-muted);
    }
    .footer-columns {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1fr 1.2fr;
      gap: 40px;
      margin-bottom: 50px;
    }
    .footer-col-brand p {
      margin: 16px 0 20px;
      line-height: 1.65;
      max-width: 320px;
      font-size: 14px;
      color: var(--text-muted);
    }
    .footer-col-title {
      font-family: var(--font-family);
      font-size: 16px;
      font-weight: 700;
      color: var(--text);
      margin-bottom: 18px;
      letter-spacing: -0.01em;
    }
    .footer-col-links {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      gap: 11px;
    }
    .footer-col-links a {
      color: var(--text-muted);
      transition: color 0.2s;
      font-size: 13.5px;
    }
    .footer-col-links a:hover {
      color: var(--emerald);
    }
    .footer-compliance-box {
      border-top: 1px solid var(--border);
      padding-top: 30px;
      margin-top: 20px;
      display: flex;
      flex-direction: column;
      gap: 14px;
      font-size: 12.5px;
      color: var(--text-subtle);
      line-height: 1.6;
    }
    .footer-bottom-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-top: 1px solid var(--border);
      padding-top: 24px;
      margin-top: 20px;
      font-size: 13px;
      color: var(--text-subtle);
      flex-wrap: wrap;
      gap: 16px;
    }

    /* Floating Stakeholder Preview Notice */
    .floating-preview-banner {
      position: fixed;
      bottom: 24px;
      right: 24px;
      z-index: 100;
      background: var(--bg-surface);
      border: 1px solid rgba(36, 71, 224, 0.4);
      padding: 12px 20px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 700;
      color: var(--text);
      box-shadow: var(--shadow-lg);
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .preview-badge-pill {
      background: var(--emerald);
      color: #ffffff;
      font-size: 10px;
      font-weight: 900;
      padding: 3px 8px;
      border-radius: 999px;
      text-transform: uppercase;
    }

    @media (max-width: 768px), (prefers-reduced-motion: reduce) { .ambient-glow { animation: none; filter: none; } }

    /* Responsive */
    @media (max-width: 1024px) {
      .process-grid, .editorial-grid { grid-template-columns: 1fr; }
      .footer-columns { grid-template-columns: 1fr 1fr; }
      .nav-menu { display: none; }
      .mobile-toggle-btn { display: inline-flex; }
      .d-none-mobile { display: none !important; }
    }
    @media (max-width: 768px) {
      .hero-launcher { border-radius: 18px; }
      .launcher-form { flex-direction: column; align-items: stretch; }
      .launcher-form .btn { width: 100%; }
      .tools-grid { grid-template-columns: 1fr; }
      .footer-columns { grid-template-columns: 1fr; }
      .cta-card { padding: 40px 24px; }
    }
  </style>
  <link rel="stylesheet" href="{{ asset('assets/css/site-typography.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/site-typography.css') ?: '1' }}">
  <link rel="stylesheet" href="{{ asset('assets/css/site-header.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/site-header.css') ?: '1' }}">
  <link rel="stylesheet" href="{{ asset('assets/css/site-redesign.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/site-redesign.css') ?: '1' }}">
  <link rel="stylesheet" href="{{ asset('assets/css/home-sections.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/home-sections.css') ?: '1' }}">
  <link rel="stylesheet" href="{{ asset('assets/css/home-faq.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/home-faq.css') ?: '1' }}">
  <link rel="stylesheet" href="{{ asset('assets/css/featured-images.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/featured-images.css') ?: '1' }}">
  <link rel="stylesheet" href="{{ asset('assets/css/home-audience.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/home-audience.css') ?: '1' }}">
</head>
<body class="{{ $__isThemeDark ? 'theme-dark dark' : 'theme-light light' }}">

  <!-- Ambient Light Accents -->
  <div class="ambient-effects" aria-hidden="true">
    <div class="ambient-glow glow-1"></div>
    <div class="ambient-glow glow-2"></div>
    <div class="ambient-glow glow-3"></div>
  </div>

  <!-- Header Navigation -->
  <x-public.navbar />

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="wrap hero-content">
      <div class="hero-copy">
        <h1 class="hero-title">{{ __('Check a domain.') }}<br>{{ __('See the numbers.') }}</h1>

        <p class="hero-desc">
          {{ __('Free SEO and YouTube tools that run in your browser. Look up Domain Authority, list backlinks, audit meta tags or pull data from a video, with no account and no card.') }}
        </p>

        <!-- Quick-run launcher -->
        <div class="hero-launcher">
          <div class="launcher-tabs" role="group" aria-label="{{ __('Choose a tool') }}">
            <button class="launcher-tab active" type="button" aria-pressed="true" onclick="switchLauncherTab(this, 'domain-authority-checker', 'Enter domain e.g. fxnseo.com or wikipedia.org', 'domain')">{{ __('Domain Authority') }}</button>
            <button class="launcher-tab" type="button" aria-pressed="false" onclick="switchLauncherTab(this, 'backlink-checker', 'Enter domain to check live backlinks e.g. github.com', 'domain')">{{ __('Backlink Checker') }}</button>
            <button class="launcher-tab" type="button" aria-pressed="false" onclick="switchLauncherTab(this, 'meta-tags-analyzer', 'Enter website URL to audit meta tags', 'link')">{{ __('Meta Tags Analyzer') }}</button>
            <button class="launcher-tab" type="button" aria-pressed="false" onclick="switchLauncherTab(this, 'youtube-title-extractor', 'Paste YouTube video URL e.g. https://www.youtube.com/watch?v=...', 'link')">{{ __('YouTube Extractor') }}</button>
          </div>

          <form class="launcher-form" id="launcher-form" onsubmit="return handleLauncherSubmit(event)">
            <input
              type="text"
              id="launcher-input"
              class="launcher-input"
              placeholder="{{ __('Enter domain e.g. fxnseo.com or wikipedia.org') }}"
              aria-label="{{ __('Domain or URL to check') }}"
              required
            >
            <button type="submit" class="btn btn-primary">{{ __('Run check') }}</button>
          </form>
        </div>
      </div>

      <figure class="hero-readout">
        <figcaption><strong>{{ __('Example result') }}</strong> {{ __('for a Domain Authority check') }}</figcaption>
        <dl class="readout-grid">
          <div class="is-key"><dt>{{ __('Domain Authority') }}</dt><dd>54<small>/100</small></dd></div>
          <div><dt>{{ __('Page Authority') }}</dt><dd>47<small>/100</small></dd></div>
          <div><dt>{{ __('Linking domains') }}</dt><dd>1,204</dd></div>
          <div><dt>{{ __('Spam score') }}</dt><dd>2<small>%</small></dd></div>
        </dl>
        <p>{{ __('Metrics come from the Moz API. Treat them as a way to compare sites, not a ranking guarantee.') }}</p>
      </figure>
    </div>
  </section>

  <!-- Tools Explorer Section -->
  <section class="section-tools" id="tools">
    <div class="wrap">
      <div class="section-head-bar">
        <div>
          <h2 class="section-title">{{ __('All 60 free tools') }}</h2>
        </div>
        <p class="section-subtitle">
          {{ __('Domain authority, backlinks, metadata, redirects and YouTube research. Pick a tool and run it in your browser.') }}
        </p>
      </div>

      <!-- Filter Pills & Search -->
      <div class="filter-bar">
        <div class="category-pills" id="category-pills">
          <button class="category-pill active" onclick="filterCategory('all', this)">{{ __('All tools (') }}{{ count($allTools) }})</button>
          <button class="category-pill" onclick="filterCategory('popular', this)">{{ __('Most popular') }}</button>
          <button class="category-pill" onclick="filterCategory('youtube', this)">{{ __('YouTube (18)') }}</button>
          <button class="category-pill" onclick="filterCategory('backlink', this)">{{ __('Backlinks & authority') }}</button>
          <button class="category-pill" onclick="filterCategory('content', this)">{{ __('Content & text') }}</button>
          <button class="category-pill" onclick="filterCategory('technical', this)">{{ __('Technical & DNS') }}</button>
        </div>

        <div class="search-input-box">
          <label for="tool-search-input" class="tools-sr-only">{{ __('Search tools') }}</label>
          <input
            type="text"
            id="tool-search-input"
            placeholder="{{ __('Search tools: Moz, YouTube, DNS') }}"
            oninput="handleToolSearch(this.value)"
          >
        </div>
      </div>

      <!-- Dynamic Cards Grid -->
      <div class="tools-grid" id="tools-grid">
        @foreach($allTools as $tool)
          @php
            $slug = $tool['slug'];
            $isYt = str_contains($slug, 'youtube');
            $isMoz = str_contains($slug, 'authority') || str_contains($slug, 'moz') || str_contains($slug, 'backlink');
            $isContent = str_contains($slug, 'rewriter') || str_contains($slug, 'keyword') || str_contains($slug, 'word') || str_contains($slug, 'text') || str_contains($slug, 'plagiarism');
            $isTech = str_contains($slug, 'dns') || str_contains($slug, 'whois') || str_contains($slug, 'robots') || str_contains($slug, 'sitemap') || str_contains($slug, 'redirect') || str_contains($slug, 'ping') || str_contains($slug, 'speed') || str_contains($slug, 'server');

            $catTag = 'tools';
            if ($isYt) $catTag = 'youtube';
            elseif ($isMoz) $catTag = 'backlink';
            elseif ($isContent) $catTag = 'content';
            elseif ($isTech) $catTag = 'technical';
          @endphp

          <a
            href="{{ $tool['link'] }}"
            class="tool-card"
            data-slug="{{ $tool['slug'] }}"
            data-category="{{ $catTag }}"
            data-popular="{{ !empty($tool['popular']) ? '1' : '0' }}"
            data-search="{{ strtolower($tool['title'] . ' ' . $tool['description'] . ' ' . $tool['slug']) }}"
          >
            <div class="card-top">
              <div class="tool-icon-wrap">
                @if(!empty($tool['icon_image']))
                  <img loading="lazy" decoding="async" src="{{ $tool['icon_image'] }}" alt="{{ $tool['title'] }}">
                @else
                  ⚡
                @endif
              </div>

              @if(!empty($tool['popular']))
                <span class="card-tag tag-pop">{{ __('Popular') }}</span>
              @elseif($isYt)
                <span class="card-tag tag-yt">{{ __('YouTube API') }}</span>
              @elseif($isMoz)
                <span class="card-tag tag-moz">{{ __('Moz Engine') }}</span>
              @else
                <span class="card-tag">{{ __('Fast Check') }}</span>
              @endif
            </div>

            <h3 class="tool-title">{{ $tool['title'] }}</h3>
            <p class="tool-desc">{{ \Illuminate\Support\Str::limit($tool['description'] ?: 'Perform instant, reliable SEO data lookups with real-time accuracy.', 110) }}</p>

            <div class="card-bottom">
              <span>{{ __('Launch Tool') }}</span>
              <span class="card-arrow">→</span>
            </div>
          </a>
        @endforeach
      </div>

      <div id="no-search-results" style="display: none; text-align: center; padding: 60px 20px;">
        <h3 style="font-size: 22px; color: var(--text); margin-bottom: 8px;">{{ __('No matching tools found') }}</h3>
        <p style="color: var(--text-muted); margin-bottom: 20px;">{{ __('Try searching for "backlink", "youtube", "keyword", or "authority".') }}</p>
        <button class="btn btn-ghost" onclick="resetToolSearch()">{{ __('Clear Search Filter') }}</button>
      </div>
    </div>
  </section>

  <!-- Editorial Knowledge & Search Standards Section (AdSense Value-Add Content) -->
  <section class="section-editorial" id="editorial-insights">
    <div class="wrap">
      <div class="section-head">
        <span class="section-eyebrow">{{ __('A stronger search foundation') }}</span>
        <h2 class="section-title">{{ __('The Four Pillars of Search Visibility') }}</h2>
        <p class="section-subtitle">
          {{ __('High organic rankings require a balance of technical accessibility, editorial content relevance, domain authority, and multimedia discoverability.') }}
        </p>
      </div>

      <div class="editorial-grid">
        <div class="editorial-block">
          <span class="pillar-number" aria-hidden="true">01</span>
          <h3>{{ __('Domain Authority & Backlink Health') }}</h3>
          <p>
            {{ __('Search algorithms rely on inbound hyperlink citations to gauge trustworthiness. Moz\'s 100-point Domain Authority (DA) and Page Authority (PA) metrics predict ranking capability based on root domain diversity and link equity.') }}
          </p>
          <ul class="editorial-points">
            <li>{{ __('Assess competitor link velocity and anchor text variation.') }}</li>
            <li>{{ __('Detect broken or lost referral pathways before ranking drop-offs.') }}</li>
            <li>{{ __('Prioritize relevant editorial links over bulk automated placements.') }}</li>
          </ul>
        </div>

        <div class="editorial-block">
          <span class="pillar-number" aria-hidden="true">02</span>
          <h3>{{ __('Technical Crawlability & Indexation') }}</h3>
          <p>
            {{ __('Before a page can rank, search engine crawlers (like Googlebot) must find, render, and index it efficiently. Technical hygiene prevents wasted crawl budget and eliminates indexation barriers.') }}
          </p>
          <ul class="editorial-points">
            <li>{{ __('Generate explicit crawler permissions with validated robots.txt syntax.') }}</li>
            <li>{{ __('Structure clean XML sitemaps to communicate page hierarchy and updates.') }}</li>
            <li>{{ __('Diagnose redirect loops, canonical anomalies, and server latency.') }}</li>
          </ul>
        </div>

        <div class="editorial-block">
          <span class="pillar-number" aria-hidden="true">03</span>
          <h3>{{ __('On-Page Relevance & Entity Optimization') }}</h3>
          <p>
            {{ __('Modern semantic algorithms (like Google BERT and MUM) look for comprehensive answers to search intent rather than repeated keywords. Natural keyword density and high-converting meta tags drive click-throughs.') }}
          </p>
          <ul class="editorial-points">
            <li>{{ __('Use relevant terms naturally and answer the reader’s question without repeating keywords unnecessarily.') }}</li>
            <li>{{ __('Write click-worthy meta titles (under 60 chars) and meta descriptions.') }}</li>
            <li>{{ __('Refresh outdated passages to maintain topical authority and freshness.') }}</li>
          </ul>
        </div>

        <div class="editorial-block">
          <span class="pillar-number" aria-hidden="true">04</span>
          <h3>{{ __('Video SEO & YouTube Algorithm Signals') }}</h3>
          <p>
            {{ __('YouTube is the world\'s second-largest search engine. Video discoverability relies on high-CTR thumbnails, matching search tags, informative descriptions, and audience retention metrics.') }}
          </p>
          <ul class="editorial-points">
            <li>{{ __('Extract trending hashtags and high-ranking competitor video tags.') }}</li>
            <li>{{ __('Analyze channel subscriber velocity, view velocity, and engagement ratios.') }}</li>
            <li>{{ __('Structure timestamped video descriptions for enhanced Google rich snippets.') }}</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="section-features" id="features" aria-labelledby="features-title">
    <div class="wrap">
      <div class="features-intro">
        <div class="section-head">
          <span class="section-eyebrow">{{ __('Find your next move') }}</span>
          <h2 class="section-title" id="features-title">{{ __('Built for Creators, Webmasters & SEO Teams') }}</h2>
        </div>
        <div class="features-intro-copy">
          <p>{{ __('From your next video to your next site audit, turn search data into a clear plan of action.') }}</p>
          <a href="#tools" class="features-explore">{{ __('Explore all tools') }} <span aria-hidden="true">↗</span></a>
        </div>
      </div>
      <div class="audience-grid">
        <article class="audience-card">
          <div class="audience-card-top"><span class="audience-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="4"/><path d="M10 8L16 12L10 16Z"/></svg></span><span class="audience-label">{{ __('For creators') }}</span></div>
          <h3>{{ __('Make your next upload count.') }}</h3>
          <p>{{ __('Shape stronger video titles and descriptions with a focused YouTube toolkit.') }}</p>
          <ul><li>{{ __('Discover tags and content ideas') }}</li><li>{{ __('Review channel and video statistics') }}</li><li>{{ __('Refine titles, descriptions and keywords') }}</li></ul>
          <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/youtube-tag-extractor') }}" class="audience-tool-link">{{ __('Explore video tags') }} <span aria-hidden="true">↗</span></a>
        </article>
        <article class="audience-card">
          <div class="audience-card-top"><span class="audience-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="4"/><path d="M3 9H21M8 14L6 16L8 18M16 14L18 16L16 18M13 13L11 19"/></svg></span><span class="audience-label">{{ __('For webmasters') }}</span></div>
          <h3>{{ __('Keep your website in good shape.') }}</h3>
          <p>{{ __('Check the technical details that help search engines reach and understand your pages.') }}</p>
          <ul><li>{{ __('Check HTTP responses and redirects') }}</li><li>{{ __('Build robots.txt files and XML sitemaps') }}</li><li>{{ __('Inspect DNS records and meta tags') }}</li></ul>
          <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/http-status-code-checker') }}" class="audience-tool-link">{{ __('Check your site status') }} <span aria-hidden="true">↗</span></a>
        </article>
        <article class="audience-card">
          <div class="audience-card-top"><span class="audience-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20H21M6 16V12M12 16V8M18 16V4M4 9L10 4L14 6L20 2"/></svg></span><span class="audience-label">{{ __('For SEO teams') }}</span></div>
          <h3>{{ __('Give your next audit more clarity.') }}</h3>
          <p>{{ __('Bring authority metrics, backlink checks and on-page insights into your review process.') }}</p>
          <ul><li>{{ __('Compare Moz Domain and Page Authority') }}</li><li>{{ __('Review backlink health and opportunities') }}</li><li>{{ __('Analyze keywords and on-page content') }}</li></ul>
          <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/da-pa-checker') }}" class="audience-tool-link">{{ __('Check domain authority') }} <span aria-hidden="true">↗</span></a>
        </article>
      </div>
      <div class="features-bottom-note"><span class="features-note-dot" aria-hidden="true"></span>{{ __('Free tools. No installation. A clearer place to start.') }}</div>
    </div>
  </section>

<!-- FAQ Section (Crucial for AdSense Editorial Depth) -->
  <section class="section-faq" id="faqs">
    <div class="wrap">
      <div class="section-head">
        <span class="faq-eyebrow">{{ __('Answers at a glance') }}</span>
        <h2 class="section-title">{{ __('Common Questions About Our SEO Suite') }}</h2>
        <p class="section-subtitle">
          {{ __('Learn more about how our tools work, data sources, accuracy, and user privacy commitments.') }}
        </p>
      </div>

      <div class="faq-container">
        <div class="faq-column">
          <details class="faq-item" name="home-faq">
          <summary class="faq-question"><span>{{ __('What is FXN SEO and how do the free tools work?') }}</span></summary>
          <div class="faq-answer">{{ __('FXN SEO is a comprehensive collection of 60+ webmaster and digital marketing utilities designed to assist website owners, developers, and creators. Our tools run high-speed diagnostic queries directly against authoritative APIs (such as Mozscape for authority metrics and Google YouTube Data API for video intelligence) as well as native server-side parsers for DNS, whois, and HTML validation. All tools are 100% free with no software installation or registration required.') }}</div>
        </details>

          <details class="faq-item" name="home-faq">
          <summary class="faq-question"><span>{{ __('Are the Moz Domain Authority and Page Authority metrics official?') }}</span></summary>
          <div class="faq-answer">{{ __('Yes. Our Domain Authority (DA) and Page Authority (PA) checkers query the official Mozscape™ API in real time. Moz calculates these metrics using a logarithmic scale from 1 to 100 based on indexed root domains, inbound links, and historical quality signals, providing the exact same data seen in industry-standard enterprise audits.') }}</div>
        </details>

          <details class="faq-item" name="home-faq">
          <summary class="faq-question"><span>{{ __('Do you store my input data, video URLs, or target domains?') }}</span></summary>
          <div class="faq-answer">{{ __('No. We prioritize visitor privacy. All data submitted through our tools (including target URLs, keywords, and text submissions) is processed ephemerally in server memory solely to generate your results. We never sell, rent, or share user search queries or proprietary domain data with third-party brokers.') }}</div>
        </details>
        </div>
        <div class="faq-column">
          <details class="faq-item" name="home-faq">
          <summary class="faq-question"><span>{{ __('Why is keyword density important for on-page SEO?') }}</span></summary>
          <div class="faq-answer">{{ __('Keyword density measures the percentage frequency of a specific word or phrase relative to the total word count of an article. Maintaining an optimal ratio (typically between 1% and 3%) helps search algorithms understand the topical focus of your page without triggering over-optimization penalties associated with unnatural keyword stuffing.') }}</div>
        </details>

          <details class="faq-item" name="home-faq">
          <summary class="faq-question"><span>{{ __('How often should webmasters monitor backlinks and technical health?') }}</span></summary>
          <div class="faq-answer">{{ __('Active websites should conduct backlink audits monthly to detect lost citations, identify potential negative SEO, and spot new referring domains. Technical health checks (such as robots.txt validation, HTTP status redirect audits, and XML sitemap inspection) should be performed immediately after site updates, redesigns, or migration events.') }}</div>
        </details>

          <details class="faq-item" name="home-faq">
          <summary class="faq-question"><span>{{ __('Can I use these tools on mobile devices and tablets?') }}</span></summary>
          <div class="faq-answer">{{ __('Yes. Every tool on FXN SEO is fully responsive and optimized for seamless operation across smartphones, tablets, laptops, and desktop computers without loss of functionality.') }}</div>
        </details>
        </div>
      </div>
    </div>
  </section>

  <!-- Latest Guides / Blog Section -->
  <section class="section-guides">
    <div class="wrap">
      <div class="section-head-bar">
        <div>
          <h2 class="section-title">{{ __('Fresh SEO & Backlink Insights') }}</h2>
        </div>
        <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/blog') }}" class="btn btn-ghost">{{ __('View all articles') }}</a>
      </div>

      <div class="guides-grid">
        @forelse($resources as $post)
          <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/blog/' . $post['slug']) }}" class="guide-card">
            <div class="guide-image-wrap">
              <img class="post-featured-image" src="{{ !empty($post['featured_image']) ? $post['featured_image'] : asset('assets/img/no-thumb.svg') }}" alt="{{ $post['title'] }}" loading="lazy">
            </div>
            <div class="guide-body">
              <div class="guide-meta">{{ $post['published_at'] ?? 'Guide' }}</div>
              <h3 class="guide-title">{{ $post['title'] }}</h3>
              <p class="guide-excerpt">{{ \Illuminate\Support\Str::limit($post['excerpt'] ?: 'Discover essential strategies and actionable guidance for ranking higher in organic search.', 120) }}</p>
              <span class="guide-link">{{ __('Read guide') }}</span>
            </div>
          </a>
        @empty
          <p style="color: var(--text-muted);">{{ __('Articles are being loaded.') }}</p>
        @endforelse
      </div>
    </div>
  </section>

  <!-- Bottom CTA -->
  <section class="section-cta">
    <div class="wrap">
      <div class="cta-card">
        <div>
          <h2>{{ __('Ready to Audit & Grow Your Traffic?') }}</h2>
          <p>{{ __('Join thousands of webmasters, digital marketers, and agencies making smarter SEO decisions every single day.') }}</p>
        </div>
        <a href="#tools" class="btn btn-primary">
          {{ __('Start checking, free') }}
        </a>
      </div>
    </div>
  </section>

  <!-- Rich AdSense-Compliant Multi-Column Footer -->
  <footer class="site-footer">
    <div class="wrap">
      <div class="footer-columns">
        <!-- Brand Info -->
        <div class="footer-col-brand">
          <a href="{{ route('home') }}" class="brand-logo" aria-label="fxnSEO">
            <img src="{{ asset('assets/img/logo-light.svg') }}?v={{ @filemtime(dirname(base_path()).'/assets/img/logo-light.svg') ?: '1' }}" alt="fxnSEO" class="logo-light" height="38" width="auto">
            <img src="{{ asset('assets/img/logo-dark.svg') }}?v={{ @filemtime(dirname(base_path()).'/assets/img/logo-dark.svg') ?: '1' }}" alt="fxnSEO" class="logo-dark" height="38" width="auto">
          </a>
          <p>
            {{ __('FXN SEO provides professional-grade, free diagnostic utilities for webmasters, creators, and agencies. Analyze domain authority, audit backlinks, inspect technical tags, and optimize content in real time.') }}
          </p>
          <div style="display: flex; gap: 10px; align-items: center; color: var(--emerald); font-weight: 700; font-size: 13px;">
            <span>{{ __('✓ Verified Moz Data') }}</span> • <span>{{ __('✓ YouTube v3 API') }}</span>
          </div>
        </div>

        <!-- Col 1: SEO Tools -->
        <div>
          <h4 class="footer-col-title">{{ __('Popular Tools') }}</h4>
          <ul class="footer-col-links">
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/domain-authority-checker') }}">{{ __('Domain Authority') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/page-authority-checker') }}">{{ __('Page Authority') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/da-pa-checker') }}">{{ __('DA PA Checker') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/backlink-checker') }}">{{ __('Backlink Checker') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/meta-tags-analyzer') }}">{{ __('Meta Tags Analyzer') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/keyword-density-checker') }}">{{ __('Keyword Density') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/google-index-checker') }}">{{ __('Google Index Checker') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/robots-txt-generator') }}">{{ __('Robots.txt Generator') }}</a></li>
          </ul>
        </div>

        <!-- Col 2: YouTube Suite -->
        <div>
          <h4 class="footer-col-title">{{ __('YouTube Suite') }}</h4>
          <ul class="footer-col-links">
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/youtube-title-extractor') }}">{{ __('Title Extractor') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/youtube-tag-extractor') }}">{{ __('Tag Extractor') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/youtube-hashtag-extractor') }}">{{ __('Hashtag Extractor') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/youtube-channel-statistics') }}">{{ __('Channel Statistics') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/youtube-video-statistics') }}">{{ __('Video Statistics') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/youtube-money-calculator') }}">{{ __('Money Calculator') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/youtube-trend') }}">{{ __('Trending Videos') }}</a></li>
          </ul>
        </div>

        <!-- Col 3: Knowledge Hub -->
        <div>
          <h4 class="footer-col-title">{{ __('Knowledge Hub') }}</h4>
          <ul class="footer-col-links">
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/blog') }}">{{ __('SEO Blog') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/backlink-monitoring-guide') }}">{{ __('Backlink Guide') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/link-opportunity-guide') }}">{{ __('Link Building Guide') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/seo-audit-guide') }}">{{ __('SEO Audit Hub') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/faqs') }}">{{ __('Common FAQs') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/report') }}">{{ __('Report Broken Tool') }}</a></li>
          </ul>
        </div>

        <!-- Col 4: Trust & Compliance -->
        <div>
          <h4 class="footer-col-title">{{ __('Trust & Legal') }}</h4>
          <ul class="footer-col-links">
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/about-us') }}">{{ __('About Us') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/contact') }}">{{ __('Contact Support') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/privacy-policy') }}">{{ __('Privacy Policy') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/terms-conditions') }}">{{ __('Terms of Service') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/cookie-information') }}">{{ __('Cookie Information') }}</a></li>
            <li><a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/affiliate-disclosure') }}">{{ __('Affiliate Disclosure') }}</a></li>
          </ul>
        </div>
      </div>

      <!-- Compliance & AdSense Policy Notice -->
      <div class="footer-compliance-box">
        <p>
          <strong>{{ __('Publisher & Advertising Disclosure:') }}</strong> {{ __('FXN SEO is an independent digital marketing intelligence resource. This platform is supported by digital advertising, including Google AdSense and affiliate partnerships. In accordance with Google Publisher Policies and FTC guidelines, we may receive compensation when visitors interact with sponsored placements or acquire services through external links, at no additional cost to you.') }}
        </p>
        <p>
          <strong>{{ __('Data Privacy & GDPR Commitment:') }}</strong> {{ __('We do not log, retain, or commercialize individual website queries, target domains, or video URLs submitted to our tools. All third-party trademarks and brand logos (including Moz, YouTube, and Google) belong to their respective copyright holders.') }}
        </p>
      </div>

      <!-- Bottom Bar -->
      <div class="footer-bottom-bar">
        <div>
          © {{ date('Y') }} {{ __('FXN SEO. All rights reserved.') }}
        </div>
        <div style="display: flex; gap: 20px;">
          <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/privacy-policy') }}">{{ __('Privacy') }}</a>
          <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/terms-conditions') }}">{{ __('Terms') }}</a>
          <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/cookie-information') }}">{{ __('Cookies') }}</a>
          <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/contact') }}">{{ __('Contact') }}</a>
          <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/report') }}">{{ __('Report') }}</a>
        </div>
      </div>
    </div>
  </footer>

  <script>
    // State for launcher
    let currentLauncherSlug = 'domain-authority-checker';
    let currentLauncherParam = 'domain';

    function switchLauncherTab(btn, slug, placeholder, param) {
      document.querySelectorAll('.launcher-tab').forEach(t => {
        t.classList.remove('active');
        t.setAttribute('aria-pressed', 'false');
      });
      btn.classList.add('active');
      btn.setAttribute('aria-pressed', 'true');
      currentLauncherSlug = slug;
      currentLauncherParam = param;
      const input = document.getElementById('launcher-input');
      input.placeholder = placeholder;
      input.value = '';
      input.focus();
    }

    function handleLauncherSubmit(e) {
      e.preventDefault();
      const val = document.getElementById('launcher-input').value.trim();
      if (!val) return false;
      const targetUrl = '{{ route('home') }}/' + currentLauncherSlug;
      window.location.href = targetUrl;
      return false;
    }

    // Category Filter Pills
    let activeCategory = 'all';
    function filterCategory(cat, btn) {
      activeCategory = cat;
      document.querySelectorAll('.category-pill').forEach(p => p.classList.remove('active'));
      btn.classList.add('active');
      applyToolFilters();
    }

    // Search Tool Cards
    function handleToolSearch(query) {
      applyToolFilters();
    }

    function resetToolSearch() {
      document.getElementById('tool-search-input').value = '';
      activeCategory = 'all';
      document.querySelectorAll('.category-pill').forEach((p, idx) => {
        p.classList.toggle('active', idx === 0);
      });
      applyToolFilters();
    }

    function applyToolFilters() {
      const query = (document.getElementById('tool-search-input').value || '').trim().toLowerCase();
      const cards = document.querySelectorAll('.tool-card');
      let visibleCount = 0;

      cards.forEach(card => {
        const cardSearch = card.dataset.search || '';
        const cardCategory = card.dataset.category || '';
        const isPop = card.dataset.popular === '1';

        // Check category
        let matchesCat = true;
        if (activeCategory === 'popular') {
          matchesCat = isPop;
        } else if (activeCategory !== 'all') {
          matchesCat = (cardCategory === activeCategory);
        }

        // Check search query
        const matchesQuery = !query || cardSearch.includes(query);

        if (matchesCat && matchesQuery) {
          card.style.display = 'flex';
          visibleCount++;
        } else {
          card.style.display = 'none';
        }
      });

      const noRes = document.getElementById('no-search-results');
      if (noRes) {
        noRes.style.display = visibleCount === 0 ? 'block' : 'none';
      }
    }

    // FAQ Accordion Toggle
    }
  </script>
</body>
</html>
