<?php
namespace TEST;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();



use \Bitrix\Main\Loader,
    \Bitrix\Iblock\Iblock,
    \Bitrix\Iblock\SectionTable,
    \Bitrix\Iblock\PriceTable;

class TestTask extends \CBitrixComponent
{

    public function executeComponent()
    {
        try {
            $this->checkModules();
            $this->getResult();
        }
        catch (SystemException $e) {
            ShowError($e->getMessage());
        }
    }

   
    protected function checkModules()
    {
       
        if (!Loader::includeModule('iblock'))
           
            throw new SystemException('Модуль Iblock не установлен!');
    }

   
    public function onPrepareComponentParams($arParams)
    {
       
        if (!isset($arParams['CACHE_TIME'])) {
            $arParams['CACHE_TIME'] = 3600;
        } else {
            $arParams['CACHE_TIME'] = intval($arParams['CACHE_TIME']);
        }
       
        return $arParams;
    }

   
    protected function getResult()
    {
        
        if ($this->startResultCache()) {
			
			$request = \Bitrix\Main\Context::getCurrent()->getRequest();
			
			$iblock_class = Iblock::wakeUp($this->arParams['IBLOCK_ID'])->getEntityDataClass();
			
			$getReviewElements = $iblock_class::getList([
                'filter'=>['IS_CHECKED_VALUE'=>'Y'],
                'select' => ['*', 'MESSAGE_'=>'MESSAGE', 'EMAIL_'=>'EMAIL', 'POSITIVES_'=>'POSITIVES', 'NEGATIVES_'=>'NEGATIVES', 'IS_CHECKED_'=>'IS_CHECKED'],
            ]);
			
			foreach($getReviewElements->fetchAll() as $review)
			{
				$this->arResult['ITEMS'][] = $review;
			}
			
			if($request->get('MESSAGE'))
			{
				if(check_bitrix_sessid())
				{
					$el = new \CIBlockElement;
					$PROP = array();
					$PROP['AUTHOR'] = $request->get('AUTHOR');  
					$PROP['MESSAGE'] = $request->get('MESSAGE'); 
					$PROP['EMAIL'] = $request->get('EMAIL');  
					$PROP['POSITIVES'] = $request->get('POSITIVES');  
					$PROP['NEGATIVES'] = $request->get('NEGATIVES'); 
					$PROP['IS_CHECKED'] = 'N';  
					
					
					$arLoadProductArray = Array(

						"IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
						"IBLOCK_ID"      => $this->arParams['IBLOCK_ID'],
						"PROPERTY_VALUES"=> $PROP,
						"NAME"           => $request->get('AUTHOR'),
						"ACTIVE"         => "Y",            // активен
						

					);
					if($PRODUCT_ID = $el->Add($arLoadProductArray))
						$this->arResult['OK_TEXT'] = $this->arParams['OK_TEXT'];
					else
						echo "Error: ".$el->LAST_ERROR;
					
					
				}
			}
			
	           

            if (isset($this->arResult)) {
               $this->SetResultCacheKeys(
                    array()
                );
                
                $this->IncludeComponentTemplate();
            } else { 
                $this->AbortResultCache();
                \Bitrix\Iblock\Component\Tools::process404(
                    Loc::getMessage('PAGE_NOT_FOUND'),
                    true,
                    true
                );
            }
        }
    }


}

