<?php

/**
 * Displays : 应用程序配置文件
 * Author   : xy
 */

return array(

    'upload_student' => array('path' => './uploads/student/',
	    'length' => 20000,
	    'type' => array('xlsx','xls','csv'),
	    'isrename' => true,
    ),
    'upload_exam' => array('path' => './uploads/exam/',
	    'length' => 20000,
	    'type' => array('xlsx','xls','csv'),
	    'isrename' => true,
    ),
    'upload_answer'=>array(
		'path' => './uploads/answer/',
		'length' => 4000,
        'type' => array('jpg','gif','png','jpeg'),
        'isrename' => true,
        'thumb'=>false,
        'width'=>300,
        'height'=>300,
        'thumbpath'=>'./uploads/answer/',
        'ratio'=>false,
	),
);