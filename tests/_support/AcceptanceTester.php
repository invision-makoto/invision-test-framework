<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    public $previousSettings = [];

    /**
 * Login to an account
 * @param string $name
 * @param string $password
 * @param bool $skipValidation
 */
    public function login($name='codecept', $password='codecept', $skipValidation=false)
    {
        $I = $this;
        $I->am('Logging into the account ' . $name);
        $I->resetCookie('ips4_IPSSessionFront');

        $I->amOnPage('/login/');
        $I->see('Sign In');

        $I->fillField('auth', $name);
        $I->fillField('password', $password);
        //       $I->checkOption('signin_anonymous_checkbox');
        $I->click('Sign In', 'button[type="submit"]');

        if (!$skipValidation)
        {
            $I->canSeeCookie('ips4_IPSSessionFront');
            $I->seeElement('a#elUserLink');
        }
    }

    /**
     * Attempt to register an account
     *
     * @param string $name
     * @param string $password
     * @param string $email
     * @param bool   $skipValidation
     */
    public function register($name='codecept', $password='codecept', $email='codecept@example.com', $skipValidation=false)
    {
        $I = $this;
        $I->am('Registering a new account with the name ' . $name);
        $I->resetCookie('ips4_IPSSessionFront');

        $I->amOnPage('/register/');
        $I->see('Sign Up');

        $I->fillField('Display Name', $name);
        $I->fillField('Email Address', $email);
        $I->fillField('Password', $password);
        $I->fillField('Confirm Password', $password);
        $I->checkOption('reg_agreed_terms_checkbox');
        $I->uncheckOption('reg_admin_mails_checkbox');
        $I->click('Create my Account', 'button[type="submit"]');

        if (!$skipValidation)
        {
            $I->canSeeCookie('ips4_IPSSessionFront');
            $I->seeElement('a#elUserLink');
        }
    }

    /**
     * Helper function to either login to a standard testing account, or register one if it doesn't exist
     *
     * @return void
     */
    public function loginOrRegisterDemo()
    {
        $I = $this;
        if ( $I->tryToseeInDatabase( 'core_members', [ 'email' => 'codecept@example.com' ] ) )
        {
            $I->login();
            return;
        }

        $I->register();
    }

    /**
     * Deletes a member
     * @param   $email
     */
    public function deleteMember( $email='codecept@example.com' )
    {
        $I = $this;
//        $I->seeInDatabase('core_members', array('email' => $email));
        \IPS\Member::load( $email, 'email' )->delete(FALSE, FALSE);
    }

    /**
     * Change settings to specified values for the current test Only
     *
     * @param array $values
     * @return void
     */
    public function changeSettings( array $values )
    {
        foreach ( array_keys( $values ) as $settingKey )
        {
            // We might change the same setting multiple times; make sure we preserve the original setting still
            if ( isset( $this->previousSettings[ $settingKey ] ) )
            {
                continue;
            }

            $this->previousSettings[ $settingKey ] = \IPS\Settings::i()->$settingKey;
        }

        \IPS\Settings::i()->changeValues( $values );
    }

    /**
     * Change settings back to their default values after running a test
     *
     * @return void
     */
    public function changeSettingsBack()
    {
        if ( $this->previousSettings !== NULL )
        {
            \IPS\Settings::i()->changeValues( $this->previousSettings );
        }
    }
}
