$(function() {
    $('.delete').click(function (event) {
        if (confirm('Are you sure?')) {
            
        } else {
            event.stopPropagation();
            event.preventDefault();
        }
    });
});