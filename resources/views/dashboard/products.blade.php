@extends('layouts.app')

@section('title', 'Products')
@section('page_title', 'Products')
@section('breadcrumb')
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div><h1>Products</h1><p>Manage your product catalog</p></div>
    <button class="btn-primary-custom" onclick="openCreateModal()">
        <i class="bi bi-plus-lg"></i> Add Product
    </button>
</div>

<!-- Summary Row -->
<div class="row g-3 mb-4" id="productStats">
    <div class="col-md-3">
        <div class="stat-card indigo">
            <div class="stat-icon indigo"><i class="bi bi-box-seam"></i></div>
            <div class="stat-value" id="totalCount">—</div>
            <div class="stat-label">Total Products</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card emerald">
            <div class="stat-icon emerald"><i class="bi bi-check-circle"></i></div>
            <div class="stat-value" id="activeCount">—</div>
            <div class="stat-label">Active</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card rose">
            <div class="stat-icon rose"><i class="bi bi-exclamation-triangle"></i></div>
            <div class="stat-value" id="lowCount">—</div>
            <div class="stat-label">Low Stock</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card amber">
            <div class="stat-icon amber"><i class="bi bi-currency-dollar"></i></div>
            <div class="stat-value" id="totalValue">—</div>
            <div class="stat-label">Total Value</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="card-title"><i class="bi bi-box-seam me-2"></i>All Products</h6>
        <div class="d-flex gap-2 align-items-center">
            <select class="form-select form-select-sm" id="statusFilter" onchange="filterTable()" style="width:130px;border-radius:8px;">
                <option value="">All Status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" placeholder="Search products..." oninput="filterTable()">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div id="tableContainer"><div class="loading-overlay"><div class="spinner-ring"></div></div></div>
    </div>
</div>

<!-- Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="productId">
                <div class="row g-3">
                    <!-- Basic Info -->
                    <div class="col-12"><h6 class="fw-700 text-muted mb-0" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.5px;">Basic Information</h6><hr class="mt-1 mb-0"></div>
                    <div class="col-md-6">
                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="pName" placeholder="Product name">
                        <div class="invalid-feedback" id="pNameError"></div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">SKU</label>
                        <input type="text" class="form-control" id="pSku" placeholder="Auto-generated if empty">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Barcode</label>
                        <input type="text" class="form-control" id="pBarcode" placeholder="Barcode">
                    </div>

                    <!-- Relations -->
                    <div class="col-12"><h6 class="fw-700 text-muted mb-0" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.5px;">Classification</h6><hr class="mt-1 mb-0"></div>
                    <div class="col-md-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" id="pCategory"><option value="">Select category</option></select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Brand</label>
                        <select class="form-select" id="pBrand"><option value="">Select brand</option></select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Unit</label>
                        <select class="form-select" id="pUnit"><option value="">Select unit</option></select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tax</label>
                        <select class="form-select" id="pTax"><option value="">Select tax</option></select>
                    </div>

                    <!-- Pricing -->
                    <div class="col-12"><h6 class="fw-700 text-muted mb-0" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.5px;">Pricing</h6><hr class="mt-1 mb-0"></div>
                    <div class="col-md-4">
                        <label class="form-label">Purchase Price <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="pPurchase" placeholder="0.00" step="0.01">
                        <div class="invalid-feedback" id="pPurchaseError"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Selling Price <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="pSelling" placeholder="0.00" step="0.01">
                        <div class="invalid-feedback" id="pSellingError"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Discount Price</label>
                        <input type="number" class="form-control" id="pDiscount" placeholder="0.00" step="0.01">
                    </div>

                    <!-- Stock -->
                    <div class="col-12"><h6 class="fw-700 text-muted mb-0" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.5px;">Stock Settings</h6><hr class="mt-1 mb-0"></div>
                    <div class="col-md-3">
                        <label class="form-label">Initial Quantity</label>
                        <input type="number" class="form-control" id="pQty" placeholder="0" min="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Min. Quantity</label>
                        <input type="number" class="form-control" id="pMinQty" placeholder="0" min="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Max. Quantity</label>
                        <input type="number" class="form-control" id="pMaxQty" placeholder="0" min="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="pStatus"><option value="1">Active</option><option value="0">Inactive</option></select>
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="pDesc" rows="3" placeholder="Product description"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-primary-custom" id="saveBtn" onclick="saveProduct()">
                    <span id="saveBtnText">Save Product</span>
                    <span id="saveBtnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let allProducts = [];
let categories = [], brands = [], units = [], taxes = [];
const modal = new bootstrap.Modal(document.getElementById('productModal'));

