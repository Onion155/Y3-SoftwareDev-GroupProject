<dialog class="dialog" id="delete-dialog">
    <div class="delete-container form-wrapper">
        <h2>Are you sure you want to delete?</h2>
        <p>Data will be lost forever</p>
        <button>Cancel</button>
        <form id="egfr-form" method="POST" action="requestHandler.php?action=deletePatientRecords">
        <button id="red-button">Delete</button>
        </form>
        <button id="blue-button" onclick=showDeleteDialog(false)>Cancel</button>
    </div>

</dialog>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const deleteDialog = document.getElementById("delete-dialog");
    const deleteWrapper = document.querySelector(".delete-container");
    const showDeleteDialog = (show) => show ? deleteDialog.showModal() : deleteDialog.close();
    deleteDialog.deleteEventListener("click", (e) => !deleteWrapper.contains(e.target) && deleteDialog.close());
</script>