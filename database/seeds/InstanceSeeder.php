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
            'provider' => 'microsoft',
            'external_id' => '66127fdf-8259-429c-9899-6ec066ff8915',
            'external_type' => 'direct',
            'external_token' => 'AQABAAAAAABeAFzDwllzTYGDLh_qYbH8mzMfQxnxmganTs8P6dciALzEiimvI1pkkyAef8Sy9Zce5xXSrZRLtAFl8BBjJR46pUY5OVxUWAbdRNYqt5rj6OoyeUnpYwLUNwa8m_W01j0wGb5cOf13qknCl1u14UdriP9c1qky-VGXxL5TDyN1jvgmZsIhf29XQzYLVGzNMZYKJbvaQJMEQjGW6valg2sheHohChimYSFvt_ilY_c9oBPjvoD6x-TDbtUgJDVFJ7N5OCEZ61_YkW6EeRYn5k64lnOc-gE4faLtMW5IRbqvJjy89NzWy7sanxg3r9tDlhlrz7NTWsAoBtNdsB9hp9GRnB4-W0nAL9R9dslzab7YZT8mgopAPXqsBLwjnl67ZLI1Jv8AyZCqDGNepUzkZEqTXzU9qZB8xh6p3isAjQwZ-zrFR4fG6kD9f4GTa86gkz2xRrv3yGlvMqYjaGAfTNiNcScW3YB53N4JnstJXjbBJOC5m7vvZx0SDdWCmO8Pl6Misb5H6fPq2v8HHtVJEXuVxh21IXUKkzwHnS51Fwoa39nhc44cXvZid3OSOLmyt78IHLlAkkW43VHplFWO9hdUx19btKZZzA71octb8zDP7Q5bVkjlQ_Zj5s6-t8B5MFn4wezx8xyPzbAyD9PydO2RnXJ-YL7qVXJGRJOXn_OzC3N_6DTP3TgIUI0J-WsFy0f1yhC72UBYHK75eMetisAMRogL1ZteIjX4HwTy09dbdg3bjD1358G5YJPhBaxreqdJyxM5lyobkJO4M-q0yq69fe2hbOrkuMbo77DU3znP2QIBBH3XWm58XN-4YnhLpOsWwWzu5_yTBDDUTkhga478kiDbBWT_naneJUynne0f2Tmw86fzNtfjcQBw_kc9AdOsFMlv-iPXHC6CQY3ez2_IfnnoWBsKSJMMy2R2lKWW0tKSK0dwDJ_ttbZVkxwEx-Eftiaj-JUfY8thJXD8o5mGnlKzapXFyinzSColNrY_L3jz6Qk2_C4KT_FPK3m4Qf_TUhFH9ep0gxDKBARVsCOO-TdAAAHtrMWK33Tn0WyDb7cV5ULaWPJxiIrpaEFrisiUGasw3BmsZ5MKTL8Bp9rTIAA',
        ]);
    }
}
