<dialog class="dialog" id="delete-dialog">
			<div class="delete-container form-wrapper">
				<h2>User Confirmation</h2>
				<div class="form">
					<p>
						The selected items will be deleted forever and won't be able to be
						recovered.
					</p>
				</div>
					<button type="submit" class="red-button">Delete</button>
					<button
						type="reset"
						class="green-button"
						onclick="showDeleteDialog(false)"
					>
						Cancel
					</button>
			</div>
		</dialog>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            const deleteDialog = document.getElementById("delete-dialog");
            const showDeleteDialog = (show) => show ? deleteDialog.showModal() : deleteDialog.close();
        </script>