<?php 

class CustomerCest
{

	/**
	 * User bob is a registered affiliate with a coupon code `bob`.
	 *
	 * When his affiliate link is visited, the customer should see a success message.
	 *
	 * @param AcceptanceTester $I
	 */
	public function testHappyBob(AcceptanceTester $I) {

		$affiliate_link = '/?ref=bob';

		$I->amOnPage( $affiliate_link );

		$I->canSee('Coupon code applied successfully.' );
	}

	/**
	 * User bob2 is a registered affiliate *without* a coupon.
	 *
	 * When his affiliate link is visited, a coupon should be created and the customer should see a success message.
	 *
	 * Verify bob2 now has a coupon.
	 *
	 * @param AcceptanceTester $I
	 */
	public function testHappyBobNoCoupon(AcceptanceTester $I) {

		$affiliate_link = '/?ref=bob2';

		$I->amOnPage( $affiliate_link );

		$I->canSee('Coupon code applied successfully.' );

		$I->loginAsAdmin();

		$I->amOnAdminPage( 'edit.php?post_type=shop_coupon' );

		$I->canSee('bob2' );
	}


	/**
	 * User bob2 is a WordPress user but is not a registered affiliate.
	 *
	 * When his affiliate link is visited, he should be registered as an affiliate, a coupon should be created
	 * and the customer should see a success message.
	 *
	 * Verify bob3 is now a registered affiliate.
	 *
	 * @param AcceptanceTester $I
	 */
	public function testHappyBobNotRegistered(AcceptanceTester $I) {

		$affiliate_link = '/?ref=bob3';

		$I->amOnPage( $affiliate_link );

		$I->canSee('Coupon code applied successfully.' );

		$I->loginAsAdmin();

		$I->amOnAdminPage( 'admin.php?page=affiliate-wp-affiliates' );

		$I->canSee('bob3' );
	}

}
