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
	<li><?=$message['AUTHOR']?><br>
		<?=$message['EMAIL']?><br>
		<?=$message['MESSAGE']?><br>
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
    

                <label class="send-a-request__label" for="send-a-request__name">Author:</label>
				<input type="text" value="<?=$arResult["AUTHOR_NAME"]?>" name="user_name" class="simple-input send-a-request__input">
           
                <label class="send-a-request__label" for="send-a-request__email">Email:</label>
				<input type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>" class="simple-input send-a-request__input">
           
                <label class="send-a-request__label" for="send-a-request__text">Message:</label>
				<textarea name="MESSAGE" class="simple-textarea send-a-request__textarea"><?=$arResult["MESSAGE"]?></textarea>
          


        
	
</div>   
</form>
<!--send-a-request-->


