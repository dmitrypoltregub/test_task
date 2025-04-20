<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

?>
<!--send-a-request-->
<ul>
<?foreach($arResult['ITEMS'] as $message):?>

	<li>ИМЯ: <?=$message['NAME']?><br>
		EMAIL: <?=$message['EMAIL_VALUE']?><br>
		ОТЗЫВ: <?=$message['MESSAGE_VALUE']?><br>
		ПЛЮСЫ: <?=$message['POSITIVES_VALUE']?><br>
		МИНУСЫ: <?=$message['NEGATIVES_VALUE']?><br>
	</li>
<?endforeach;?>
</ul>

<form enctype="multipart/form-data" action="" id='' method="POST">


    <div class="header">
        <div class="send-a-request__title">Отправить заявку</div>
		
    
<?
if($arResult["OK_MESSAGE"])
{
    ?>
	<div class='ok'><?=$arResult["OK_MESSAGE"]?></div>
	<?
}else{
?>
   <div class='subtitle'>Отправьте сообщение</div>
<?}?>
	</div>
<div class='body'>
    <?=bitrix_sessid_post()?>
   
	<?foreach($arParams['REQUIRED_FIELDS'] as $field)
	{?>
		<label class="send-a-request__label" for="send-a-request__name"><?= $field?>:</label>
		<input type="text" value="<?=$arResult["AUTHOR_NAME"]?>" name="<?= $field?>" class="simple-input send-a-request__input"><br>
	<?}?>
	<?foreach($arParams['REQUIRED_TEXTAREAS'] as $textarea)
	{?>
		 <label class="send-a-request__label" for="send-a-request__text"><?= $textarea?>:</label>
				<textarea name="<?= $textarea?>" class="simple-textarea send-a-request__textarea"><?=$arResult[$textarea]?></textarea><br><br>
	<?}?>
                
          <label class="send-a-request__label" for="send-a-request__text">Отзыв:</label>
				<textarea name="MESSAGE" class="simple-textarea send-a-request__textarea"><?=$arResult['MESSAGE']?></textarea><br><br> 
               
       <input type="submit" value="Отправить!" />   


        
	
</div>   
</form>
<!--send-a-request-->


