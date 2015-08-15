<?php

/* @var $this yii\web\View */

$this->title = 'English Improver - тренажер для доведения до автоматизма построения правильных английских предложений   ';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>English Improver</h1>  <br/>
        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary active">
                <input type="checkbox" id="level1" autocomplete="off" checked> <b>Простой уровень</b>
            </label>
            <label class="btn btn-primary">
                <input type="checkbox" id="level2" autocomplete="off" > <b>Продвинутый уровень</b>
            </label>
        </div>
        <br/>  <br/>  <br/>

        <div class="input-group">
            <input type="text" class="form-control  input-lg"  placeholder="Введите сюда английский перевод верхнего предложения"  aria-label="...">
            <div class="input-group-btn">
                <button type="button" id="myButton" data-loading-text="Работаю.."  class="btn btn-primary" autocomplete="off">
                    Enter
                </button>

                </div>

        </div><br/>

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
