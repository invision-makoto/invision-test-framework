<?php
class LoginCest 
{    
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
    }

    public function loginSuccessfully(AcceptanceTester $I)
    {
        $I->loginOrRegisterDemo();
    }    
}