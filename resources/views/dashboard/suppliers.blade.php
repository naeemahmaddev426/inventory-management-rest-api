@extends('layouts.app')

@section('title', 'Suppliers')
@section('page_title', 'Suppliers')
@section('breadcrumb')
    <li class="breadcrumb-item active">Suppliers</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div><h1>Suppliers</h1><p>Manage your suppliers</p></div>
    <button class="btn-primary-custom" onclick="openCreateModal()">
        <i class="bi bi-plus-lg"></i> Add Supplier
    </button>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="card-title"><i class="bi bi-truck me-2"></i>All Suppliers</h6>
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Search suppliers..." oninput="filterTable()">
        </div>
    </div>
    <div class="card-body p-0">
        <div id="tableContainer"><div class="loading-overlay"><div class="spinner-ring"></div></div></div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="supplierModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="supplierId">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Company Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="supCompany" placeholder="Company name">
                        <div class="invalid-feedback" id="companyError"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contact Person</label>
                        <input type="text" class="form-control" id="supContact" placeholder="Contact name">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="supEmail" placeholder="email@example.com">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" id="supPhone" placeholder="+1234567890">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Mobile</label>
                        <input type="text" class="form-control" id="supMobile">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">NTN</label>
                        <input type="text" class="form-control" id="supNtn">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">STRN</label>
                        <input type="text" class="form-control" id="supStrn">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Credit Limit</label>
                        <input type="number" class="form-control" id="supCredit" placeholder="0.00" step="0.01">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Payment Days</label>
                        <input type="number" class="form-control" id="supPayDays" placeholder="30">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" id="supAddress">
                    </div>
                    <div class="col-md-4"><label class="form-label">City</label><input type="text" class="form-control" id="supCity"></div>
                    <div class="col-md-4">
                        <label class="form-label">Country</label>
                        <input type="text" class="form-control" id="supCountry">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="supStatus"><option value="1">Active</option><option value="0">Inactive</option></select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-primary-custom" id="saveBtn" onclick="saveSupplier()">
                    <span id="saveBtnText">Save Supplier</span>
                    <span id="saveBtnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let allSuppliers = [];
const modal = new bootstrap.Modal(document.getElementById('supplierModal'));

async function loadData() {
    const container = document.getElementById('tableContainer');
    container.innerHTML = '<div class="loading-overlay"><div class="spinner-ring"></div></div>';
    const { ok, data } = await apiRequest('/suppliers?per_page=100');
    if (!ok || !data?.data) {
        container.innerHTML = '<div class="empty-state"><i class="bi bi-truck"></i><p>Failed to load suppliers</p></div>'; return;
    }
    allSuppliers = data.data;
    renderTable(allSuppliers);
}

function renderTable(items) {
    if (!items.length) {
        document.getElementById('tableContainer').innerHTML = '<div class="empty-state"><i class="bi bi-truck"></i><p>No suppliers found</p></div>'; return;
    }
    document.getElementById('tableContainer').innerHTML = `
        <div class="table-responsive"><table class="table mb-0">
            <thead><tr><th>#</th><th>Code</th><th>Company</th><th>Contact</th><th>Phone</th><th>City</th><th>Credit Limit</th><th>Status</th><th style="width:100px;">Actions</th></tr></thead>
            <tbody>${items.map((s,i)=>`
            <tr>
                <td class="text-muted">${i+1}</td>
                <td><code>${s.supplier_code||'—'}</code></td>
                <td><strong>${s.company_name}</strong></td>
                <td class="text-muted">${s.contact_person||'—'}</td>
                <td class="text-muted">${s.phone||'—'}</td>
                <td class="text-muted">${[s.city,s.country].filter(Boolean).join(', ')||'—'}</td>
                <td style="font-weight:600;color:var(--primary);">${formatCurrency(s.credit_limit)}</td>
                <td>${statusBadge(s.status)}</td>
                <td>
                    <button class="btn-sm-icon btn-view me-1" onclick="viewSupplier(${s.id})" title="View"><i class="bi bi-eye"></i></button>
                    <button class="btn-sm-icon btn-edit me-1" onclick="editSupplier(${s.id})" title="Edit"><i class="bi bi-pencil"></i></button>
                    <button class="btn-sm-icon btn-delete" onclick="deleteSupplier(${s.id},'${s.company_name}')" title="Delete"><i class="bi bi-trash"></i></button>
                </td>
            </tr>`).join('')}
            </tbody>
        </table></div>`;
}

function filterTable() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    renderTable(allSuppliers.filter(s => s.company_name.toLowerCase().includes(q) || (s.contact_person||'').toLowerCase().includes(q)));
}

