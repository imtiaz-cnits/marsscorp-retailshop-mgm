
<style>
      .select2-container--default .select2-dropdown {
            z-index: 999999 !important; /* Set high z-index */
        }
</style>


<section id="createProduct" class="financemodal">
            <div class="modal-content">
                <a class="close-btn closes">
                    <i class="fa-solid fa-xmark"></i>
                </a>
                <h2 class="heading">Create Sub Category</h2>
                <div id="popup-modal">
                    <form id="expenseForm" onsubmit="return Save(event)">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-row">
                                    <select  id="ProductCategoryID" style="width: 100%;">
                                        <option>
                                            Select Category
                                        </option>
                                    </select>
                                    <button type="button" class="btn-add newcategory-open">
                                        + Add
                                    </button>
                                </div>
                            </div>
                            <div class="col-12">

                                <div class="form-row">
                                    <input type="text" placeholder="Enter Sub Category *" id="SubcategoryName" required />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-row">
                                    <label class="country">
                                        <select name="status" id="SelectStatus" required>
                                            <option value="">Select Status</option>
                                            <option value="Active">Active</option>
                                            <option value="InActive">Inactive</option>
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="actions">
                                <button onclick="SubCategoryDataSave(event)" class="btn-save">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- Create Product Modal End -->

            <!-- Add Product modal to New Category Modal Start -->
            <div class="newcategory" id="addCategoryModal">
                <div class="newcategory-content">
                    <div class="newmodal-header">
                        <h3>Add New Category</h3>
                        <button type="button" class="newmodal-close-btn newcategory-close" aria-label="Close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <form id="addCategoryForm" onsubmit="CategorySave(event)">
                        <div class="newmodal-upload-area">
                            <div class="newmodal-img-preview" id="SubCatCategoryImgBox">
                                <i class="fa-regular fa-image" id="CategoryImgIcon"></i>
                                <img id="CategoryImgPreview" src="" alt="Preview" style="display: none;" />
                            </div>
                            <div class="newmodal-upload-info">
                                <label for="CategoryImg" class="newmodal-file-btn">
                                    <i class="fa-solid fa-cloud-arrow-up"></i> Upload Photo
                                </label>
                                <input type="file" id="CategoryImg" accept="image/*" style="display: none;" />
                                <p>PNG, JPG or GIF (up to 1 MB)</p>
                            </div>
                        </div>

                        <div class="newmodal-form-group">
                            <label class="newmodal-label" for="CategoryName">Category Name <span class="text-danger">*</span></label>
                            <input type="text" id="CategoryName" class="newmodal-input" placeholder="Enter category name" required />
                        </div>

                        <div class="newmodal-form-group">
                            <label class="newmodal-label" for="CategorySelectStatus">Status <span class="text-danger">*</span></label>
                            <div class="newmodal-select-wrapper">
                                <select id="CategorySelectStatus" class="newmodal-select" required>
                                    <option value="Active" selected>Active</option>
                                    <option value="InActive">Inactive</option>
                                </select>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>

                        <div class="newmodal-actions">
                            <button type="button" class="newmodal-btn-cancel newcategory-close">Cancel</button>
                            <button type="submit" class="newmodal-btn-save">Save Category</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Add Product modal to New Category Modal End -->
