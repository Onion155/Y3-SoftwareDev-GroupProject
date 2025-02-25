function showDialog() {
    dialog.showModal()
}
function closeDialog() {
    dialog.close()
}

dialog.addEventListener("click", (e) => {
    if(!wrapper.contains(e.target)) {
        dialog.close()
    }
})

