<?php
namespace backend\widgets\sidebar;

/**
 * 后台siderbar插件
 */
use Yii;
use yii\base\Widget;
use yii\widgets\Menu;
use common\models\PostModel;

class SidebarWidget extends Menu
{    
    public $submenuTemplate = "\n<ul class=\"children\">\n{items}\n</ul>\n";
    
    public $options = ['class'=>'nav nav-pills nav-stacked nav-quirk'];
    
    public $activateParents = true;
    
    public function init()
    {
        $this->items = [
            ['label' =>'<i class="fa fa-dashboard"></i><span>仪表盘</span>','url'=>['site/index']],
            ['label' =>'<a href=""><i class="fa fa-th-list"></i><span>内容管理</span></a>','options'=>['class'=>'nav-parent'],'items'=>[
                    ['label'=>'文章管理','url'=>['post/index'],'items'=>[
                    	['label'=>'文章详情','url'=>['post/view'],'visible'=>false],
                        ['label'=>'创建文章','url'=>['post/create'],'visible'=>false],
                        ['label'=>'更新文章','url'=>['post/update'],'visible'=>false],
                        ]                       
                    ],
                    ['label'=>'分类管理','url'=>['cat/index'],'items'=>[
                    	['label'=>'分类详情','url'=>['cat/view'],'visible'=>false],
                        ['label'=>'创建分类','url'=>['cat/create'],'visible'=>false],
                        ['label'=>'更新分类','url'=>['cat/update'],'visible'=>false],
                        ]                        
                    ],
                    ['label'=>'标签管理','url'=>['tag/index'],'items'=>[
                    	['label'=>'标签详情','url'=>['tag/view'],'visible'=>false],
                    	['label'=>'创建标签','url'=>['tag/create'],'visible'=>false],
                    	['label'=>'更新标签','url'=>['tag/update'],'visible'=>false],
                    	]
                    ],
                ]
            ],
            ['label' =>'<a href=""><i class="fa fa-user"></i><span>会员管理</span></a>','options'=>['class'=>'nav-parent'],'items'=>[
                    ['label'=>'会员信息','url'=>['user/index'],'items'=>[
                    	['label'=>'修改会员','url'=>['user/update'],'visible'=>false],
                    ]],
                ]
            ],
        	['label' => '<a href=""><i class="fa fa-key"></i><span>管理员</span></a>','options' => ['class'=>'nav-parent'],'items'=>[
        			['label' => '管理员信息','url' => ['admin/index'], 'items'=>[
        				['label'=>'新增管理员', 'url' => ['admin/create'], 'visible'=>false],
        				['label'=>'查看管理员', 'url' => ['admin/view'], 'visible'=>false],	
        				['label'=>'修改管理员', 'url' => ['admin/update'], 'visible'=>false],
        				['label'=>'删除管理员', 'url' => ['admin/delete'], 'visible'=>false],
        				['label'=>'重置密码', 'url' => ['admin/resetpwd'], 'visible'=>false],
        				['label'=>'权限分配', 'url'=>['admin/privilege'], 'visible'=>false],
        			]],
        		]		
        	],
        ];
    }
    
    /**
     * Normalizes the [[items]] property to remove invisible items and activate certain items.
     * @param array $items the items to be normalized.
     * @param boolean $active whether there is an active child menu item.
     * @return array the normalized menu items
     */
    protected function normalizeItems($items, &$active)
    {
    	foreach ($items as $i => $item) {
    		if (!isset($item['label'])) {
    			$item['label'] = '';
    		}
    		$encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
    		$items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
    		$hasActiveChild = false;
    		if (isset($item['items'])) {
    			$items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
    			if (empty($items[$i]['items']) && $this->hideEmptyItems) {
    				unset($items[$i]['items']);
    				if (!isset($item['url'])) {
    					unset($items[$i]);
    					continue;
    				}
    			}
    		}
    		if (!isset($item['active'])) {
    			if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
    				$active = $items[$i]['active'] = true;
    			} else {
    				$items[$i]['active'] = false;
    			}
    		} elseif ($item['active']) {
    			$active = true;
    		}
    		 
    		if (isset($item['visible']) && !$item['visible']) {
    			unset($items[$i]);
    			continue;
    		}
    	}
    
    	return array_values($items);
    }
}