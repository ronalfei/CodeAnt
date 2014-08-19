<?php

final class config_router
{
    public static $map = Array(
        '/^svn\/up/i' => array(
                            'get' => array('svn', 'up'),
                            'post' => array('svn', 'up'),
                        ),

        '/^v1\/user\/login/i' => array('user', 'login'),
        '/^v1\/user\/logout/i' => array('user', 'logout'),
        '/^v1\/user\/info\/(\w*)/i' => array('user', 'info'),
        '/^v1\/user\/detail\/(\w*)/i' => array('user', 'detail'),
        '/^v1\/user\/list/i' => array('user', 'list'),
        '/^v1\/user\/self/i' => array('user', 'self'),
		
        '/^v1\/user\/password\/verify/i' => array('user', 'verify_oldpassword'),
        '/^v1\/user\/delete\/(\d*)/i' => array('user', 'delete'),

        '/^v1\/camera\/categories/i' => array('camera', 'categories'),
        '/^v1\/camera\/public/i' => array('camera', 'public'),
        '/^v1\/camera\/self/i' => array('camera', 'self'),
        '/^v1\/camera\/own/i' => array('camera', 'own'),
        '/^v1\/camera\/add/i' => array('device', 'add'),
        '/^v1\/camera\/bind/i' => array('camera', 'bind'),
        '/^v1\/camera\/unbind/i' => array('camera', 'unbind'),
        '/^v1\/camera\/setting/i' => array('camera', 'setting'),
        '/^v1\/camera\/dvr\/config\/info/i' => array('camera', 'dvr_info'),
        '/^v1\/camera\/dvr\/config/i' => array('camera', 'dvr_config'),
        '/^v1\/camera\/snapshot\/upload/i' => array('camera', 'snapshot_upload'),
        '/^v1\/device\/snapshot\/upload/i' => array('camera', 'snapshot_upload'),
        '/^v1\/camera\/snapshot/i' => array('camera', 'snapshot'),
        '/^v1\/camera\/info/i' => array('camera', 'info'),
        '/^v1\/camera\/init/i' => array('camera', 'init'),
        '/^v1\/camera\/(\d+)\/like/i' => array('camera', 'like'),
        '/^v1\/camera\/(\d+)\/share\/status/i' => array('share', 'status'),

        '/^v1\/camera\/live\/url/i' => array('camera', 'get_live_url'),

        '/^v1\/camera\/clips/i' => array('clip', 'list'),
        '/^v1\/clips\/shared/i' => array('clip', 'list', 'Y'),
        '/^v1\/clip\/delete/i' => array('clip', 'delete'),
        '/^v1\/event\/clip/i' => array('clip', 'list'),
        '/^v1\/clip\/commit/i' => array('clip', 'commit'),
        '/^v1\/clip\/zip\/download\/list/i' => array('clip', 'zip_download'),
		
		'/^v1\/clips\/list_download/i' => array('clip', 'list_download'),

        '/^v1\/event\/id/i' => array('event', 'id'),
        '/^v1\/event\/record/i' => array('event', 'record'),
        '/^v1\/events/i' => array('event', 'list'),
        '/^v1\/event\/delete/i' => array('event', 'delete'),
        '/^v1\/event\/update/i' => array('event', 'update'),
        '/^v1\/event\/frequency/i' => array('event', 'frequency_level'),
        '/^v1\/event\/frequency_level/i' => array('event', 'frequency_level'),

        '/^v1\/token\/check/i' => array('token', 'check'),
        '/^v1\/token\/get/i' => array('token', 'get'),
        '/^v1\/auth/i' => array('token', 'check'),

//-------------------------service(epack)---------------------------

        '/^v1\/service\/items/i' => array('service', 'items'),

        '/^v1\/service\/list/i' => array('service', 'list'),
        '/^v1\/service\/add/i' => array('service', 'add'),
        '/^v1\/service\/update/i' => array('service', 'update'),
        '/^v1\/service\/info\/(\w+)/i' => array('service', 'info'),
        '/^v1\/service\/delete\/([,\w]+)/i' => array('service', 'delete'),
        '/^v1\/service\/export/i' => array('service', 'export'),

//-------------------------service(category)---------------------------

        '/^v1\/ops\/category\/list/i' => array('category', 'list'),
        '/^v1\/ops\/category\/add/i' => array('category', 'add'),
        '/^v1\/ops\/category\/update/i' => array('category', 'update'),
        '/^v1\/ops\/category\/info\/(\w+)/i' => array('category', 'info'),
        '/^v1\/ops\/category\/delete\/([,\w]+)/i' => array('category', 'delete'),

        '/^category\/ico\/(\d+)/i' => array('category', 'ico'),

//-------------------------check_id(service card)---------------------------

        '/^v1\/service\/card\/list/i' => array('card', 'list'),
        '/^v1\/service\/card\/lot\/create/i' => array('card', 'create_lot'),
        '/^v1\/service\/card\/add/i' => array('card', 'add'),
        '/^v1\/service\/card\/import\/tpl/i' => array('card', 'import_tpl'),
        '/^v1\/service\/card\/import/i' => array('card', 'import'),
        '/^v1\/service\/card\/export/i' => array('card', 'export'),
        '/^v1\/service\/card\/update/i' => array('card', 'update'),
        '/^v1\/service\/card\/delete\/([,\w]+)/i' => array('card', 'delete'),
        '/^v1\/service\/card\/info\/(\d+)/i' => array('card', 'info'),

//-------------------------camera_in&out(backend operations)---------------------------

        '/^v1\/ops\/device\/list/i' => array('device', 'list'),
        '/^v1\/ops\/camera\/lot\/create/i' => array('card', 'create_lot'),
        '/^v1\/ops\/device\/add/i' => array('device', 'add'),
        '/^v1\/ops\/device\/in\/list/i' => array('device', 'in_list'),  //摄像头的入库记录
        '/^v1\/ops\/device\/out\/list/i' => array('device', 'out_list'),  //摄像头的入库记录
        '/^v1\/ops\/device\/out\/delete\/([,\w]+)/i' => array('device', 'out_delete'),  //删除出库记录
        //'/^v1\/ops\/camera\/update/i' => array('camera', 'update'),
        '/^v1\/ops\/device\/delete\/([,\w]+)/i' => array('device', 'delete'),
        '/^v1\/ops\/device\/detail\/(\w+)/i' => array('device', 'detail'),
        '/^v1\/ops\/camera\/info\/(\d+)/i' => array('camera', 'info'),
        '/^v1\/ops\/device\/out\/single/i' => array('device', 'out', '1'),  //单一摄像头出库
        '/^v1\/ops\/device\/out\/replace/i' => array('device', 'out', '2'), //维修更换
        '/^v1\/ops\/device\/out\/bind\/service/i' => array('device', 'out', '3'), //设备出库,并且绑定了服务
        '/^v1\/ops\/device\/public\/set\/(\d+)/i' => array('device', 'set_public'), //维修更换
        '/^v1\/ops\/device\/public\/(\d+)/i' => array('device', 'public'), //维修更换

//-------------------------device_bind&unbind(backend operations)---------------------------
        '/^v1\/ops\/device\/unbind\/captcha/i' => array('captcha', 'send', 'unbind'),  //获取取消绑定的校验码
        '/^v1\/ops\/device\/bind\/captcha/i' => array('captcha', 'send', 'bind'), //获取绑定的校验码
        '/^v1\/ops\/device\/replace\/captcha/i' => array('captcha', 'send', 'replace'), //获取更换的校验码
        '/^v1\/ops\/device\/replace\/history/i' => array('device', 'replace_history'), // 获取用户的更换摄像头记录
        '/^v1\/ops\/device\/service\/change\/captcha/i' => array('captcha', 'send', 'change_service'), //获取更换的校验码
        '/^v1\/ops\/device\/service\/add/i' => array('device', 'add_service'), //添加服务期限
        '/^v1\/ops\/device\/service\/delete/i' => array('device', 'delete_service'), //添加服务期限
        '/^v1\/ops\/device\/service\/list/i' => array('device', 'service_list'), //摄像头的服务列表
        '/^v1\/ops\/device\/check\/captcha/i' => array('device', 'check_code'), //检测校验码
        '/^v1\/ops\/device\/search\/check_id/i' => array('device', 'search_check_id'), //检测校验码
        '/^v1\/ops\/device\/unbind/i' => array('device', 'unbind'),
        '/^v1\/ops\/device\/bind/i' => array('device', 'bind'),
        '/^v1\/ops\/device\/replace/i' => array('device', 'replace'),
        '/^v1\/ops\/device\/list/i' => array('device', 'list'),
        '/^v1\/ops\/device\/search/i' => array('device', 'search'),
        '/^v1\/ops\/device\/export/i' => array('device', 'export'),


//------------------------------test---------------------------------------

        '/^v1\/test\/x\/(\w+)\/y\/(\w+)/i' => array('example', 'test'),
        '/^v1\/test\/x\/y\/(\w+)/i' => array('example', 'test'),
        '/^v1\/test\/x\/y/i' => array('example', 'test'),

    );
}


?>
