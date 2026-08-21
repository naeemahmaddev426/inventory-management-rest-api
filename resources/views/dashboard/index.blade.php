@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Overview</li>
@endsection

@section('content')
<!-- Stats Grid -->
<div class="row g-3 mb-4" id="statsGrid">
    <!-- Stat cards injected by JS -->
    @for($i=0;$i<8;$i++)
    <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="stat-card" style="animation: fadeIn .3s ease {{ $i * 0.05 }}s both;">
            <div class="loading-overlay" style="padding:30px;">
                <div class="spinner-ring"></div>
            </div>
        </div>
    </div>
    @endfor
</div>

<!-- Recent Activity Row -->
<div class="row g-3">
    <!-- Recent Products -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title"><i class="bi bi-box-seam me-2 text-primary"></i>Recent Products</h6>
                <a href="{{ route('dashboard.products') }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;font-size:.75rem;">View All</a>
            </div>
            <div class="card-body p-0">
                <div id="recentProducts"><div class="loading-overlay"><div class="spinner-ring"></div></div></div>
            </div>
        </div>
    </div>

    <!-- Recent Purchases -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title"><i class="bi bi-cart-check me-2 text-success"></i>Recent Purchases</h6>
                <a href="{{ route('dashboard.purchases') }}" class="btn btn-sm btn-outline-success" style="border-radius:8px;font-size:.75rem;">View All</a>
            </div>
            <div class="card-body p-0">
                <div id="recentPurchases"><div class="loading-overlay"><div class="spinner-ring"></div></div></div>
            </div>
        </div>
    </div>

    <!-- Category Distribution -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="card-title"><i class="bi bi-tag me-2" style="color:#f59e0b;"></i>Categories</h6>
            </div>
            <div class="card-body p-0">
                <div id="categoryList"><div class="loading-overlay"><div class="spinner-ring"></div></div></div>
            </div>
        </div>
    </div>

    <!-- Warehouse Summary -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="card-title"><i class="bi bi-building me-2" style="color:#8b5cf6;"></i>Warehouses</h6>
            </div>
            <div class="card-body p-0">
                <div id="warehouseList"><div class="loading-overlay"><div class="spinner-ring"></div></div></div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="card-title"><i class="bi bi-lightning me-2 text-warning"></i>Quick Info</h6>
            </div>
            <div class="card-body">
                <div id="quickInfo"><div class="loading-overlay"><div class="spinner-ring"></div></div></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @keyframes fadeIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:none; } }
    .mini-list-item {
        display:flex; align-items:center; justify-content:space-between;
        padding: 10px 16px;
        border-bottom: 1px solid var(--border-color);
        font-size: .82rem;
    }
    .mini-list-item:last-child { border-bottom: none; }
    .mini-list-item .item-name { font-weight:500; color:var(--text-primary); }
    .mini-list-item .item-meta { color:var(--text-muted); font-size:.75rem; }
    .quick-info-row {
        display:flex; justify-content:space-between; align-items:center;
        padding: 10px 0;
        border-bottom: 1px solid var(--border-color);
        font-size:.85rem;
    }
    .quick-info-row:last-child { border-bottom: none; }
    .quick-info-row span:first-child { color:var(--text-muted); }
    .quick-info-row span:last-child { font-weight:600; }
</style>
@endpush

@push('scripts')
<script>
const STATS = [
    { key:'products',    label:'Total Products',   icon:'bi-box-seam',     color:'indigo',  endpoint:'/products' },
    { key:'categories',  label:'Categories',        icon:'bi-tag',          color:'amber',   endpoint:'/categories' },
    { key:'brands',      label:'Brands',            icon:'bi-award',        color:'emerald', endpoint:'/brands' },
    { key:'units',       label:'Units',             icon:'bi-rulers',       color:'cyan',    endpoint:'/units' },
    { key:'taxes',       label:'Tax Rates',         icon:'bi-percent',      color:'rose',    endpoint:'/taxes' },
    { key:'warehouses',  label:'Warehouses',        icon:'bi-building',     color:'violet',  endpoint:'/warehouses' },
    { key:'suppliers',   label:'Suppliers',         icon:'bi-truck',        color:'orange',  endpoint:'/suppliers' },
    { key:'customers',   label:'Customers',         icon:'bi-people',       color:'teal',    endpoint:'/purchases' },
];

async function loadDashboard() {
    const grid = document.getElementById('statsGrid');

    // Fetch all in parallel
    const results = await Promise.all(
        STATS.map(s => apiRequest(s.endpoint).then(r => ({ ...s, count: extractCount(r.data) })).catch(() => ({ ...s, count: 0 })))
    );

    // Build stat cards
    grid.innerHTML = results.map((s, i) => `
        <div class="col-xl-3 col-lg-4 col-md-6">
            <a href="/dashboard/${s.key === 'customers' ? 'purchases' : s.key}" class="text-decoration-none">
                <div class="stat-card ${s.color}" style="animation:fadeIn .3s ease ${i*0.05}s both;">
                    <div class="stat-icon ${s.color}"><i class="bi ${s.icon}"></i></div>
                    <div class="stat-value">${s.count.toLocaleString()}</div>
                    <div class="stat-label">${s.label}</div>
                </div>
            </a>
        </div>
    `).join('');

    // Load panels
    loadRecentProducts();
    loadRecentPurchases();
    loadCategoryList();
    loadWarehouseList();
    loadQuickInfo();
}

