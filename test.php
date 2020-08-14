<?php

require 'vendor/autoload.php';
$client = \Elasticsearch\ClientBuilder::create()->setHosts(['127.0.0.1'])->build();

/**
 * index:一个索引，可以看做是关系型数据库的一个库；
 * type:一种类型，可以看做是关系型数据库的一个表；
 * id:可以看做是关系型数据库的主键ID字段；
 */
//创建索引
/*$params = [
    'index' => 'my_index',
    'body' => [
        'settings' => [               // 自定义设置配置
            'number_of_shards' => 2,  // 数据分片数
            'number_of_replicas' => 0 // 数据备份数
        ]
    ]
];

$response = $client->indices()->create($params);
print_r($response);*/
//========================================================
//获取 ES 的状态信息，包括index 列表
/*$response = $client->indices()->stats();
echo "<pre>";
print_r($response);exit;*/


//========================================================
//删除索引（删除整个数据库）
/*$deleteParams = [
'index' => 'my_index'
];
$response = $client->indices()->delete($deleteParams);
print_r($response);exit;*/
//=====================================================

//检查Index 是否存在
/*$params = [
    'index' => 'my_index',
];
$response = $client->indices()->exists($params);
print_r($response);exit;*/

//================================
$params = [
    'index' => 'my_index',
    'type' => 'my_type'
];
$response = $client->indices()->getMapping($params);

print_r($response);exit;
// 建立 type ES中的type对应MySQL里面的表。
$params = [
    'index' => 'my_index',
    'type' => 'my_type',
    'body' => [
        'my_type' => [
            '_source' => [
                'enabled' => true
            ],
            'properties' => [
                'id' => [
                    'type' => 'integer'
                ],
                'first_name' => [
                    'type' => 'string',
                   // 'analyzer' => 'ik_max_word'
                ],
                'last_name' => [
                    'type' => 'string',
                   // 'analyzer' => 'ik_max_word'
                ],
                'age' => [
                    'type' => 'integer'
                ]
            ]
        ]
    ]
];
$client->indices()->putMapping($params);exit;





//创建一条数据
/*$params = [
    'index' => 'my_index',
    'type' => 'my_type',
    'id' => 1004,
    'body' => [
        "id" => 1004,
        "first_name" => '王张李',
        "last_name"  => '凯',
        "age" => 25
    ] // 此条数据的内容，数组可以任意定义。
];

$response = $client->index($params);
print_r($response);exit;*/

//========================================================
//查找所有数据

/*$data = $client->search();
echo "<pre>";
print_r($data);exit;*/

//=================================================

//查询一条记录
/*$params = [
    'index' => 'my_index',
    'type' => 'my_type',
    'id' => 'my_id'
];

$response = $client->get($params);
print_r($response);*/
//==================================================
//更新记录
/*$params = [
    'index' => 'my_index',
    'type' => 'my_type',
    'id' => '1001',
    'body' =>[
        'doc' => [
            'last_name' => "三丰",
            'age' => 99
        ]

    ]
];

$response = $client->update($params);
echo "<pre>";
print_r($response);exit;*/
//===========================================
/*$params = [
    'index' => 'my_index'
];
$response = $client->getMapping($params);
echo "<pre>";
print_r($response);exit;*/
//=====================================
//一次获取多个文档
/*$params = [
    'index' => 'my_index',
    'type' => 'my_type',
    '_source' => ['first_name','age'], //可有 可无 指定需要返回的字段
    'body' => ['ids' => [1002,1003]]
];

$response = $client->mget($params);
echo "<pre>";
print_r($response);exit;*/

//========================================================
//全文搜索  https://www.cnblogs.com/codeAB/p/10288273.html
$params = [
    'index' => 'my_index',
    'type' => 'my_type',
    '_source' => ['first_name','age','last_name'], //可有 可无 指定需要返回的字段
    'body' => [
        'query' => [ // 查询时必须制定的`query`参数
            'match' => [
                'first_name' => '张'
            ],
        ],
        'sort' => [
            ['age' => ['order' => 'desc']]
        ]
    ]
];

$response = $client->search($params);
echo "<pre>";
print_r($response);
//========================================================
// 删除一个文档（仅删除一条记录）
/*$params = [
    'index' => 'my_index',
    'type' => 'my_type',
    'id' => 'my_id'
];

$response = $client->delete($params);
print_r($response);*/



