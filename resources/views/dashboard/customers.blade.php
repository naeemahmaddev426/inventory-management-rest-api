@extends('layouts.app')

@section('title', 'Customers')
@section('page_title', 'Customers')
@section('breadcrumb')
    <li class="breadcrumb-item active">Customers</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div><h1>Customers</h1><p>Manage customer accounts</p></div>
    <button class="btn-primary-custom" onclick="openCreateModal()">
        <i class="bi bi-plus-lg"></i> Add Customer
    </button>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="card-title"><i class="bi bi-people me-2"></i>All Customers</h6>
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Search customers..." oninput="filterTable()">
        </div>
    </div>
    <div class="card-body p-0">
        <div id="tableContainer"><div class="loading-overlay"><div class="spinner-ring"></div></div></div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="customerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="customerId">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="custName" placeholder="Customer name">
                        <div class="invalid-feedback" id="nameError"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Company Name</label>
                        <input type="text" class="form-control" id="custCompany" placeholder="Company (optional)">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="custEmail">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" id="custPhone">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Alternate Phone</label>
                        <input type="text" class="form-control" id="custAltPhone">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" id="custAddress">
                    </div>
                    <div class="col-md-3"><label class="form-label">City</label><input type="text" class="form-control" id="custCity"></div>
                    <div class="col-md-3"><label class="form-label">State</label><input type="text" class="form-control" id="custState"></div>
                    <div class="col-md-3"><label class="form-label">Country</label><input type="text" class="form-control" id="custCountry"></div>
                    <div class="col-md-3"><label class="form-label">Postal Code</label><input type="text" class="form-control" id="custPostal"></div>
                    <div class="col-md-4">
                        <label class="form-label">Credit Limit</label>
                        <input type="number" class="form-control" id="custCredit" placeholder="0.00" step="0.01">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Opening Balance</label>
                        <input type="number" class="form-control" id="custBalance" placeholder="0.00" step="0.01">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="custStatus"><option value="1">Active</option><option value="0">Inactive</option></select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" id="custNotes" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-primary-custom" id="saveBtn" onclick="saveCustomer()">
                    <span id="saveBtnText">Save Customer</span>
                    <span id="saveBtnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let allCustomers = [];
const modal = new bootstrap.Modal(document.getElementById('customerModal'));

async function loadData() {
    const container = document.getElementById('tableContainer');
    container.innerHTML = '<div class="loading-overlay"><div class="spinner-ring"></div></div>';
    const { ok, data } = await apiRequest('/customers?per_page=100');
    if (!ok || !data?.data) {
        container.innerHTML = '<div class="empty-state"><i class="bi bi-people"></i><p>Failed to load customers</p></div>'; return;
    }
    allCustomers = data.data;
    renderTable(allCustomers);
}

function renderTable(items) {
    if (!items.length) {
        document.getElementById('tableContainer').innerHTML = '<div class="empty-state"><i class="bi bi-people"></i><p>No customers found</p></div>'; return;
    }
    document.getElementById('tableContainer').innerHTML = `
        <div class="table-responsive"><table class="table mb-0">
            <thead><tr><th>#</th><th>Code</th><th>Name</th><th>Email</th><th>Phone</th><th>City</th><th>Balance</th><th>Status</th><th style="width:100px;">Actions</th></tr></thead>
            <tbody>${items.map((c,i)=>`
            <tr>
                <td class="text-muted">${i+1}</td>
                <td><code>${c.customer_code||'—'}</code></td>
                <td>
                    <strong>${c.name}</strong>
                    ${c.company_name ? `<div class="text-muted" style="font-size:.75rem;">${c.company_name}</div>` : ''}
                </td>
                <td class="text-muted">${c.email||'—'}</td>
                <td class="text-muted">${c.phone||'—'}</td>
                <td class="text-muted">${[c.city,c.country].filter(Boolean).join(', ')||'—'}</td>
                <td style="font-weight:600;color:var(--teal,#14b8a6);">${formatCurrency(c.current_balance||c.opening_balance)}</td>
                <td>${statusBadge(c.status)}</td>
                <td>
                    <button class="btn-sm-icon btn-edit me-1" onclick="editCustomer(${c.id})"><i class="bi bi-pencil"></i></button>
                    <button class="btn-sm-icon btn-delete" onclick="deleteCustomer(${c.id},'${c.name}')"><i class="bi bi-trash"></i></button>
                </td>
            </tr>`).join('')}
            </tbody>
        </table></div>`;
}