async function loadData() {
    const container = document.getElementById('tableContainer');
    container.innerHTML = '<div class="loading-overlay"><div class="spinner-ring"></div></div>';

    // Load everything in parallel
    const [prodRes, catRes, brandRes, unitRes, taxRes] = await Promise.all([
        apiRequest('/products?per_page=200'),
        apiRequest('/categories?per_page=100'),
        apiRequest('/brands?per_page=100'),
        apiRequest('/units?per_page=100'),
        apiRequest('/taxes?per_page=100'),
    ]);

    allProducts = prodRes.data?.data || [];
    categories  = catRes.data?.data || [];
    brands      = brandRes.data?.data || [];
    units       = unitRes.data?.data || [];
    taxes       = taxRes.data?.data || [];

    // Update stats
    const total = allProducts.length;
    const active = allProducts.filter(p=>p.status).length;
    const low = allProducts.filter(p => (p.quantity||0) <= (p.minimum_quantity||0) && p.minimum_quantity).length;
    const value = allProducts.reduce((sum,p) => sum + (p.selling_price||0) * (p.quantity||0), 0);
    document.getElementById('totalCount').textContent = total.toLocaleString();
    document.getElementById('activeCount').textContent = active.toLocaleString();
    document.getElementById('lowCount').textContent = low.toLocaleString();
    document.getElementById('totalValue').textContent = formatCurrency(value);

    populateSelects();
    renderTable(allProducts);
}

function populateSelects() {
    const selects = {
        pCategory: categories, pBrand: brands,
        pUnit: units, pTax: taxes
    };
    Object.entries(selects).forEach(([selId, list]) => {
        const el = document.getElementById(selId);
        const cur = el.value;
        el.innerHTML = '<option value="">Select...</option>' + list.map(i=>`<option value="${i.id}">${i.name}</option>`).join('');
        if (cur) el.value = cur;
    });
}

function renderTable(items) {
    if (!items.length) {
        document.getElementById('tableContainer').innerHTML = '<div class="empty-state"><i class="bi bi-box-seam"></i><p>No products found</p></div>'; return;
    }
    document.getElementById('tableContainer').innerHTML = `
        <div class="table-responsive"><table class="table mb-0">
            <thead><tr>
                <th>#</th><th>Product</th><th>SKU</th><th>Category</th>
                <th>Purchase</th><th>Selling</th><th>Stock</th><th>Status</th>
                <th style="width:110px;">Actions</th>
            </tr></thead>
            <tbody>${items.map((p,i)=>`
            <tr>
                <td class="text-muted">${i+1}</td>
                <td>
                    <strong>${p.name}</strong>
                    ${p.barcode ? `<div class="text-muted" style="font-size:.72rem;">Barcode: ${p.barcode}</div>` : ''}
                </td>
                <td><code>${p.sku||'—'}</code></td>
                <td class="text-muted">${p.category?.name||'—'}</td>
                <td style="color:var(--text-muted);">${formatCurrency(p.purchase_price)}</td>
                <td style="font-weight:700;color:var(--primary);">${formatCurrency(p.selling_price)}</td>
                <td>
                    <span class="${(p.quantity||0)<=(p.minimum_quantity||0)&&p.minimum_quantity ? 'badge-status badge-inactive' : 'badge-status badge-active'}">
                        ${p.quantity ?? 0}
                    </span>
                </td>
                <td>${statusBadge(p.status)}</td>
                <td>
                    <button class="btn-sm-icon btn-view me-1" onclick="viewProduct(${p.id})" title="View"><i class="bi bi-eye"></i></button>
                    <button class="btn-sm-icon btn-edit me-1" onclick="editProduct(${p.id})" title="Edit"><i class="bi bi-pencil"></i></button>
                    <button class="btn-sm-icon btn-delete" onclick="deleteProduct(${p.id},'${p.name.replace(/'/g,"\\'")}')" title="Delete"><i class="bi bi-trash"></i></button>
                </td>
            </tr>`).join('')}
            </tbody>
        </table></div>`;
}

function filterTable() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    const status = document.getElementById('statusFilter').value;
    let items = allProducts;
    if (q) items = items.filter(p => p.name.toLowerCase().includes(q) || (p.sku||'').toLowerCase().includes(q));
    if (status !== '') items = items.filter(p => String(p.status?1:0) === status);
    renderTable(items);
}

function resetProductForm() {
    ['productId','pName','pSku','pBarcode','pPurchase','pSelling','pDiscount','pQty','pMinQty','pMaxQty','pDesc'].forEach(id=>{
        const el=document.getElementById(id); if(el) el.value='';
    });
    document.getElementById('pStatus').value='1';
    document.getElementById('pCategory').value='';
    document.getElementById('pBrand').value='';
    document.getElementById('pUnit').value='';
    document.getElementById('pTax').value='';
    ['pName','pPurchase','pSelling'].forEach(id=>document.getElementById(id).classList.remove('is-invalid'));
}

function openCreateModal() {
    resetProductForm();
    document.getElementById('modalTitle').textContent='Add Product';
    document.getElementById('saveBtnText').textContent='Save Product';
    modal.show();
}

