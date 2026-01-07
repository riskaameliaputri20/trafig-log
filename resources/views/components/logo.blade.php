<style>
    .brand-logo-container {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        padding: 8px 16px;
        transition: all 0.3s ease;
    }

    /* Monitoring Dot dengan efek Neon */
    .brand-status-dot {
        width: 8px;
        height: 8px;
        background-color: #22c55e; /* Hijau Monitor */
        border-radius: 50%;
        margin-right: 12px;
        position: relative;
        box-shadow: 0 0 10px rgba(34, 197, 94, 0.8);
        animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
        70% { box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }

    /* LOG SCREEN - Bold & Tech */
    .brand-text-main {
        font-size: 22px;
        font-weight: 900;
        color: #ffffff;
        letter-spacing: -1px; /* Rapat agar terlihat solid */
        text-transform: uppercase;
        font-family: 'Inter', sans-serif;
    }

    /* Pembatas (Divider) Tipis */
    .brand-divider {
        height: 20px;
        width: 1px;
        background-color: rgba(255, 255, 255, 0.2);
        margin: 0 12px;
    }

    /* RISKA - Signature Style */
    .brand-text-riska {
        font-size: 18px;
        font-weight: 200; /* Sangat tipis */
        color: #94a3b8; /* Abu-abu metalik */
        letter-spacing: 4px; /* Sangat renggang untuk kesan mewah */
        text-transform: uppercase;
        font-family: 'Inter', sans-serif;
        transition: color 0.3s ease;
    }

    /* Hover effect agar interaktif */
    .brand-logo-container:hover .brand-text-riska {
        color: #0ab39c; /* Berubah ke warna identitas saat di-hover */
    }
</style>
<div class="text-center mb-10">
    <a href="/" class="brand-logo-container group">
        <div class="brand-status-dot"></div>
        
        <span class="brand-text-main">LOG<span class="text-emerald-400">SCREEN</span></span>
        
        <div class="brand-divider"></div>
        
        <span class="brand-text-riska">RISKA</span>
    </a>
    
    <p class="mt-2 text-slate-400 text-sm font-light tracking-widest">
        APACHE TRAFFIC ANALYZER SYSTEM
    </p>
</div>