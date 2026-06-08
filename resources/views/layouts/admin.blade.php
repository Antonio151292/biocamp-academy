@extends('adminlte::page')

@section('css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
/* ============================================================
   BIOCAMP ACADEMY — Modern Dark Admin Theme Override
   ============================================================ */
:root {
    --bc-primary: #7c3aed;
    --bc-primary-light: #8b5cf6;
    --bc-primary-glow: rgba(124, 58, 237, 0.25);
    --bc-accent: #06b6d4;
    --bc-bg: #0f172a;
    --bc-bg-card: #1e293b;
    --bc-bg-sidebar: #0f172a;
    --bc-border: rgba(255,255,255,0.07);
    --bc-text: #f1f5f9;
    --bc-text-muted: #94a3b8;
    --bc-success: #10b981;
    --bc-warning: #f59e0b;
    --bc-danger: #ef4444;
    --bc-info: #06b6d4;
}

body, .wrapper, html {
    font-family: 'Inter', sans-serif !important;
    background-color: var(--bc-bg) !important;
    color: var(--bc-text) !important;
}

/* ---- Sidebar ---- */
.main-sidebar, .sidebar {
    background: linear-gradient(180deg, #0f172a 0%, #1a1040 50%, #0f172a 100%) !important;
    border-right: 1px solid var(--bc-border) !important;
    box-shadow: 4px 0 24px rgba(0,0,0,0.4) !important;
}
.brand-link {
    background: linear-gradient(135deg, #7c3aed, #4f46e5) !important;
    border-bottom: 1px solid rgba(255,255,255,0.1) !important;
    padding: 16px 20px !important;
}
.brand-text { font-family: 'Outfit', sans-serif !important; font-weight: 800 !important; letter-spacing: -0.5px; }
.sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link {
    color: var(--bc-text-muted) !important;
    border-radius: 10px !important;
    margin: 2px 10px !important;
    padding: 10px 14px !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    transition: all 0.2s ease !important;
}
.sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link:hover,
.sidebar-dark-primary .nav-sidebar > .nav-item.menu-open > .nav-link,
.sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
    background: rgba(124, 58, 237, 0.18) !important;
    color: #c4b5fd !important;
    border-left: 3px solid var(--bc-primary) !important;
    padding-left: 11px !important;
}
.sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link .nav-icon { color: #8b5cf6 !important; }
.nav-header { color: #4b5563 !important; font-size: 10px !important; letter-spacing: 1.5px !important; padding: 14px 20px 4px !important; }
.sidebar-dark-primary .sidebar a { color: var(--bc-text-muted) !important; }

/* ---- Top Navbar ---- */
.main-header.navbar {
    background: rgba(15, 23, 42, 0.95) !important;
    backdrop-filter: blur(16px) !important;
    border-bottom: 1px solid var(--bc-border) !important;
    box-shadow: 0 1px 20px rgba(0,0,0,0.3) !important;
}
.navbar-white .nav-link, .navbar-light .nav-link { color: var(--bc-text-muted) !important; }
.navbar-white .nav-link:hover { color: var(--bc-text) !important; }

/* ---- Content Wrapper ---- */
.content-wrapper {
    background: var(--bc-bg) !important;
    min-height: 100vh;
}
.content-header h1 {
    font-family: 'Outfit', sans-serif !important;
    font-weight: 700 !important;
    color: var(--bc-text) !important;
    font-size: 1.5rem !important;
}
.breadcrumb-item, .breadcrumb-item.active, .breadcrumb-item a { color: var(--bc-text-muted) !important; }

/* ---- Cards ---- */
.card {
    background: var(--bc-bg-card) !important;
    border: 1px solid var(--bc-border) !important;
    border-radius: 16px !important;
    box-shadow: 0 4px 24px rgba(0,0,0,0.25) !important;
    color: var(--bc-text) !important;
    overflow: hidden;
}
.card-header {
    background: rgba(255,255,255,0.03) !important;
    border-bottom: 1px solid var(--bc-border) !important;
    padding: 16px 20px !important;
}
.card-title { color: var(--bc-text) !important; font-weight: 600 !important; font-size: 14px !important; }
.card-body { color: var(--bc-text) !important; }
.card-footer { background: rgba(255,255,255,0.02) !important; border-top: 1px solid var(--bc-border) !important; }

/* Colored card accent bars */
.card-primary { border-top: 3px solid var(--bc-primary) !important; }
.card-info { border-top: 3px solid var(--bc-info) !important; }
.card-success { border-top: 3px solid var(--bc-success) !important; }
.card-warning { border-top: 3px solid var(--bc-warning) !important; }
.card-danger { border-top: 3px solid var(--bc-danger) !important; }

/* ---- Small boxes (dashboard stats) ---- */
.small-box {
    border-radius: 16px !important;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,0.3) !important;
    border: 1px solid var(--bc-border) !important;
}
.small-box .inner h3 { font-family: 'Outfit', sans-serif !important; font-size: 2rem !important; }
.small-box-footer { font-size: 12px !important; }
.small-box.bg-info { background: linear-gradient(135deg, #0891b2, #0e7490) !important; }
.small-box.bg-success { background: linear-gradient(135deg, #059669, #047857) !important; }
.small-box.bg-warning { background: linear-gradient(135deg, #d97706, #b45309) !important; }
.small-box.bg-danger { background: linear-gradient(135deg, #dc2626, #b91c1c) !important; }
.small-box.bg-primary { background: linear-gradient(135deg, #7c3aed, #4f46e5) !important; }

/* ---- Tables ---- */
.table { color: var(--bc-text) !important; }
.table thead th {
    background: rgba(255,255,255,0.04) !important;
    color: var(--bc-text-muted) !important;
    border-bottom: 1px solid var(--bc-border) !important;
    font-size: 11px !important;
    text-transform: uppercase !important;
    letter-spacing: 0.8px !important;
    font-weight: 600 !important;
    padding: 12px 16px !important;
}
.table tbody td { border-top: 1px solid var(--bc-border) !important; padding: 12px 16px !important; vertical-align: middle !important; }
.table-striped tbody tr:nth-of-type(odd) { background-color: rgba(255,255,255,0.02) !important; }
.table tbody tr:hover { background: rgba(124,58,237,0.06) !important; }

/* ---- Badges ---- */
.badge-success { background: rgba(16,185,129,0.2) !important; color: #34d399 !important; border: 1px solid rgba(16,185,129,0.3) !important; border-radius: 6px !important; padding: 4px 8px !important; }
.badge-warning { background: rgba(245,158,11,0.2) !important; color: #fbbf24 !important; border: 1px solid rgba(245,158,11,0.3) !important; border-radius: 6px !important; padding: 4px 8px !important; }
.badge-danger { background: rgba(239,68,68,0.2) !important; color: #f87171 !important; border: 1px solid rgba(239,68,68,0.3) !important; border-radius: 6px !important; padding: 4px 8px !important; }
.badge-primary { background: rgba(124,58,237,0.25) !important; color: #c4b5fd !important; border: 1px solid rgba(124,58,237,0.4) !important; border-radius: 6px !important; padding: 4px 8px !important; }
.badge-info { background: rgba(6,182,212,0.2) !important; color: #67e8f9 !important; border: 1px solid rgba(6,182,212,0.3) !important; border-radius: 6px !important; padding: 4px 8px !important; }
.badge-secondary { background: rgba(148,163,184,0.15) !important; color: #94a3b8 !important; border: 1px solid rgba(148,163,184,0.2) !important; border-radius: 6px !important; padding: 4px 8px !important; }

/* ---- Buttons ---- */
.btn-primary {
    background: linear-gradient(135deg, var(--bc-primary), #4f46e5) !important;
    border: none !important;
    border-radius: 10px !important;
    font-weight: 600 !important;
    letter-spacing: 0.3px !important;
    box-shadow: 0 4px 12px var(--bc-primary-glow) !important;
    transition: all 0.2s ease !important;
}
.btn-primary:hover { transform: translateY(-1px) !important; box-shadow: 0 6px 20px var(--bc-primary-glow) !important; }
.btn-success { background: linear-gradient(135deg, #059669, #047857) !important; border: none !important; border-radius: 10px !important; }
.btn-danger { background: linear-gradient(135deg, #dc2626, #b91c1c) !important; border: none !important; border-radius: 10px !important; }
.btn-info { background: linear-gradient(135deg, #0891b2, #0e7490) !important; border: none !important; border-radius: 10px !important; }
.btn-secondary { background: rgba(255,255,255,0.08) !important; border: 1px solid var(--bc-border) !important; border-radius: 10px !important; color: var(--bc-text-muted) !important; }
.btn-warning { background: linear-gradient(135deg, #d97706, #b45309) !important; border: none !important; border-radius: 10px !important; }
.btn-outline-primary { border-color: rgba(124,58,237,0.5) !important; color: #c4b5fd !important; border-radius: 10px !important; }
.btn-outline-primary:hover { background: rgba(124,58,237,0.15) !important; }
.btn-outline-secondary { border-color: var(--bc-border) !important; color: var(--bc-text-muted) !important; border-radius: 10px !important; }
.btn-outline-secondary:hover { background: rgba(255,255,255,0.05) !important; }
.btn-outline-info { border-color: rgba(6,182,212,0.5) !important; color: #67e8f9 !important; border-radius: 10px !important; }
.btn-outline-success { border-color: rgba(16,185,129,0.5) !important; color: #34d399 !important; border-radius: 10px !important; }
.btn-outline-danger { border-color: rgba(239,68,68,0.5) !important; color: #f87171 !important; border-radius: 10px !important; }
.btn-block { width: 100% !important; }

/* ---- Forms ---- */
.form-control {
    background: rgba(255,255,255,0.05) !important;
    border: 1px solid var(--bc-border) !important;
    border-radius: 10px !important;
    color: var(--bc-text) !important;
    font-size: 14px !important;
    padding: 10px 14px !important;
    transition: all 0.2s ease !important;
}
.form-control:focus {
    background: rgba(255,255,255,0.08) !important;
    border-color: rgba(124,58,237,0.6) !important;
    box-shadow: 0 0 0 3px var(--bc-primary-glow) !important;
    color: var(--bc-text) !important;
}
.form-control::placeholder { color: #475569 !important; }
select.form-control option { background: #1e293b; color: var(--bc-text); }
label { color: var(--bc-text-muted) !important; font-size: 12px !important; font-weight: 600 !important; letter-spacing: 0.4px !important; text-transform: uppercase !important; margin-bottom: 6px !important; }
.form-group { margin-bottom: 18px !important; }
.input-group-text { background: rgba(255,255,255,0.06) !important; border: 1px solid var(--bc-border) !important; color: var(--bc-text-muted) !important; }
.custom-control-label { color: var(--bc-text) !important; }
.custom-control-label::before { background-color: rgba(255,255,255,0.07) !important; border-color: var(--bc-border) !important; }
.custom-control-input:checked ~ .custom-control-label::before { background-color: var(--bc-primary) !important; border-color: var(--bc-primary) !important; }

/* ---- Nav pills ---- */
.nav-pills .nav-link { border-radius: 10px !important; color: var(--bc-text-muted) !important; font-size: 13px !important; font-weight: 500 !important; padding: 8px 16px !important; }
.nav-pills .nav-link.active { background: rgba(124,58,237,0.2) !important; color: #c4b5fd !important; border: 1px solid rgba(124,58,237,0.4) !important; }

/* ---- Alerts ---- */
.alert-success { background: rgba(16,185,129,0.12) !important; border: 1px solid rgba(16,185,129,0.3) !important; color: #34d399 !important; border-radius: 12px !important; }
.alert-danger { background: rgba(239,68,68,0.12) !important; border: 1px solid rgba(239,68,68,0.3) !important; color: #f87171 !important; border-radius: 12px !important; }
.alert-warning { background: rgba(245,158,11,0.12) !important; border: 1px solid rgba(245,158,11,0.3) !important; color: #fbbf24 !important; border-radius: 12px !important; }

/* ---- List groups ---- */
.list-group-item { background: var(--bc-bg-card) !important; border: 1px solid var(--bc-border) !important; color: var(--bc-text) !important; }
.list-group-item:hover { background: rgba(124,58,237,0.08) !important; }
.list-group-item.active { background: rgba(124,58,237,0.2) !important; border-color: rgba(124,58,237,0.5) !important; color: #c4b5fd !important; }

/* ---- Modal ---- */
.modal-content { background: var(--bc-bg-card) !important; border: 1px solid var(--bc-border) !important; border-radius: 20px !important; }
.modal-header { border-bottom: 1px solid var(--bc-border) !important; padding: 20px 24px !important; }
.modal-footer { border-top: 1px solid var(--bc-border) !important; padding: 16px 24px !important; }
.modal-title { color: var(--bc-text) !important; font-family: 'Outfit', sans-serif !important; font-weight: 700 !important; }
.close { color: var(--bc-text-muted) !important; opacity: 1 !important; }
.close:hover { color: var(--bc-text) !important; }

/* ---- Accordion / Collapse ---- */
.card.border { border: 1px solid var(--bc-border) !important; }
.card-header.bg-light { background: rgba(255,255,255,0.04) !important; }
.accordion .card { margin-bottom: 4px !important; }

/* ---- Scrollbar ---- */
::-webkit-scrollbar { width: 5px; height: 5px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: rgba(124,58,237,0.35); border-radius: 3px; }
::-webkit-scrollbar-thumb:hover { background: rgba(124,58,237,0.6); }

/* ---- Page header strip ---- */
.content-header { padding: 20px 20px 10px !important; }
.content-header .breadcrumb { background: transparent !important; }

/* ---- TinyMCE modern wrapper ---- */
.modern-canva-editor {
    background: rgba(255,255,255,0.03);
    padding: 16px;
    border-radius: 14px;
    border: 1px solid var(--bc-border);
    margin-bottom: 15px;
}
.modern-canva-editor .tox-tinymce {
    border: none !important;
    border-radius: 10px !important;
    background: #1e293b !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3) !important;
    transition: box-shadow 0.2s ease;
}
.modern-canva-editor .tox-tinymce:focus-within {
    box-shadow: 0 8px 30px var(--bc-primary-glow) !important;
}
.tox .tox-editor-header { background: #1e293b !important; border-bottom: 1px solid var(--bc-border) !important; }
.tox .tox-toolbar, .tox .tox-toolbar__overflow, .tox .tox-toolbar-overlord { background: #1e293b !important; }
.tox .tox-toolbar__group { border-right: 1px solid rgba(255,255,255,0.06) !important; }
.tox .tox-tbtn svg { fill: #94a3b8 !important; }
.tox .tox-tbtn:hover svg { fill: #c4b5fd !important; }
.tox-statusbar { background: #1e293b !important; border-top: 1px solid var(--bc-border) !important; color: #475569 !important; }
.tox .tox-edit-area__iframe { background: #0f172a !important; }

/* ---- Canva Page Builder specific ---- */
.page-builder-canvas {
    background: rgba(15,23,42,0.8);
    border-radius: 20px;
    border: 1px solid var(--bc-border);
    min-height: 500px;
    position: relative;
    overflow: hidden;
}
.page-builder-canvas::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(255,255,255,0.03) 1px, transparent 1px);
    background-size: 24px 24px;
    pointer-events: none;
}
.block-palette-item {
    background: rgba(255,255,255,0.04);
    border: 1px dashed rgba(124,58,237,0.35);
    border-radius: 12px;
    padding: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
}
.block-palette-item:hover {
    background: rgba(124,58,237,0.12);
    border-color: rgba(124,58,237,0.7);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(124,58,237,0.15);
}
.block-palette-item i { font-size: 22px; color: #8b5cf6; margin-bottom: 6px; display: block; }
.block-palette-item span { font-size: 11px; color: var(--bc-text-muted); font-weight: 600; }
.canvas-section-item {
    background: rgba(255,255,255,0.03);
    border: 1px solid var(--bc-border);
    border-radius: 12px;
    padding: 12px 16px;
    margin-bottom: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.canvas-section-item:hover { background: rgba(124,58,237,0.08); border-color: rgba(124,58,237,0.4); }
.canvas-section-item.selected { background: rgba(124,58,237,0.15); border-color: rgba(124,58,237,0.7); }
.drag-handle { color: #334155; cursor: grab; padding: 4px 8px; border-radius: 6px; transition: color 0.15s; }
.drag-handle:hover { color: #8b5cf6; background: rgba(124,58,237,0.15); }
.canvas-section-item.selected .drag-handle { color: #8b5cf6; }
.inspector-panel { position: sticky; top: 80px; max-height: calc(100vh - 120px); overflow-y: auto; }
.section-type-badge {
    font-size: 9px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
    background: rgba(124,58,237,0.25); color: #c4b5fd; border-radius: 5px; padding: 2px 8px;
    border: 1px solid rgba(124,58,237,0.4);
}
.bc-divider { height: 1px; background: var(--bc-border); margin: 20px 0; }
.stats-sparkline { height: 3px; border-radius: 2px; }
</style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
@endsection

@section('content')
    {{ $slot }}
@endsection
