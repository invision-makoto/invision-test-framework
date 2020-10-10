<?php 

class CreateTopicCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loginOrRegisterDemo();
        $I->am('Making sure the test forum exists');
        $I->amOnPage('/forum/2-a-test-forum/');
    }

    public function createTopic(AcceptanceTester $I)
    {
        $I->am('Creating a new topic');
        $I->see('Start new topic');
        $I->click('Start new topic');
        $I->fillField('topic_title', 'Codeception Test Topic');
        $I->fillField('topic_content_noscript', '<p>Hello, world!</p>');
        $I->click('Submit Topic', 'button[type="submit"]');

        $I->am('Verifying the topic was created successfully');
        $I->see('Reply to this topic');
        $I->see('Codeception Test Topic');
        $I->see('Hello, world!');
    }

    public function seeTopicInActivityFeed(AcceptanceTester $I)
    {
        $I->amOnPage('http://invision-test.local/discover/');
        $I->seeLink('Codeception Test Topic');
    }

    public function seeTopicInProfileFeed(AcceptanceTester $I)
    {
        $I->click('#cUserLink a');
        $I->seeLink('Codeception Test Topic');
    }
}
