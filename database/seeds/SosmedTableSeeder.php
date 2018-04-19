<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facedes\DB;

class SosmedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //insert table group
        \DB::table('group_unit')
            ->insert(
                [
                    ['group_name'=>'MNC GROUP'],
                    ['group_name'=>'EMTEK GROUP'],
                    ['group_name'=>'TRANS CORP'],
                    ['group_name'=>'VIVA GROUP'],
                    ['group_name'=>'OTHERS']
                ]
            );
        
        
        /* insert table business_unit */
        \DB::table('business_unit')
            ->insert(
                [
                    [
                        'group_unit_id'=>1,
                        'unit_name'=>'RCTI'       
                    ],
                    [
                        'group_unit_id'=>1,
                        'unit_name'=>'MNCTV'
                    ],
                    [
                        'group_unit_id'=>1,
                        'unit_name'=>'GTV'
                    ],
                    [
                        'group_unit_id'=>1,
                        'unit_name'=>'INEWS (4TV News)'
                    ],
                    /* emtek group */
                    [
                        'group_unit_id'=>2,
                        'unit_name'=>'IVM'
                    ],
                    [
                        'group_unit_id'=>2,
                        'unit_name'=>'SCTV'
                    ],

                    /* TRANS CORP */
                    [
                        'group_unit_id'=>3,
                        'unit_name'=>'TRANS7'
                    ],
                    [
                        'group_unit_id'=>3,
                        'unit_name'=>'TRANSTV'
                    ],

                    /* VIVA GROUP */
                    [
                        'group_unit_id'=>4,
                        'unit_name'=>'TV ONE'
                    ],
                    [
                        'group_unit_id'=>4,
                        'unit_name'=>'ANTV'
                    ],

                    /* OTHERS */
                    [
                        'group_unit_id'=>5,
                        'unit_name'=>'METRO'
                    ],
                    [
                        'group_unit_id'=>5,
                        'unit_name'=>'KOMPAS'
                    ],
                    [
                        'group_unit_id'=>5,
                        'unit_name'=>'NET'
                    ]
                ]
            );

        /* SOSMED */
        \DB::table('sosmed')
            ->insert(
                [
                    [
                        'sosmed_name'=>'Twitter'
                    ],
                    [
                        'sosmed_name'=>'Facebook'
                    ],
                    [
                        'sosmed_name'=>'Instagram'
                    ]
                ]
            );

        /* UNIT SOSMED */
        \DB::table('unit_sosmed')
            ->insert(
                /* official rcti */
                [
                    [
                        'type_sosmed'=>'corporate',
                        'business_program_unit'=>1,
                        'sosmed_id'=>1,
                        'unit_sosmed_name'=>'officialrcti'
                    ],
                    [
                        'type_sosmed'=>'corporate',
                        'business_program_unit'=>1,
                        'sosmed_id'=>2,
                        'unit_sosmed_name'=>'OfficialRCTI.TV'
                    ],
                    [
                        'type_sosmed'=>'corporate',
                        'business_program_unit'=>1,
                        'sosmed_id'=>3,
                        'unit_sosmed_name'=>'officialrcti'
                    ],
                    /* end official rcti */

                    /* official sctv */
                    [
                        'type_sosmed'=>'corporate',
                        'business_program_unit'=>6,
                        'sosmed_id'=>1,
                        'unit_sosmed_name'=>'SCTV_'
                    ],
                    [
                        'type_sosmed'=>'corporate',
                        'business_program_unit'=>6,
                        'sosmed_id'=>2,
                        'unit_sosmed_name'=>'SCTV'
                    ],
                    [
                        'type_sosmed'=>'corporate',
                        'business_program_unit'=>6,
                        'sosmed_id'=>1,
                        'unit_sosmed_name'=>'sctv'
                    ],
                    /* end official sctv */

                    /* official mnctv */
                    [
                        'type_sosmed'=>'corporate',
                        'business_program_unit'=>2,
                        'sosmed_id'=>1,
                        'unit_sosmed_name'=>'Official_MNCTV'
                    ],
                    [
                        'type_sosmed'=>'corporate',
                        'business_program_unit'=>2,
                        'sosmed_id'=>2,
                        'unit_sosmed_name'=>'MnctvOfficial'
                    ],
                    [
                        'type_sosmed'=>'corporate',
                        'business_program_unit'=>2,
                        'sosmed_id'=>3,
                        'unit_sosmed_name'=>'officialmnctv'
                    ],
                    /* end official mnctv */

                    /* indosial official */
                    [
                        'type_sosmed'=>'corporate',
                        'business_program_unit'=>5,
                        'sosmed_id'=>1,
                        'unit_sosmed_name'=>'IndosiarID'
                    ],
                    [
                        'type_sosmed'=>'corporate',
                        'business_program_unit'=>5,
                        'sosmed_id'=>2,
                        'unit_sosmed_name'=>'IndosiarID.TV'
                    ],
                    [
                        'type_sosmed'=>'corporate',
                        'business_program_unit'=>5,
                        'sosmed_id'=>3,
                        'unit_sosmed_name'=>'indosiar'
                    ],
                    /* end indosial official */

                    /* antv official */
                    [
                        'type_sosmed'=>'corporate',
                        'business_program_unit'=>10,
                        'sosmed_id'=>1,
                        'unit_sosmed_name'=>'whatsonANTV'
                    ],
                    [
                        'type_sosmed'=>'corporate',
                        'business_program_unit'=>10,
                        'sosmed_id'=>2,
                        'unit_sosmed_name'=>'ANTVOfficial'
                    ],
                    [
                        'type_sosmed'=>'corporate',
                        'business_program_unit'=>10,
                        'sosmed_id'=>3,
                        'unit_sosmed_name'=>'antv_official'
                    ],
                    /* end antv official */

                    /* GTV OFFICIAL */
                    [
                        'type_sosmed'=>'corporate',
                        'business_program_unit'=>3,
                        'sosmed_id'=>1,
                        'unit_sosmed_name'=>'@OfficialGTVID'
                    ],
                    [
                        'type_sosmed'=>'corporate',
                        'business_program_unit'=>3,
                        'sosmed_id'=>2,
                        'unit_sosmed_name'=>'GTV - Indonesia'
                    ],
                    [
                        'type_sosmed'=>'corporate',
                        'business_program_unit'=>3,
                        'sosmed_id'=>3,
                        'unit_sosmed_name'=>'officialgtvid'
                    ]
                    /* END GTV OFFFICIAL */
                ]
            );
    }
}
