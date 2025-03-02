<dialog class="dialog" id="add-dialog">
    <div class="add-container form-wrapper">
        <h2>Calculate eGFR</h2>
  <form id="egfr-form" method="POST" action="requestHandler.php?action=addPatientRecord">
    <div id="input-container">
      <label for="creatinine">Serum Creatinine</label>
      <div id="input-content">
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
    <button type="submit">Create record</button>
  </form>
</div>
</dialog>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const addDialog = document.getElementById("add-dialog");
const addWrapper = document.querySelector(".add-container");
const showAddDialog = (show) => show ? addDialog.showModal() : addDialog.close();
addDialog.addEventListener("click", (e) => !addWrapper.contains(e.target) && addDialog.close());
</script>