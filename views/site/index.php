<?php

/* @var $this yii\web\View */

$this->title = 'English Improver - тренажер для доведения до автоматизма построения правильных английских предложений   ';
?>
<div class="site-index">
   <!-- <center><img src="/images/logo.jpg"><br/></center>-->
    <div class="jumbotron">

        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary active">
                <input type="checkbox" id="level1" autocomplete="off" checked> <b>Простой уровень</b>
            </label>
            <label class="btn btn-primary">
                <input type="checkbox" id="level2" autocomplete="off" > <b>Продвинутый уровень</b>
            </label>
        </div>
        <br/>  <br/>  <br/>
        <div class="row">
            <div class="col-md-6"><div class="well well-sm" ><div id="offer"></div></div></div>
            <div class="col-md-3"><div class="well well-sm">Правильных ответов: <span class="label label-success" id="right"></span> </div></div>
            <div class="col-md-3"><div class="well well-sm"> Не правильных ответов: <span class="label label-danger" id="wrong"></span>  </div></div>
            <!--<div class="col-md-1"><div class="well well-sm"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></div></div>-->
        </div>


        <div class="input-group">
                <input type="text" id="userinput" class="form-control  input-lg"  placeholder="Введите сюда английский перевод верхнего предложения" >

            <div class="input-group-btn">
                <button type="button" id="enterButton" data-loading-text="Работаю.."  class="btn btn-primary btn-lg" autocomplete="off">Enter</button>
            </div>

        </div>
        <br/>
        <div id="answer"></div>


    </div>

    <div class="body-content">
        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
          Грамантическая подсказка
        </a><br/>
        <div class="collapse" id="collapseExample">
            <div class="well">
                <br/> (do,does,did,will,-ed,negatives,questions etc...)
                <br/> (can,may,must,should,would,to be etc...)
            </div>
        </div>

    </div>
</div>