function filterTable() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    renderTable(allCustomers.filter(c => c.name.toLowerCase().includes(q) || (c.email||'').toLowerCase().includes(q) || (c.company_name||'').toLowerCase().includes(q)));
}

const CFIELDS = ['customerId','custName','custCompany','custEmail','custPhone','custAltPhone','custAddress','custCity','custState','custCountry','custPostal','custCredit','custBalance','custNotes'];
function resetForm() {
    CFIELDS.forEach(id=>{const el=document.getElementById(id);if(el)el.value='';});
    document.getElementById('custStatus').value='1';
    document.getElementById('custName').classList.remove('is-invalid');
}

function openCreateModal() {
    resetForm();
    document.getElementById('modalTitle').textContent='Add Customer';
    document.getElementById('saveBtnText').textContent='Save Customer';
    modal.show();
}

function editCustomer(id) {
    const c=allCustomers.find(x=>x.id===id); if(!c) return;
    resetForm();
    document.getElementById('modalTitle').textContent='Edit Customer';
    document.getElementById('customerId').value=c.id;
    document.getElementById('custName').value=c.name;
    document.getElementById('custCompany').value=c.company_name||'';
    document.getElementById('custEmail').value=c.email||'';
    document.getElementById('custPhone').value=c.phone||'';
    document.getElementById('custAltPhone').value=c.alternate_phone||'';
    document.getElementById('custAddress').value=c.address||'';
    document.getElementById('custCity').value=c.city||'';
    document.getElementById('custState').value=c.state||'';
    document.getElementById('custCountry').value=c.country||'';
    document.getElementById('custPostal').value=c.postal_code||'';
    document.getElementById('custCredit').value=c.credit_limit||'';
    document.getElementById('custBalance').value=c.opening_balance||'';
    document.getElementById('custNotes').value=c.notes||'';
    document.getElementById('custStatus').value=c.status?'1':'0';
    document.getElementById('saveBtnText').textContent='Update Customer';
    modal.show();
}

async function saveCustomer() {
    const id=document.getElementById('customerId').value;
    const name=document.getElementById('custName').value.trim();
    if(!name){document.getElementById('custName').classList.add('is-invalid');document.getElementById('nameError').textContent='Name required';return;}
    document.getElementById('custName').classList.remove('is-invalid');
    document.getElementById('saveBtn').disabled=true; document.getElementById('saveBtnSpinner').classList.remove('d-none');
    const payload={name,company_name:document.getElementById('custCompany').value,email:document.getElementById('custEmail').value,phone:document.getElementById('custPhone').value,alternate_phone:document.getElementById('custAltPhone').value,address:document.getElementById('custAddress').value,city:document.getElementById('custCity').value,state:document.getElementById('custState').value,country:document.getElementById('custCountry').value,postal_code:document.getElementById('custPostal').value,credit_limit:parseFloat(document.getElementById('custCredit').value)||0,opening_balance:parseFloat(document.getElementById('custBalance').value)||0,notes:document.getElementById('custNotes').value,status:parseInt(document.getElementById('custStatus').value)};
    const {ok,data}=await apiRequest(id?`/customers/${id}`:'/customers',{method:id?'PUT':'POST',body:JSON.stringify(payload)});
    document.getElementById('saveBtn').disabled=false; document.getElementById('saveBtnSpinner').classList.add('d-none');
    if(ok){showToast(id?'Customer updated!':'Customer created!');modal.hide();loadData();}
    else showToast(data.message||'Failed','error');
}

async function deleteCustomer(id,name) {
    const r=await Swal.fire({title:'Delete Customer?',text:`"${name}" will be deleted.`,icon:'warning',showCancelButton:true,confirmButtonColor:'#ef4444',confirmButtonText:'Delete'});
    if(!r.isConfirmed) return;
    const {ok}=await apiRequest(`/customers/${id}`,{method:'DELETE'});
    if(ok){showToast('Customer deleted!');loadData();}else showToast('Delete failed','error');
}

loadData();
</script>
@endpush