function editProduct(id) {
    const p=allProducts.find(x=>x.id===id); if(!p) return;
    resetProductForm();
    document.getElementById('modalTitle').textContent='Edit Product';
    document.getElementById('productId').value=p.id;
    document.getElementById('pName').value=p.name;
    document.getElementById('pSku').value=p.sku||'';
    document.getElementById('pBarcode').value=p.barcode||'';
    document.getElementById('pCategory').value=p.category?.id||'';
    document.getElementById('pPurchase').value=p.purchase_price||'';
    document.getElementById('pSelling').value=p.selling_price||'';
    document.getElementById('pDiscount').value=p.discount_price||'';
    document.getElementById('pQty').value=p.quantity||0;
    document.getElementById('pMinQty').value=p.minimum_quantity||0;
    document.getElementById('pMaxQty').value=p.maximum_quantity||0;
    document.getElementById('pDesc').value=p.description||'';
    document.getElementById('pStatus').value=p.status?'1':'0';
    document.getElementById('saveBtnText').textContent='Update Product';
    modal.show();
}

function viewProduct(id) {
    const p=allProducts.find(x=>x.id===id); if(!p) return;
    Swal.fire({
        title:`<strong>${p.name}</strong>`,
        html:`
        <div class="row text-start g-2">
            <div class="col-6"><small class="text-muted">SKU</small><div class="fw-bold">${p.sku||'—'}</div></div>
            <div class="col-6"><small class="text-muted">Category</small><div>${p.category?.name||'—'}</div></div>
            <div class="col-6"><small class="text-muted">Purchase Price</small><div class="fw-bold text-muted">${formatCurrency(p.purchase_price)}</div></div>
            <div class="col-6"><small class="text-muted">Selling Price</small><div class="fw-bold" style="color:var(--primary)">${formatCurrency(p.selling_price)}</div></div>
            <div class="col-6"><small class="text-muted">Current Stock</small><div class="fw-bold">${p.quantity??0}</div></div>
            <div class="col-6"><small class="text-muted">Min/Max Stock</small><div>${p.minimum_quantity||0} / ${p.maximum_quantity||'∞'}</div></div>
            <div class="col-12"><small class="text-muted">Description</small><div>${p.description||'No description'}</div></div>
        </div>`,
        showCloseButton:true, showConfirmButton:false, width:'500px'
    });
}

async function saveProduct() {
    const id=document.getElementById('productId').value;
    const name=document.getElementById('pName').value.trim();
    const purchase=document.getElementById('pPurchase').value;
    const selling=document.getElementById('pSelling').value;
    let valid=true;
    if(!name){document.getElementById('pName').classList.add('is-invalid');document.getElementById('pNameError').textContent='Name required';valid=false;}
    if(!purchase){document.getElementById('pPurchase').classList.add('is-invalid');document.getElementById('pPurchaseError').textContent='Required';valid=false;}
    if(!selling){document.getElementById('pSelling').classList.add('is-invalid');document.getElementById('pSellingError').textContent='Required';valid=false;}
    if(!valid) return;
    ['pName','pPurchase','pSelling'].forEach(i=>document.getElementById(i).classList.remove('is-invalid'));
    document.getElementById('saveBtn').disabled=true; document.getElementById('saveBtnSpinner').classList.remove('d-none');
    const payload={name,sku:document.getElementById('pSku').value,barcode:document.getElementById('pBarcode').value,category_id:document.getElementById('pCategory').value||null,brand_id:document.getElementById('pBrand').value||null,unit_id:document.getElementById('pUnit').value||null,tax_id:document.getElementById('pTax').value||null,purchase_price:parseFloat(purchase),selling_price:parseFloat(selling),discount_price:parseFloat(document.getElementById('pDiscount').value)||null,quantity:parseInt(document.getElementById('pQty').value)||0,minimum_quantity:parseInt(document.getElementById('pMinQty').value)||0,maximum_quantity:parseInt(document.getElementById('pMaxQty').value)||0,description:document.getElementById('pDesc').value,status:parseInt(document.getElementById('pStatus').value)};
    const {ok,data}=await apiRequest(id?`/products/${id}`:'/products',{method:id?'PUT':'POST',body:JSON.stringify(payload)});
    document.getElementById('saveBtn').disabled=false; document.getElementById('saveBtnSpinner').classList.add('d-none');
    if(ok){showToast(id?'Product updated!':'Product created!');modal.hide();loadData();}
    else{
        if(data.errors){Object.entries(data.errors).forEach(([k,v])=>{const el=document.getElementById('p'+k.charAt(0).toUpperCase()+k.slice(1));if(el){el.classList.add('is-invalid');const err=document.getElementById('p'+k.charAt(0).toUpperCase()+k.slice(1)+'Error');if(err)err.textContent=v[0];}});}
        showToast(data.message||'Failed to save','error');
    }
}

async function deleteProduct(id,name) {
    const r=await Swal.fire({title:'Delete Product?',text:`"${name}" will be permanently deleted.`,icon:'warning',showCancelButton:true,confirmButtonColor:'#ef4444',confirmButtonText:'Delete'});
    if(!r.isConfirmed) return;
    const {ok}=await apiRequest(`/products/${id}`,{method:'DELETE'});
    if(ok){showToast('Product deleted!');loadData();}else showToast('Delete failed','error');
}

loadData();
</script>
@endpush
