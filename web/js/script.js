//Send data from form
$('#enterButton').on('click', function () {
    $(this).button('loading').delay(1000).queue(function() {
        $(this).button('reset');
        $(this).dequeue();
    });
})

//place a random sentence to the holder from the YII2 actionPerform function


$.getJSON("site/perform", function(result){
    $('#offer').append(JSON.stringify(result['rus_phrase']));
    $('#answer').append(JSON.stringify(result['id']));
});

