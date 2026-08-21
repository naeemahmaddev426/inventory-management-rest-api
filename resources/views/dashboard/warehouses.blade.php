@extends('layouts.app')

@section('title', 'Warehouses')
@section('page_title', 'Warehouses')
@section('breadcrumb')
    <li class="breadcrumb-item active">Warehouses</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div><h1>Warehouses</h1><p>Manage storage warehouses</p></div>
    <button class="btn-primary-custom" onclick="openCreateModal()">
        <i class="bi bi-plus-lg"></i> Add Warehouse
    </button>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="card-title"><i class="bi bi-building me-2"></i>All Warehouses</h6>
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Search warehouses..." oninput="filterTable()">
        </div>
    </div>
    <div class="card-body p-0">
        <div id="tableContainer"><div class="loading-overlay"><div class="spinner-ring"></div></div></div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="warehouseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Warehouse</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="warehouseId">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Warehouse Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="whName" placeholder="Warehouse name">
                        <div class="invalid-feedback" id="nameError"></div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Code</label>
                        <input type="text" class="form-control" id="whCode" placeholder="WH001">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="whStatus"><option value="1">Active</option><option value="0">Inactive</option></select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Manager Name</label>
                        <input type="text" class="form-control" id="whManager" placeholder="Manager name">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" id="whPhone" placeholder="+1234567890">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="whEmail" placeholder="email@example.com">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" id="whAddress" placeholder="Street address">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" id="whCity">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">State</label>
                        <input type="text" class="form-control" id="whState">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Country</label>
                        <input type="text" class="form-control" id="whCountry">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-primary-custom" id="saveBtn" onclick="saveWarehouse()">
                    <span id="saveBtnText">Save Warehouse</span>
                    <span id="saveBtnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let allWarehouses = [];
const modal = new bootstrap.Modal(document.getElementById('warehouseModal'));

async function loadData() {
    const container = document.getElementById('tableContainer');
    container.innerHTML = '<div class="loading-overlay"><div class="spinner-ring"></div></div>';
    const { ok, data } = await apiRequest('/warehouses?per_page=100');
    if (!ok || !data?.data) {
        container.innerHTML = '<div class="empty-state"><i class="bi bi-building"></i><p>Failed to load warehouses</p></div>'; return;
    }
    allWarehouses = data.data;
    renderTable(allWarehouses);
}

function renderTable(items) {
    if (!items.length) {
        document.getElementById('tableContainer').innerHTML = '<div class="empty-state"><i class="bi bi-building"></i><p>No warehouses found</p></div>'; return;
    }
    document.getElementById('tableContainer').innerHTML = `
        <div class="table-responsive"><table class="table mb-0">
            <thead><tr><th>#</th><th>Name</th><th>Code</th><th>Manager</th><th>Phone</th><th>City</th><th>Status</th><th style="width:100px;">Actions</th></tr></thead>
            <tbody>${items.map((w,i)=>`
            <tr>
                <td class="text-muted">${i+1}</td>
                <td><strong>${w.name}</strong></td>
                <td><code>${w.code||'—'}</code></td>
                <td>${w.manager_name||'—'}</td>
                <td class="text-muted">${w.phone||'—'}</td>
                <td class="text-muted">${[w.city,w.country].filter(Boolean).join(', ')||'—'}</td>
                <td>${statusBadge(w.status)}</td>
                <td>
                    <button class="btn-sm-icon btn-edit me-1" onclick="editWarehouse(${w.id})"><i class="bi bi-pencil"></i></button>
                    <button class="btn-sm-icon btn-delete" onclick="deleteWarehouse(${w.id},'${w.name}')"><i class="bi bi-trash"></i></button>
                </td>
            </tr>`).join('')}
            </tbody>
        </table></div>`;
}

function filterTable() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    renderTable(allWarehouses.filter(w => w.name.toLowerCase().includes(q) || (w.code||'').toLowerCase().includes(q)));
}

function resetForm() {
    ['whName','whCode','whManager','whPhone','whEmail','whAddress','whCity','whState','whCountry','warehouseId'].forEach(id => {
        const el = document.getElementById(id); if (el) el.value = '';
    });
    document.getElementById('whStatus').value='1';
    document.getElementById('whName').classList.remove('is-invalid');
}

function openCreateModal() {
    resetForm();
    document.getElementById('modalTitle').textContent='Add Warehouse';
    document.getElementById('saveBtnText').textContent='Save Warehouse';
    modal.show();
}

function editWarehouse(id) {
    const w = allWarehouses.find(x=>x.id===id); if(!w) return;
    resetForm();
    document.getElementById('modalTitle').textContent='Edit Warehouse';
    document.getElementById('warehouseId').value=w.id;
    document.getElementById('whName').value=w.name;
    document.getElementById('whCode').value=w.code||'';
    document.getElementById('whManager').value=w.manager_name||'';
    document.getElementById('whPhone').value=w.phone||'';
    document.getElementById('whEmail').value=w.email||'';
    document.getElementById('whAddress').value=w.address||'';
    document.getElementById('whCity').value=w.city||'';
    document.getElementById('whState').value=w.state||'';
    document.getElementById('whCountry').value=w.country||'';
    document.getElementById('whStatus').value=w.status?'1':'0';
    document.getElementById('saveBtnText').textContent='Update Warehouse';
    modal.show();
}

async function saveWarehouse() {
    const id=document.getElementById('warehouseId').value;
    const name=document.getElementById('whName').value.trim();
    if(!name){document.getElementById('whName').classList.add('is-invalid');document.getElementById('nameError').textContent='Name required';return;}
    document.getElementById('whName').classList.remove('is-invalid');
    document.getElementById('saveBtn').disabled=true; document.getElementById('saveBtnSpinner').classList.remove('d-none');
    const payload={name,code:document.getElementById('whCode').value,manager_name:document.getElementById('whManager').value,phone:document.getElementById('whPhone').value,email:document.getElementById('whEmail').value,address:document.getElementById('whAddress').value,city:document.getElementById('whCity').value,state:document.getElementById('whState').value,country:document.getElementById('whCountry').value,status:parseInt(document.getElementById('whStatus').value)};
    const {ok,data}=await apiRequest(id?`/warehouses/${id}`:'/warehouses',{method:id?'PUT':'POST',body:JSON.stringify(payload)});
    document.getElementById('saveBtn').disabled=false; document.getElementById('saveBtnSpinner').classList.add('d-none');
    if(ok){showToast(id?'Warehouse updated!':'Warehouse created!');modal.hide();loadData();}
    else showToast(data.message||'Failed','error');
}

async function deleteWarehouse(id,name) {
    const r=await Swal.fire({title:'Delete Warehouse?',text:`"${name}" will be deleted.`,icon:'warning',showCancelButton:true,confirmButtonColor:'#ef4444',confirmButtonText:'Delete'});
    if(!r.isConfirmed) return;
    const {ok}=await apiRequest(`/warehouses/${id}`,{method:'DELETE'});
    if(ok){showToast('Warehouse deleted!');loadData();}else showToast('Delete failed','error');
}

loadData();
</script>
@endpush
