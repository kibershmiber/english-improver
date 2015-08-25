<?php

/* @var $this yii\web\View */

$this->title = 'English Improver - тренажер для доведения до автоматизма построения правильных английских предложений   ';
?>
<div class="site-index">
    <br/>
   <center><img src="/images/logo.png"><br/></center>

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
            <div class="col-md-6"><div class="well well-sm" ><div id="offer"  data-toggle="tooltip" data-placement="bottom" title="Предложение на русском языке которое нужно перевести"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></div></div></div>
            <div class="col-md-2"><div class="well well-sm">Правильно: <span class="label label-success" id="right">0</span> </div></div>
            <div class="col-md-2"><div class="well well-sm">Не правильно: <span class="label label-danger" id="wrong">0</span>  </div></div>
            <div class="col-md-2"><div class="well well-sm"><div id="timer"  data-toggle="tooltip" data-placement="bottom" title="Таймер запускаеться сам при первом вводе анг. предложения"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> 00:00 </div></a></div>
        </div>

        </div>
        <div class="input-group">
                <input type="text" id="userinput" class="form-control  input-lg"  placeholder="Введите сюда английский перевод верхнего предложения" >

            <div class="input-group-btn">
                <button type="button" id="enterButton"  class="btn btn-primary btn-lg" data-toggle="tooltip" data-placement="bottom" title="Проверка предложения и генерация следующего" >Enter</button>
                <button type="button" id="resetButton" class="btn btn-primary btn-lg" data-toggle="tooltip" data-placement="bottom" title="Сброс счетчиков и таймера" ><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <button type="button" id="quaButton" class="btn btn-primary btn-lg"  data-toggle="modal" data-placement="bottom" title="Граматическая помощь" data-target="#helpModal"><span class="glyphicon glyphicon-question-sign" aria-hidden="true" ></span></button>
            </div>

        </div>
        <br/>
        <div id="answer"></div>


    </div>

    <!-- Modal -->
    <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="helpModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="helpModalLabel">Скорая граматическая помощь</h4>
                </div>
                <div class="modal-body">

              <img src="/images/table_verbs.PNG">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Спасибо, закрыть.</button>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">

    </div>
</div>
