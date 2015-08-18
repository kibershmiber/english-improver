/*
English Improver main-js file
Poremchuk E. (c) 2015
e.poremchuk@gmail.com
*/

var $siteurl = 'site/perform';
answersCounter('start')
getData();
setInitialCookies();

//Set initial cookies
function setInitialCookies(){
    // Init counter ERROR
    if(Cookies.get('error') == undefined){
        Cookies.set('error', 0);
    }

    // Init counter RIGHT
    if(Cookies.get('right') == undefined){
        Cookies.set('right', 0);
    }

    //Initial button level1 in site
    if(Cookies.get('level1') == undefined){
        Cookies.set('level', true);
    }

    //Initial button level2 in site
    if(Cookies.get('level1') == undefined){
        Cookies.set('level', false);
    }
}
//TODO: Why it doesn't work? Finish it ! ))
//Cache a click on level1 button
$('#level1').on('click', function () {
    console.log('false');
    changeLevel('level1');
});

$('#level2').on('click', function () {
    changeLevel('level2');
});

//Handle check in buttons (level chenger)
function changeLevel(level){
    if(level == "level1"){
        if(Cookies.get('level1') == true){
            Cookies.set('level1', false);
            console.log('level1');
        }else if(Cookies.get('level1') == false){
            Cookies.set('level1', true);
            console.log('level1f');
        }
    }else if(level == "level2"){
        if(Cookies.get('level2') == true || Cookies.get('level2') == undefined){
            Cookies.set('level2', false);
            console.log('level2');
        }else if(Cookies.get('level2') == false){
            Cookies.set('level2', false);
            console.log('level2f');
        }
            }
    return true;
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
        Cookies.set('next', false);
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
                Cookies.set('next', true);
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
                }
            }
        });
    }
}
//place a random sentence to the holder from the YII2 actionPerform function
function getData() {
    $.getJSON("site/perform", function (result) {
        $('.input-group').removeClass("has-error");
        $('.input-group').removeClass("has-success");
        $('#offer').text(JSON.stringify(result['rus_phrase']));
        Cookies.set('last_id', result['id']);
    })
}
