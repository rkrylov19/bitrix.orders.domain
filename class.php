<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Localization\Loc,
    Bitrix\Sale\Order;

Loc::loadMessages(__FILE__);

class OrdersDomain extends CBitrixComponent {

    protected function getOrders()
    {
        global $USER;
        if($USER->isAdmin()) {
            $select = array("EMAIL_DOMAIN", "EMAIL_DOMAIN_COUNT");
            $filter = array("LID" => SITE_ID, 'PROPERTY.CODE' => 'EMAIL');
            $runTime = array(
                new Bitrix\Main\Entity\ExpressionField('EMAIL_DOMAIN', 'SUBSTRING_INDEX(%s, "@", -1)', "PROPERTY.VALUE"),
                new Bitrix\Main\Entity\ExpressionField('EMAIL_DOMAIN_COUNT', 'COUNT(%s)', "EMAIL_DOMAIN"),
            );
            $group = array("EMAIL_DOMAIN");
            $queryParams = array(
                "filter" => $filter,
                "select" => $select,
                'runtime' => $runTime,
                'group' => $group
            );

            $dbItems = Order::getList($queryParams);

            while ($row = $dbItems->Fetch()) {
                $this->arResult[] = $row;
            }
        }
    }


    public function executeComponent() {
        if ($this->startResultCache()) {
            $this->getOrders();
            $this->includeComponentTemplate();
        }
    }
}