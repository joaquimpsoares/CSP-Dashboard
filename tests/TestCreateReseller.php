<?php


namespace CreateReseller;

class ResellerCreateTest extends TestCase
{

    /**
     * My test implementation
     */
    public function testCreateReseller()
    {
        $this->visit('/reseller');
        $this->press('Options');
        $this->visit('/reseller/create');
        $this->type('superadmin@admin.com', 'email');
        $this->type('admin123', 'password');
        $this->type('Enim', 'null');
        $this->type('Hoover and Patton Inc', 'null');
        $this->type('676', 'nif');
        $this->type('17 Rocky Fabien Drive', 'address_1');
        $this->type('Aut excepteur tenetu', 'address_2');
        $this->type('Amet sed fugit vol', 'city');
        $this->type('Incididunt qui qui p', 'state');
        $this->type('70128', 'postal_code');
        $this->type('52', 'mpnid');
        $this->type('Brendan', 'name');
        $this->type('Branch', 'last_name');
        $this->type('Dolores aliqua Duci', 'socialite_id');
        $this->type('+1 (958) 777-6056', 'phone');
        $this->type('Delectus velit earu', 'address');
        $this->type('sozojy@mailinator.com', 'email');
        $this->type('Pa$$w0rd!', 'password');
        $this->type('Pa$$w0rd!', 'password_confirmation');
        $this->select('800', 'country_id');
        $this->select('5', 'status');
        $this->type('12346789', 'password');
        $this->type('123456789', 'password_confirmation');
        $this->press('Create');
        $this->type('123456789', 'password');
        $this->press('Create');
        $this->seePageIs('/reseller');


    }
}
