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
                'filter'=>['IS_CHECKED'=>'Y'],
                'select' => ['*', 'MESSAGE_'=>'MESSAGE', 'AUTHOR_'=>'AUTHOR', 'EMAIL_'=>'EMAIL', 'IS_CHECKED'],
            ]);
			
			foreach($review = $getReviewElements->fetch())
			{
				$this->arResult['ITEMS'][] = $review;
			}
			
			if($request->get('MESSAGE'))
			{
				if(check_bitrix_sessid())
				{
					$new_element = $iblock_class::add([
						'NAME' => $request->get('AUTHOR'),
						'MESSAGE' => $request->get('MESSAGE'),
						'EMAIL' => $request->get('EMAIL'),
						'IS_CHECKED' => 'N',
						
					]);
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