<script>


    // Save Category Function
    async function CategorySave(event) {
        event.preventDefault(); // Prevent form submission and reload

        try {
            const CategoryName = document.getElementById('CategoryName').value.trim();
            const CategorySelectStatus = document.getElementById('CategorySelectStatus').value;
            const imgInput = document.getElementById('CategoryImg');
            const imgFile = imgInput.files[0]; // Get the selected file

            // Validation
            if (!CategoryName) {
                errorToast("Category Name is required!");
                return;
            }
            if (!CategorySelectStatus || CategorySelectStatus === 'Select category status') {
                errorToast("Category Status is required!");
                return;
            }

            // Prepare Form Data
            const formData = new FormData();
            formData.append('category_name', CategoryName);
            formData.append('status', CategorySelectStatus);
            if (imgFile) {
                formData.append('img_url', imgFile); // Append image file if provided
            }

            // Axios Request Configuration
            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    ...HeaderToken().headers,
                },
            };

            // API Call to Save Category
            const res = await axios.post("/api/create-category", formData, config);

            if (res.data.status === "success") {
                successToast(res.data.message);

                // Clear Form Fields
                document.getElementById('CategoryName').value = '';
                document.getElementById('CategorySelectStatus').value = 'Select category status';
                imgInput.value = ''; // Clear the file input

                // Close Modal
                closeCategoryModal();

                // Refresh Dropdown
                await refreshCategoryList(res.data.newCategoryId);
            } else {
                errorToast(res.data.message || "Failed to save category.");
            }
        } catch (error) {
            console.error("Error saving category:", error);
            errorToast("An error occurred while saving the category. Please try again.");
        }
    }

    // Refresh Category Dropdown
    async function refreshCategoryList(selectedCategoryId = null) {
        try {
            const res = await axios.get("/api/category-list", HeaderToken());

            if (res.data.status === "success") {
                const categories = res.data.CategoryData;

                // Build the options for the dropdown
                let optionsHtml = `<option value="none" selected>Select Category</option>`;
                optionsHtml += categories
                    .map(category => `<option value="${category.id}">${category.category_name}</option>`)
                    .join('');

                // Populate the dropdown
                const categoryDropdown = document.getElementById("ProductCategoryID");
                categoryDropdown.innerHTML = optionsHtml;

                // Optionally select the newly created category
                if (selectedCategoryId) {
                    categoryDropdown.value = selectedCategoryId;
                }
            } else {
                console.error("Failed to fetch categories:", res.data.message);
                errorToast("Failed to update categories. Please try again.");
            }
        } catch (error) {
            console.error("Error fetching categories:", error);
            errorToast("An error occurred while updating the category list.");
        }
    }

    // Modal Handling (Open/Close)
    function closeCategoryModal() {
        document.getElementById('addCategoryModal').style.display = 'none';
    }

    function openCategoryModal() {
        document.getElementById('addCategoryModal').style.display = 'block';
    }

    // Modal Trigger Setup
    document.querySelector('.newcategory-open').addEventListener('click', openCategoryModal);
    document.querySelectorAll('.newcategory-close').forEach(btn =>
        btn.addEventListener('click', closeCategoryModal)
    );

    // Optional: Initial Dropdown Refresh
    document.addEventListener('DOMContentLoaded', () => {
        refreshCategoryList();
    });
</script>






<script>

async function Save(event) {
    event.preventDefault(); // Prevent form submission and page reload
    try {
        const SubcategoryName = document.getElementById('SubcategoryName').value;
        const ProductCategoryID = document.getElementById('ProductCategoryID').value;
        const SelectStatus = document.getElementById('SelectStatus').value;

        if (!ProductCategoryID) {
            errorToast("Category ID required!");
            return false;
        }

        else if (!SubcategoryName) {
            errorToast("Sub Category Name is required!");
            return false;
        }


        else if (!SelectStatus) {
            errorToast("Select Status is required!");
            return false;
        }



        else {
            let formData = new FormData();
            formData.append('sub_category_name', SubcategoryName);
            formData.append('category_id', ProductCategoryID);
            formData.append('status', SelectStatus);




            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers,
                },
            };

            let res = await axios.post("/api/sub-create-category", formData, config);

            if (res.data['status'] === "success") {
                successToast(res.data['message']);
                document.getElementById("expenseForm").reset();
                const modalElement = document.getElementById('createProduct') || document.getElementById('myModal');
                if (modalElement) closeModal(modalElement);
                setTimeout(() => {
                    location.reload();
                }, 500);
            } else {
                errorToast(res.data['message']);
            }
        }
    } catch (e) {
        unauthorized(e.response.status);
    }
}

function closeModal(modal) {
    modal.style.display = 'none';
}
</script>