const FIELDS = ['supplierId','supCompany','supContact','supEmail','supPhone','supMobile','supNtn','supStrn','supCredit','supPayDays','supAddress','supCity','supCountry'];
function resetForm() {
    FIELDS.forEach(id => { const el=document.getElementById(id); if(el) el.value=''; });
    document.getElementById('supStatus').value='1';
    document.getElementById('supCompany').classList.remove('is-invalid');
}

function openCreateModal() {
    resetForm();
    document.getElementById('modalTitle').textContent='Add Supplier';
    document.getElementById('saveBtnText').textContent='Save Supplier';
    modal.show();
}

function editSupplier(id) {
    const s=allSuppliers.find(x=>x.id===id); if(!s) return;
    resetForm();
    document.getElementById('modalTitle').textContent='Edit Supplier';
    document.getElementById('supplierId').value=s.id;
    document.getElementById('supCompany').value=s.company_name;
    document.getElementById('supContact').value=s.contact_person||'';
    document.getElementById('supEmail').value=s.email||'';
    document.getElementById('supPhone').value=s.phone||'';
    document.getElementById('supMobile').value=s.mobile||'';
    document.getElementById('supNtn').value=s.ntn||'';
    document.getElementById('supStrn').value=s.strn||'';
    document.getElementById('supCredit').value=s.credit_limit||'';
    document.getElementById('supPayDays').value=s.payment_days||'';
    document.getElementById('supAddress').value=s.address||'';
    document.getElementById('supCity').value=s.city||'';
    document.getElementById('supCountry').value=s.country||'';
    document.getElementById('supStatus').value=s.status?'1':'0';
    document.getElementById('saveBtnText').textContent='Update Supplier';
    modal.show();
}

function viewSupplier(id) {
    const s=allSuppliers.find(x=>x.id===id); if(!s) return;
    Swal.fire({
        title:`<strong>${s.company_name}</strong>`,
        html:`<table class="table table-sm text-start">
            <tr><td class="text-muted">Code</td><td><strong>${s.supplier_code||'—'}</strong></td></tr>
            <tr><td class="text-muted">Contact</td><td>${s.contact_person||'—'}</td></tr>
            <tr><td class="text-muted">Email</td><td>${s.email||'—'}</td></tr>
            <tr><td class="text-muted">Phone</td><td>${s.phone||'—'}</td></tr>
            <tr><td class="text-muted">City</td><td>${[s.city,s.country].filter(Boolean).join(', ')||'—'}</td></tr>
            <tr><td class="text-muted">Credit Limit</td><td><strong>${formatCurrency(s.credit_limit)}</strong></td></tr>
            <tr><td class="text-muted">Payment Days</td><td>${s.payment_days||'—'} days</td></tr>
        </table>`,
        showCloseButton:true, showConfirmButton:false, width:'480px'
    });
}

async function saveSupplier() {
    const id=document.getElementById('supplierId').value;
    const company=document.getElementById('supCompany').value.trim();
    if(!company){document.getElementById('supCompany').classList.add('is-invalid');document.getElementById('companyError').textContent='Company name required';return;}
    document.getElementById('supCompany').classList.remove('is-invalid');
    document.getElementById('saveBtn').disabled=true; document.getElementById('saveBtnSpinner').classList.remove('d-none');
    const payload={company_name:company,contact_person:document.getElementById('supContact').value,email:document.getElementById('supEmail').value,phone:document.getElementById('supPhone').value,mobile:document.getElementById('supMobile').value,ntn:document.getElementById('supNtn').value,strn:document.getElementById('supStrn').value,credit_limit:parseFloat(document.getElementById('supCredit').value)||0,payment_days:parseInt(document.getElementById('supPayDays').value)||0,address:document.getElementById('supAddress').value,city:document.getElementById('supCity').value,country:document.getElementById('supCountry').value,status:parseInt(document.getElementById('supStatus').value)};
    const {ok,data}=await apiRequest(id?`/suppliers/${id}`:'/suppliers',{method:id?'PUT':'POST',body:JSON.stringify(payload)});
    document.getElementById('saveBtn').disabled=false; document.getElementById('saveBtnSpinner').classList.add('d-none');
    if(ok){showToast(id?'Supplier updated!':'Supplier created!');modal.hide();loadData();}
    else showToast(data.message||'Failed','error');
}

async function deleteSupplier(id,name) {
    const r=await Swal.fire({title:'Delete Supplier?',text:`"${name}" will be deleted.`,icon:'warning',showCancelButton:true,confirmButtonColor:'#ef4444',confirmButtonText:'Delete'});
    if(!r.isConfirmed) return;
    const {ok}=await apiRequest(`/suppliers/${id}`,{method:'DELETE'});
    if(ok){showToast('Supplier deleted!');loadData();}else showToast('Delete failed','error');
}

loadData();
</script>
@endpush
