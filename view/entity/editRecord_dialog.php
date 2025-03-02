<dialog class="dialog" id="edit-dialog">
    <div class="edit-container form-wrapper">
        <h2>Calculate eGFR</h2>
  <form id="egfr-form" method="POST" action="requestHandler.php?action=editPatientRecord">
    <div id="input-container">
      <label for="creatinine">Serum Creatinine</label>
      <div id="input-content">
        <input type="hidden" id="record-id" name="record-id">
        <input type="text" id="creatinine" name="creatinine" required>
        <text>micromol/l</text>
      </div>
    </div>
    <div id="input-container">
      <label for="blood-pressure">Blood Pressure</label>
      <div id="input-content">
        <input type="text" id="blood-pressure" name="blood-pressure" required>
        <text>mmHg</text>
      </div>
    </div>
    <button type="submit">Edit record</button>
  </form>
</div>
</dialog>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const editDialog = document.getElementById("edit-dialog");
const editWrapper = document.querySelector(".edit-container");
const showEditDialog = (show) => show ? editDialog.showModal() : editDialog.close();
editDialog.editEventListener("click", (e) => !editWrapper.contains(e.target) && editDialog.close());
</script>