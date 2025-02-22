
$('#doctor-notes').on('input', function() {
    updateNotes(this.value);
    $('#notes-save-status').text("Saving");

}
)

const updateNotes = debounce((notes) =>
    {
        $.get("requestHandler.php", { action: 'setNotes', notes: notes }, function(data, status) {
            if(status == "success") {
                $('#notes-save-status').text(data);
            } else {
                $('#notes-save-status').text("Save failed");
            }
        })
    }
    )

function debounce(cb, delay = 1000) {
    let timeout
    return (...args) => {
        clearTimeout(timeout)
        timeout = setTimeout(() => {
            cb(...args)
        }, delay)
    }
}