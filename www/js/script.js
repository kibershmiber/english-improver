/*
English Improver main-js file
Poremchuk E. (c) 2015
e.poremchuk@gmail.com
*/
// Start a application instant
init();

// Configure application
function init(){
    $siteurl = 'site/perform'; //API url
    answersCounter('start') // Initialize answer counters
    getData(); // Fetch a sentence
    setInitialCookies(); // Initialize cookies

    //Initialze tooltips
    $("[data-toggle='tooltip']").tooltip({'delay': { show: 500, hide: 800 }});
    $("[data-toggle='popover']").popover();
}

//Set initial cookies
// I've separated all "if-else" statement to better implicit
function setInitialCookies(){
    // Init counter ERROR
   // if(Cookies.get('error') == undefined){
        Cookies.set('error', 0);
    //}
    // Init counter RIGHT
    //if(Cookies.get('right') == undefined){
        Cookies.set('right', 0);
    //}
        Cookies.set('timer', false);
    //reset timer
    //$('#timer').timer('remove');

    //Initial button level1 in site
   // if(Cookies.get('level1') == undefined){
        Cookies.set('level1', true);
  //  }

    //Initial button level2 in site
   // if(Cookies.get('level2') == undefined){
        Cookies.set('level2', false);
   // }

}
$("#userinput").focus(function() {

    if(Cookies.get('timer') == "false"){
        startTimer();
    }
});

//Start the timer
function startTimer(){
    $('#timer').timer();
    Cookies.set('timer', true);
}

//Pause timer
$("div#timer").on('click',function(){
    if(Cookies.get('timer') == "true") {
        $('#timer').timer('pause');
        Cookies.set('timer', 'pause');
    }else if(Cookies.get('timer') == 'pause'){
        $('#timer').timer('resume');
        Cookies.set('timer', 'true');
    }
});

//Perform click on reset image
$('#resetButton').on('click', function(){
    resetCounters();
});

//Reset answer counters to '0'
function resetCounters(){
    Cookies.set('error', 0);
    Cookies.set('right', 0);
    $('#wrong').html('0');
    $('#right').html('0');
    Cookies.set('timer', false);
    $('#timer').timer('remove');
    $('#timer').html('<span class="glyphicon glyphicon-time" aria-hidden="true"></span> 00:00');
    console.log('Counters and timer has been reset');
    return false;
}

//Cache a click on level1 button
$("div.btn-group>label:nth-child(1)").on('click',function() {
    changeLevel(1);
    getData();
});
//Cache a click on level2 button
$("div.btn-group>label:nth-child(2)").on('click',function() {
    changeLevel(2);
    getData();

});

//Handle check in buttons (level changer)
function changeLevel(level){
    if(level == 1){
        if(Cookies.get('level1') == "true"){
            Cookies.set('level1', false);

        }else if(Cookies.get('level1') == "false"){
            Cookies.set('level1', true);
        }
    }else if(level == 2){
        if(Cookies.get('level2') == "true" || Cookies.get('level2') == "undefined"){
            Cookies.set('level2', false);

        }else if(Cookies.get('level2') == "false"){
            Cookies.set('level2', true);
        }
    }
}
//Count the answers on site
function answersCounter(type){
    if(type == 'error'){
        var $count;
        $count = Cookies.get('error');
        $count++;
        Cookies.set('error', $count);
        $('#wrong').html(Cookies.get('error'));
        return true;

    }else if(type == 'right'){
        var $count;
        $count = Cookies.get('right');
        $count++;
        Cookies.set('right', $count);
        $('#right').html(Cookies.get('right'));
        return true;
    }else{
        $('#right').html(Cookies.get('right'));
        $('#wrong').html(Cookies.get('error'));
    }
}

//Press Enter on input form
$("#userinput").keypress(function(event) {
    if (event.which == 13) {
        event.preventDefault();
        check();
    }
});
$('#enterButton').on('click', function () {
    check();
});

//Send data from form
function check(){
    if($("#userinput").val() == ''){
    $('.input-group').addClass("has-error");
        $('#answer').html('Введите предложение!');
        return true;
    }
    $('.input-group').removeClass("has-error");
    $('.input-group').removeClass("has-success");
    if(Cookies.get('next') == "true"){
        $('#answer').empty();
        $("#userinput").val('');
        console.log('next - true');
        getData();
    }else{
        $.ajax({
            url: $siteurl,
            type: 'GET',
            data: {
                id: Cookies.get('last_id'),
                sentence: String($("#userinput").val())
            },
            error: function (data) {
                $('#answer').html('<p>An error has occurred</p>');
            },
            success: function (data) {
                data = jQuery.parseJSON(data);
                Cookies.set('next', true);
                console.log(data);
                console.log(data.status);
                if (data.status !== undefined) {
                    if (data.status == false) {
                        $('.input-group').addClass("has-error");
                        $('#answer').html('<div class="alert alert-danger" role="alert"><h3>Не верно!</h3>А нужно было: <b>'+data.eng_phrase+'</b><br/>Для продолжения нажмите "Enter"</div>');
                        answersCounter('error');
                    } else {
                        $('.input-group').addClass("has-success");
                        $('#answer').html('<div class="alert alert-success" role="alert"><h3>Верно!</h3>Для продолжения нажмите "Enter"</div>');
                        answersCounter('right');
                    }
                }else{
                    $('#answer').html('data.status == undefined');
                }
            }
        });
    }
}

//place a random sentence to the holder from the YII2 actionPerform function
function getData() {
    if(Cookies.get('level_q') == "false") {
        Cookies.set('level_q', true);
    }else if(Cookies.get('level_q') == undefined){
        Cookies.set('level_q', false);
    }else{
        Cookies.set('level_q', false);
    }
    $.getJSON("site/perform", function (result) {
        $('.input-group').removeClass("has-error");
        $('.input-group').removeClass("has-success");
        Cookies.set('next', false);
        $('#offer').text(JSON.stringify(result['rus_phrase']));
        Cookies.set('last_id', result['id'],'value', { domain: 'improver.dev' });

    })
}