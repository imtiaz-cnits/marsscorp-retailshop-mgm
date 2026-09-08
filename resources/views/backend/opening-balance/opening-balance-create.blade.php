<!-- Create Product Modal Start -->
<section id="createProduct" class="financemodal">
<div class="modal-content">
    <a class="close-btn closes">
    <i class="fa-solid fa-xmark"></i>
    </a>
    <h2 class="heading">Add New Opening Balance</h2>
    <div id="popup-modal">
    <form id="openingBalanceForm" onsubmit="return saveOpeningBalance(event)">
        <div class="row">
            <div class="col">
                <div class="form-row">
                <div class="input-datepicker-wrapper">
                    <input type="date" class="datepicker-input" id="obDate"
                        placeholder="dd/mm/yyyy" />
                    <i class="fas fa-calendar-alt icon"></i>
                </div>
            </div>
                <div class="form-row">
                    <input type="number" placeholder="Amount *" id="obAmount" required />
                </div>
                <div class="form-row">
                        <textarea name="obNote" id="obNote" cols="30" rows="10"
                            placeholder="Note (optional) *"></textarea>
                    </div>

                
            </div>
        </div>
        <div class="actions">
        <button type="submit" class="btn-save">Submit</button>
    </div>
    </form>
    </div>
</div>
</section>
<!-- Create Product Modal End -->



<script>
    // Opening Balance Save Function
    async function SaveOpeningBalance(event) {
        event.preventDefault();

        const date   = document.getElementById('obDate').value;
        const amount = document.getElementById('obAmount').value;
        const note   = document.getElementById('obNote').value.trim();

        // Validation
        if (!date) {
            errorToast("Date is required!");
            return;
        }
        if (!amount || parseFloat(amount) < 0) {
            errorToast("Valid Amount is required!");
            return;
        }

        // Create FormData
        let formData = new FormData();
        formData.append('date', date);
        formData.append('amount', amount);
        formData.append('note', note || '');

        try {
            showLoader(); // Show loader if exists

            const res = await axios.post("/api/create-opening-balance", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            });

            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message || "Opening Balance saved successfully!");
                
                // Form reset
                document.getElementById("openingBalanceForm").reset();

                // Close modal
                const modal = document.getElementById('myModal');
                if (modal) {
                    closeModal(modal);
                }

                // Refresh page
                setTimeout(() => {
                    location.reload();
                }, 800);

            } else {
                errorToast(res.data.message || "Failed to save!");
            }

        } catch (e) {
            hideLoader();
            console.error(e);
            if (e.response?.status === 401) {
                unauthorized(401);
            } else {
                errorToast("Server error. Please try again.");
            }
        }
    }

    // Close modal function
    function closeModal(modal) {
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // Form submit handler
    document.getElementById('openingBalanceForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        SaveOpeningBalance(e);
    });
</script>