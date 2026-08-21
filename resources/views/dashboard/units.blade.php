@extends('layouts.app')

@section('title', 'Units')
@section('page_title', 'Units')
@section('breadcrumb')
    <li class="breadcrumb-item active">Units</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div><h1>Units</h1><p>Manage measurement units</p></div>
    <button class="btn-primary-custom" onclick="openCreateModal()">
        <i class="bi bi-plus-lg"></i> Add Unit
    </button>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="card-title"><i class="bi bi-rulers me-2"></i>All Units</h6>
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Search units..." oninput="filterTable()">
        </div>
    </div>
    <div class="card-body p-0">
        <div id="tableContainer"><div class="loading-overlay"><div class="spinner-ring"></div></div></div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="unitModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="unitId">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Unit Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="unitName" placeholder="e.g. Kilogram">
                        <div class="invalid-feedback" id="nameError"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Short Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="unitShort" placeholder="e.g. kg">
                        <div class="invalid-feedback" id="shortError"></div>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" id="unitStatus">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-primary-custom" id="saveBtn" onclick="saveUnit()">
                    <span id="saveBtnText">Save Unit</span>
                    <span id="saveBtnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let allUnits = [];
const modal = new bootstrap.Modal(document.getElementById('unitModal'));

async function loadData() {
    const container = document.getElementById('tableContainer');
    container.innerHTML = '<div class="loading-overlay"><div class="spinner-ring"></div></div>';
    const { ok, data } = await apiRequest('/units?per_page=100');
    if (!ok || !data?.data) {
        container.innerHTML = '<div class="empty-state"><i class="bi bi-rulers"></i><p>Failed to load units</p></div>'; return;
    }
    allUnits = data.data;
    renderTable(allUnits);
}

function renderTable(items) {
    if (!items.length) {
        document.getElementById('tableContainer').innerHTML = '<div class="empty-state"><i class="bi bi-rulers"></i><p>No units found</p></div>'; return;
    }
    document.getElementById('tableContainer').innerHTML = `
        <div class="table-responsive"><table class="table mb-0">
            <thead><tr><th>#</th><th>Name</th><th>Short Name</th><th>Status</th><th>Created</th><th style="width:100px;">Actions</th></tr></thead>
            <tbody>${items.map((u,i) => `
            <tr>
                <td class="text-muted">${i+1}</td>
                <td><strong>${u.name}</strong></td>
                <td><span class="badge bg-light text-dark fw-600" style="font-size:.8rem;">${u.short_name || u.symbol || '—'}</span></td>
                <td>${statusBadge(u.status)}</td>
                <td class="text-muted">${formatDate(u.created_at)}</td>
                <td>
                    <button class="btn-sm-icon btn-edit me-1" onclick="editUnit(${u.id})"><i class="bi bi-pencil"></i></button>
                    <button class="btn-sm-icon btn-delete" onclick="deleteUnit(${u.id},'${u.name}')"><i class="bi bi-trash"></i></button>
                </td>
            </tr>`).join('')}
            </tbody>
        </table></div>`;
}

function filterTable() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    renderTable(allUnits.filter(u => u.name.toLowerCase().includes(q) || (u.short_name||'').toLowerCase().includes(q)));
}

function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Add Unit';
    document.getElementById('unitId').value = '';
    document.getElementById('unitName').value = '';
    document.getElementById('unitShort').value = '';
    document.getElementById('unitStatus').value = '1';
    document.getElementById('saveBtnText').textContent = 'Save Unit';
    ['unitName','unitShort'].forEach(id => document.getElementById(id).classList.remove('is-invalid'));
    modal.show();
}

function editUnit(id) {
    const u = allUnits.find(x => x.id === id); if (!u) return;
    document.getElementById('modalTitle').textContent = 'Edit Unit';
    document.getElementById('unitId').value = u.id;
    document.getElementById('unitName').value = u.name;
    document.getElementById('unitShort').value = u.short_name || u.symbol || '';
    document.getElementById('unitStatus').value = u.status ? '1' : '0';
    document.getElementById('saveBtnText').textContent = 'Update Unit';
    ['unitName','unitShort'].forEach(id => document.getElementById(id).classList.remove('is-invalid'));
    modal.show();
}

async function saveUnit() {
    const id = document.getElementById('unitId').value;
    const name = document.getElementById('unitName').value.trim();
    const short = document.getElementById('unitShort').value.trim();
    let valid = true;
    if (!name) { document.getElementById('unitName').classList.add('is-invalid'); document.getElementById('nameError').textContent='Name required'; valid=false; }
    if (!short) { document.getElementById('unitShort').classList.add('is-invalid'); document.getElementById('shortError').textContent='Short name required'; valid=false; }
    if (!valid) return;
    ['unitName','unitShort'].forEach(i => document.getElementById(i).classList.remove('is-invalid'));
    document.getElementById('saveBtn').disabled = true;
    document.getElementById('saveBtnSpinner').classList.remove('d-none');
    const { ok, data } = await apiRequest(id ? `/units/${id}` : '/units', {
        method: id ? 'PUT' : 'POST',
        body: JSON.stringify({ name, short_name: short, status: parseInt(document.getElementById('unitStatus').value) })
    });
    document.getElementById('saveBtn').disabled = false;
    document.getElementById('saveBtnSpinner').classList.add('d-none');
    if (ok) { showToast(id ? 'Unit updated!' : 'Unit created!'); modal.hide(); loadData(); }
    else showToast(data.message || 'Failed to save', 'error');
}

async function deleteUnit(id, name) {
    const r = await Swal.fire({ title:'Delete Unit?', text:`"${name}" will be deleted.`, icon:'warning', showCancelButton:true, confirmButtonColor:'#ef4444', confirmButtonText:'Delete' });
    if (!r.isConfirmed) return;
    const { ok } = await apiRequest(`/units/${id}`, { method:'DELETE' });
    if (ok) { showToast('Unit deleted!'); loadData(); }
    else showToast('Delete failed', 'error');
}

loadData();
</script>
@endpush
