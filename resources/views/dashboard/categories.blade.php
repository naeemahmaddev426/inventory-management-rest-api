@extends('layouts.app')

@section('title', 'Categories')
@section('page_title', 'Categories')
@section('breadcrumb')
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1>Categories</h1>
        <p>Manage product categories</p>
    </div>
    <button class="btn-primary-custom" onclick="openCreateModal()">
        <i class="bi bi-plus-lg"></i> Add Category
    </button>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="card-title"><i class="bi bi-tag me-2"></i>All Categories</h6>
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Search categories..." oninput="filterTable()">
        </div>
    </div>
    <div class="card-body p-0">
        <div id="tableContainer"><div class="loading-overlay"><div class="spinner-ring"></div></div></div>
    </div>
</div>

<!-- Create/Edit Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="categoryId">
                <div class="mb-3">
                    <label class="form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="categoryName" placeholder="Enter category name">
                    <div class="invalid-feedback" id="nameError"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" id="categoryDesc" rows="3" placeholder="Optional description"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" id="categoryStatus">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-primary-custom" id="saveBtn" onclick="saveCategory()">
                    <span id="saveBtnText">Save Category</span>
                    <span id="saveBtnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let allCategories = [];
const modal = new bootstrap.Modal(document.getElementById('categoryModal'));

async function loadData() {
    const container = document.getElementById('tableContainer');
    container.innerHTML = '<div class="loading-overlay"><div class="spinner-ring"></div></div>';

    const { ok, data } = await apiRequest('/categories?per_page=100');

    if (!ok || !data?.data) {
        container.innerHTML = '<div class="empty-state"><i class="bi bi-tag"></i><p>Failed to load categories</p></div>';
        return;
    }

    allCategories = data.data;
    renderTable(allCategories);
}

function renderTable(items) {
    if (!items.length) {
        document.getElementById('tableContainer').innerHTML =
            '<div class="empty-state"><i class="bi bi-tag"></i><p>No categories found</p></div>';
        return;
    }
    document.getElementById('tableContainer').innerHTML = `
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr>
                    <th>#</th><th>Name</th><th>Description</th><th>Status</th><th>Created</th><th style="width:100px;">Actions</th>
                </tr></thead>
                <tbody>
                    ${items.map((c, i) => `
                    <tr>
                        <td class="text-muted">${i+1}</td>
                        <td><strong>${c.name}</strong></td>
                        <td class="text-muted">${c.description || '—'}</td>
                        <td>${statusBadge(c.status)}</td>
                        <td class="text-muted">${formatDate(c.created_at)}</td>
                        <td>
                            <button class="btn-sm-icon btn-edit me-1" onclick="editCategory(${c.id})" title="Edit"><i class="bi bi-pencil"></i></button>
                            <button class="btn-sm-icon btn-delete" onclick="deleteCategory(${c.id},'${c.name}')" title="Delete"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>`).join('')}
                </tbody>
            </table>
        </div>`;
}

function filterTable() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    renderTable(allCategories.filter(c => c.name.toLowerCase().includes(q)));
}

function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Add Category';
    document.getElementById('categoryId').value = '';
    document.getElementById('categoryName').value = '';
    document.getElementById('categoryDesc').value = '';
    document.getElementById('categoryStatus').value = '1';
    document.getElementById('saveBtnText').textContent = 'Save Category';
    clearErrors();
    modal.show();
}

async function editCategory(id) {
    const cat = allCategories.find(c => c.id === id);
    if (!cat) return;
    document.getElementById('modalTitle').textContent = 'Edit Category';
    document.getElementById('categoryId').value = cat.id;
    document.getElementById('categoryName').value = cat.name;
    document.getElementById('categoryDesc').value = cat.description || '';
    document.getElementById('categoryStatus').value = cat.status ? '1' : '0';
    document.getElementById('saveBtnText').textContent = 'Update Category';
    clearErrors();
    modal.show();
}

async function saveCategory() {
    const id = document.getElementById('categoryId').value;
    const name = document.getElementById('categoryName').value.trim();
    const desc = document.getElementById('categoryDesc').value.trim();
    const status = document.getElementById('categoryStatus').value;

    clearErrors();
    if (!name) { showFieldError('categoryName', 'nameError', 'Name is required'); return; }

    setSaveLoading(true);

    const method = id ? 'PUT' : 'POST';
    const endpoint = id ? `/categories/${id}` : '/categories';
    const { ok, data } = await apiRequest(endpoint, {
        method,
        body: JSON.stringify({ name, description: desc, status: parseInt(status) })
    });

    setSaveLoading(false);

    if (ok) {
        showToast(id ? 'Category updated!' : 'Category created!', 'success');
        modal.hide();
        loadData();
    } else {
        if (data.errors?.name) showFieldError('categoryName', 'nameError', data.errors.name[0]);
        else showToast(data.message || 'Failed to save', 'error');
    }
}

async function deleteCategory(id, name) {
    const result = await Swal.fire({
        title: 'Delete Category?',
        text: `"${name}" will be permanently deleted.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        confirmButtonColor: '#ef4444',
        cancelButtonText: 'Cancel',
        borderRadius: '12px',
    });
    if (!result.isConfirmed) return;

    const { ok, data } = await apiRequest(`/categories/${id}`, { method: 'DELETE' });
    if (ok) { showToast('Category deleted!', 'success'); loadData(); }
    else showToast(data.message || 'Delete failed', 'error');
}

function setSaveLoading(on) {
    document.getElementById('saveBtn').disabled = on;
    document.getElementById('saveBtnSpinner').classList.toggle('d-none', !on);
}
function showFieldError(inputId, errId, msg) {
    document.getElementById(inputId).classList.add('is-invalid');
    document.getElementById(errId).textContent = msg;
}
function clearErrors() {
    ['categoryName'].forEach(id => document.getElementById(id).classList.remove('is-invalid'));
}

loadData();
</script>
@endpush
