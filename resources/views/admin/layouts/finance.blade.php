<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Finance') · 153 Kreatif</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/img/153.png') }}">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <style>
    /* ═══════════════════════════════════════════════════
   iOS / iPhone Design System — Finance Layout
═══════════════════════════════════════════════════ */
    :root {
      /* iOS System Colors */
      --ios-blue: #007AFF;
      --ios-blue-dk: #0055D4;
      --ios-blue-lt: rgba(0, 122, 255, .12);
      --ios-indigo: #5856D6;
      --ios-purple: #AF52DE;
      --ios-pink: #FF2D55;
      --ios-red: #FF3B30;
      --ios-orange: #FF9500;
      --ios-yellow: #FFCC00;
      --ios-green: #34C759;
      --ios-teal: #5AC8FA;
      --ios-gray: #8E8E93;

      /* Backgrounds */
      --bg: #F2F2F7;
      --surface: #FFFFFF;
      --surface2: #F2F2F7;

      /* Labels */
      --label: #000000;
      --label-2: rgba(60, 60, 67, .6);
      --label-3: rgba(60, 60, 67, .3);

      /* Separators */
      --sep: rgba(60, 60, 67, .29);
      --sep-opaque: #C6C6C8;

      /* Fill */
      --fill: rgba(120, 120, 128, .2);
      --fill-2: rgba(120, 120, 128, .16);
      --fill-3: rgba(118, 118, 128, .12);
      --fill-4: rgba(116, 116, 128, .08);

      /* Layout */
      --sw: 260px;
      --th: 52px;

      /* Radius */
      --r-xs: 6px;
      --r-sm: 10px;
      --r-md: 14px;
      --r-lg: 18px;
      --r-xl: 22px;
      --r-2xl: 28px;

      /* Shadows */
      --sh-sm: 0 1px 4px rgba(0, 0, 0, .06), 0 1px 2px rgba(0, 0, 0, .04);
      --sh: 0 4px 16px rgba(0, 0, 0, .07), 0 2px 6px rgba(0, 0, 0, .04);
      --sh-lg: 0 12px 40px rgba(0, 0, 0, .10), 0 4px 12px rgba(0, 0, 0, .06);
      --sh-xl: 0 24px 64px rgba(0, 0, 0, .14), 0 8px 24px rgba(0, 0, 0, .07);

      /* Transitions */
      --spring: cubic-bezier(.34, 1.56, .64, 1);
      --ease: cubic-bezier(.25, .46, .45, .94);
    }

    /* Layout shell */
    *,
    *::before,
    *::after {
      box-sizing: border-box;
    }

    html,
    body {
      height: 100vh;
      height: 100dvh;
      overflow: hidden
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'SF Pro Display', sans-serif;
      background: var(--bg);
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    /* ── TOPBAR ─────────────────────────────── */
    #f-top {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: var(--th);
      z-index: 300;
      background: rgba(242, 242, 247, .85);
      backdrop-filter: saturate(180%) blur(20px);
      -webkit-backdrop-filter: saturate(180%) blur(20px);
      border-bottom: .5px solid var(--sep-opaque);
      display: flex;
      align-items: center;
    }

    .f-hamburger {
      width: 36px;
      height: 36px;
      border-radius: var(--r-sm);
      border: none;
      background: var(--fill);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: var(--ios-blue);
      transition: all .18s var(--ease);
      margin-left: 16px;
      flex-shrink: 0;
    }

    .f-hamburger:hover {
      background: var(--fill-2);
      transform: scale(.96)
    }

    .f-hamburger:active {
      transform: scale(.90)
    }

    .f-hamburger svg {
      width: 18px;
      height: 18px
    }

    .f-brand {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 0 16px;
      text-decoration: none;
      transition: opacity .15s;
      flex-shrink: 0;
    }

    .f-brand:hover {
      opacity: .8
    }

    .f-brand-img {
      height: 30px;
      width: auto;
      object-fit: contain
    }

    .f-brand-tag {
      font-size: 10px;
      font-weight: 700;
      letter-spacing: .08em;
      text-transform: uppercase;
      background: var(--ios-blue-lt);
      color: var(--ios-blue);
      border: 1px solid rgba(0, 122, 255, .2);
      padding: 2px 8px;
      border-radius: 6px;
    }

    .f-top-center {
      flex: 1;
      padding: 0 20px;
      display: flex;
      align-items: center
    }

    .f-breadcrumb {
      font-size: 13px;
      color: var(--label-3);
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .f-breadcrumb-cur {
      color: var(--label);
      font-weight: 700;
      letter-spacing: -.2px
    }

    .f-top-right {
      display: flex;
      align-items: center;
      gap: 10px;
      padding-right: 16px
    }

    .f-icon-btn {
      width: 36px;
      height: 36px;
      border-radius: var(--r-sm);
      border: none;
      background: var(--fill);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: var(--ios-blue);
      transition: all .18s var(--ease);
      text-decoration: none;
    }

    .f-icon-btn svg {
      width: 16px;
      height: 16px
    }

    .f-icon-btn:hover {
      background: var(--fill-2);
      transform: scale(.96)
    }

    .f-icon-btn:active {
      transform: scale(.90)
    }

    .f-avatar {
      width: 34px;
      height: 34px;
      border-radius: var(--r-sm);
      background: linear-gradient(135deg, var(--ios-blue), var(--ios-indigo));
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      font-weight: 800;
      color: #fff;
      box-shadow: 0 4px 12px rgba(0, 122, 255, .25);
      cursor: default;
    }

    /* ── SIDEBAR ────────────────────────────── */
    #f-side {
      position: fixed;
      left: 0;
      top: var(--th);
      width: var(--sw);
      height: calc(100vh - var(--th));
      height: calc(100dvh - var(--th));
      z-index: 200;
      background: rgba(255, 255, 255, .78);
      backdrop-filter: saturate(180%) blur(24px);
      -webkit-backdrop-filter: saturate(180%) blur(24px);
      border-right: .5px solid var(--sep-opaque);
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .f-nav {
      flex: 1;
      overflow-y: auto;
      padding: 12px 10px;
      scrollbar-width: none
    }

    .f-nav::-webkit-scrollbar {
      width: 0
    }

    .f-sec {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: .06em;
      text-transform: uppercase;
      color: var(--label-3);
      padding: 14px 8px 5px;
    }

    .f-link {
      display: flex;
      align-items: center;
      gap: 11px;
      padding: 10px 10px;
      border-radius: var(--r-md);
      font-size: 14px;
      font-weight: 500;
      color: var(--label-2);
      text-decoration: none;
      transition: all .2s var(--ease);
      margin-bottom: 2px;
      position: relative;
      white-space: nowrap;
      overflow: hidden;
      border: none;
      background: transparent;
      cursor: pointer;
      width: 100%;
      text-align: left;
    }

    .f-link:hover {
      background: var(--fill-4);
      color: var(--label)
    }

    .f-link.on {
      background: var(--surface);
      color: var(--ios-blue);
      font-weight: 600;
      box-shadow: var(--sh-sm);
    }

    .f-link .ico {
      width: 30px;
      height: 30px;
      border-radius: var(--r-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      background: var(--fill-3);
      transition: all .2s var(--ease);
    }

    .f-link .ico svg {
      width: 15px;
      height: 15px;
      color: var(--label-3);
      transition: color .2s
    }

    .f-link:hover .ico {
      background: var(--fill-2)
    }

    .f-link:hover .ico svg {
      color: var(--label)
    }

    .f-link.on .ico {
      background: var(--ios-blue);
      box-shadow: 0 4px 12px rgba(0, 122, 255, .3);
    }

    .f-link.on .ico svg {
      color: #fff
    }

    .f-link .lbl {
      flex: 1;
      min-width: 0;
      overflow: hidden;
      text-overflow: ellipsis
    }

    .f-badge {
      font-size: 11px;
      font-weight: 700;
      padding: 2px 8px;
      border-radius: 10px;
      flex-shrink: 0;
    }

    .f-badge.r {
      background: rgba(255, 59, 48, .1);
      color: var(--ios-red)
    }

    .f-badge.a {
      background: rgba(255, 149, 0, .1);
      color: var(--ios-orange)
    }

    .f-badge.g {
      background: rgba(52, 199, 89, .1);
      color: var(--ios-green)
    }

    .f-foot {
      padding: 10px;
      border-top: .5px solid var(--sep-opaque);
      flex-shrink: 0;
    }

    .f-logout {
      display: flex;
      align-items: center;
      gap: 11px;
      padding: 10px 10px;
      border-radius: var(--r-md);
      font-size: 14px;
      font-weight: 600;
      color: var(--ios-red);
      cursor: pointer;
      transition: all .2s var(--ease);
      border: none;
      background: transparent;
      width: 100%;
    }

    .f-logout .ico {
      width: 30px;
      height: 30px;
      border-radius: var(--r-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      background: rgba(255, 59, 48, .1);
      transition: all .2s var(--ease);
    }

    .f-logout .ico svg {
      width: 15px;
      height: 15px;
      color: var(--ios-red)
    }

    .f-logout:hover {
      background: rgba(255, 59, 48, .06)
    }

    /* ── MAIN ───────────────────────────────── */
    #f-main {
      margin-left: var(--sw);
      margin-top: var(--th);
      height: calc(100vh - var(--th));
      height: calc(100dvh - var(--th));
      overflow-y: auto;
      position: relative;
    }

    #f-main::-webkit-scrollbar {
      width: 4px
    }

    #f-main::-webkit-scrollbar-thumb {
      background: var(--sep-opaque);
      border-radius: 4px
    }

    .f-page {
      padding: 28px 32px;
      min-height: calc(100vh - var(--th));
      min-height: calc(100dvh - var(--th));
      max-width: 1400px;
      margin: 0 auto
    }

    /* ── PAGE HEADER ────────────────────────── */
    .page-hd {
      margin-bottom: 24px
    }

    .page-hd h1 {
      font-size: 22px;
      font-weight: 800;
      color: var(--label);
      letter-spacing: -.6px
    }

    .page-hd p {
      font-size: 14px;
      color: var(--label-2);
      margin-top: 3px
    }

    /* ── CARD ───────────────────────────────── */
    .card {
      background: var(--surface);
      border-radius: var(--r-lg);
      overflow: hidden;
      transition: box-shadow .25s, transform .25s;
      box-shadow: var(--sh);
    }

    .card:hover {
      box-shadow: var(--sh-lg);
      transform: translateY(-2px)
    }

    .card-hd {
      padding: 18px 22px;
      border-bottom: .5px solid var(--sep-opaque);
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
    }

    .card-title {
      font-size: 15px;
      font-weight: 700;
      color: var(--label);
      letter-spacing: -.3px
    }

    .card-sub {
      font-size: 12px;
      color: var(--label-3);
      margin-top: 2px
    }

    .card-bd {
      padding: 22px
    }

    /* ── TABLE ──────────────────────────────── */
    .tbl {
      width: 100%;
      border-collapse: collapse;
      font-size: 13.5px
    }

    .tbl thead th {
      padding: 12px 16px;
      text-align: left;
      font-size: 11px;
      font-weight: 700;
      color: var(--label-3);
      text-transform: uppercase;
      letter-spacing: .07em;
      background: var(--surface2);
      border-bottom: .5px solid var(--sep-opaque);
      white-space: nowrap;
    }

    .tbl tbody td {
      padding: 13px 16px;
      color: var(--label-2);
      border-bottom: .5px solid rgba(60, 60, 67, .08);
      vertical-align: middle;
    }

    .tbl tbody tr:last-child td {
      border-bottom: none
    }

    .tbl tbody tr {
      transition: background .15s
    }

    .tbl tbody tr:hover td {
      background: var(--fill-4)
    }

    .tbl-right {
      text-align: right
    }

    .tbl-center {
      text-align: center
    }

    /* ── STATUS BADGE ───────────────────────── */
    .s {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 3px 9px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 600;
      white-space: nowrap;
    }

    .s::before {
      content: '';
      width: 5px;
      height: 5px;
      border-radius: 50%;
      display: inline-block;
      flex-shrink: 0
    }

    .s-paid {
      background: rgba(52, 199, 89, .12);
      color: #1B7A35
    }

    .s-paid::before {
      background: var(--ios-green)
    }

    .s-sent {
      background: rgba(0, 122, 255, .12);
      color: #0055D4
    }

    .s-sent::before {
      background: var(--ios-blue)
    }

    .s-draft {
      background: var(--fill-3);
      color: var(--label-2)
    }

    .s-draft::before {
      background: var(--ios-gray)
    }

    .s-overdue {
      background: rgba(255, 59, 48, .1);
      color: #CC3028
    }

    .s-overdue::before {
      background: var(--ios-red)
    }

    .s-partial {
      background: rgba(255, 149, 0, .12);
      color: #CC7800
    }

    .s-partial::before {
      background: var(--ios-orange)
    }

    .s-approved {
      background: rgba(52, 199, 89, .12);
      color: #1B7A35
    }

    .s-approved::before {
      background: var(--ios-green)
    }

    .s-pending {
      background: rgba(255, 204, 0, .15);
      color: #8B7000
    }

    .s-pending::before {
      background: var(--ios-yellow)
    }

    .s-rejected {
      background: rgba(255, 59, 48, .1);
      color: #CC3028
    }

    .s-rejected::before {
      background: var(--ios-red)
    }

    .s-active {
      background: rgba(52, 199, 89, .12);
      color: #1B7A35
    }

    .s-active::before {
      background: var(--ios-green)
    }

    .s-converted {
      background: rgba(88, 86, 214, .12);
      color: #3E3CB0
    }

    .s-converted::before {
      background: var(--ios-indigo)
    }

    .s-completed {
      background: var(--fill-3);
      color: var(--label-2)
    }

    .s-completed::before {
      background: var(--ios-gray)
    }

    .s-over_budget {
      background: rgba(255, 59, 48, .1);
      color: #CC3028
    }

    .s-over_budget::before {
      background: var(--ios-red)
    }

    .s-paid_partial {
      background: rgba(255, 149, 0, .12);
      color: #CC7800
    }

    .s-paid_partial::before {
      background: var(--ios-orange)
    }

    .s-paid_full {
      background: rgba(52, 199, 89, .12);
      color: #1B7A35
    }

    .s-paid_full::before {
      background: var(--ios-green)
    }

    /* ── BUTTON ─────────────────────────────── */
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 10px 18px;
      border-radius: var(--r-sm);
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      border: none;
      text-decoration: none;
      transition: all .2s var(--ease);
      font-family: inherit;
      white-space: nowrap;
      line-height: 1;
    }

    .btn svg {
      width: 15px;
      height: 15px;
      flex-shrink: 0
    }

    .btn-primary {
      background: var(--ios-blue);
      color: #fff;
      box-shadow: 0 4px 14px rgba(0, 122, 255, .3);
    }

    .btn-primary:hover {
      background: var(--ios-blue-dk);
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(0, 122, 255, .4)
    }

    .btn-primary:active {
      transform: scale(.97)
    }

    .btn-outline {
      background: var(--fill-3);
      color: var(--ios-blue);
      border: none
    }

    .btn-outline:hover {
      background: var(--fill-2);
      transform: translateY(-1px)
    }

    .btn-ghost {
      background: transparent;
      color: var(--label-2)
    }

    .btn-ghost:hover {
      background: var(--fill-4);
      color: var(--label)
    }

    .btn-danger {
      background: rgba(255, 59, 48, .1);
      color: var(--ios-red)
    }

    .btn-danger:hover {
      background: rgba(255, 59, 48, .18)
    }

    .btn-green {
      background: rgba(52, 199, 89, .12);
      color: #1B7A35
    }

    .btn-green:hover {
      background: rgba(52, 199, 89, .2)
    }

    .btn-blue {
      background: rgba(0, 122, 255, .1);
      color: var(--ios-blue)
    }

    .btn-blue:hover {
      background: rgba(0, 122, 255, .18)
    }

    .btn-purple {
      background: rgba(88, 86, 214, .1);
      color: var(--ios-indigo)
    }

    .btn-sm {
      padding: 7px 13px;
      font-size: 13px;
      border-radius: var(--r-xs)
    }

    .btn-xs {
      padding: 4px 10px;
      font-size: 12px;
      border-radius: 6px
    }

    /* ── GRID ───────────────────────────────── */
    .g2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px
    }

    .g3 {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px
    }

    .g4 {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px
    }

    .g-main {
      display: grid;
      grid-template-columns: 1fr 320px;
      gap: 16px;
      margin-bottom: 24px
    }

    .gc2 {
      grid-column: span 2
    }

    .gc3 {
      grid-column: span 3
    }

    .gc4 {
      grid-column: span 4
    }

    /* ── FORM ───────────────────────────────── */
    .fl {
      display: block;
      font-size: 13px;
      font-weight: 600;
      color: var(--label-2);
      margin-bottom: 6px
    }

    .fl .req {
      color: var(--ios-red);
      margin-left: 2px
    }

    .fi {
      width: 100%;
      padding: 11px 14px;
      border: .5px solid var(--sep-opaque);
      border-radius: var(--r-sm);
      font-size: 14px;
      color: var(--label);
      background: var(--surface);
      outline: none;
      font-family: inherit;
      transition: all .2s var(--ease);
      -webkit-appearance: none;
    }

    .fi:focus {
      border-color: var(--ios-blue);
      box-shadow: 0 0 0 3px rgba(0, 122, 255, .12)
    }

    .fi::placeholder {
      color: var(--label-3)
    }

    .fi-grp {
      margin-bottom: 16px
    }

    /* ── KPI ────────────────────────────────── */
    .kpi {
      background: var(--surface);
      border-radius: var(--r-lg);
      padding: 22px;
      position: relative;
      overflow: hidden;
      transition: all .3s var(--ease);
      cursor: default;
      box-shadow: var(--sh);
    }

    .kpi:hover {
      transform: translateY(-4px);
      box-shadow: var(--sh-lg)
    }

    .kpi-glow {
      position: absolute;
      right: -20px;
      bottom: -20px;
      width: 110px;
      height: 110px;
      border-radius: 50%;
      opacity: .15;
      pointer-events: none;
      filter: blur(22px);
    }

    .kpi-ico {
      width: 42px;
      height: 42px;
      border-radius: var(--r-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 14px;
    }

    .kpi-ico svg {
      width: 20px;
      height: 20px
    }

    .kpi-lbl {
      font-size: 11px;
      font-weight: 700;
      color: var(--label-3);
      text-transform: uppercase;
      letter-spacing: .08em;
      margin-bottom: 5px
    }

    .kpi-val {
      font-size: 25px;
      font-weight: 800;
      letter-spacing: -.8px;
      line-height: 1
    }

    .kpi-sub {
      font-size: 12px;
      color: var(--label-3);
      margin-top: 7px;
      display: flex;
      align-items: center;
      gap: 5px
    }

    /* ── MODAL ──────────────────────────────── */
    .modal-wrap {
      position: fixed;
      inset: 0;
      z-index: 500;
      background: rgba(0, 0, 0, .35);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      display: flex;
      align-items: flex-start;
      justify-content: center;
      padding: 16px;
      opacity: 0;
      pointer-events: none;
      transition: opacity .25s;
      overflow-y: auto;
    }

    .modal-wrap.open {
      opacity: 1;
      pointer-events: all
    }

    .modal {
      background: rgba(255, 255, 255, .95);
      backdrop-filter: saturate(180%) blur(20px);
      -webkit-backdrop-filter: saturate(180%) blur(20px);
      border-radius: var(--r-xl);
      width: 100%;
      max-width: 560px;
      max-height: 90vh;
      margin: 40px auto;
      overflow-y: auto;
      box-shadow: var(--sh-xl);
      transform: translateY(28px) scale(.94);
      transition: transform .3s var(--spring);
      scrollbar-width: none;
    }

    .modal::-webkit-scrollbar {
      width: 0
    }

    .modal-wrap.open .modal {
      transform: translateY(0) scale(1)
    }

    .modal-hd {
      padding: 22px 26px 18px;
      border-bottom: .5px solid var(--sep-opaque);
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      background: rgba(255, 255, 255, .9);
      backdrop-filter: blur(10px);
      z-index: 2;
    }

    .modal-title {
      font-size: 17px;
      font-weight: 800;
      color: var(--label);
      letter-spacing: -.4px
    }

    .modal-subtitle {
      font-size: 13px;
      color: var(--label-2);
      margin-top: 3px
    }

    .modal-x {
      width: 30px;
      height: 30px;
      border-radius: var(--r-xs);
      border: none;
      background: var(--fill-3);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: var(--label-2);
      transition: all .2s;
      flex-shrink: 0;
    }

    .modal-x:hover {
      background: var(--fill-2);
      color: var(--label)
    }

    .modal-x svg {
      width: 14px;
      height: 14px
    }

    .modal-bd {
      padding: 22px 26px
    }

    .modal-ft {
      padding: 18px 26px;
      border-top: .5px solid var(--sep-opaque);
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      position: sticky;
      bottom: 0;
      background: rgba(255, 255, 255, .9);
      backdrop-filter: blur(10px);
    }

    /* ── ALERT ──────────────────────────────── */
    .alert {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      padding: 13px 16px;
      border-radius: var(--r-sm);
      font-size: 14px;
      margin-bottom: 16px;
      line-height: 1.5;
    }

    .alert svg {
      width: 17px;
      height: 17px;
      flex-shrink: 0;
      margin-top: 1px
    }

    .alert-ok {
      background: rgba(52, 199, 89, .1);
      color: #1B7A35
    }

    .alert-err {
      background: rgba(255, 59, 48, .08);
      color: #CC3028
    }

    .alert-warn {
      background: rgba(255, 204, 0, .12);
      color: #8B7000
    }

    .alert-info {
      background: rgba(0, 122, 255, .1);
      color: var(--ios-blue)
    }

    /* ── SEARCH BAR ─────────────────────────── */
    .search-bar {
      display: flex;
      align-items: center;
      gap: 9px;
      background: var(--fill-3);
      border-radius: var(--r-sm);
      padding: 10px 14px;
      min-width: 0;
      transition: all .2s;
    }

    .search-bar:focus-within {
      background: var(--surface);
      box-shadow: 0 0 0 3px rgba(0, 122, 255, .12)
    }

    .search-bar svg {
      width: 15px;
      height: 15px;
      color: var(--label-3);
      flex-shrink: 0
    }

    .search-bar input {
      border: none;
      outline: none;
      font-size: 14px;
      color: var(--label);
      background: transparent;
      width: 100%;
      font-family: inherit;
    }

    .search-bar input::placeholder {
      color: var(--label-3)
    }

    /* ── FILTER PILLS ───────────────────────── */
    .pill {
      padding: 7px 14px;
      border-radius: var(--r-sm);
      font-size: 13px;
      font-weight: 600;
      color: var(--label-2);
      text-decoration: none;
      background: var(--fill-3);
      transition: all .2s var(--ease);
      white-space: nowrap;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .pill:hover {
      background: var(--fill-2);
      color: var(--label);
      transform: translateY(-1px)
    }

    .pill.on {
      background: var(--ios-blue);
      color: #fff;
      box-shadow: 0 4px 12px rgba(0, 122, 255, .3);
    }

    .pill-count {
      font-size: 11px;
      font-weight: 800;
      background: rgba(0, 0, 0, .08);
      padding: 1px 6px;
      border-radius: 6px;
    }

    .pill.on .pill-count {
      background: rgba(255, 255, 255, .2);
      color: #fff
    }

    /* ── MISC ───────────────────────────────── */
    .row {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap
    }

    .row-between {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px
    }

    .mb-12 {
      margin-bottom: 12px
    }

    .mb-16 {
      margin-bottom: 16px
    }

    .mb-20 {
      margin-bottom: 20px
    }

    .mb-24 {
      margin-bottom: 24px
    }

    .mt-8 {
      margin-top: 8px
    }

    .mt-12 {
      margin-top: 12px
    }

    .mt-16 {
      margin-top: 16px
    }

    .nowrap {
      white-space: nowrap
    }

    .mono {
      font-family: 'Courier New', monospace;
      letter-spacing: .02em
    }

    .bold {
      font-weight: 700
    }

    .semibold {
      font-weight: 600
    }

    .small {
      font-size: 12.5px
    }

    .smaller {
      font-size: 11px
    }

    .muted {
      color: var(--label-3)
    }

    .fw {
      width: 100%
    }

    .trunc {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis
    }

    .empty-state {
      padding: 60px 24px;
      text-align: center;
      color: var(--label-3)
    }

    .empty-state-ico {
      width: 68px;
      height: 68px;
      border-radius: var(--r-xl);
      background: var(--fill-4);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 18px;
    }

    .empty-state-ico svg {
      width: 30px;
      height: 30px;
      color: var(--label-3)
    }

    .empty-state p {
      font-size: 14px;
      margin-bottom: 14px;
      color: var(--label-2);
      font-weight: 500
    }

    .progress-bar {
      height: 6px;
      background: var(--fill-3);
      border-radius: 10px;
      overflow: hidden
    }

    .progress-fill {
      height: 100%;
      border-radius: 10px;
      transition: width .6s var(--spring)
    }

    .divider {
      border: none;
      border-top: .5px solid var(--sep-opaque);
      margin: 0
    }

    .tag {
      display: inline-flex;
      align-items: center;
      padding: 3px 8px;
      border-radius: 6px;
      font-size: 12px;
      font-weight: 700
    }

    .info-box {
      background: rgba(0, 122, 255, .06);
      border: .5px solid rgba(0, 122, 255, .2);
      border-left: 3px solid var(--ios-blue);
      border-radius: var(--r-sm);
      padding: 14px 18px;
      font-size: 13.5px;
      color: var(--label-2);
      line-height: 1.6;
    }

    .info-box strong {
      color: var(--label)
    }

    /* ── RESPONSIVE ─────────────────────────── */
    @media(max-width:1024px) {
      .g4 {
        grid-template-columns: 1fr 1fr
      }

      .gc4 {
        grid-column: span 2
      }

      .g-main {
        grid-template-columns: 1fr
      }
    }

    @media(max-width:768px) {
      :root {
        --sw: 0px;
        --th: 52px
      }

      #f-side {
        width: 270px;
        transform: translateX(-100%);
        transition: transform .3s var(--ease);
        box-shadow: var(--sh-xl);
      }

      #f-side.open {
        transform: translateX(0)
      }

      .f-overlay {
        position: fixed;
        inset: 0;
        z-index: 150;
        background: rgba(0, 0, 0, .4);
        backdrop-filter: blur(2px);
        opacity: 0;
        pointer-events: none;
        transition: opacity .3s var(--ease);
      }

      .f-overlay.open {
        opacity: 1;
        pointer-events: all
      }

      .f-top-center {
        display: none
      }

      #f-main {
        margin-left: 0
      }

      .f-page {
        padding: 16px;
        padding-bottom: 120px
      }

      .g2,
      .g3,
      .g4 {
        grid-template-columns: 1fr;
        gap: 12px
      }

      .gc2,
      .gc3,
      .gc4 {
        grid-column: span 1
      }

      .row-between {
        flex-direction: column;
        align-items: flex-start
      }
    }

    /* ══════════════════════════════════════════
   SPLASH SCREEN
══════════════════════════════════════════ */
    #splash {
      position: fixed;
      inset: 0;
      z-index: 9999;
      background: #ffffff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      transition: opacity .55s ease, visibility .55s ease;
      overflow: hidden;
    }

    #splash.hide {
      opacity: 0;
      visibility: hidden;
      pointer-events: none
    }

    /* Glow pojok kanan bawah — sesuai brand 153 */
    #splash::after {
      content: '';
      position: absolute;
      bottom: -80px;
      right: -80px;
      width: 460px;
      height: 460px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255, 107, 0, .28) 0%, rgba(255, 60, 0, .12) 45%, transparent 70%);
      pointer-events: none;
      animation: glowPulse 3s ease-in-out infinite alternate;
    }

    @keyframes glowPulse {
      from {
        transform: scale(.9);
        opacity: .7
      }

      to {
        transform: scale(1.05);
        opacity: 1
      }
    }

    /* Optional: glow kiri atas tipis */
    #splash::before {
      content: '';
      position: absolute;
      top: -120px;
      left: -120px;
      width: 350px;
      height: 350px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255, 160, 60, .1) 0%, transparent 65%);
      pointer-events: none;
    }

    .splash-logo-wrap {
      position: relative;
      z-index: 1;
      animation: splashIn .65s cubic-bezier(.34, 1.56, .64, 1) forwards;
      opacity: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    @keyframes splashIn {
      from {
        opacity: 0;
        transform: scale(.75) translateY(24px)
      }

      to {
        opacity: 1;
        transform: scale(1) translateY(0)
      }
    }

    /* Logo langsung — tanpa box gelap */
    .splash-logo-inner {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .splash-logo-inner img {
      height: 72px;
      width: auto;
      object-fit: contain;
    }

    /* Teks brand */
    .splash-brand-name {
      margin-top: 18px;
      font-size: 15px;
      font-weight: 800;
      letter-spacing: .18em;
      text-transform: uppercase;
      background: linear-gradient(135deg, #C0390A, #E8510A, #FF8C00);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      animation: splashIn .65s .15s cubic-bezier(.34, 1.56, .64, 1) forwards;
      opacity: 0;
    }

    .splash-brand-sub {
      margin-top: 4px;
      font-size: 9.5px;
      font-weight: 700;
      letter-spacing: .32em;
      text-transform: uppercase;
      color: #bbb;
      animation: splashIn .65s .25s cubic-bezier(.34, 1.56, .64, 1) forwards;
      opacity: 0;
    }

    /* Loading bar — warna oranye brand */
    .splash-bar-wrap {
      margin-top: 36px;
      width: 130px;
      height: 2.5px;
      background: rgba(0, 0, 0, .06);
      border-radius: 4px;
      overflow: hidden;
      animation: splashIn .4s .3s ease forwards;
      opacity: 0;
    }

    .splash-bar {
      height: 100%;
      width: 0;
      background: linear-gradient(90deg, #E8510A, #FF8C00, #FFB347);
      border-radius: 4px;
      animation: barFill .85s .45s cubic-bezier(.4, 0, .2, 1) forwards;
    }

    @keyframes barFill {
      from {
        width: 0
      }

      to {
        width: 100%
      }
    }

    /* ══════════════════════════════════════════
   SIDEBAR INTERACTIVE ENHANCEMENTS
══════════════════════════════════════════ */

    /* Ripple */
    .f-link {
      overflow: hidden
    }

    /* already set, just confirming */
    .f-ripple {
      position: absolute;
      border-radius: 50%;
      background: rgba(0, 122, 255, .18);
      transform: scale(0);
      pointer-events: none;
      animation: rippleOut .55s ease-out forwards;
    }

    @keyframes rippleOut {
      to {
        transform: scale(4);
        opacity: 0
      }
    }

    /* Stagger sidebar links — hanya saat first visit / F5 */
    body:not(.nav-internal) .f-link,
    body:not(.nav-internal) .f-sec {
      opacity: 0;
      animation: sideSlideIn .35s var(--ease) forwards;
    }

    /* Navigasi internal: langsung tampil tanpa animasi */
    body.nav-internal .f-link,
    body.nav-internal .f-sec {
      opacity: 1;
      animation: none;
    }

    @keyframes sideSlideIn {
      from {
        opacity: 0;
        transform: translateX(-12px)
      }

      to {
        opacity: 1;
        transform: translateX(0)
      }
    }

    /* Sidebar active indicator */
    .f-link.on::after {
      content: '';
      position: absolute;
      right: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 3px;
      height: 60%;
      border-radius: 3px 0 0 3px;
      background: var(--ios-blue);
      animation: indicatorIn .25s var(--spring) forwards;
    }

    @keyframes indicatorIn {
      from {
        height: 0;
        opacity: 0
      }

      to {
        height: 60%;
        opacity: 1
      }
    }

    /* Tooltip for nav links */
    .f-link[data-tip]::before {
      content: attr(data-tip);
      position: absolute;
      left: calc(100% + 10px);
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0, 0, 0, .82);
      color: #fff;
      font-size: 11px;
      font-weight: 600;
      padding: 5px 10px;
      border-radius: 7px;
      white-space: nowrap;
      pointer-events: none;
      opacity: 0;
      transition: opacity .15s;
      z-index: 999;
    }

    .f-link[data-tip]:hover::before {
      opacity: 1
    }

    /* Page fade-in */
    #f-main {
      animation: pageIn .4s .1s ease both;
    }

    @keyframes pageIn {
      from {
        opacity: 0;
        transform: translateY(8px)
      }

      to {
        opacity: 1;
        transform: none
      }
    }

    /* Skip ALL animations on internal navigation */
    body.nav-internal #f-main {
      animation: none !important;
      opacity: 1
    }

    body.nav-internal .f-link,
    body.nav-internal .f-sec {
      animation: none !important;
      opacity: 1
    }

    body.nav-internal #splash {
      display: none !important
    }
  </style>
  @stack('styles')
