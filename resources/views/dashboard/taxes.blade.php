@extends('layouts.app')

@section('title', 'Taxes')
@section('page_title', 'Taxes')
@section('breadcrumb')
    <li class="breadcrumb-item active">Taxes</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div><h1>Taxes</h1><p>Manage tax rates and types</p></div>
    <button class="btn-primary-custom" onclick="openCreateModal()">
        <i class="bi bi-plus-lg"></i> Add Tax
    </button>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="card-title"><i class="bi bi-percent me-2"></i>All Taxes</h6>
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Search taxes..." oninput="filterTable()">
        </div>
    </div>
    <div class="card-body p-0">
        <div id="tableContainer"><div class="loading-overlay"><div class="spinner-ring"></div></div></div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="taxModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Tax</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="taxId">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Tax Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="taxName" placeholder="e.g. GST 17%">
                        <div class="invalid-feedback" id="nameError"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Rate (%) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="taxRate" placeholder="0.00" step="0.01" min="0">
                        <div class="invalid-feedback" id="rateError"></div>
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label class="form-label">Type</label>
                        <select class="form-select" id="taxType">
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Fixed Amount</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="taxStatus">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" id="taxDesc" rows="2" placeholder="Optional"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-primary-custom" id="saveBtn" onclick="saveTax()">
                    <span id="saveBtnText">Save Tax</span>
                    <span id="saveBtnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let allTaxes = [];
const modal = new bootstrap.Modal(document.getElementById('taxModal'));

async function loadData() {
    const container = document.getElementById('tableContainer');
    container.innerHTML = '<div class="loading-overlay"><div class="spinner-ring"></div></div>';
    const { ok, data } = await apiRequest('/taxes?per_page=100');
    if (!ok || !data?.data) {
        container.innerHTML = '<div class="empty-state"><i class="bi bi-percent"></i><p>Failed to load taxes</p></div>'; return;
    }
    allTaxes = data.data;
    renderTable(allTaxes);
}

function renderTable(items) {
    if (!items.length) {
        document.getElementById('tableContainer').innerHTML = '<div class="empty-state"><i class="bi bi-percent"></i><p>No taxes found</p></div>'; return;
    }
    document.getElementById('tableContainer').innerHTML = `
        <div class="table-responsive"><table class="table mb-0">
            <thead><tr><th>#</th><th>Name</th><th>Rate</th><th>Type</th><th>Description</th><th>Status</th><th style="width:100px;">Actions</th></tr></thead>
            <tbody>${items.map((t,i)=>`
            <tr>
                <td class="text-muted">${i+1}</td>
                <td><strong>${t.name}</strong></td>
                <td><span class="badge bg-warning text-dark fw-bold">${t.rate}${t.type==='percentage' ? '%' : ' (Fixed)'}</span></td>
                <td class="text-muted text-capitalize">${t.type || 'percentage'}</td>
                <td class="text-muted">${t.description || '—'}</td>
                <td>${statusBadge(t.status)}</td>
                <td>
                    <button class="btn-sm-icon btn-edit me-1" onclick="editTax(${t.id})"><i class="bi bi-pencil"></i></button>
                    <button class="btn-sm-icon btn-delete" onclick="deleteTax(${t.id},'${t.name}')"><i class="bi bi-trash"></i></button>
                </td>
            </tr>`).join('')}
            </tbody>
        </table></div>`;
}

function filterTable() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    renderTable(allTaxes.filter(t => t.name.toLowerCase().includes(q)));
}

function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Add Tax';
    document.getElementById('taxId').value=''; document.getElementById('taxName').value='';
    document.getElementById('taxRate').value=''; document.getElementById('taxType').value='percentage';
    document.getElementById('taxStatus').value='1'; document.getElementById('taxDesc').value='';
    document.getElementById('saveBtnText').textContent = 'Save Tax';
    ['taxName','taxRate'].forEach(id => document.getElementById(id).classList.remove('is-invalid'));
    modal.show();
}

function editTax(id) {
    const t = allTaxes.find(x => x.id===id); if(!t) return;
    document.getElementById('modalTitle').textContent = 'Edit Tax';
    document.getElementById('taxId').value=t.id; document.getElementById('taxName').value=t.name;
    document.getElementById('taxRate').value=t.rate; document.getElementById('taxType').value=t.type||'percentage';
    document.getElementById('taxStatus').value=t.status?'1':'0'; document.getElementById('taxDesc').value=t.description||'';
    document.getElementById('saveBtnText').textContent = 'Update Tax';
    ['taxName','taxRate'].forEach(id => document.getElementById(id).classList.remove('is-invalid'));
    modal.show();
}

async function saveTax() {
    const id=document.getElementById('taxId').value;
    const name=document.getElementById('taxName').value.trim();
    const rate=document.getElementById('taxRate').value;
    let valid=true;
    if(!name){document.getElementById('taxName').classList.add('is-invalid');document.getElementById('nameError').textContent='Name required';valid=false;}
    if(!rate){document.getElementById('taxRate').classList.add('is-invalid');document.getElementById('rateError').textContent='Rate required';valid=false;}
    if(!valid) return;
    document.getElementById('saveBtn').disabled=true; document.getElementById('saveBtnSpinner').classList.remove('d-none');
    const { ok, data } = await apiRequest(id?`/taxes/${id}`:'/taxes',{
        method:id?'PUT':'POST',
        body:JSON.stringify({name,rate:parseFloat(rate),type:document.getElementById('taxType').value,status:parseInt(document.getElementById('taxStatus').value),description:document.getElementById('taxDesc').value})
    });
    document.getElementById('saveBtn').disabled=false; document.getElementById('saveBtnSpinner').classList.add('d-none');
    if(ok){showToast(id?'Tax updated!':'Tax created!');modal.hide();loadData();}
    else showToast(data.message||'Failed','error');
}

async function deleteTax(id, name) {
    const r = await Swal.fire({title:'Delete Tax?',text:`"${name}" will be deleted.`,icon:'warning',showCancelButton:true,confirmButtonColor:'#ef4444',confirmButtonText:'Delete'});
    if(!r.isConfirmed) return;
    const {ok} = await apiRequest(`/taxes/${id}`,{method:'DELETE'});
    if(ok){showToast('Tax deleted!');loadData();}else showToast('Delete failed','error');
}

loadData();
</script>
@endpush
