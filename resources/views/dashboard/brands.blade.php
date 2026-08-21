@extends('layouts.app')

@section('title', 'Brands')
@section('page_title', 'Brands')
@section('breadcrumb')
    <li class="breadcrumb-item active">Brands</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div><h1>Brands</h1><p>Manage product brands</p></div>
    <button class="btn-primary-custom" onclick="openCreateModal()">
        <i class="bi bi-plus-lg"></i> Add Brand
    </button>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="card-title"><i class="bi bi-award me-2"></i>All Brands</h6>
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Search brands..." oninput="filterTable()">
        </div>
    </div>
    <div class="card-body p-0">
        <div id="tableContainer"><div class="loading-overlay"><div class="spinner-ring"></div></div></div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="brandModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="brandId">
                <div class="mb-3">
                    <label class="form-label">Brand Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="brandName" placeholder="Enter brand name">
                    <div class="invalid-feedback" id="nameError"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" id="brandDesc" rows="3" placeholder="Optional description"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" id="brandStatus">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-primary-custom" id="saveBtn" onclick="saveBrand()">
                    <span id="saveBtnText">Save Brand</span>
                    <span id="saveBtnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let allBrands = [];
const modal = new bootstrap.Modal(document.getElementById('brandModal'));

async function loadData() {
    const container = document.getElementById('tableContainer');
    container.innerHTML = '<div class="loading-overlay"><div class="spinner-ring"></div></div>';
    const { ok, data } = await apiRequest('/brands?per_page=100');
    if (!ok || !data?.data) {
        container.innerHTML = '<div class="empty-state"><i class="bi bi-award"></i><p>Failed to load brands</p></div>'; return;
    }
    allBrands = data.data;
    renderTable(allBrands);
}

function renderTable(items) {
    if (!items.length) {
        document.getElementById('tableContainer').innerHTML = '<div class="empty-state"><i class="bi bi-award"></i><p>No brands found</p></div>'; return;
    }
    document.getElementById('tableContainer').innerHTML = `
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>#</th><th>Name</th><th>Description</th><th>Status</th><th>Created</th><th style="width:100px;">Actions</th></tr></thead>
                <tbody>${items.map((b, i) => `
                <tr>
                    <td class="text-muted">${i+1}</td>
                    <td><strong>${b.name}</strong></td>
                    <td class="text-muted">${b.description || '—'}</td>
                    <td>${statusBadge(b.status)}</td>
                    <td class="text-muted">${formatDate(b.created_at)}</td>
                    <td>
                        <button class="btn-sm-icon btn-edit me-1" onclick="editBrand(${b.id})"><i class="bi bi-pencil"></i></button>
                        <button class="btn-sm-icon btn-delete" onclick="deleteBrand(${b.id},'${b.name}')"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>`).join('')}
                </tbody>
            </table>
        </div>`;
}

function filterTable() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    renderTable(allBrands.filter(b => b.name.toLowerCase().includes(q)));
}

function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Add Brand';
    document.getElementById('brandId').value = '';
    document.getElementById('brandName').value = '';
    document.getElementById('brandDesc').value = '';
    document.getElementById('brandStatus').value = '1';
    document.getElementById('saveBtnText').textContent = 'Save Brand';
    document.getElementById('brandName').classList.remove('is-invalid');
    modal.show();
}

function editBrand(id) {
    const b = allBrands.find(x => x.id === id);
    if (!b) return;
    document.getElementById('modalTitle').textContent = 'Edit Brand';
    document.getElementById('brandId').value = b.id;
    document.getElementById('brandName').value = b.name;
    document.getElementById('brandDesc').value = b.description || '';
    document.getElementById('brandStatus').value = b.status ? '1' : '0';
    document.getElementById('saveBtnText').textContent = 'Update Brand';
    document.getElementById('brandName').classList.remove('is-invalid');
    modal.show();
}

async function saveBrand() {
    const id = document.getElementById('brandId').value;
    const name = document.getElementById('brandName').value.trim();
    if (!name) { document.getElementById('brandName').classList.add('is-invalid'); document.getElementById('nameError').textContent = 'Name is required'; return; }
    document.getElementById('brandName').classList.remove('is-invalid');
    document.getElementById('saveBtn').disabled = true;
    document.getElementById('saveBtnSpinner').classList.remove('d-none');

    const { ok, data } = await apiRequest(id ? `/brands/${id}` : '/brands', {
        method: id ? 'PUT' : 'POST',
        body: JSON.stringify({ name, description: document.getElementById('brandDesc').value, status: parseInt(document.getElementById('brandStatus').value) })
    });

    document.getElementById('saveBtn').disabled = false;
    document.getElementById('saveBtnSpinner').classList.add('d-none');

    if (ok) { showToast(id ? 'Brand updated!' : 'Brand created!'); modal.hide(); loadData(); }
    else showToast(data.message || 'Failed to save', 'error');
}

async function deleteBrand(id, name) {
    const r = await Swal.fire({ title:'Delete Brand?', text:`"${name}" will be deleted.`, icon:'warning', showCancelButton:true, confirmButtonColor:'#ef4444', confirmButtonText:'Delete' });
    if (!r.isConfirmed) return;
    const { ok } = await apiRequest(`/brands/${id}`, { method:'DELETE' });
    if (ok) { showToast('Brand deleted!'); loadData(); }
    else showToast('Delete failed', 'error');
}

loadData();
</script>
@endpush
