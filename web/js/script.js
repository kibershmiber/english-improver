$('#myButton').on('click', function () {
    $(this).button('loading').delay(1000).queue(function() {
        $(this).button('reset');
        $(this).dequeue();
    });
})
