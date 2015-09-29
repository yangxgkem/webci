<?php

//协议名对应service目录和实例化后(service目录, 加载后service name, 协议目录)
$protocol_name = array(
	//login proto
	'c2s_login_login' => array('login/login_service', 'login_service', 'login/login.php'),
	'c2s_login_register' => array('login/login_service', 'login_service', 'login/login.php'),
	'c2s_login_code' => array('login/login_service', 'login_service', 'login/login.php'),
	'c2s_login_guide_check' => array('login/login_service', 'login_service', 'login/login.php'),
	'c2s_login_retrieve' => array('login/login_service', 'login_service', 'login/login.php'),
	'c2s_login_retrieve_check' => array('login/login_service', 'login_service', 'login/login.php'),
	'c2s_login_newpw' => array('login/login_service', 'login_service', 'login/login.php'),

	//notebook proto
	'c2s_notebook_info' => array('notebook/notebook_service', 'notebook_service', 'notebook/notebook.php'),
	'c2s_notebook_create' => array('notebook/notebook_service', 'notebook_service', 'notebook/notebook.php'),
	'c2s_notebook_update' => array('notebook/notebook_service', 'notebook_service', 'notebook/notebook.php'),
	'c2s_notebook_delete' => array('notebook/notebook_service', 'notebook_service', 'notebook/notebook.php'),
	'c2s_notebook_upload_pic' => array('notebook/notebook_service', 'notebook_service', 'notebook/notebook.php'),
	'c2s_notebook_list_info' => array('notebook/notebook_service', 'notebook_service', 'notebook/notebook.php'),

	//guide proto
	'c2s_guide_info' => array('user/guide_service', 'guide_service', 'guide/guide.php'),
	'c2s_guide_update' => array('user/guide_service', 'guide_service', 'guide/guide.php'),
	'c2s_guide_email_code' => array('user/guide_service', 'guide_service', 'guide/guide.php'),
	'c2s_guide_bind_email' => array('user/guide_service', 'guide_service', 'guide/guide.php'),
	'c2s_guide_upload_pic' => array('user/guide_service', 'guide_service', 'guide/guide.php'),
	'c2s_guide_feedback' => array('user/guide_service', 'guide_service', 'guide/guide.php'),
	'c2s_guide_phone_code' => array('user/guide_service', 'guide_service', 'guide/guide.php'),
	'c2s_guide_bind_phone' => array('user/guide_service', 'guide_service', 'guide/guide.php'),


	//systips proto
	'c2s_systips_list_info' => array('systips/systips_service', 'systips_service','systips/systips.php'),	
	'c2s_systips_delete' => array('systips/systips_service', 'systips_service','systips/systips.php'),	
	'c2s_systips_send' => array('systips/systips_service', 'systips_service','systips/systips.php'),

	//trip proto
	'c2s_trip_create' => array('trip/trip_service', 'trip_service', 'trip/trip.php'),
	'c2s_trip_update' => array('trip/trip_service', 'trip_service', 'trip/trip.php'),
	'c2s_trip_status' => array('trip/trip_service', 'trip_service', 'trip/trip.php'),
	'c2s_trip_del' => array('trip/trip_service', 'trip_service', 'trip/trip.php'),
	'c2s_trip_list' => array('trip/trip_service', 'trip_service', 'trip/trip.php'),

	//cmd
	'c2s_cmd_cmd' => array('cmd/cmd_service', 'cmd_service', 'cmd/cmd.php'),

	//trip content proto
	'c2s_tripcontent_create' => array('trip/tripcontent_service', 'tripcontent_service', 'trip/tripcontent.php'),
	'c2s_tripcontent_update' => array('trip/tripcontent_service', 'tripcontent_service', 'trip/tripcontent.php'),
	'c2s_tripcontent_del' => array('trip/tripcontent_service', 'tripcontent_service', 'trip/tripcontent.php'),
	'c2s_tripcontent_list' => array('trip/tripcontent_service', 'tripcontent_service', 'trip/tripcontent.php'),
	'c2s_tripcontent_upload' => array('trip/tripcontent_service', 'tripcontent_service', 'trip/tripcontent.php'),

	//trip addr proto
	'c2s_tripaddr_create' => array('trip/tripaddr_service', 'tripaddr_service', 'trip/tripaddr.php'),
	'c2s_tripaddr_update' => array('trip/tripaddr_service', 'tripaddr_service', 'trip/tripaddr.php'),
	'c2s_tripaddr_del' => array('trip/tripaddr_service', 'tripaddr_service', 'trip/tripaddr.php'),
	'c2s_tripaddr_list' => array('trip/tripaddr_service', 'tripaddr_service', 'trip/tripaddr.php'),
	'c2s_tripaddr_impress' => array('trip/tripaddr_service', 'tripaddr_service', 'trip/tripaddr.php'),

	//rollcall proto
	'c2s_rollcall_create' => array('rollcall/rollcall_service', 'rollcall_service', 'rollcall/rollcall.php'),
	'c2s_rollcall_list_info' => array('rollcall/rollcall_service', 'rollcall_service', 'rollcall/rollcall.php'),
	'c2s_rollcall_del' => array('rollcall/rollcall_service', 'rollcall_service', 'rollcall/rollcall.php'),
	'c2s_rollcall_update' => array('rollcall/rollcall_service', 'rollcall_service', 'rollcall/rollcall.php'),
);

