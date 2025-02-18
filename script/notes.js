
$('#doctor-notes').on('input', function() {
    updateNotes(this.value);
    $('#notes-save-status').html("Saving");

}
)

const updateNotes = debounce((notes) =>
    {
        $.get("requestHandler.php", { action: 'setNotes', notes: notes }, function(data, status) {
            if(status == "success") {
                console.log(data);
                $('#notes-save-status').html(data);
            } else {
                $('#notes-save-status').html("Save failed");
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