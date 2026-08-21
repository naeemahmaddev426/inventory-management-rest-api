@extends('layouts.app')

@section('title', 'Purchases')
@section('page_title', 'Purchases')
@section('breadcrumb')
    <li class="breadcrumb-item active">Purchases</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div><h1>Purchases</h1><p>Manage purchase orders and invoices</p></div>
    <button class="btn-primary-custom" onclick="openCreateModal()">
        <i class="bi bi-plus-lg"></i> New Purchase
    </button>
</div>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card indigo">
            <div class="stat-icon indigo"><i class="bi bi-cart-check"></i></div>
            <div class="stat-value" id="totalPurchases">—</div>
            <div class="stat-label">Total Purchases</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card emerald">
            <div class="stat-icon emerald"><i class="bi bi-check2-circle"></i></div>
            <div class="stat-value" id="paidCount">—</div>
            <div class="stat-label">Paid</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card rose">
            <div class="stat-icon rose"><i class="bi bi-x-circle"></i></div>
            <div class="stat-value" id="unpaidCount">—</div>
            <div class="stat-label">Unpaid</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card amber">
            <div class="stat-icon amber"><i class="bi bi-currency-dollar"></i></div>
            <div class="stat-value" id="totalAmount">—</div>
            <div class="stat-label">Total Amount</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="card-title"><i class="bi bi-cart-check me-2"></i>All Purchases</h6>
        <div class="d-flex gap-2 align-items-center">
            <select class="form-select form-select-sm" id="payFilter" onchange="filterTable()" style="width:150px;border-radius:8px;">
                <option value="">All Payments</option>
                <option value="paid">Paid</option>
                <option value="partial">Partial</option>
                <option value="unpaid">Unpaid</option>
            </select>
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" placeholder="Search purchases..." oninput="filterTable()">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div id="tableContainer"><div class="loading-overlay"><div class="spinner-ring"></div></div></div>
    </div>
</div>

<!-- Create/View Modal -->
<div class="modal fade" id="purchaseModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">New Purchase Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="purchaseId">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Supplier <span class="text-danger">*</span></label>
                        <select class="form-select" id="poSupplier">
                            <option value="">Select supplier</option>
                        </select>
                        <div class="invalid-feedback" id="poSupplierError"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Warehouse</label>
                        <select class="form-select" id="poWarehouse"><option value="">Select warehouse</option></select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Purchase Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="poDate">
                        <div class="invalid-feedback" id="poDateError"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Invoice Number</label>
                        <input type="text" class="form-control" id="poInvoice" placeholder="INV-0001">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Payment Status</label>
                        <select class="form-select" id="poPayStatus">
                            <option value="unpaid">Unpaid</option>
                            <option value="partial">Partial</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="poStatus">
                            <option value="pending">Pending</option>
                            <option value="received">Received</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <!-- Financial -->
                    <div class="col-12"><h6 class="fw-700 text-muted mb-0" style="font-size:.8rem;text-transform:uppercase;">Financial Details</h6><hr class="mt-1 mb-0"></div>
                    <div class="col-md-3">
                        <label class="form-label">Subtotal</label>
                        <input type="number" class="form-control" id="poSubtotal" placeholder="0.00" step="0.01">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tax Amount</label>
                        <input type="number" class="form-control" id="poTax" placeholder="0.00" step="0.01">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Discount</label>
                        <input type="number" class="form-control" id="poDiscount" placeholder="0.00" step="0.01">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Shipping</label>
                        <input type="number" class="form-control" id="poShipping" placeholder="0.00" step="0.01">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" id="poNotes" rows="2" placeholder="Purchase notes..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-primary-custom" id="saveBtn" onclick="savePurchase()">
                    <span id="saveBtnText">Save Purchase</span>
                    <span id="saveBtnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let allPurchases = [];
let suppliers = [], warehouses = [];
const modal = new bootstrap.Modal(document.getElementById('purchaseModal'));

async function loadData() {
    const container = document.getElementById('tableContainer');
    container.innerHTML = '<div class="loading-overlay"><div class="spinner-ring"></div></div>';
    const [purRes, supRes, whRes] = await Promise.all([
        apiRequest('/purchases?per_page=200'),
        apiRequest('/suppliers?per_page=100'),
        apiRequest('/warehouses?per_page=100'),
    ]);
    allPurchases = purRes.data?.data || [];
    suppliers = supRes.data?.data || [];
    warehouses = whRes.data?.data || [];

    // Stats
    const total = allPurchases.length;
    const paid = allPurchases.filter(p=>p.payment_status==='paid').length;
    const unpaid = allPurchases.filter(p=>p.payment_status==='unpaid').length;
    const amount = allPurchases.reduce((s,p)=>s+(p.financial?.grand_total||0),0);
    document.getElementById('totalPurchases').textContent = total.toLocaleString();
    document.getElementById('paidCount').textContent = paid.toLocaleString();
    document.getElementById('unpaidCount').textContent = unpaid.toLocaleString();
    document.getElementById('totalAmount').textContent = formatCurrency(amount);

    populateDropdowns();
    renderTable(allPurchases);
}

