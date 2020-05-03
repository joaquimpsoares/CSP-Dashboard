<?php

use App\Instance;
use Illuminate\Database\Seeder;

class InstanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Instance::create([
        	'user_id' => '0',
            'name' => 'Microsoft Instance 1',
            'type' => 'microsoft',
            'provider_id' => '1',
            'external_id' => '66127fdf-8259-429c-9899-6ec066ff8915',
            'external_type' => 'direct',
            'external_token' => '0.ATAAlQ-vvbPnyUeiLov0PCcoCd9_EmZZgpxCmJluwGb_iRUwALw.AQABAAAAAABeAFzDwllzTYGDLh_qYbH824LLxmeDTPjbS0act2ubL7kzk_9n2udIyEKERv7b-RRXcRhae2L1ylJyl2t0lnAmzEMtGFuhFaVFNuiNpCWL-e9wYRMG1Yz1PjtVw8UYQD8-tuGDxXVv5gOdlCJOjJaIqDcizDQCBil3oP-BBoOtXUyw3wvTvAI3AzrvpR9WSh5JvoBtHLsHJfJzADOiJDYvDMNGwfIaPjkncsVEk9KBedg6Q1o263akz4HhdJLXnHXTgPGz_0ASUi6Zp1toC-N09xuvIa_VpHGTkCoZi_8qvCC7udXsIZgxOwllmsdfTXNbZA0ZPby94jVjosX_JC3wMx9Hjq6rtn2bQra15hj3zgCGsCQnNGdFceeHanDEnYOy3xmIKfbMY2ONrz9kr6I_fbtfswyC9m8lrOWHKeanE__clEwpB2LDDwpwJFC9nydya6gcWiYZVIY3KSJ730X4cYlmk_D7YrVeJaWNULgdfhWKLSFe9ZzYqB-XBSOfbVg3tAwM66pyMcWgRlaEzdsP90jgQHjmqJPJIRSfqxqy60_Wu0cVVym9AsXlOW7KyqXKm68h2fTWzbJBZ2e8WLSq7ISM3p3wJzeaGyMHz1ZE5h1GgAqBHYqj5x4t1Cl3urTBD-kDOiEDifHBeY1yUI4D1gAFMS1BpcyPlEyhvDKtmev5vgL2QtDWSdEhm7OFiplzNN3l1voWyUt5-udU5eQ90CNhL03jkl7MXPYbymHbx9PMybIb5NCdWvL-eVCARJ9V9lOqK2Pghid9C7d4Wt7BbwU_ZahL59vQLjVjxwtpgz3QMxWhlFL7PXW7_lReV3QVFxVBx4-PJzmEEU-YlQmVlgqN2m79J-G-EykbdxkIWNfosAm7EqI6Uot_LMpnH2t9EVoyKXF_Xy62GA_ky9r046ynzW6qT27tM_yYKmYOIlmNECPaFqO0rN8Q0b58rcQCmIWs56SS2q2Jtts7QwfyVL_Y5BuZWur_7YWM3gw67xR4oGqR7uNB8uWZmJL4bV4B0ofCYkjb9Ua6aS3GgG17IAA',
        ]);
    }
}