function extractCount(data) {
    if (!data) return 0;
    if (typeof data.total === 'number') return data.total;
    if (data.meta?.total) return data.meta.total;
    if (Array.isArray(data.data)) return data.data.length;
    if (typeof data.count === 'number') return data.count;
    return 0;
}

async function loadRecentProducts() {
    const { ok, data } = await apiRequest('/products?per_page=6');
    const el = document.getElementById('recentProducts');
    if (!ok || !data?.data?.length) {
        el.innerHTML = '<div class="empty-state"><i class="bi bi-box-seam"></i><p>No products found</p></div>';
        return;
    }
    el.innerHTML = data.data.map(p => `
        <div class="mini-list-item">
            <div>
                <div class="item-name">${p.name}</div>
                <div class="item-meta">SKU: ${p.sku || '—'} &middot; Qty: ${p.quantity ?? 0}</div>
            </div>
            <div class="text-end">
                <div style="font-weight:700;color:var(--primary);font-size:.85rem;">${formatCurrency(p.selling_price)}</div>
                ${statusBadge(p.status)}
            </div>
        </div>`).join('');
}

async function loadRecentPurchases() {
    const { ok, data } = await apiRequest('/purchases?per_page=6');
    const el = document.getElementById('recentPurchases');
    if (!ok || !data?.data?.length) {
        el.innerHTML = '<div class="empty-state"><i class="bi bi-cart-check"></i><p>No purchases found</p></div>';
        return;
    }
    const payBadge = (s) => {
        const map = { paid:'badge-paid', partial:'badge-partial', unpaid:'badge-unpaid' };
        return `<span class="badge-status ${map[s]||'badge-inactive'}">${s||'—'}</span>`;
    };
    el.innerHTML = data.data.map(p => `
        <div class="mini-list-item">
            <div>
                <div class="item-name">${p.purchase_number || p.invoice_number || '#'+p.id}</div>
                <div class="item-meta">${p.supplier?.name || '—'} &middot; ${formatDate(p.purchase_date)}</div>
            </div>
            <div class="text-end">
                <div style="font-weight:700;color:var(--success);font-size:.85rem;">${formatCurrency(p.financial?.grand_total)}</div>
                ${payBadge(p.payment_status)}
            </div>
        </div>`).join('');
}

async function loadCategoryList() {
    const { ok, data } = await apiRequest('/categories?per_page=8');
    const el = document.getElementById('categoryList');
    if (!ok || !data?.data?.length) {
        el.innerHTML = '<div class="empty-state"><i class="bi bi-tag"></i><p>No categories</p></div>';
        return;
    }
    el.innerHTML = data.data.map(c => `
        <div class="mini-list-item">
            <span class="item-name"><i class="bi bi-tag-fill me-2" style="color:var(--warning);"></i>${c.name}</span>
            ${statusBadge(c.status)}
        </div>`).join('');
}

async function loadWarehouseList() {
    const { ok, data } = await apiRequest('/warehouses?per_page=8');
    const el = document.getElementById('warehouseList');
    if (!ok || !data?.data?.length) {
        el.innerHTML = '<div class="empty-state"><i class="bi bi-building"></i><p>No warehouses</p></div>';
        return;
    }
    el.innerHTML = data.data.map(w => `
        <div class="mini-list-item">
            <div>
                <div class="item-name"><i class="bi bi-building-fill me-2" style="color:#8b5cf6;"></i>${w.name}</div>
                <div class="item-meta">${w.city || ''} ${w.country || ''}</div>
            </div>
            ${statusBadge(w.status)}
        </div>`).join('');
}

async function loadQuickInfo() {
    const [sup, cust, taxes, brands] = await Promise.all([
        apiRequest('/suppliers').catch(() => ({ data:{} })),
        apiRequest('/customers').catch(() => ({ data:{} })),
        apiRequest('/taxes').catch(() => ({ data:{} })),
        apiRequest('/brands').catch(() => ({ data:{} })),
    ]);
    const el = document.getElementById('quickInfo');
    el.innerHTML = `
        <div class="quick-info-row"><span>Active Suppliers</span><span style="color:var(--primary);">${extractCount(sup.data)}</span></div>
        <div class="quick-info-row"><span>Active Customers</span><span style="color:var(--success);">${extractCount(cust.data)}</span></div>
        <div class="quick-info-row"><span>Tax Rates</span><span style="color:var(--warning);">${extractCount(taxes.data)}</span></div>
        <div class="quick-info-row"><span>Brands</span><span style="color:#8b5cf6;">${extractCount(brands.data)}</span></div>
        <div class="quick-info-row"><span>API Status</span><span style="color:var(--success);">● Online</span></div>
        <div class="quick-info-row"><span>Last Refresh</span><span style="color:var(--text-muted);">${new Date().toLocaleTimeString()}</span></div>
    `;
}

function loadData() { loadDashboard(); }
loadDashboard();
</script>
@endpush
