<?php 

class ViewAccountSettingsCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loginOrRegisterDemo();
    }

    public function viewOverview(AcceptanceTester $I)
    {
        $I->amOnPage('/settings/');
        $I->seeResponseCodeIs(200);
    }

    public function viewEmail(AcceptanceTester $I)
    {
        $I->amOnPage('/settings/');

        $I->seeLink('Email Address');
        $I->click('Email Address');
        $I->seeCurrentUrlEquals('/settings/email/');
        $I->seeResponseCodeIs(200);
    }

    public function viewPassword(AcceptanceTester $I)
    {
        $I->amOnPage('/settings/');

        $I->seeLink('Password');
        $I->click('Password');
        $I->seeCurrentUrlEquals('/settings/password/');
        $I->seeResponseCodeIs(200);
    }

    public function viewAccountSecurity(AcceptanceTester $I)
    {
        $I->amOnPage('/settings/');

        $I->seeLink('Security and Privacy');
        $I->click('Security and Privacy');
        $I->seeCurrentUrlEquals('/settings/account-security/');
        $I->seeResponseCodeIs(200);
    }

    public function viewDevices(AcceptanceTester $I)
    {
        $I->amOnPage('/settings/');

        $I->seeLink('Recently Used Devices');
        $I->click('Recently Used Devices');
        $I->seeCurrentUrlEquals('/settings/devices/');
        $I->seeResponseCodeIs(200);
    }
}