function populateDropdowns() {
    document.getElementById('poSupplier').innerHTML = '<option value="">Select supplier</option>' + suppliers.map(s=>`<option value="${s.id}">${s.company_name}</option>`).join('');
    document.getElementById('poWarehouse').innerHTML = '<option value="">Select warehouse</option>' + warehouses.map(w=>`<option value="${w.id}">${w.name}</option>`).join('');
}

const payBadge = (s) => {
    const map = {paid:'badge-paid',partial:'badge-partial',unpaid:'badge-unpaid'};
    return `<span class="badge-status ${map[s]||'badge-inactive'}">${s||'—'}</span>`;
};
const statusBadgeP = (s) => {
    const map = {received:'badge-active',pending:'badge-pending',cancelled:'badge-inactive'};
    return `<span class="badge-status ${map[s]||'badge-inactive'}">${s||'—'}</span>`;
};

function renderTable(items) {
    if (!items.length) {
        document.getElementById('tableContainer').innerHTML = '<div class="empty-state"><i class="bi bi-cart-check"></i><p>No purchases found</p></div>'; return;
    }
    document.getElementById('tableContainer').innerHTML = `
        <div class="table-responsive"><table class="table mb-0">
            <thead><tr><th>#</th><th>PO Number</th><th>Supplier</th><th>Warehouse</th><th>Date</th><th>Grand Total</th><th>Payment</th><th>Status</th><th style="width:100px;">Actions</th></tr></thead>
            <tbody>${items.map((p,i)=>`
            <tr>
                <td class="text-muted">${i+1}</td>
                <td>
                    <strong>${p.purchase_number||'PO-'+p.id}</strong>
                    ${p.invoice_number?`<div class="text-muted" style="font-size:.72rem;">${p.invoice_number}</div>`:''}
                </td>
                <td>${p.supplier?.name||'—'}</td>
                <td class="text-muted">${p.warehouse?.name||'—'}</td>
                <td class="text-muted">${formatDate(p.purchase_date)}</td>
                <td style="font-weight:700;color:var(--success);">${formatCurrency(p.financial?.grand_total)}</td>
                <td>${payBadge(p.payment_status)}</td>
                <td>${statusBadgeP(p.status)}</td>
                <td>
                    <button class="btn-sm-icon btn-view me-1" onclick="viewPurchase(${p.id})" title="View"><i class="bi bi-eye"></i></button>
                    <button class="btn-sm-icon btn-edit me-1" onclick="editPurchase(${p.id})" title="Edit"><i class="bi bi-pencil"></i></button>
                    <button class="btn-sm-icon btn-delete" onclick="deletePurchase(${p.id},'${p.purchase_number||'PO-'+p.id}')" title="Delete"><i class="bi bi-trash"></i></button>
                </td>
            </tr>`).join('')}
            </tbody>
        </table></div>`;
}

function filterTable() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    const pay = document.getElementById('payFilter').value;
    let items = allPurchases;
    if (q) items = items.filter(p => (p.purchase_number||'').toLowerCase().includes(q) || (p.supplier?.name||'').toLowerCase().includes(q));
    if (pay) items = items.filter(p => p.payment_status === pay);
    renderTable(items);
}