</head>

<body>
  <!-- Deteksi navigasi internal SEBELUM elemen lain render -->
  <script>
    (function () {
      var nav = performance.getEntriesByType('navigation')[0];
      var type = nav ? nav.type : 'navigate';
      var ref = document.referrer;
      var internal = (type === 'navigate') && ref && ref.indexOf(window.location.host) !== -1;
      if (internal) document.body.classList.add('nav-internal');
    })();
  </script>

  <!-- ░░░ SPLASH SCREEN ░░░ -->
  <div id="splash">
    <div class="splash-logo-wrap">
      <div class="splash-logo-inner">
        <img src="{{ asset('assets/img/153.png') }}" alt="153 Kreatif">
      </div>
      <div class="splash-brand-name">PT 153 CREATIVE</div>
      <div class="splash-brand-sub">Event Organizer</div>
      <div class="splash-bar-wrap">
        <div class="splash-bar"></div>
      </div>
    </div>
  </div>

  <!-- TOPBAR -->
  <header id="f-top">
    <button class="f-hamburger" onclick="toggleSidebar()" aria-label="Toggle sidebar">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
          d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
      </svg>
    </button>
    <a href="{{ route('admin.finance.index') }}" class="f-brand">
      <img src="{{ asset('assets/img/153.png') }}" alt="153 Kreatif" class="f-brand-img">
      <span class="f-brand-tag">Finance</span>
    </a>
    <div class="f-top-center">
      <div class="f-breadcrumb">
        <span>Finance</span>
        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="f-breadcrumb-cur">@yield('page-title', 'Dashboard Keuangan')</span>
      </div>
    </div>
    <div class="f-top-right">
      <a href="{{ route('admin.home.index') }}" class="f-icon-btn" title="Kembali ke Admin">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
      </a>
      <div class="f-avatar" title="Administrator">AD</div>
    </div>
  </header>

  <!-- SIDEBAR -->
  <aside id="f-side">
    <nav class="f-nav">
      <div class="f-sec">Overview</div>
      <a href="{{ route('admin.finance.index') }}"
        class="f-link {{ request()->routeIs('admin.finance.index') ? 'on' : '' }}">
        <span class="ico"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10-1a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z" />
          </svg></span>
        <span class="lbl">Dashboard</span>
      </a>

      <div class="f-sec">Transaksi</div>
      <a href="{{ route('admin.finance.invoices.index') }}"
        class="f-link {{ request()->routeIs('admin.finance.invoices.*') ? 'on' : '' }}">
        <span class="ico"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg></span>
        <span class="lbl">Invoice</span>
        @if($sidebarOverdueCount > 0)<span class="f-badge r">{{ $sidebarOverdueCount }}</span>@endif
      </a>
      <a href="{{ route('admin.finance.quotations.index') }}"
        class="f-link {{ request()->routeIs('admin.finance.quotations.*') ? 'on' : '' }}">
        <span class="ico"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
          </svg></span>
        <span class="lbl">Quotation</span>
        @if($sidebarQuotationCount > 0)<span class="f-badge a">{{ $sidebarQuotationCount }}</span>@endif
      </a>
      <a href="{{ route('admin.finance.purchase-orders.index') }}"
        class="f-link {{ request()->routeIs('admin.finance.purchase-orders.*') ? 'on' : '' }}">
        <span class="ico"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
          </svg></span>
        <span class="lbl">Purchase Order</span>
        @if($sidebarPendingPOCount > 0)<span class="f-badge a">{{ $sidebarPendingPOCount }}</span>@endif
      </a>

      <div class="f-sec">Keuangan</div>
      <a href="{{ route('admin.finance.incomes.index') }}"
        class="f-link {{ request()->routeIs('admin.finance.incomes.*') ? 'on' : '' }}">
        <span class="ico"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
          </svg></span>
        <span class="lbl">Pemasukan</span>
      </a>
      <a href="{{ route('admin.finance.expenses.index') }}"
        class="f-link {{ request()->routeIs('admin.finance.expenses.*') ? 'on' : '' }}">
        <span class="ico"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
          </svg></span>
        <span class="lbl">Pengeluaran</span>
      </a>
      <a href="{{ route('admin.finance.commissions.index') }}"
        class="f-link {{ request()->routeIs('admin.finance.commissions.*') ? 'on' : '' }}">
        <span class="ico"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg></span>
        <span class="lbl">Komisi</span>
      </a>
      <a href="{{ route('admin.finance.bank.index') }}"
        class="f-link {{ request()->routeIs('admin.finance.bank.*') ? 'on' : '' }}">
        <span class="ico"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 10h18M3 14h18m-9-4V6m0 8v4M5 6l7-3 7 3M5 18h14" />
          </svg></span>
        <span class="lbl">Bank &amp; Kas</span>
      </a>

      <div class="f-sec">Perencanaan</div>
      <a href="{{ route('admin.finance.budgets.index') }}"
        class="f-link {{ request()->routeIs('admin.finance.budgets.*') ? 'on' : '' }}">
        <span class="ico"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg></span>
        <span class="lbl">Anggaran</span>
      </a>
    </nav>

    <div class="f-foot">
      <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit" class="f-logout">
          <span class="ico">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
          </span>
          <span class="lbl">Keluar</span>
        </button>
      </form>
    </div>
  </aside>

  <div class="f-overlay" onclick="toggleSidebar()"></div>

  <!-- CONTENT -->
  <main id="f-main">
    <div class="f-page">
      @if(session('success'))
        <div class="alert alert-ok">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>{{ session('success') }}</span>
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-err">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>{{ session('error') }}</span>
        </div>
      @endif
      @yield('content')
    </div>
  </main>

  @stack('scripts')
  <script>
    /* ── Splash — muncul saat F5 / first visit, skip saat navigasi internal ── */
    (function () {
      const s = document.getElementById('splash');
      if (!s) return;

      // Deteksi jenis load
      const navEntry = performance.getEntriesByType('navigation')[0];
      const navType = navEntry ? navEntry.type : 'navigate';          // 'reload' | 'navigate' | 'back_forward'
      const isReload = navType === 'reload';
      const isFirst = !document.referrer || !document.referrer.includes(window.location.host);

      if (!isReload && !isFirst) {
        // Navigasi antar halaman internal → langsung hilang
        s.style.display = 'none';
        s.remove();
        return;
      }

      // F5 atau buka pertama kali → tampilkan splash
      window.addEventListener('load', () => {
        setTimeout(() => {
          s.classList.add('hide');
          setTimeout(() => s.remove(), 600);
        }, 1100);
      });
    })();

    /* ── Sidebar stagger — hanya saat F5/first visit ── */
    (function () {
      const navEntry = performance.getEntriesByType('navigation')[0];
      const navType = navEntry ? navEntry.type : 'navigate';
      const isInternal = (navType === 'navigate') &&
        document.referrer &&
        document.referrer.includes(window.location.host);

      if (isInternal) {
        // Navigasi internal: matikan semua animasi sidebar
        document.body.classList.add('nav-internal');
      } else {
        // F5 / first visit: terapkan stagger delay
        const items = document.querySelectorAll('#f-side .f-link, #f-side .f-sec');
        items.forEach((el, i) => {
          el.style.animationDelay = (0.05 + i * 0.045) + 's';
        });
      }
    })();

    /* ── Sidebar ripple ── */
    document.querySelectorAll('.f-link').forEach(link => {
      link.addEventListener('click', function (e) {
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        const rip = document.createElement('span');
        rip.className = 'f-ripple';
        rip.style.cssText = `width:${size}px;height:${size}px;left:${x}px;top:${y}px`;
        this.appendChild(rip);
        setTimeout(() => rip.remove(), 600);
      });
    });

    /* ── Sidebar toggle ── */
    function toggleSidebar() {
      const s = document.getElementById('f-side');
      const o = document.querySelector('.f-overlay');
      s.classList.toggle('open');
      if (o) o.classList.toggle('open');
    }
  </script>
</body>

</html>