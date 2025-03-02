<dialog class="dialog" id="delete-dialog">
			<div class="delete-container form-wrapper">
				<h2>User Confirmation</h2>
				<div class="form">
					<p>
						The selected items will be deleted forever and won't be able to be
						recovered.
					</p>
				</div>
				<div id="button-row">
					<button
						type="reset"
						id="cancel-button"
						onclick="showDeleteDialog(false)"
					>
						Cancel
					</button>
					<button type="submit" id="delete-button">Delete</button>
				</div>
			</div>
		</dialog>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            const deleteDialog = document.getElementById("delete-dialog");
            const deleteWrapper = document.querySelector(".delete-container");
            const showDeleteDialog = (show) => show ? deleteDialog.showModal() : deleteDialog.close();
            deleteDialog.deleteEventListener("click", (e) => !deleteWrapper.contains(e.target) && deleteDialog.close());
        </script>