function resetPOForm() {
    ['purchaseId','poInvoice','poSubtotal','poTax','poDiscount','poShipping','poNotes'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';});
    document.getElementById('poSupplier').value='';
    document.getElementById('poWarehouse').value='';
    document.getElementById('poDate').value = new Date().toISOString().split('T')[0];
    document.getElementById('poPayStatus').value='unpaid';
    document.getElementById('poStatus').value='pending';
    document.getElementById('poSupplier').classList.remove('is-invalid');
}

function openCreateModal() {
    resetPOForm();
    document.getElementById('modalTitle').textContent='New Purchase Order';
    document.getElementById('saveBtnText').textContent='Save Purchase';
    modal.show();
}

function editPurchase(id) {
    const p=allPurchases.find(x=>x.id===id); if(!p) return;
    resetPOForm();
    document.getElementById('modalTitle').textContent='Edit Purchase';
    document.getElementById('purchaseId').value=p.id;
    document.getElementById('poSupplier').value=p.supplier?.id||'';
    document.getElementById('poWarehouse').value=p.warehouse?.id||'';
    document.getElementById('poDate').value=p.purchase_date||'';
    document.getElementById('poInvoice').value=p.invoice_number||'';
    document.getElementById('poPayStatus').value=p.payment_status||'unpaid';
    document.getElementById('poStatus').value=p.status||'pending';
    document.getElementById('poSubtotal').value=p.financial?.subtotal||'';
    document.getElementById('poTax').value=p.financial?.tax_amount||'';
    document.getElementById('poDiscount').value=p.financial?.discount_amount||'';
    document.getElementById('poShipping').value=p.financial?.shipping_amount||'';
    document.getElementById('poNotes').value=p.notes||'';
    document.getElementById('saveBtnText').textContent='Update Purchase';
    modal.show();
}

function viewPurchase(id) {
    const p=allPurchases.find(x=>x.id===id); if(!p) return;
    const f=p.financial||{};
    Swal.fire({
        title:`<strong>${p.purchase_number||'PO-'+p.id}</strong>`,
        html:`
        <table class="table table-sm text-start">
            <tr><td class="text-muted">Supplier</td><td><strong>${p.supplier?.name||'—'}</strong></td></tr>
            <tr><td class="text-muted">Warehouse</td><td>${p.warehouse?.name||'—'}</td></tr>
            <tr><td class="text-muted">Invoice</td><td>${p.invoice_number||'—'}</td></tr>
            <tr><td class="text-muted">Date</td><td>${formatDate(p.purchase_date)}</td></tr>
            <tr><td class="text-muted">Subtotal</td><td>${formatCurrency(f.subtotal)}</td></tr>
            <tr><td class="text-muted">Tax</td><td>${formatCurrency(f.tax_amount)}</td></tr>
            <tr><td class="text-muted">Discount</td><td>${formatCurrency(f.discount_amount)}</td></tr>
            <tr><td class="text-muted">Shipping</td><td>${formatCurrency(f.shipping_amount)}</td></tr>
            <tr><td class="text-muted fw-bold">Grand Total</td><td><strong style="color:var(--success);font-size:1.1em;">${formatCurrency(f.grand_total)}</strong></td></tr>
            <tr><td class="text-muted">Payment Status</td><td>${p.payment_status||'—'}</td></tr>
            <tr><td class="text-muted">Notes</td><td>${p.notes||'—'}</td></tr>
        </table>`,
        showCloseButton:true, showConfirmButton:false, width:'500px'
    });
}

async function savePurchase() {
    const id=document.getElementById('purchaseId').value;
    const supplier=document.getElementById('poSupplier').value;
    const date=document.getElementById('poDate').value;
    let valid=true;
    if(!supplier){document.getElementById('poSupplier').classList.add('is-invalid');document.getElementById('poSupplierError').textContent='Supplier required';valid=false;}
    if(!date){document.getElementById('poDate').classList.add('is-invalid');document.getElementById('poDateError').textContent='Date required';valid=false;}
    if(!valid) return;
    document.getElementById('poSupplier').classList.remove('is-invalid');
    document.getElementById('saveBtn').disabled=true; document.getElementById('saveBtnSpinner').classList.remove('d-none');
    const subtotal=parseFloat(document.getElementById('poSubtotal').value)||0;
    const tax=parseFloat(document.getElementById('poTax').value)||0;
    const disc=parseFloat(document.getElementById('poDiscount').value)||0;
    const ship=parseFloat(document.getElementById('poShipping').value)||0;
    const payload={supplier_id:parseInt(supplier),warehouse_id:document.getElementById('poWarehouse').value||null,purchase_date:date,invoice_number:document.getElementById('poInvoice').value,payment_status:document.getElementById('poPayStatus').value,status:document.getElementById('poStatus').value,subtotal,tax_amount:tax,discount_amount:disc,shipping_amount:ship,grand_total:subtotal+tax-disc+ship,notes:document.getElementById('poNotes').value};
    const {ok,data}=await apiRequest(id?`/purchases/${id}`:'/purchases',{method:id?'PUT':'POST',body:JSON.stringify(payload)});
    document.getElementById('saveBtn').disabled=false; document.getElementById('saveBtnSpinner').classList.add('d-none');
    if(ok){showToast(id?'Purchase updated!':'Purchase created!');modal.hide();loadData();}
    else showToast(data.message||'Failed to save','error');
}

async function deletePurchase(id, num) {
    const r=await Swal.fire({title:'Delete Purchase?',text:`"${num}" will be deleted.`,icon:'warning',showCancelButton:true,confirmButtonColor:'#ef4444',confirmButtonText:'Delete'});
    if(!r.isConfirmed) return;
    const {ok}=await apiRequest(`/purchases/${id}`,{method:'DELETE'});
    if(ok){showToast('Purchase deleted!');loadData();}else showToast('Delete failed','error');
}

loadData();
</script>
@endpush
